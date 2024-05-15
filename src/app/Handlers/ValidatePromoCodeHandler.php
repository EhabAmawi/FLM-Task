<?php

namespace App\Handlers;

use Illuminate\Http\JsonResponse;
use App\DTOs\ValidatePromoCodeDTO;
use App\Enums\PromoCodeDiscountType;
use App\Services\PromoCodesService;

readonly class ValidatePromoCodeHandler
{
    public function __construct(
        private PromoCodesService $service,
    ) {
    }

    public function handle(ValidatePromoCodeDTO $dto): JsonResponse
    {
        try {
            $promoCode = $this->service->validatePromoCode($dto);
        } catch (\Exception $e) {
            return response()->json([
                'error_message' => $e->getMessage(),
            ], 404);
        }
        $this->service->markPromoCodeAsUsed($promoCode, $dto->user_id);

        $price = $dto->price;
        $priceAfterDiscount = match ($promoCode->discount_type) {
            PromoCodeDiscountType::Percentage => $price - ($price * $promoCode->discount / 100),
            PromoCodeDiscountType::Fixed => $price - $promoCode->discount,
        };
        $discountAmount = $price - $priceAfterDiscount;

        return response()->json([
            'price' => $dto->price,
            'promocode_discounted_amount' => $discountAmount,
            'final_price' => $priceAfterDiscount,
        ]);
    }
}
