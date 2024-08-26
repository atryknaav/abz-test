<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerifyTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {   
        $ckName = null;
        $tokenValue = null;

        if (!empty($_COOKIE)) {
        
            foreach ($_COOKIE as $name => $value) {
                if (strpos($name, 'access_token') !== false) {
                    $ckName = $name;
                    $tokenValue = $value;
                    break; // Exit loop once we find the desired cookie
                }
            }
        
            if ($ckName === null) {
                // Collect all cookie names and values for debugging
                $cookies = [];
                foreach ($_COOKIE as $name => $value) {
                    $cookies[] = "$name: $value";
                }
                $cookiesStr = implode(', ', $cookies);
        
                return response()->json([
                    'message' => 'Unauthorized on cookie.',
                ], 401);
            }

            
        }
        else{
            return response()->json(['message' => 'Unauthorized on cookie'], 401);
        }

        $id = str_replace('access_token_', '', $ckName);

        $tokenRow = Token::where('id_', $id)->first();
        
        // return response()->json(['message' => 'Unauthorized on db, id: '.$id], 401);
        if($tokenRow){
            if( !Hash::check($tokenRow->token, $tokenValue)) {
            }
        }
        else{
            return response()->json(['message' => 'Unauthorized: cookie does not exist in db'], 401);

        }

        if ($tokenRow->expires_at < now()) {
            return response()->json(['message' => 'Unauthorized expired'], 401);
        }

        return $next($request);
    }
}
