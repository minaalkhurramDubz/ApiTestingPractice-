<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

// this class to handle incoming POST requests (like creating a ticket) — in a clean, organized way. Instead of writing validation rules inside your controlle

class BaseTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    // this function displays messages, like if user enters invalid data and displays message

    public function messages()
    {
        return [
            'data.attributes.status' => ' The data.attributes.status value is invalid, please user : A , C , H , X ',
        ];
    }

    public function mappedAttributes()
    {
        // thos function is for the patch method to build an array depending on the required changes

        // keys are the data attributes
        $attributeMap = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
            'data.relationships.author.data.id' => 'user_id',
        ];

        $attributesToUpdate = [];
        // iterate over the array and check what is required

        foreach ($attributeMap as $key => $attribute) {

            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);

            }
        }

        return $attributesToUpdate;

    }
}
