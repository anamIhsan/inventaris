<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExitItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ExitItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $query = ExitItem::with('items');

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->whereHas('items', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('location', 'like', "%{$keyword}%");
                })
                ->orWhere('quantity', 'like', "%{$keyword}%")
                ->orWhere('date_out', 'like', "%{$keyword}%")
                ->orWhere('recipient', 'like', "%{$keyword}%");
        }

        $exitItems = $query->latest()->paginate(10);

        return view('admin.pages.exit-item.index', compact('exitItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $items = Item::get();
        return view('admin.pages.exit-item.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'item_id'   => 'required|exists:items,id',
            'date_out'  => 'required|date',
            'quantity'  => 'required|integer|min:1',
            'location'  => 'required|string|max:255',
            'recipient' => 'required|string|max:255',
            'notes'     => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $exitItemData = [
                'item_id'   => $request->item_id,
                'date_out'  => $request->date_out,
                'quantity'  => $request->quantity,
                'location'  => $request->location,
                'recipient' => $request->recipient,
                'notes'     => $request->notes,
            ];

            ExitItem::create($exitItemData);

            return redirect()->route('exit-item.index')
                ->with('success', 'Data barang keluar berhasil ditambah');
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
        $exitItem = ExitItem::findOrFail($id);
        $items = Item::all();
        return view('admin.pages.exit-item.edit', compact('exitItem', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $exitItem = ExitItem::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'date_out' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'recipient' => 'required|string|max:255',
            'notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'item_id'   => $request->item_id,
                'date_out'  => $request->date_out,
                'quantity'  => $request->quantity,
                'location'  => $request->location,
                'recipient' => $request->recipient,
                'notes'     => $request->notes,
            ];

            $exitItem->update($updateData);

            return redirect()->route('exit-item.index')
                ->with('success', 'Data barang keluar berhasil diubah');
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
        $exitItem = ExitItem::findOrFail($id);

        try {
            $exitItem->delete();

            return redirect()->route('exit-item.index')
                ->with('success', 'Data barang keluar berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
