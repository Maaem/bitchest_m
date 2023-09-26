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
    public function getCurrenciesWithHistories(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this::with([
            "currencyHistories" => function (HasMany $query) {
                $query->orderBy("date", "desc");
            },
        ])->get();
    }

    public function getCurrencyHistory(
        Currency $currency,
    ): Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return $this::with("currencyHistories")->findOrFail($currency->id);
    }
}
