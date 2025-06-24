<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

// this class to handle incoming POST requests (like creating a ticket) — in a clean, organized way. Instead of writing validation rules inside your controlle

class BaseUserRequest extends FormRequest
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

    public function mappedAttributes(array $otherAttributes = [])
    {
        // thos function is for the patch method to build an array depending on the required changes

        // keys are the data attributes
        $attributeMap = array_merge([
            'data.attributes.name' => 'name',
            'data.attributes.email' => 'email',
            'data.attributes.isManager' => 'is_manager',
            'data.attributes.password' => 'password',
        ], $otherAttributes);

        $attributesToUpdate = [];
        // iterate over the array and check what is required

        foreach ($attributeMap as $key => $attribute) {

            if ($this->has($key)) {
                // get input value of password key to compare

                $value = $this->input($key);
                if ($attribute === 'password') {
                    $value = bcrypt($value);

                }
                $attributesToUpdate[$attribute] = $this->input($key);

            }
        }

        return $attributesToUpdate;

    }
}
