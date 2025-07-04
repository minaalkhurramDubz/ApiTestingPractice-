<?php

namespace App\Http\Requests\Api\V1;

class StoreUserRequest extends BaseUserRequest
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
            'data.attributes.name' => ['required', 'string'],
            'data.attributes.email' => ['required', 'email'],
            'data.attributes.isManager' => ['required', 'boolean'],
            'data.attributes.password' => ['required', 'string'],
        ];

        return $rules;
    }
}
