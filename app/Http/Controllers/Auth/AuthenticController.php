<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticController extends Controller
{
    // Login Form dekhonor jonno
    public function showLogin()
    {
        return view('auth.login');
    }

    // Login Process korar jonno
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'employeeID' => ['required', 'string'],
            'password'   => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'hr') {
                return redirect()->route('hr.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

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

        return redirect('/');
    }

}
