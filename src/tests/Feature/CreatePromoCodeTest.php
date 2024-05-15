<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreatePromoCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_promoCode_creation(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(200);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'promo_code' => [
                'id',
                'code',
                'discount',
                'discount_type',
                'max_uses',
                'max_uses_per_user',
                'users_ids',
                'expires_at',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_expires_at(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2020-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'expires_at',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_discount_type(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'invalid',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'discount_type',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_code_max_length(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => Str::random(256),
            'discount' => 10,
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'code',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_expires_at_date_format(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => 'invalid',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'expires_at',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_expires_at_after_today_date_format(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2020-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'expires_at',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_discount_required(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'discount',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_discount_type_required(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'discount_type',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_discount_type_in(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'invalid',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'discount_type',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_discount_integer(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 'invalid',
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'discount',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_max_uses_integer(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'percentage',
            'max_uses' => 'invalid',
            'max_uses_per_user' => 2,
            'users_ids' => [1, 2, 3],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'max_uses',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_max_uses_per_user_integer(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 'invalid',
            'users_ids' => [1, 2, 3],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'max_uses_per_user',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_users_ids_array(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => 'invalid',
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'users_ids',
            ],
        ]);
    }

    public function test_promoCode_creation_failure_on_users_ids_array_values_integer(): void
    {
        // generate a test for create promo code http request
        $response = $this->postJson('/api/admin/promo-codes', [
            'code' => 'TESTCODE',
            'discount' => 10,
            'discount_type' => 'percentage',
            'max_uses' => 10,
            'max_uses_per_user' => 2,
            'users_ids' => ['invalid'],
            'expires_at' => '2024-12-31',
        ]);

        // assert the response status code
        $response->assertStatus(422);

        // assert the response date structure
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'users_ids.0',
            ],
        ]);
    }
}
