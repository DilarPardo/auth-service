<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest; 
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{

    public function login(LoginRequest $request): JsonResponse
    {
        
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) 
        {
            return response()->json(['message' => 'Credenciales inválidas.'], 401); 
        }

        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200); 

    }

    public function me(Request $request)
    {

        return response()->json($request->user());
        
    }

    public function logout(Request $request): JsonResponse
    {

        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada exitosamente.']);

    }
    
}
