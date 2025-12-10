<?php

namespace App\Repositories;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Interfaces\AuthInterfaces;
use App\Models\User;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthRepositories implements AuthInterfaces
{
    use HttpResponseTraits;

    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->error('Email tidak ditemukan', 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->error('Password salah', 400);
        }

        Auth::login($user);

        return $this->success([
            'message' => 'Login berhasil',
            'redirect' => url('/dashboard')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->success([
            'message' => 'Logout berhasil',
            'redirect' => route('login')
        ]);
    }
}
