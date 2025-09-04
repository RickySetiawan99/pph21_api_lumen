<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'username'     => $request->username,
            'email'    => $request->email,
            'password_hash' => Hash::make($request->password),
        ]);

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Pakai kolom sesuai database CI4 kamu
        $hashColumn = $user->password_hash ?? $user->password;

        if (! password_verify($request->password, $hashColumn)) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        return response()->json(['token' => $token]);
    }
}
