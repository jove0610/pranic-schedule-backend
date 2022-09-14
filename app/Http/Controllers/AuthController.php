<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return abort(401, 'Invalid Credentials');
        }

        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Auth::guard('web')->logout();
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
