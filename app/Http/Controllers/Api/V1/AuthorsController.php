<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\filters\V1\AuthorFilter;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuthorFilter $filters)
    {

        return UserResource::collection(User::filter($filters)->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $author)
    {
        if ($this->include('tickets')) {
            $author->load('tickets');
        }
        // dd($user->tickets);

        return new UserResource($author);

    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id, $ticket_id)
    {
        // for deleting requests

        /* find the resource to be deleted ( check if it exists basicaslly )

        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {

                $ticket->delete();

                return $this->ok('Ticket successfully deleted ');

            }

            return $this->error('Ticket not found ', 404);

        } catch (ModelNotFoundException $exception) {

            return $this->error('Ticket not found ', 404);

        }*/
    }
}
