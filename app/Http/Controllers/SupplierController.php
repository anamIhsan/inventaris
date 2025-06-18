<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
    $query = Supplier::query();

    if ($request->has('search') && $request->search != '') {
        $keyword = $request->search;
        $query->where('name', 'like', "%{$keyword}%")
              ->orWhere('phone', 'like', "%{$keyword}%")
              ->orWhere('address', 'like', "%{$keyword}%");
    }

    $suppliers = $query->latest()->paginate(10);

    return view('admin.pages.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.supplier.create');
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
            'name' => 'required|string|max:255|unique:suppliers,name',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $supplierData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ];

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image');
                $imageFileName = 'supplier-' . Str::uuid() . '.' . $imagePath->getClientOriginalExtension();
                $uploadImage = Storage::putFileAs('public/suppliers', $imagePath, $imageFileName);
                $supplierData['image'] = $uploadImage;
            }

            Supplier::create($supplierData);

            return redirect()->route('supplier.index')
                ->with('success', 'Data Supplier Berhasil Ditambah');
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
        $supplier = Supplier::findOrFail($id);
        return view('admin.pages.supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.pages.supplier.edit', compact('supplier'));
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
        $supplier = Supplier::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
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
                'phone' => $request->phone,
                'address' => $request->address,
            ];

            // Handle image upload if new file is provided
            if ($request->hasFile('image')) {
                // Check if old image exists and delete it
                if ($supplier->image && Storage::exists($supplier->image)) {
                    Storage::delete($supplier->image);
                }

                $imagePath = $request->file('image');
                $imageFileName = 'supplier-' . Str::uuid() . '.' . $imagePath->getClientOriginalExtension();
                $updateData['image'] = Storage::putFileAs('public/suppliers', $imagePath, $imageFileName);
            }

            $supplier->update($updateData);

            return redirect()->route('supplier.index')
                ->with('success', 'Data Supplier Berhasil Diubah');
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
        $supplier = Supplier::findOrFail($id);

        try {
            // Delete associated image if exists
            if ($supplier->image && Storage::exists($supplier->image)) {
                Storage::delete($supplier->image);
            }

            $supplier->delete();

            return redirect()->route('supplier.index')
                ->with('success', 'Data Supplier Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
