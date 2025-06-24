<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\filters\V1\AuthorFilter;
use App\Http\Requests\Api\V1\ReplaceUserRequest;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    protected $policyClass = UserPolicy::class;

    public function index(AuthorFilter $filters)
    {

        // only return the users that have created a ticket

        return UserResource::collection(
            User::filter($filters)->paginate()
        );
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // this stores the data for the post request

        // check if user exists

        try {
            // wether the user exists is being checked in storeticketrequests : rules() method
            //      $user = User::findOrFail($request->input('data.relationships.author.data.id'));

            // policy
            $this->isAble('store', User::class);

            return new UserResource(User::create($request->mappedAttributes()));

        } catch (AuthorizationException $exception) {
            return $this->error('You Are Not Authorized to create this resource ', 401);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        if ($this->include('tickets')) {
            $user->load('tickets');
        }
        // dd($user->tickets);

        return new UserResource($user);

    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $user_id)
    {

        try {
            // dd(2);

            $user = User::findOrFail($user_id);

            $this->isAble('update', $user);
            //   dd(2);
            // if the ticket exists , update the model
            $user->update($request->mappedAttributes());

            return new UserResource($user);

        } catch (ModelNotFoundException $exception) {

            return $this->error('User not found ', 404);

        } catch (AuthorizationException $exception) {
            return $this->error('You Are Not Authorized to update oooo', 401);

        }
    }

    public function replace(ReplaceUserRequest $request, $user_id)
    {

        // put
        // this stores the data for the post request

        // check if user exists

        try {
            $user = User::findOrFail($user_id);

            // check the policy
            $this->isAble('replace', $user);

            // if the ticket exists , update the model

            $user->update($request->mappedAttributes());

            return new UserResource($user);

        } catch (ModelNotFoundException $exception) {

            return $this->error('User not found ', 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {

        // for deleting requests

        // find the resource to be deleted ( check if it exists basicaslly )

        try {
            $user = User::findOrFail($user_id);
            $this->isAble('delete', $user);
            $user->delete();

            return $this->ok('User successfully deleted ');

        } catch (ModelNotFoundException $exception) {

            return $this->error('User not found ', 404);

        }
    }
}
