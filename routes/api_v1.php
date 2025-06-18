<?php

use App\Http\Controllers\Api\V1\ApiV1TicketController;
use App\Http\Controllers\Api\V1\UsersController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Ticket;


//we dont want to use resource here because it will provide routes 
//for functions not implemented yet like /tickets/create, but we dont have an interface for creating tickets yet 
/*(

Route::resource('tickets',TicketController::class)
{};*/

// instead we will use apiResource becuase it will provide routes only for the things we need 
//Route::apiResource('tickets', ApiV1TicketController::class);    


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// this makes sure that to access our ticket resources , the request has to include a sanctum token 
//this prottects our route / api 
Route::middleware('auth:sanctum')->apiResource('tickets', ApiV1TicketController::class);

//in postman add bearer token
// take token returned from the login request and add that in auth -> bearer token , then the api request will be authnoried 


Route::middleware('auth:sanctum')->apiResource('users', UsersController::class);