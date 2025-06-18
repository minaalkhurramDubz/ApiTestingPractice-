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
            'attributes'=> $this->description,
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
    'links'=>[
        ['self'=>'todo']

    ]
]
             ]];
      

    }
}
