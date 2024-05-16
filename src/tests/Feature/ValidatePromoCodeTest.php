<?php

namespace Tests\Feature;

use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidatePromoCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_return_200_when_promo_code_is_valid(): void
    {
        $code = 'VALIDCODE';
        $price = 100;
        $discount = 10;

        $user = User::factory()->create();

        PromoCode::factory()->create([
            'code' => $code,
            'discount' => $discount,
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 1,
            'users_ids' => ['*'],
            'expires_at' => now()->addDays(),
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/promo-codes/validate', [
                'code' => $code,
                'price' => $price,
            ]);

        $response->assertStatus(200);

        $response->assertJson([
            'price' => $price,
            'promocode_discounted_amount' => $price * $discount / 100,
            'final_price' => $price - ($price * $discount / 100),
        ]);
    }

    public function test_it_should_return_404_when_promo_code_is_invalid(): void
    {
        $code = 'INVALIDCODE';
        $price = 100;

        $user = User::factory()->create();

        PromoCode::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/promo-codes/validate', [
                'code' => $code,
                'price' => $price,
            ]);

        $response->assertStatus(404);
    }

    public function test_it_should_return_404_when_promo_code_is_expired(): void
    {
        $code = 'EXPIREDCODE';
        $price = 100;

        $user = User::factory()->create();

        PromoCode::factory()->create([
            'code' => $code,
            'expires_at' => now()->subDays(),
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/promo-codes/validate', [
                'code' => $code,
                'price' => $price,
            ]);

        $response->assertStatus(404);
    }

    public function test_it_should_return_404_when_promo_code_is_not_for_user(): void
    {
        $code = 'NOTFORUSERCODE';
        $price = 100;

        $user = User::factory()->create();

        PromoCode::factory()->create([
            'code' => $code,
            'users_ids' => [User::factory()->create()->id],
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/promo-codes/validate', [
                'code' => $code,
                'price' => $price,
            ]);

        $response->assertStatus(404);
    }

    public function test_it_should_return_404_when_promo_code_is_not_for_multiple_users(): void
    {
        $code = 'NOTFORMULTIPLEUSERSCODE';
        $price = 100;

        $user = User::factory()->create();

        PromoCode::factory()->create([
            'code' => $code,
            'users_ids' => [User::factory()->create()->id, User::factory()->create()->id],
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/promo-codes/validate', [
                'code' => $code,
                'price' => $price,
            ]);

        $response->assertStatus(404);
    }

    public function test_it_should_return_404_when_promo_code_is_exceeded_max_uses(): void
    {
        $code = 'EXCEEDEDMAXUSESCODE';
        $price = 100;

        $user = User::factory()->create();

        PromoCode::factory()->create([
            'code' => $code,
            'max_uses' => 1,
            'max_uses_per_user' => 100,
        ]);

        $firstResponse = $this->actingAs($user)
            ->postJson('/api/promo-codes/validate', [
                'code' => $code,
                'price' => $price,
            ]);

        $firstResponse->assertStatus(200);

        $secondResponse = $this->actingAs($user)
            ->postJson('/api/promo-codes/validate', [
                'code' => $code,
                'price' => $price,
            ]);

        $secondResponse->assertStatus(404);
    }

    public function test_it_should_return_404_when_promo_code_is_exceeded_max_uses_per_user()
    {
        $code = 'EXCEEDEDMAXUSESPERUSERCODE';
        $price = 100;

        $user = User::factory()->create();

        PromoCode::factory()->create([
            'code' => $code,
            'max_uses' => 100,
            'max_uses_per_user' => 1,
        ]);

        $firstResponse = $this->actingAs($user)
            ->postJson('/api/promo-codes/validate', [
                'code' => $code,
                'price' => $price,
            ]);

        $firstResponse->assertStatus(200);

        $secondResponse = $this->actingAs($user)
            ->postJson('/api/promo-codes/validate', [
                'code' => $code,
                'price' => $price,
            ]);

        $secondResponse->assertStatus(404);
    }
}
