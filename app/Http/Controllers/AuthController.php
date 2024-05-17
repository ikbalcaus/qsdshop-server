<?php

namespace App\Http\Controllers;


use App\Http\Requests\RegisterRequests;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function register(RegisterRequests $request){
//dodati registraciju roleova i status za usere

        //custom request class
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'city' => $request->input('city'),
            'address' => $request->input('address'),
            'zip_code' => $request->input('zip_code'),
            'phone' => $request->input('phone'),
            'role'=> $request->input('role'),
            'status'=>$request->input('status')
        ]);

        //Popraviti token
            // $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
            ], 200);
        }
}
