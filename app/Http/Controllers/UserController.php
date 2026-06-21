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

    public function index()
    { 
         $users = User::with('role')
           ->orderBy('created_at', 'asc')
            ->get();

            return response()->json([
           'number of users' => $users->count(),
           'data' => $users
           ]);
    }
    public function update_employee(Request $request, User $user)
    {
   
        if ($request->user()->role->name !== 'manager') {
        return response()->json([
            'message' => 'Only manager can update users'
        ], 403);
        }

    
         $validated = $request->validate([
        'name' => 'sometimes|string|max:255|regex:/^[\pL\s\-]+$/u',
        'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6',
        'role_id' => 'sometimes|integer|exists:roles,id',
        ]);

    
        $user->fill($request->only(['name', 'email', 'role_id']));

    
        if ($request->filled('password')) {
         $user->password = Hash::make($request->password);
         }

    
       $user->save();

    
      return response()->json([
        'message' => 'User updated successfully',
        'user' => $user->load('role')
      ], 200);
   }
   public function destroy_employee(Request $request, User $user)
   {
        if ($request->user()->role->name !== 'manager') {
            return response()->json([
            'message' => 'Only manager can delete users'
            ], 403);
        }

    
       if ($request->user()->id === $user->id) {
           return response()->json([
            'message' => 'You cannot delete your own account'
          ], 400); // 400 تعني Bad Request (طلب غير منطقي)
        }

    
        $user->delete();

   
         return response()->json([
           'message' => 'User deleted successfully'
         ], 200);
    }

    public function show(Request $request, User $user)
    {
    
        if ($request->user()->role->name !== 'manager') {
             return response()->json([
            'message' => 'Only manager can view user details'
            ], 403);
        } 
        return response()->json($user->load('role'), 200);
    }



}

