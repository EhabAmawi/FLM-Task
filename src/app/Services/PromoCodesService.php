<?php

namespace App\Services;

use App\DTOs\CreatePromoCodeDTO;
use App\Models\PromoCode;
use Illuminate\Support\Str;

class PromoCodesService
{
    public function createPromoCode(CreatePromoCodeDTO $dto): PromoCode
    {
        return PromoCode::create([
            'code' => $dto->code ?? Str::random(8),
            'expires_at' => $dto->expires_at,
            'max_uses' => $dto->max_uses,
            'max_uses_per_user' => $dto->max_uses_per_user,
            'discount' => $dto->discount,
            'discount_type' => $dto->discount_type,
            'users_ids' => $dto->users_ids ?? ['*'],
        ]);
    }
}
