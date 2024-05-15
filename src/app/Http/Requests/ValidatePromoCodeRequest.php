<?php

namespace App\Http\Requests;

use App\DTOs\ValidatePromoCodeDTO;
use Illuminate\Foundation\Http\FormRequest;

class ValidatePromoCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'price' => ['required', 'number', 'min:0.1'],
            'code' => ['required', 'string'],
        ];
    }

    public function getDTO(): ValidatePromoCodeDTO
    {
        return new ValidatePromoCodeDTO(
            price: $this->input('price'),
            code: $this->input('code'),
            user_id: $this->user()->id,
        );
    }
}
