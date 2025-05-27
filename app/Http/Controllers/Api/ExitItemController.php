<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResponse;
use App\Models\ExitItem;
use Illuminate\Http\Request;

class ExitItemController extends Controller
{
    public function index()
    {
        $data = ExitItem::with('items')->get();
        return new DataResponse($data, "Data barang keluar berhasil ditampilkan", 200);
    }

    public function show($id)
    {
        $data = ExitItem::with('items')->find($id);

        if (!$data) {
            return new DataResponse(null, "Data barang keluar tidak ditemukan", 404);
        }

        return new DataResponse($data, "Detail barang keluar berhasil ditampilkan", 200);
    }
}
