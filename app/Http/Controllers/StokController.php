<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $query = Item::query();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                ->orWhereHas('categories', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%{$keyword}%");
                });
            });
        }

        // Ambil semua data tanpa pagination
        $items = $query->latest()->get();

        // Tambahkan field stok
        $items->transform(function ($item) {
            $item->stok = $item->incomingItems->sum('quantity')
                        - $item->exitItems->sum('quantity')
                        - $item->borrowings->where('status', 'dipinjam')->sum('quantity');

            // untuk hasil perubahan fieldnya di return
            return $item;
        });

        return view('admin.pages.stok', compact('items'));
    }
}
