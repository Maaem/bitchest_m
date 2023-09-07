<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\CryptoWallet
 *
 * @property int $id
 * @property string|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $sell_at
 * @property string $capital_gain
 * @property int $quantity
 * @property int $user_id
 * @property int $currency_id
 * @property-read \App\Models\Currency $currency
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CryptoWalletFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet whereCapitalGain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet whereSellAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CryptoWallet withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperCryptoWallet {}
}

namespace App\Models{
/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string $crypto_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CryptoWallet> $cryptoWallets
 * @property-read int|null $crypto_wallets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CurrencyHistory> $currencyHistories
 * @property-read int|null $currency_histories_count
 * @method static \Database\Factories\CurrencyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCryptoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCurrency {}
}

namespace App\Models{
/**
 * App\Models\CurrencyHistory
 *
 * @property int $id
 * @property int $quoting
 * @property string $date
 * @property int $currency_id
 * @property-read \App\Models\Currency $currency
 * @method static \Database\Factories\CurrencyHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyHistory whereQuoting($value)
 * @mixin \Eloquent
 */
	class IdeHelperCurrencyHistory {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $role
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CryptoWallet> $cryptoWallets
 * @property-read int|null $crypto_wallets_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Wallet|null $wallet
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\WalletFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperWallet {}
}

