<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// inherit the api controller instead of general controller because it has the include method
class ApiV1TicketController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filters)
    {

        /*old method , we are changing this to handle all filters in resources
                if($this->include('author'))
                {
                    return  TicketResource::collection(Ticket::with('user')->paginate());

                }


                //returns all the records  from the tickets table as json response

                return TicketResource::collection(Ticket::paginate());
                // use the ticket resource to transalte the payload

                */

        // the filters variable will contain all the query param filters for the resource

        // $filters=>status($value);

        // return TicketResource::collection(Ticket::filter($filters)->paginate());

        $query = Ticket::filter($filters);

        // If request includes relationships like 'include=user'

        return TicketResource::collection($query->paginate());

    }

    /**
     * Show the form for creating a new resource.
     */
    /* public function create()
     {
         //not implemented yet
     }*/

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        // this stores the data for the post request

        // check if user exists

        try {
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));

        } catch (ModelNotFoundException $exception) {
            return $this->ok('User not found', [
                'error' => ' The provided user id does not exist ',
            ]);
        }

        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $request->input('data.relationships.author.data.id'),
        ];

        return new TicketResource(Ticket::create($model));
    }

    /**
     * Display the specified resource.
     */
    public function show($ticket_id)
    {
        // the try catch here , handles requests for tickets that have been deleted / not exists
        try {

            $ticket = Ticket::findOrFail($ticket_id);
            if ($this->include('author')) {
                return new TicketResource($ticket->load('user'));

            }

            // returns a single ticket , resource transalates the ticket into json sturcture
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $exception) {

            return $this->error('Ticket not found ', 404);

        }

    }

    /**
     * Show the form for editing the specified resource.
     */

    /*
    public function edit(Ticket $ticket)
    {
       //not implemented yet
    }*/

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        // for deleting requests

        // find the resource to be deleted ( check if it exists basicaslly )

        try {
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->delete();

            return $this->ok('Ticket successfully deleted ');

        } catch (ModelNotFoundException $exception) {

            return $this->error('Ticket not found ', 404);

        }
    }
}
