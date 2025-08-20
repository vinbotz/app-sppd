<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->update(['last_login_at' => now()]);
        $role = $user->role;
        $pesan = 'Selamat datang, kamu masuk sebagai ' . ($role == 'admin' ? 'admin' : 'supervisor');
        session()->flash('login_success', $pesan);

        if ($user->role === 'supervisor') {
            return redirect()->route('supervisor.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('login');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'password' => ['password salah'],
        ]);
    }
} 