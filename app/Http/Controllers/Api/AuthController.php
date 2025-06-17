<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

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

        //include the token here 
        return $this->ok('user logged in');

    }


    public function register()
    {

        return $this->ok('register') ;
    }
}
