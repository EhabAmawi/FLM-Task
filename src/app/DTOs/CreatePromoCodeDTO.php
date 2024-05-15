<?php

namespace App\DTOs;

use App\Enums\PromoCodeDiscountType;

readonly class CreatePromoCodeDTO
{
    public function __construct(
        public ?string $code,
        public ?string $expires_at,
        public ?int $max_uses,
        public ?int $max_uses_per_user,
        public ?array $users_ids,
        public int $discount,
        public PromoCodeDiscountType $discount_type,
    ) {
    }
}
