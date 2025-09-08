<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login page
    public function showLogin()
    {
        return view('auth::admin.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string', // email or phone
            'password' => 'required|string',
        ]);

        // Determine if email or phone number
        $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        $credentials = [
            $loginField => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Only allow admin or super admin
            if ($user->hasAnyRole(['admin', 'super admin'])) {
                return redirect()->route('admin.dashboard');
            }

            // Unauthorized users
            Auth::logout();
            return redirect()->back()->withErrors(['email' => 'دسترسی به پنل ادمین ندارید']);
        }

        // Wrong credentials
        return redirect()->back()->withErrors(['email' => 'ایمیل یا رمز عبور اشتباه است']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
