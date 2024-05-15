<?php

namespace App\Services;

use Exception;
use App\Models\PromoCode;
use Illuminate\Support\Str;
use App\DTOs\CreatePromoCodeDTO;
use App\DTOs\ValidatePromoCodeDTO;

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

    public function validatePromoCode(ValidatePromoCodeDTO $dto): PromoCode
    {
        /* @var PromoCode $promoCode */
        $promoCode = PromoCode::where('code', $dto->code)
            ->first();

        if (!$promoCode) {
            throw new Exception('Promo code not found');
        }

        if ($promoCode->expires_at?->isPast()) {
            throw new Exception('Promo code has expired');
        }

        if ($promoCode->max_uses && $promoCode->usages()->count() >= $promoCode->max_uses) {
            throw new Exception('Promo code has reached its maximum uses');
        }

        if ($promoCode->max_uses_per_user && $promoCode->usages()->where('user_id', $dto->user_id)->count() >= $promoCode->max_uses_per_user) {
            throw new Exception('Promo code has reached its maximum uses per user');
        }

        if (!in_array('*', $promoCode->users_ids) && !in_array($dto->user_id, $promoCode->users_ids)) {
            throw new Exception('Promo code is not valid for this user');
        }

        return $promoCode;
    }

    public function markPromoCodeAsUsed(PromoCode $promoCode, int $user_id): void
    {
        $promoCode->usages()->create([
            'user_id' => $user_id,
        ]);
    }
}
