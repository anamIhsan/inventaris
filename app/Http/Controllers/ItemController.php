<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
    public function index(Request $request){
        $query = Item::query();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('condition', 'like', "%{$keyword}%")
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

        return view('admin.pages.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.item.create', compact('categories'));
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'condition' => 'required|string|max:100',
            'price' => 'required|string|max:255',
            'funding_source' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $itemData = [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'condition' => $request->condition,
                'price' => $request->price,
                'funding_source' => $request->funding_source,
                'description' => $request->description,
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('admin.pages.item.edit', compact('item', 'categories'));
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'condition' => 'required|string|max:100',
            'price' => 'required|string|max:255',
            'funding_source' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'condition' => $request->condition,
                'price' => $request->price,
                'funding_source' => $request->funding_source,
                'description' => $request->description,
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
