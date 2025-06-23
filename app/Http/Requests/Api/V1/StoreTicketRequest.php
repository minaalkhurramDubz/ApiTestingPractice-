<?php

namespace App\Http\Requests\Api\V1;

// this class to handle incoming POST requests (like creating a ticket) — in a clean, organized way. Instead of writing validation rules inside your controlle

class StoreTicketRequest extends BaseTicketRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        // defines the format/ the required field client should send in a post request
        // base rule needed for all routes
        $rules = [
            'data.attributes.title' => ['required', 'string'],
            'data.attributes.description' => ['required', 'string'],
            'data.attributes.status' => ['required', 'string', 'in:A,C,H,X'],

            // author id only needs to be seperated for the tickets route not the user routes
            // 'data.relationships.author.data.id' => ['required', 'integer'],
        ];

        // if the route is for tickets post request then data id rules is added
        if ($this->routeIs('tickets.store')) {
            $rules['data.relationships.author.data.id'] = 'required|integer';

        }

        return $rules;
    }

    // this function displays messages, like if user enters invalid data and displays message

}
