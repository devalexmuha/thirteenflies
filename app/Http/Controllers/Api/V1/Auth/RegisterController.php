<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Account\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'min:3', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4', 'max:255', 'confirmed'],
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'locale' => app()->getLocale(),
        ]);

        $user->userProfile()->create();

        return response()->json([
            'data' => [
                'user' => UserResource::make($user),
                'token' => $user->createToken('next-client', ['*'], now()->addDays(30))->plainTextToken,
            ],
        ], 201);

    }
}
