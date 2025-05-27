<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowingController extends Controller
{
    public function index(Request $request){
        $query = Borrowing::with('items');

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('condition', 'like', "%{$keyword}%")
                ->orWhere('status', 'like', "%{$keyword}%")
                ->orWhere('borrowed_at', 'like', "%{$keyword}%")
                ->orWhere('returned_at', 'like', "%{$keyword}%")
                ->orWhereHas('items', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
        }

        $borrowings = $query->latest()->paginate(10);

        return view('admin.pages.borrowing.index', compact('borrowings'));
    }

    public function create(){
        $items = Item::all();
        return view('admin.pages.borrowing.create', compact('items'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'borrowed_at' => 'required|date',
            'returned_at' => 'required|date|after_or_equal:borrowed_at',
            'condition' => 'required|string|max:100',
            'status' => 'required|in:dipinjam,dikembalikan,overdue',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Borrowing::create($request->only([
                'name', 'item_id', 'quantity', 'borrowed_at', 'returned_at', 'condition', 'status'
            ]));

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
            'name' => 'required|string|max:255',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'borrowed_at' => 'required|date',
            'returned_at' => 'required|date|after_or_equal:borrowed_at',
            'condition' => 'required|string|max:100',
            'status' => 'required|in:dipinjam,dikembalikan,overdue',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $borrowing->update([
                'name' => $request->name,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'borrowed_at' => $request->borrowed_at,
                'returned_at' => $request->returned_at,
                'condition' => $request->condition,
                'status' => $request->status,
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

    public function returnItem($id){
        $borrowing = Borrowing::findOrFail($id);

        try {
            if ($borrowing->status === 'dikembalikan') {
                return redirect()->back()->withErrors(['status' => 'Barang sudah dikembalikan sebelumnya.']);
            }

            $borrowing->update([
                'status' => 'dikembalikan',
                'returned_at' => now(),
            ]);

            return redirect()->route('borrowing.index')->with('success', 'Barang berhasil dikembalikan');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
