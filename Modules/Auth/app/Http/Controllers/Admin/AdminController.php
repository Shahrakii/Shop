<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        // Optionally check role or permission
        if (auth()->user()->hasAnyRole(['customer'])) {
            abort(403, 'شما دسترسی ندارید');
        }

        return view('admin::dashboard');
    }
}
