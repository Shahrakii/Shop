<?php

use Spatie\Permission\Middlewares\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middlewares\RoleMiddleware as SpatieRoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware as SpatiePermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Redirect guests and logged-in users
        $middleware->redirectGuestsTo('/admin/login');
        $middleware->redirectUsersTo('/admin/dashboard');
    })
    ->withExceptions(fn($exceptions) => null)
    ->create();