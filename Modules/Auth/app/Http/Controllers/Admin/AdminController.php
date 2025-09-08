<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // Require authentication for all methods
        $this->middleware('auth');
    }

    public function dashboard()
    {
        // Optionally check role or permission
        if (!auth()->user()->hasAnyRole(['admin', 'super admin'])) {
            abort(403, 'شما دسترسی ندارید');
        }

        return view('admin::dashboard');
    }

    // Example page with permission check
    public function rolesPage()
    {
        if (!auth()->user()->can('view roles section')) {
            abort(403, 'شما اجازه دسترسی به این صفحه را ندارید');
        }

        return view('admin::roles.index');
    }
}
