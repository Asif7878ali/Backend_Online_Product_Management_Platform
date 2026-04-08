<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        try {
            $validated = $req->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6'
            ], [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
                'email.unique' => 'User already exists with this email'
            ]);

            $user = User::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function login(Request $req)
    {
        $user = User::where('email', $req->email)->first();

        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successfully',
            'token' => $token,
            'user' => $user
        ], 200);
    }
}
