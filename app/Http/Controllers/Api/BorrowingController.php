<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResponse;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->attributes->get('payload')->get('sub');

        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = Borrowing::with('items')
            ->where('user_id', $userId)
            ->get();

        return new DataResponse($data, "Data peminjaman berhasil ditampilkan", 200);
    }

    public function show($id, Request $request)
    {
        $userId = $request->attributes->get('payload')->get('sub');

        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = Borrowing::with('items')
            ->where('user_id', $userId)
            ->find($id);

        if (!$data) {
            return new DataResponse(null, "Data peminjaman tidak ditemukan", 404);
        }

        return new DataResponse($data, "Detail peminjaman berhasil ditampilkan", 200);
    }

    public function store(Request $request)
    {
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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = $request->attributes->get('payload')->get('sub');

        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $borrowing = Borrowing::create([
            'user_id' => $userId,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'borrowed_at' => $request->borrowed_at,
            'returned_at' => $request->returned_at,
            'condition' => $request->condition,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return new DataResponse($borrowing, 'Data peminjaman berhasil ditambahkan', 201);
    }
}
