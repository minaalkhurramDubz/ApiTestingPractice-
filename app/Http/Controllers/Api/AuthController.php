<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponses;

    // public function login ( RequestName $reqParams)
    public function login(LoginUserRequest $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok('Authenticated', [
            'token' => $user->createToken('API token for '.$user->email)->plainTextToken,
        ]);
    }

    public function register()
    {

        //  return $this->ok('register') ;
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return $this->ok('');

    }
}
