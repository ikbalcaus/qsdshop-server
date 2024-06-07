<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequests;
use App\Http\Requests\RegisterRequests;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\AuthenticationToken;
use App\Models\ValidationKey;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ValidationKeyRequest;
use App\Mail\ValidationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Http;

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
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 200);
    }

    public function login(LoginRequests $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user->status) {
            return response()->json(['error' => 'U have been banned.'], 403);
        }
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        if ($request->has('validation_key')) {
            $validationKey = ValidationKey::where('user_id', $user->id)
                ->where('validationKey', $request->input('validation_key'))
                ->where('expires_at', '>', Carbon::now())
                ->first();
            if (!$validationKey) {
                return response()->json(['message' => 'Invalid validation key'], 400);
            }
            $validationKey->delete();
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'user' => $user,
                'message' => 'User logged in successfully',
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], 200);
        } else {
            $validationKey = rand(100000, 999999);
            $key = new ValidationKey([
                'user_id' => $user->id,
                'validationKey' => $validationKey,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]);
            $key->save();
            Mail::to($user->email)->queue(new ValidationMail($validationKey));

            return response()->json(['message' => 'A validation key has been sent to your email. Please provide the key to complete the login.',], 200);
        }
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Token not provided'], 400);
        }
        try {
            JWTAuth::invalidate(JWTAuth::parseToken()->getToken());
            auth()->logout();
            return response()->json([
                'message' => 'User logged out successfully.'
            ], 200);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => 'Failed to invalidate the token.', 'error' => $e->getMessage()], 500);
        }
    }

    public function changePassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        $user = JWTAuth::parseToken($token)->authenticate();
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['message' => 'Current password is incorrect!'], 400);
        }
        $user->password = Hash::make($request->input('new_password'));
        $user->save();
        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    public function requestValidationKey(ValidationKeyRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = DB::table('users')->where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $validationKey = rand(100000, 999999);
        $key = new ValidationKey([
            'user_id' => $user->id,
            'validationKey' => $validationKey
        ]);
        $key->save();
        Mail::to($user->email)->queue(new ValidationMail($validationKey));
        return response()->json(['message' => "Validation key sent to mail"]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid mail'], 404);
        }
        $authKey = DB::table('validation_keys')
            ->where('user_id', $user->id)->where('validationKey', $request->key)->first();
        if (!$authKey) {
            return response()->json(['message' => "Invalid validation key"], 400);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['message' => "Password reset successfully"], 200);
    }

    public function refresh(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        JWTAuth::parseToken()->invalidate();
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
            ],
            'authorization' => [
                'token' => $token,
                'type' => 'Bearer'
            ]
        ]);
    }
}
