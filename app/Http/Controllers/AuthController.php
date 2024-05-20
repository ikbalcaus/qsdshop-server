<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequests;
use App\Http\Requests\RegisterRequests;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\AuthenticationToken;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ValidationKeyRequest;
use App\Mail\ValidationMail;

class AuthController extends Controller
{
    public function register(RegisterRequests $request): \Illuminate\Http\JsonResponse
    {
//dodati registraciju roleova i status za usere


        if (User::where('email', $request->input('email'))->exists()) {
            return response()->json(['message' => 'Email is already used'], 400);
        }
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
            'role' => $request->input('role'),
            'status' => $request->input('status'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //Popraviti token
        // $token = $user->createToken('AuthToken')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 200);
    }

    public function login(LoginRequests $request): \Illuminate\Http\JsonResponse
    {

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        //   $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'message' => 'User logged in successfully',
            // 'access_token'=>$token,
            // 'token_type'=>'Bearer'
        ], 200);
    }

    public function requestValidationKey(ValidationKeyRequest $request): \Illuminate\Http\JsonResponse
    {

        $user = DB::table('users')->where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validationKey = rand(100000, 999999);
        $key = new AuthenticationToken([
            'user_id' => $user->id,
            'token_value' => $validationKey
        ]);
        $key->save();
        Mail::to($user->email)->send(new ValidationMail($validationKey));
        return response()->json(['message' => "Validation key sent to mail"]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid mail'], 404);
        }
        $authKey = DB::table('authentication_token')
            ->where('user_id', $user->id)->where('token_value', $request->key)->first();
        if (!$authKey) {
            return response()->json(['message' => "Invalid validation key"], 400);

        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['message' => "Password reset successfully"], 200);
    }

    public function refresh(Request $request)
    {
        $user = auth()->guard('api')->user();
        $newToken = $user->createToken('Personal access token'); // kreira novi token za korisnika
        $token = $newToken->token;
        $token->expires_at = Carbon::now()->addMinutes(60); // postavljanje vremena nakon kojeg ce isteci
        $token->save(); //spasava u bazu
        return response()->json(['user' => ['user' => $user],
            'authorization' => [
                'token' => $newToken->accessToken,
                'type' => 'Bearer'
            ]]);
    }
}
