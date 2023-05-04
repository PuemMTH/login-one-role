<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember' => 'boolean',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user = $request->user();

        $token = $user->createToken('Access Token');

        $user->access_token = $token->plainTextToken;

        return response()->json([
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function listTokens(Request $request)
    {
        $user = $request->user(); // ผู้ใช้งานปัจจุบัน
        $activeTokens = $user->tokens; // รายการ token ที่ใช้งานอยู่

        return response()->json([
            'tokens' => $activeTokens
        ]);
    }

    public function revokeAllTokens(Request $request)
    {
        $user = $request->user(); // ผู้ใช้งานปัจจุบัน
        $user->tokens()->delete(); // ลบ token ทั้งหมดของผู้ใช้

        return response()->json([
            'message' => 'All tokens revoked successfully'
        ]);
    }

}
