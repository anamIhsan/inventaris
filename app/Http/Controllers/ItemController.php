<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $query = Item::query();

    if ($request->has('search') && $request->search != '') {
        $keyword = $request->search;
        $query->where('name', 'like', "%{$keyword}%")
              ->orWhere('location', 'like', "%{$keyword}%")
              ->orWhere('item_type', 'like', "%{$keyword}%");
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

    return view('admin.pages.item.index', compact('items'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specification' => 'required|string',
            'location' => 'required|string|max:255',
            'condition' => 'required|string|max:100',
            'funding_source' => 'required|string|max:255',
            'description' => 'required|string',
            'item_type' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $itemData = [
                'name' => $request->name,
                'specification' => $request->specification,
                'location' => $request->location,
                'condition' => $request->condition,
                'funding_source' => $request->funding_source,
                'description' => $request->description,
                'item_type' => $request->item_type,
            ];

            // Handle item image upload if provided
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image');
                $imageFileName = 'item-' . Str::uuid() . '.' . $imagePath->getClientOriginalExtension();
                $uploadImage = Storage::putFileAs('public/items', $imagePath, $imageFileName);
                $itemData['image'] = $uploadImage;
            }

            Item::create($itemData);

            return redirect()->route('item.index')
                ->with('success', 'Data Barang Berhasil Ditambah');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.pages.item.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.pages.item.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'specification' => 'required|string',
            'location' => 'required|string|max:255',
            'condition' => 'required|string|max:100',
            'funding_source' => 'required|string|max:255',
            'description' => 'required|string',
            'item_type' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'name' => $request->name,
                'specification' => $request->specification,
                'location' => $request->location,
                'condition' => $request->condition,
                'funding_source' => $request->funding_source,
                'description' => $request->description,
                'item_type' => $request->item_type,
            ];

            // Handle item image upload if new file is provided
            if ($request->hasFile('image')) {
                // Check if old image exists and delete it
                if ($item->image && Storage::exists($item->image)) {
                    Storage::delete($item->image);
                }

                $imagePath = $request->file('image');
                $imageFileName = 'item-' . Str::uuid() . '.' . $imagePath->getClientOriginalExtension();
                $updateData['image'] = Storage::putFileAs('public/items', $imagePath, $imageFileName);
            }

            $item->update($updateData);

            return redirect()->route('item.index')
                ->with('success', 'Data Barang Berhasil Diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        try {
            // Delete associated image if exists
            if ($item->image && Storage::exists($item->image)) {
                Storage::delete($item->image);
            }

            $item->delete();

            return redirect()->route('item.index')
                ->with('success', 'Data Barang Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
