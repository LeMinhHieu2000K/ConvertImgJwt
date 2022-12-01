<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;

class OtpMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Token::where('token', request()->bearerToken())->where('verify', 1)->exists()){
            return abort(response()->json([
                "status" => 403,
                "message" => "Please verify with your otp code"
            ], 403));
        }

        return $next($request);
    }
}