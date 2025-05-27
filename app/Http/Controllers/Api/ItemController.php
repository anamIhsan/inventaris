<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResponse;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        return new DataResponse($items, "Data item berhasil ditampilkan", 200);
    }

    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return new DataResponse(null, "Item tidak ditemukan", 404);
        }

        return new DataResponse($item, "Detail item berhasil ditampilkan", 200);
    }
}
