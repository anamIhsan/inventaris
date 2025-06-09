<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('level', 'like', "%{$keyword}%");
        }

        $users = $query->latest()->paginate(10);

        return view('admin.pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.pages.user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'photo'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'level'    => ['required', Rule::in(['Administrator', 'Manajemen', 'User'])],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $userData = [
                'name'  => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => $request->level,
            ];

            if ($request->hasFile('photo')) {
                $photoFile = $request->file('photo');
                $photoFileName = 'user-' . Str::uuid() . '.' . $photoFile->getClientOriginalExtension();
                $userData['photo'] = Storage::putFileAs('public/users', $photoFile, $photoFileName);
            }

            User::create($userData);

            return redirect()->route('user.index')
                ->with('success', 'Data Pengguna Berhasil Ditambah');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pages.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => ['nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'level'    => ['required', Rule::in(['Administrator', 'Manajemen', 'User'])],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'name'  => $request->name,
                'email' => $request->email,
                'level' => $request->level,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('photo')) {
                if ($user->photo && Storage::exists($user->photo)) {
                    Storage::delete($user->photo);
                }

                $photoFile = $request->file('photo');
                $photoFileName = 'user-' . Str::uuid() . '.' . $photoFile->getClientOriginalExtension();
                $updateData['photo'] = Storage::putFileAs('public/users', $photoFile, $photoFileName);
            }

            $user->update($updateData);

            return redirect()->route('user.index')
                ->with('success', 'Data Pengguna Berhasil Diubah');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            if ($user->photo && Storage::exists($user->photo)) {
                Storage::delete($user->photo);
            }

            $user->delete();

            return redirect()->route('user.index')
                ->with('success', 'Data Pengguna Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withErrors($th->getMessage());
        }
    }
}
