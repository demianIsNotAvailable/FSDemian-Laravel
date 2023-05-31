<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    const ROLE_ADMIN = 2;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('isADMIN');

        $roleUserId = auth()->user()->role_id;

        if ($roleUserId === self::ROLE_ADMIN) {
            return $next($request);
        }

        return response()->json(
            [
                "success" => true,
                "message" => "You dont have permissions"
            ],
            401
        );
    }
}
