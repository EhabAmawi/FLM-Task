<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Handlers\ValidatePromoCodeHandler;
use App\Http\Requests\ValidatePromoCodeRequest;

class ValidatePromoCodeController extends Controller
{
    public function __construct(
        private readonly ValidatePromoCodeHandler $handler,
    ) {
    }

    public function __invoke(ValidatePromoCodeRequest $request): JsonResponse
    {
        return $this->handler->handle($request->getDTO());
    }
}
