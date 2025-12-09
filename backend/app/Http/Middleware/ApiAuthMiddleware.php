<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware{
    public function handle(Request $request, Closure $next): Response
    {

        // For API routes, do NOT redirect
        if ($request->expectsJson() || $request->is('api/*')) {
            return '';
        }

        if (!auth('sanctum')->check()) {
            return response()->json([
                'message' => 'Unauthenticated. Please login again.',
                'status' => 401
            ], 401);
        }

        return $next($request);
    }
}
