<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\Abilities;

class UpdateTicketRequest extends BaseTicketRequest
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

    // This defines the validation rules for the request’s payload.
    public function rules(): array
    {
        $rules = [
            'data.attributes.title' => ['sometimes', 'string'],
            'data.attributes.description' => ['sometimes', 'string'],
            'data.attributes.status' => ['sometimes', 'string', 'in:A,C,H,X'],

            // author id only needs to be seperated for the tickets route not the user routes
            'data.relationships.author.data.id' => ['sometimes', 'integer'],
        ];

        // If the token only allows the user to update their own tickets, then you prohibit editing the author id.
        if ($this->user()->tokenCan(Abilities::UpdateOwnTicket)) {
            $rules['data.relationships.author.data.id'] = 'prohibited';
        }

        return $rules;
    }
}
