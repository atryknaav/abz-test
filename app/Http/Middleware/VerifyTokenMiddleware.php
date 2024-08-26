<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class VerifyTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $id = $request->id;

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cacheKey = 'access_token_'. $id . '_' . $token;
        $tokenInCache = Cache::get($cacheKey);
        $id = Cache::get($cacheKey);

        if ($tokenInCache) {
            return $next($request);
        }

        $tokenRow = Token::where('id', $id)->first();

        if (Hash::check($tokenRow->token, $token)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!$tokenRow || $tokenRow->expires_at < now()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
