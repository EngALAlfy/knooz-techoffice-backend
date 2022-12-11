<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IsBanned
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (Auth::user()->banned == 1) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false , 'data' => 'banned']);
            } else {
                return Redirect::route('banned');
            }
        }

        return $next($request);
    }
}
