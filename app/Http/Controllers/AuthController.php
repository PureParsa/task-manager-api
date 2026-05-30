<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'name' => $validated['name'],
        ]);

        $token = $user->createToken($validated['email']);

        return response()->json([
            "message" => "register success",
            "user" => $user,
            "token" => $token->plainTextToken,
        ], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                "message" => "Wrong credentials"
            ], 401);
        }

        $token = $user->createToken($validated['email']);

        return response()->json([
            "message" => "login success",
            "user" => $user,
            "token" => $token->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "message" => "logout success"
        ]);
    }
}
