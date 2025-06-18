<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Ticket;


use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);



Route::post('/register',[AuthController::class,'register']);


Route::get('/tickets',function()
{
    return Ticket::all();

});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// makes sure that the user calling logut , is a user thats currently authorized/logged in 

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);