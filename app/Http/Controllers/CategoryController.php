<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where('name', 'like', "%{$keyword}%");
        }

        $categories = $query->latest()->paginate(10);

        return view('admin.pages.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Category::create([
                'name' => $request->name,
            ]);

            return redirect()->route('category.index')
                ->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.pages.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $category->update([
                'name' => $request->name,
            ]);

            return redirect()->route('category.index')
                ->with('success', 'Kategori berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        try {
            $category->delete();

            return redirect()->route('category.index')
                ->with('success', 'Kategori berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withErrors($th->getMessage());
        }
    }
}
