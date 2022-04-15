<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()){
            return ResponseHelper::fail($validator->messages()->first(), 422);
        }

        $user = User::where('email', $request->email)->first();
        $check_password = Hash::check($request->password, $user->password);

        if (!$check_password){
            return ResponseHelper::fail('Authentication failed, incorrect credentials', 422);
        }

        $token =  $user->createToken('access_token')->accessToken;
        $data = [
            'user' => $user,
            'access_token' => $token
        ];

        return  ResponseHelper::successWithData('Authentication successful', $data);

    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return ResponseHelper::fail($validator->messages()->first(), 422);
        }

        $data = $validator->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $token =  $user->createToken('access_token')->accessToken;
        $data = [
            'user' => $user,
            'access_token' => $token
        ];

        return  ResponseHelper::successWithData('Registration successful', $data);

    }
}
