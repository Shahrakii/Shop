<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // فقط admin یا super admin میتونن ببینن
        if (! $user->hasAnyRole(['admin', 'super admin'])) {
            return redirect()->route('auth::admin\dashboard')->withErrors([
                'email' => 'دسترسی به پنل ادمین ندارید'
            ]);
        }

        return view('auth::admin.dashboard', compact('user'));
    }
}
