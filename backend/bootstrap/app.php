<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Sanctum Middleware for SPA Authentication
        $middleware->statefulApi()->append(EnsureFrontendRequestsAreStateful::class);

        // Add throttle:api to API middleware group
        $middleware->api()->append(ThrottleRequests::class.':api');
    })
    ->withExceptions(function (Exceptions $exceptions): void {

    })->create();
