<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // POST [ name, email, password ]
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            "first_name" => "required|string",
            "last_name" => "required|string",
            "email" => "required|string|email|unique:users",
            "password" => "required"
        ]);

        // Create User
        $user = User::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        $token = $user->createToken("mytoken")->accessToken;

        return response()->json([
            "status" => true,
            "message" => "Login successful",
            "token" => $token,
            "data" => []
        ]);
    }

    // POST [ email, password ]
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|string",
            "password" => "required"
        ]);

        // User object
        $user = User::where("email", $request->email)->first();

        if (!empty($user)) {

            // User exists
            if (Hash::check($request->password, $user->password)) {

                // Password matched
                $token = $user->createToken("mytoken")->accessToken;

                return response()->json([
                    "status" => true,
                    "message" => "Login successful",
                    "token" => $token,
                    "data" => []
                ]);
            } else {

                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match",
                    "data" => []
                ]);
            }
        } else {

            return response()->json([
                "status" => false,
                "message" => "Invalid Email value",
                "data" => []
            ]);
        }
    }

    // GET [Auth: Token]
    public function logout()
    {

        $token = auth()->user()->token();

        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => "User Logged out successfully"
        ]);
    }
}
