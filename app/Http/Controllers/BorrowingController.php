<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class BorrowingController extends Controller{
    public function index(Request $request)
    {
        $token = Session::get('jwt');
        $payload = JWTAuth::setToken($token)->getPayload();

        $userId = $payload->get('sub');
        $level = $payload->get('level');

        $query = Borrowing::with(['items', 'users']);

        // Filter: Jika user biasa, tampilkan hanya miliknya
        if ($level === 'User') {
            $query->where('user_id', $userId);
        }

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('users', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%{$keyword}%");
                })
                ->orWhere('condition', 'like', "%{$keyword}%")
                ->orWhere('status', 'like', "%{$keyword}%")
                ->orWhere('borrowed_at', 'like', "%{$keyword}%")
                ->orWhere('returned_at', 'like', "%{$keyword}%")
                ->orWhereHas('items', function ($q3) use ($keyword) {
                    $q3->where('name', 'like', "%{$keyword}%");
                });
            });
        }

        $borrowings = $query->latest()->paginate(10);

        return view('admin.pages.borrowing.index', [
            'borrowings' => $borrowings,
            'payload' => $payload
        ]);
    }

    public function create(){
        $items = Item::with(['incomingItems', 'exitItems', 'borrowings'])->get();
        return view('admin.pages.borrowing.create', compact('items'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'borrowed_at' => 'required|date',
            'returned_at' => 'required|date|after_or_equal:borrowed_at',
            'condition' => 'required|string|max:100',
            'status' => 'required|in:diminta,disetujui,ditolak,dipinjam,dikembalikan',
            'catatan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $userId = $request->attributes->get('payload')->get('sub');

            if (!$userId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            Borrowing::create([
                'user_id' => $userId,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'borrowed_at' => $request->borrowed_at,
                'returned_at' => $request->returned_at,
                'condition' => $request->condition,
                'status' => $request->status,
                'catatan' => $request->catatan,
            ]);

            return redirect()->route('borrowing.index')->with('success', 'Data Peminjaman Berhasil Ditambah');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function edit($id){
        $borrowing = Borrowing::findOrFail($id);
        $items = Item::all();
        return view('admin.pages.borrowing.edit', compact('borrowing', 'items'));
    }

    public function update(Request $request, $id){
        $borrowing = Borrowing::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'borrowed_at' => 'required|date',
            'returned_at' => 'required|date|after_or_equal:borrowed_at',
            'condition' => 'required|string|max:100',
            'status' => 'required|in:diminta,disetujui,ditolak,dipinjam,dikembalikan',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $borrowing->update([
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'borrowed_at' => $request->borrowed_at,
                'returned_at' => $request->returned_at,
                'condition' => $request->condition,
                'status' => $request->status,
                'catatan' => $request->catatan,
            ]);

            return redirect()->route('borrowing.index')->with('success', 'Data Peminjaman Berhasil Diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function destroy($id){
        $borrowing = Borrowing::findOrFail($id);

        try {
            $borrowing->delete();
            return redirect()->route('borrowing.index')->with('success', 'Data Peminjaman Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updateStatus(Request $request, $id){
        $borrowing = Borrowing::findOrFail($id);

        $validStatuses = ['disetujui', 'ditolak', 'dipinjam', 'dikembalikan'];
        $newStatus = $request->input('status');

        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->back()->withErrors(['status' => 'Status tidak valid.']);
        }

        try {
            if ($borrowing->status === 'dikembalikan' && $newStatus === 'dikembalikan') {
                return redirect()->back()->withErrors(['status' => 'Barang sudah dikembalikan sebelumnya.']);
            }

            $updateData = ['status' => $newStatus];

            if ($newStatus === 'dikembalikan') {
                $updateData['returned_at'] = now();
            }

            $borrowing->update($updateData);

            return redirect()->route('borrowing.index')->with('success', "Status berhasil diubah menjadi '$newStatus'.");
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
