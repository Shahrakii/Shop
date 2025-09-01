<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth::admin\login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // اجازه ورود فقط برای admin یا super admin
        if ($user->hasAnyRole(['admin', 'super admin'])) {
            return redirect()->route('dashboard'); // مثلا صفحه داشبورد
        }

        // بقیه کاربران
        Auth::logout();
        return redirect()->back()->withErrors(['email' => 'دسترسی به پنل ادمین ندارید']);
    }

    // ایمیل یا پسورد اشتباه
    return redirect()->back()->withErrors(['email' => 'ایمیل یا رمز عبور اشتباه است']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
