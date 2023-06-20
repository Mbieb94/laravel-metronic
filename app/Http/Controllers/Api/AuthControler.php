<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControler extends Controller
{
    public function login(LoginRequest $request)
    {
        $request['status'] = 1;
        $auth = $request->authenticateApi();

        if ($auth['status'] != 200) return response(['message' => 'LoginFailed'], 401);

        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');

        return response(['token' => $tokenResult->plainTextToken, 'user' => $user], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
