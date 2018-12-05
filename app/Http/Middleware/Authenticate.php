<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $token = $request->header('Authorization');
        if($token && User::where('api_token', $token)->first()){
            return $next($request);
        }
        return response()->json([
            'message' => 'Not a valid API request.',
        ], 400);
    }
}
