<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class RedirectIfUnauthorized
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (AuthorizationException $e) {
            // Redirect back if possible, otherwise to dashboard
            $previous = $request->headers->get('referer') ?? '/admin/dashboard';
            return redirect($previous)
                ->with('error', 'شما اجازه دسترسی به این بخش را ندارید!');
        }
    }
}
