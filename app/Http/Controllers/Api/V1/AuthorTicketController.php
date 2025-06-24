<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// controller handles subqueries for the authors, tickets are a child of author, author has a ticket
class AuthorTicketController extends ApiController
{
    protected $policyClass = TicketPolicy::class;

    public function index($author_id, TicketFilter $filters)
    {
        $query = Ticket::query()->where('user_id', $author_id);

        $filtered = $filters->apply($query);

        return TicketResource::collection($filtered->paginate());
    }

    public function store(StoreTicketRequest $request)
    {
        // this stores the data for the post request

        // check if user exists

        try {
            // wether the user exists is being checked in storeticketrequests : rules() method
            //      $user = User::findOrFail($request->input('data.relationships.author.data.id'));

            // policy
            $this->isAble('store', Ticket::class);

            return new TicketResource(Ticket::create($request->mappedAttributes(
                ['author' => 'user_id']
            )));

        } catch (AuthorizationException $exception) {
            return $this->error('You Are Not Authorized to create', 401);

        }

    }

    public function destroy($author_id, $ticket_id)
    {
        // for deleting requests

        // find the resource to be deleted ( check if it exists basicaslly )

        try {
            // fetch ticket if user exists
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            $this->isAble('delete', $ticket);

            $ticket->delete();

            return $this->ok('Ticket successfully deleted ');

        } catch (ModelNotFoundException $exception) {

            return $this->error('Ticket not found ', 404);

        } catch (AuthorizationException $exception) {
            return $this->error('You Are Not Authorized to delete', 401);

        }
    }

    public function replace(ReplaceTicketRequest $request, $author_id, $ticket_id)
    {

        // this stores the data for the post request

        // check if user exists

        try {

            // fetch ticket if user exists
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            // check the policy, permissions
            $this->isAble('replace', $ticket);

            // if the ticket and permission exists , update the model
            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);

            // todo: ticket doesnt belong to user

        } catch (ModelNotFoundException $exception) {

            return $this->error('Ticket not found ', 404);

        } catch (AuthorizationException $exception) {
            return $this->error('You Are Not Authorized to update ', 401);

        }

    }

    public function update(UpdateTicketRequest $request, $author_id, $ticket_id)
    {

        // this stores the data for the post request

        // check if user exists

        try {

            // fetch ticket if user exists
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            // check the policy, permissions
            $this->isAble('update', $ticket);

            // if the ticket and permission exists , update the model
            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);
            // todo: ticket doesnt belong to user

        } catch (ModelNotFoundException $exception) {

            return $this->error('Ticket not found ', 404);

        } catch (AuthorizationException $exception) {
            return $this->error('You Are Not Authorized to update ', 401);

        }

    }
}
