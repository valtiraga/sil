<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }
        
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $login = $credentials['email'];
        $user = null;

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $user = \App\Models\User::where('email', $login)->first();
        } else {
            // Cek apakah login menggunakan NIM
            $student = \App\Models\Student::where('nim', $login)->first();
            if ($student && $student->user_id) {
                $user = \App\Models\User::find($student->user_id);
            }
        }

        if ($user && Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        return back()->withErrors([
            'email' => 'Kredensial tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function redirectBasedOnRole($role)
    {
        if ($role === 'admin') {
            return redirect()->intended('/admin');
        }
        
        if ($role === 'dosen') {
            return redirect()->intended('/dosen');
        }
        
        if ($role === 'mahasiswa') {
            return redirect()->intended('/mahasiswa');
        }

        return redirect('/login');
    }
}
