<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || $user->level !== 'User') {
            return new DataResponse(null, 'Access denied. Role not allowed.', 403);
        }

        if (!$token = auth()->attempt($credentials)) {
            return new DataResponse(null, 'Invalid credentials.', 401);
        }

        return $this->respondWithToken($token, auth()->user());
    }

    public function me()
    {
        return new DataResponse(auth()->user(), 'Data pengguna saat ini.', 200);
    }

    public function logout()
    {
        auth()->logout();
        return new DataResponse(null, 'Logout berhasil.', 200);
    }

    protected function respondWithToken($token, $user)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'photo' => $user->photo,
                'level' => $user->level
            ]
        ];

        return new DataResponse($data, 'Login berhasil.', 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 'User',
            'photo' => $photoPath,
        ]);

        $token = auth()->login($user);

        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user
        ];

        return new DataResponse($data, 'Registrasi berhasil.', 201);
    }
}
