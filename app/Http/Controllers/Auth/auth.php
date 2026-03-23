<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Login Form dekhonor jonno
    public function showLogin()
    {
        return view('auth.login');
    }

    // Login Process korar jonno
    public function login(Request $request)
    {
        // Validation check
        $credentials = $request->validate([
            'employeeID' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Authentication er chesta kora hocche
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Login shofol hole dashboard e redirect
            return redirect()->intended('admin.dashboard');
        }

        // Login beartho hole error message
        return back()->withErrors([
            'employeeID' => 'The provided credentials do not match our records.',
        ])->onlyInput('employeeID');
    }

    // Logout Process
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}