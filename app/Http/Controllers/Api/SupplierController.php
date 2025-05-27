<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResponse;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return new DataResponse($suppliers, "Data supplier berhasil ditampilkan", 200);
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return new DataResponse(null, "Supplier tidak ditemukan", 404);
        }

        return new DataResponse($supplier, "Detail supplier berhasil ditampilkan", 200);
    }
}
