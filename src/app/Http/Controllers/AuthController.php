<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class AuthController extends Controller
{
    public function login(FormRequest $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 401);
        }

        // Define abilities for the token, (AKA, `permissions`)
        $abilities = ['promo-codes.validate'];
        if ($user->is_admin) {
            $abilities[] = 'promo-codes.create';
        }

        $token = $user->createToken('auth_token', $abilities);

        return response()->json(['token' => $token->plainTextToken]);
    }
}
