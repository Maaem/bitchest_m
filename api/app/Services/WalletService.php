<?php

namespace App\Services;

use App\Models\CurrencyHistory;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Collection;

class WalletService
{
    public function __construct(
        protected Wallet $wallet,
        protected CurrencyHistory $currencyHistory,
    ) {
    }

    public function createUserWallet(User $user): void
    {
        $user->wallet()->create(["quantity" => 500]);
    }

    public function creditUserWallet(
        CurrencyHistory $quotingForDeletedCrypto,
        Collection $deletedCrypto,
    ): array {
        $capitalGainEachCrypto = $deletedCrypto->map(function ($item) use (
            $quotingForDeletedCrypto,
        ) {
            return $item->quantity * $quotingForDeletedCrypto->quoting;
        });
        $userWallet = $this->wallet->getUserWallet();
        $userWallet->update(["quantity" => $userWallet->quantity + $capitalGainEachCrypto->sum()]);
        return $capitalGainEachCrypto->toArray();
    }
}
