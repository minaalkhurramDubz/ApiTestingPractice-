<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use ApiResponses;

    //public function login ( RequestName $reqParams)
    public function login(LoginUserRequest  $request)
    {

      //validate data from request 

           $request->validated($request->all());

        // if the returned data is valid then we will authenticate it 


        //auth fail casse 
        if(!Auth::attempt($request->only('email','password')))
        {
          return $this->error('invalid credentials ',401);

        }


        //auth pass case 

        // fetch the user from the database 
        $user=User::firstWhere('email', $request->email);

        //include the token here 33
        return $this->ok('Authenticated ',
        //this is where the token is created , if there was gui the tokenname would be set by the user 
        ['token'=>$user->createToken('Api token for '. $user->email)->plainTextToken ]

        //the users email is concantenated with the  api token for message and a has value is created fo the token 
      );

    }


    public function register()
    {

      //  return $this->ok('register') ;
    }


    public function logout(Request $request)  
    {

      $request->user()->cureentAccessToken()->delete();

      return $this->ok( '');

    }
}
