<?php

namespace App\DTOs;

readonly class ValidatePromoCodeDTO
{
    public function __construct(
        public float $price,
        public string $code,
        public int $user_id,
    ) {
    }
}
