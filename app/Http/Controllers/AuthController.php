<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
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
        return JsonResource::make([
            "message" => "register success",
            "user"=>$user,
            "token"=>$token->plainTextToken,
            ]);
    }

    public function login(LoginUserRequest $request){
        $validated = $request->validated();
        $user = User::query()->where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return JsonResource::make([
                "message" => "Wrong credentials"
            ]);
        }else{
            return JsonResource::make(["user"=>$user]);
        }
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return JsonResource::make([
            "message" => "logout success"
        ]);
    }
}
