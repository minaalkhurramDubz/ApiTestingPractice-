<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// controller handles subqueries for the authors, tickets are a child of author, author has a ticket
class AuthorTicketController extends ApiController
{
    public function index($author_id, TicketFilter $filters)
    {
        $query = Ticket::query()->where('user_id', $author_id);

        $filtered = $filters->apply($query);

        return TicketResource::collection($filtered->paginate());
    }

    public function store($author_id, StoreTicketRequest $request)
    {
        // this stores the data for the post request

        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $author_id,
        ];

        return new TicketResource(Ticket::create($model));
    }

    public function destroy($author_id, $ticket_id)
    {
        // for deleting requests

        // find the resource to be deleted ( check if it exists basicaslly )

        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {

                $ticket->delete();

                return $this->ok('Ticket successfully deleted ');

            }

            return $this->error('Ticket not found ', 404);

        } catch (ModelNotFoundException $exception) {

            return $this->error('Ticket not found ', 404);

        }
    }

    public function replace(ReplaceTicketRequest $request, $author_id, $ticket_id)
    {

        // this stores the data for the post request

        // check if user exists

        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {

                // if the ticket exists , update the model
                $ticket->update($request->mappedAttributes());

                return new TicketResource($ticket);
            }

            // todo: ticket doesnt belong to user

        } catch (ModelNotFoundException $exception) {

            return $this->error('Ticket not found ', 404);

        }

    }

    public function update(UpdateTicketRequest $request, $author_id, $ticket_id)
    {

        // this stores the data for the post request

        // check if user exists

        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {

                // if the ticket exists , update the model

                $ticket->update($request->mappedAttributes());

                return new TicketResource($ticket);
            }

            // todo: ticket doesnt belong to user

        } catch (ModelNotFoundException $exception) {

            return $this->error('Ticket not found ', 404);

        }

    }
}
