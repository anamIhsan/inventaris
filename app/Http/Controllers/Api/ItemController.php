<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DataResponse;

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
