<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperCurrency
 */
class Currency extends Model
{
    use HasFactory;

    public function cryptoWallets(): HasMany
    {
        return $this->hasMany(CryptoWallet::class);
    }
    public function currencyHistories(): HasMany
    {
        return $this->hasMany(CurrencyHistory::class);
    }
}
