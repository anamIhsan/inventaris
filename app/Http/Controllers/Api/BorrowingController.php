<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResponse;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $data = Borrowing::with('items')->get();
        return new DataResponse($data, "Data peminjaman berhasil ditampilkan", 200);
    }

    public function show($id)
    {
        $data = Borrowing::with('items')->find($id);

        if (!$data) {
            return new DataResponse(null, "Data peminjaman tidak ditemukan", 404);
        }

        return new DataResponse($data, "Detail peminjaman berhasil ditampilkan", 200);
    }
}
