<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

use App\Http\Requests\CreateEmployeeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
   
    public function create_employee(CreateEmployeeRequest $request)
    {
          if ($request->user()->role->name !== 'manager') {
        return response()->json([
            'message' => 'Only manager can create users'
        ],403);
    }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role_id' => $request->role_id,
        ]);

       // 3|MBWYcqyAQKMLiCS3xNL77pww59godEwch4huGRRQ3a37df56
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    
    public function login(LoginRequest $request)
    {
        
        $credentials = $request->validated(); 
        
       
        if (Auth::attempt($credentials))
        {
           
            $user = Auth::user(); 
        

             /** @var \App\Models\User $user */;
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ]);
        } 
        else 
        {
            return response()->json(['message' => 'Invalid login details'], 401);
        }
    }

     public function logout(Request $request) // we just delete the user token
    {
      $request->user()->currentAccessToken()->delete();
       return response()->json([ 'message'=>'logout  successfully',]);
    }
}

