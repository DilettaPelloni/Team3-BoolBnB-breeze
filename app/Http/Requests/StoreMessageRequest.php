<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'apartmentId' => 'required|exists:apartments,id',
            'content' => 'required|max:3000|string',
            'sender_email' => 'required|string|max:255',
            'sender_name' => 'required|string|max:255',
        ];
    }
}
