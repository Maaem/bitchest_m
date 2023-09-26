<?php

namespace App\Events;

use App\Models\CryptoWallet;
use App\Models\CurrencyHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CryptoSale
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public CurrencyHistory $currencyHistory,
        public Collection $cryptoToDeleted,
    ) {
        dd("CryptoSale event triggered!", $currencyHistory, $cryptoToDeleted);
}
}
