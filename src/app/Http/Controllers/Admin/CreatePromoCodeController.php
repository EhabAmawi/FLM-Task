<?php

namespace App\Http\Controllers\Admin;

use App\Services\PromoCodesService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePromoCodeRequest;
use Illuminate\Http\JsonResponse;

class CreatePromoCodeController extends Controller
{
    public function __construct(
        private readonly PromoCodesService $service,
    ) {
    }

    public function __invoke(CreatePromoCodeRequest $request): JsonResponse
    {
        $dto = $request->getDTO();
        $promoCode = $this->service->createPromoCode($dto);

        return response()->json([
            'message' => 'Promo code created successfully',
            'promo_code' => $promoCode,
        ]);
    }
}
