<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;

// controller handles subqueries for the authors, tickets are a child of author, author has a ticket
class AuthorTicketController extends Controller
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
}
