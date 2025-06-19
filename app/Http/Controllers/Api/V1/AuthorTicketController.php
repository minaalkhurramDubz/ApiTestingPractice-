<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Filters\V1\AuthorFilter;
use App\Http\Resources\V1\TicketResource;
use Illuminate\Http\Request;

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

}
