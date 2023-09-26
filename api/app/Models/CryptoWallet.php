<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon; 

/**
 * @mixin IdeHelperCryptoWallet
 */
class CryptoWallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ["sell_at"];

    const DELETED_AT = "sell_at";

    protected $fillable = [
        "quantity",
        "user_id",
        "currency_id",
        "purchase_price",
        "capital_gain",
        "selling_price",
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Méthode d'accessor pour Prix d'achat
    public function getPurchasePriceAttribute()
    {
        return $this->attributes['purchase_price'];
    }

    // Méthode d'accessor pour Prix de vente
    public function getSellingPriceAttribute()
    {
        return $this->attributes['selling_price'];
    }

    // Méthode d'accessor pour Plus-values
    public function getProfitsAttribute()
    {
        // Calculez la Plus-value en soustrayant le Prix d'achat du Prix de vente
        return $this->attributes['selling_price'] - $this->attributes['purchase_price'];
    }

    // Méthode d'accessor pour updated_at
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d'); // Formate la date comme vous le souhaitez
    }
    public function sellCrypto(CryptoWallet $cryptoWallet): CryptoWallet|Collection
    {
        return $this::where("id", "=", $cryptoWallet->id)
            ->where("user_id", "=", $cryptoWallet->user_id)
            ->get()
            ->each(function ($item) {
                $item->delete();
            });
    }
}
