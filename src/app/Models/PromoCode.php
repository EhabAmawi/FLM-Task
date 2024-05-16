<?php

namespace App\Models;

use App\Enums\PromoCodeDiscountType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use SoftDeletes, hasFactory;

    protected $table = 'promo_codes';

    protected $fillable = [
        'code',
        'expires_at',
        'discount',
        'discount_type',
        'max_uses',
        'max_uses_per_user',
        'users_ids',
    ];

    protected $casts = [
        'users_ids' => 'array',
        'expires_at' => 'date',
        'discount_type' => PromoCodeDiscountType::class,
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(PromoCodeUsage::class);
    }
}
