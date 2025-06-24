<?php

use App\Http\Controllers\Api\V1\ApiV1TicketController;
use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\AuthorTicketController;
use App\Http\Controllers\Api\V1\UsersController;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// we dont want to use resource here because it will provide routes
// for functions not implemented yet like /tickets/create, but we dont have an interface for creating tickets yet
/*(

Route::resource('tickets',TicketController::class)
{};*/

// instead we will use apiResource becuase it will provide routes only for the things we need
// Route::apiResource('tickets', ApiV1TicketController::class);

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::middleware('auth:sanctum')->group(function () {
    // this makes sure that to access our ticket resources , the request has to include a sanctum token// this handles all routes related to the tickets , except the update route
    // this prottects our route / api
    Route::apiResource('tickets', ApiV1TicketController::class)->except(['update']);
    Route::put('tickets/{tickets}', [ApiV1TicketController::class, 'replace']);
    Route::patch('tickets/{tickets}', [ApiV1TicketController::class, 'update']);
    // take token returned from the login request and add that in auth -> bearer token , then the api request will be authnoried
    // Route::middleware('auth:sanctum')->apiResource('users', UsersController::class);

    Route::apiResource('users', UsersController::class)->except(['update']);
    Route::put('users/{user}', [UsersController::class, 'replace']);
    Route::patch('users/{user}', [UsersController::class, 'update']);

    // a type of users, users tickets will be filtered through this

    Route::apiResource('authors', AuthorsController::class)->except('store', 'update', 'delete');
    Route::apiResource('authors.tickets', AuthorTicketController::class)->except(['update']);
    Route::put('authors/{author}/tickets/{ticket}', [ApiV1TicketController::class, 'replace']);
    Route::patch('authors/{author}/tickets/{ticket}', [ApiV1TicketController::class, 'update']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
