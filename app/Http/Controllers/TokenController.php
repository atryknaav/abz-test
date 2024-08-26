<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tokenValue = Str::random(60);
        $id = uniqid();
        $expiresAt = now()->addMinutes(40);

        $cacheKey = 'access_token_' . $id . '_' . Hash::make($tokenValue);

        Cache::put($cacheKey, true, now()->addMinutes(40));

        Token::create([
            'id'=> $id,
            'token' => $tokenValue,
            'expires_at' => $expiresAt
        ]);

        return response()->json(['token' => Hash::make($tokenValue)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Token $token)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Token $token)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Token $token)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Token $token)
    {
        //
    }
}
