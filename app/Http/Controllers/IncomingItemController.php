<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IncomingItem;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class IncomingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $query = IncomingItem::with(['items', 'suppliers']);

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->whereHas('items', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('location', 'like', "%{$keyword}%");
                })
                ->orWhereHas('suppliers', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                })
                ->orWhere('quantity', 'like', "%{$keyword}%")
                ->orWhere('entry_date', 'like', "%{$keyword}%");
        }

        $incomingItems = $query->latest()->paginate(10);

        return view('admin.pages.incoming-item.index', compact('incomingItems'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $items = Item::all();
        $suppliers = Supplier::all();
        return view('admin.pages.incoming-item.create', compact('items', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'entry_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $incomingItemData = [
                'item_id' => $request->item_id,
                'supplier_id' => $request->supplier_id,
                'entry_date' => $request->entry_date,
                'quantity' => $request->quantity,
            ];

            IncomingItem::create($incomingItemData);

            return redirect()->route('incoming-item.index')
                ->with('success', 'Data Barang Masuk Berhasil Ditambah');
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
        $incomingItem = IncomingItem::findOrFail($id);
        $items = Item::all();
        $suppliers = Supplier::all();
        return view('admin.pages.incoming-item.edit', compact('incomingItem', 'items', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $incomingItem = IncomingItem::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'entry_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'item_id' => $request->item_id,
                'supplier_id' => $request->supplier_id,
                'entry_date' => $request->entry_date,
                'quantity' => $request->quantity,
            ];

            $incomingItem->update($updateData);

            return redirect()->route('incoming-item.index')
                ->with('success', 'Data Barang Masuk Berhasil Diubah');
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
    public function destroy($id){
        $incomingItem = IncomingItem::findOrFail($id);

        try {
            $incomingItem->delete();

            return redirect()->route('incoming-item.index')
                ->with('success', 'Data Barang Masuk Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

}
