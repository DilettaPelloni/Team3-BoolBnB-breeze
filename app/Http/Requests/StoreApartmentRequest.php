<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:apartments,title',
            'description' => 'nullable|max:3000',
            'rooms' => 'required|numeric|max:10|min:1',
            'beds' => 'required|numeric|max:10|min:1',
            'bathrooms' => 'required|numeric|max:4|min:1',
            'size' => 'required|numeric|max:300|min:12',
            'address' => 'required|string|max:255',
            "latitude" => "required|numeric|between:-90,90",
            "longitude" => "required|numeric|between:-180,180",
            'cover_img' => 'required|max:2048|image',
            'visible' => 'boolean|required',
            'activeServices' => 'nullable|array|exists:services,id'
        ];
    }
}
