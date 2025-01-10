<?php

namespace App\Http\Requests;

class UpdateClothingRequest extends StoreClothingRequest
{
    public function rules()
    {
        return parent::rules(); // ofcos we can use ignore id when updating the model and so on
    }
}
