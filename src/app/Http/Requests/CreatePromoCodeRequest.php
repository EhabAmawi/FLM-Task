<?php

namespace App\Http\Requests;

use App\DTOs\CreatePromoCodeDTO;
use App\Enums\PromoCodeDiscountType;
use Illuminate\Foundation\Http\FormRequest;

class CreatePromoCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['string', 'max:255', 'unique:promo_codes'],
            'expires_at' => ['nullable', 'date', 'after:today', 'date_format:Y-m-d'],

            'max_uses' => ['nullable', 'integer'],
            'max_uses_per_user' => ['nullable', 'integer'],

            'users_ids' => ['array'],

            'discount' => ['required', 'integer'],
            'discount_type' => ['required', 'in:percentage,value'],
        ];
    }

    public function getDTO(): CreatePromoCodeDTO
    {
        return new CreatePromoCodeDTO(
            code: $this->input('code'),
            expires_at: $this->input('expires_at'),
            max_uses: $this->input('max_uses'),
            max_uses_per_user: $this->input('max_uses_per_user'),
            users_ids: $this->input('users_ids'),
            discount: $this->input('discount'),
            discount_type: PromoCodeDiscountType::from($this->input('discount_type')),
        );
    }
}
