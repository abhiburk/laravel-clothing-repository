<?php

namespace App\Http\Requests;

use App\Enums\ClothingSizeEnums;
use App\Enums\GenderEnums;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class StoreClothingRequest extends FormRequest
{
    public string $sizes;
    public string $gender;

    public function rules()
    {
        $this->sizes = implode(',', ClothingSizeEnums::all());
        $this->gender = implode(',', GenderEnums::all());

        return [
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'size' => 'required|string|max:255|in:' . $this->sizes,
            'colour' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'gender' => 'required|string|in:' . $this->gender,
        ];
    }

    public function messages()
    {
        return [
            'brand.required' => 'Brand is required.',
            'type.required' => 'Type is required.',
            'size.required' => 'Size is required.',
            'colour.required' => 'Colour is required.',
            'price.required' => 'Price is required.',
            'price.min' => 'Price must be greater than zero.',
            'gender.required' => 'Gender is required.',
            'size.in' => "The selected size is invalid. Valid values are " . $this->sizes,
            'gender.in' => "The selected gender is invalid. Valid values are " . $this->gender
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
