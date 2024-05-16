<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use app\Models\User;
class AuthController extends Controller
{
    public function register(Request $request){
//dodati registraciju roleova i status za usere
        $validator= Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email'=> 'required|string|max:255|unique(users)',
            'password'=>'required|string|min:8',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]+$/|min:10|max:15'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::create([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'city' => $request->input('city'),
        'address' => $request->input('address'),
        'zip_code' => $request->input('zip_code'),
        'phone' => $request->input('phone'),
            ]);

            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()-> json(['user'=>$user,'token'=> $token],201);
        }
}
