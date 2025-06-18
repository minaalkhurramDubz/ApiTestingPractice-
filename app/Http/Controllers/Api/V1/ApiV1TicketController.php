<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;


// inherit the api controller instead of general controller because it has the include method 
class ApiV1TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        if($this->include('author'))
        {
            return  TicketResource::collection(Ticket::with('user')->paginate());

        }
        
        
        //returns all the records  from the tickets table as json response 

        return TicketResource::collection(Ticket::paginate()); 
        // use the ticket resource to transalte the payload 

        

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {


        if($this->include('author'))
        {
            return  new TicketResource($ticket->load('user'));

        }
           

        // returns a single ticket , resource transalates the ticket into json sturcture 
        return new TicketResource($ticket);
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
    public function destroy(Ticket $ticket)
    {
        //
    }
}
