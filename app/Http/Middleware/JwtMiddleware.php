<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        // Validating Payload
        if ($payload = JWTAuth::parseToken()->getPayload()) {
            if ($payload->get('ipa') != md5($request->ip())) {
                return abort(response()->json([
                    "status" => 403,
                    "message" => "api.blocked_device_error: origin IP is invalid"
                ], 403));
            }

            if ($payload->get('ura') != md5($request->userAgent())) {
                return abort(response()->json([
                    "status" => 403,
                    "message" => "api.blocked_device_error: origin user agent is invalid"
                ], 403));
            }
          
            if ($payload->get('hst') != md5(gethostname())) {
                return abort(response()->json([
                    "status" => 403,
                    "message" => "api.blocked_device_error: origin hostname is invalid"
                ], 403));
            }
        } else {
            return abort(response()->json([
                "status" => 403,
                "message" => "api.blocked_device_error"
            ], 403));
        }
        
        
        // Authenticate 
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return abort(response()->json([
                "status" => 403,
                "message" => "api.token_error"
            ], 403));
        }

        if(!Token::where('token', request()->bearerToken())->exists()){
            return abort(response()->json([
                "status" => 403,
                "message" => "Exceed limit login attempts"
            ], 403));
        }

        return $next($request);
    }
}