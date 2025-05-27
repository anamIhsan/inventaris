<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResponse;
use App\Models\IncomingItem;
use Illuminate\Http\Request;

class IncomingItemController extends Controller
{
    public function index()
    {
        $data = IncomingItem::with('items', 'suppliers')->get();
        return new DataResponse($data, "Data barang masuk berhasil ditampilkan", 200);
    }

    public function show($id)
    {
        $data = IncomingItem::with('items', 'suppliers')->find($id);

        if (!$data) {
            return new DataResponse(null, "Data barang masuk tidak ditemukan", 404);
        }

        return new DataResponse($data, "Detail barang masuk berhasil ditampilkan", 200);
    }
}
