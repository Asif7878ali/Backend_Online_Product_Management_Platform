<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // GET USERS
    public function index(Request $request)
    {
        try {

            $query = User::query();

            // EXCLUDE ADMIN
            $query->where('role', '!=', 'admin');

            // SEARCH
            if ($request->filled('search')) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            }

            // ROLE FILTER
            if ($request->filled('filter') && $request->filter !== 'All') {
                $query->where('role', $request->filter);
            }

            // PAGINATION
            $perPage = $request->get('per_page', 10);
            $users = $query->paginate($perPage);

            return response()->json([
                'status' => true,
                'data' => $users->items(),
                'totalPages' => $users->lastPage(),
                'totalItems' => $users->total(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // CREATE USERS
    public function register(Request $req)
    {
        try {
            $validated = $req->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,vendor,customer'
            ], [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
                'role.required' => 'Role is required',
                'email.unique' => 'User already exists with this email'
            ]);


            $validated['password'] = Hash::make($validated['password']);
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

    // LOGIN
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $req->email)->first();

        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // token (role-based)
        $token = $user->createToken($user->role . '-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successfully',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    // LOGOUT
    public function logout(Request $req)
    {
        $req->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successfully'
        ]);
    }
}
