<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */



   //  public static $wrap='ticket';


    public function toArray(Request $request): array
    {

        // design payload here 

        // only this information will be displayed in the response paylod 
        return [
            'type'=>'ticket',
            'id'=>$this->id,
            'attributes'=>[
                'title'=>$this->title,
// the when function will only display the description if the route is for tickets.show ( wont shows description for tickets list but will show it when single ticket req is sent )
            'description'=> $this->when( 
                $request->routeIs('tickets.show'),
            $this->description ),
            'status'=> $this->status,
             'createdAt'=> $this->created_at,
             'updatedAt'=> $this->updated_at],

             'links'=>[
                ['self'=>route('tickets.show',['ticket'=>$this->id])]
             ],

             'relationships'=>[
'author'=>[
    'data'=>[
        'type'=>'user',
        'id'=>$this->user_id
    ],

    'includes'=>[
        new UserResource($this->user)
        

    ],
    'links'=>[
        ['self'=>'todo']

    ]
]
             ]];
      

    }
}
