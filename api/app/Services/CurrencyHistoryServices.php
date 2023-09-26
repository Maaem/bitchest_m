<?php

namespace App\Services;

use App\Models\CryptoWallet;
use App\Models\CurrencyHistory;

class CurrencyHistoryServices
{
    public function __construct(protected CurrencyHistory $currencyHistory)
    {
    }

    public function getQuotingAtCurrentDate(
        int $currency,
    ): \Illuminate\Database\Eloquent\Model|CurrencyHistory|\Illuminate\Database\Eloquent\Builder|null {
        return $this->currencyHistory->getQuotingAtCurrentDate($currency);
    }
}
