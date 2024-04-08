<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
        
        // Data validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);

        // User Model
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ]);
    }

    public function login(Request $request){
        
        // Data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
    
        // Attempt login
        if ($token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])) {
            // Check user role
            $user = Auth::user();
            if($user->role == 'admin') { // Admin Login
                return response()->json([
                    "status" => true,
                    "message" => "Admin logged in successfully",
                    "role"=>'admin' ,
                    "token" => $token,
                    "redirect_url" => "/admin" // Redirect admin to dashboard
                ]);
            } elseif($user->role == 'agent') { // Agent Login
                return response()->json([
                    "status" => true,
                    "message" => "Agent logged in successfully",
                    "role"=>'agent',
                    "token" => $token,
                    "redirect_url" => "/agent-dashboard" // Redirect agent to agent dashboard
                ]);
            } elseif($user->role == 'user') { // Normal User Login
                return response()->json([
                    "status" => true,
                    "message" => "User logged in successfully",
                    "role"=>'user' ,
                    "token" => $token,
                    "redirect_url" => "/dashboard" // Redirect normal user to home page
                ]);
            }
        }
    
        // Invalid credentials
        return response()->json([
            "status" => false,
            "message" => "Invalid credentials"
        ]);
    }
    
    public function profile(){

        $userdata = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $userdata
        ]);
    } 

    public function refreshToken(){
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            
            return response()->json([
                "status" => true,
                "message" => "New access token",
                "token" => $newToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Unable to refresh token"
            ], 500);
        }
    }
    

    public function logout(){
        
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }

}
