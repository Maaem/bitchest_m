<?php

namespace App\Listeners;

use App\Events\CryptoSale;
use App\Models\CryptoWallet;
use App\Models\CurrencyHistory;
use App\Models\Wallet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreditUserWallet
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    // public function handle(CryptoSale $event)
    // {
    //     $benefices = $event->cryptoToDeleted
    //         ->map(function ($item) use ($event) {
    //             return $item->quantity * $event->currencyHistory->quoting;
    //         })
    //         ->sum();
    //     $userWallet = Wallet::where(
    //         "user_id",
    //         "=",
    //         $event->cryptoToDeleted->first()->user_id,
    //     )->first();
    //     $userWallet->quantity = $userWallet->quantity + $benefices;
    //     $userWallet->save();
    //     return $benefices;
    // }

    public function handle(CryptoSale $event)
    {
        $benefices = $event->cryptoToDeleted
            ->map(function ($item) use ($event) {
                // Vérification si $event->currencyHistory est nul
                if ($event->currencyHistory !== null) {
                    // Vérification si la propriété 'quoting' est définie
                    if (property_exists($event->currencyHistory, 'quoting')) {
                        return $item->quantity * $event->currencyHistory->quoting;
                    }
                }
                // Gérer le cas où $event->currencyHistory est nul ou la propriété 'quoting' n'est pas définie
                return 0; // Ou une autre valeur par défaut appropriée
            })
            ->sum();

        $userWallet = Wallet::where(
            "user_id",
            "=",
            $event->cryptoToDeleted->first()->user_id,
        )->first();

        $userWallet->quantity = $userWallet->quantity + $benefices;
        $userWallet->save();

        return $benefices;
    }
}
