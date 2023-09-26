<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["email", "password", "role"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "email_verified_at" => "datetime",
        "password" => "hashed",
    ];

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function cryptoWallets(): HasMany
    {
        return $this->hasMany(CryptoWallet::class);
    }

    public function getUserCryptoWalletListWithTrashed(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this::with([
            "wallet",
            "cryptoWallets" => function (HasMany $query) {
                $query
                    ->select([
                        "user_id",
                        "currency_id",
                        \DB::raw("SUM(capital_gain) as capital_gain"),
                        \DB::raw("SUM(quantity) as quantity"),
                    ])
                    ->groupBy(["user_id", "currency_id"])
                    ->withTrashed();
            },
            "cryptoWallets.currency",
        ])
            ->where("id", \Auth::user()->id)
            ->get();
    }

    public function getUserCryptoWalletListDetailsWithTrashed(
        Currency $currency,
    ): \Illuminate\Database\Eloquent\Collection|array {
        return $this::with([
            "wallet",
            "cryptoWallets" => function (HasMany $query) use ($currency) {
                return $query->where("currency_id", $currency->id)->withTrashed();
            },
            "cryptoWallets.currency",
        ])
            ->where("id", \Auth::user()->id)
            ->get();
    }

    public function getAllUsersExceptConnectedOne()
    {
        return $this::all()
            ->sortByDesc("created_at")
            ->where("id", "!=", Auth::user()->id);
    }
}
