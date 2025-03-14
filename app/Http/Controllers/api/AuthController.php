<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password'])
            ]);

            return response()->json(["message" => "User successfully registered"], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    public function login(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = User::where('email', $validatedData['email'])->first();

            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                return response()->json(["message" => "Email or password is incorrect"], 401);
            }

            $token = $user->createToken("AuthSanctum", ["*"], now()->addMinutes(10000))->plainTextToken;

            return response()->json(["message" => "User successfully logged in", "token" => $token], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    public function logout(request $request){
        try {

            $request->user()->currentAccessToken()->delete();
            
            return response()->json(["message "=>"user succesfully loged out "],200);

            
        } catch (\Exception $e) {
            return response()->json(["message"=>"error","error"=>$e->getMessage()],500);
        }
}
}
