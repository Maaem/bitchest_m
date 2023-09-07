<?php

namespace App\Listeners;

use App\Events\CryptoPurchase;
use App\Models\CurrencyHistory;
use App\Models\Wallet;

class DebitUserWallet
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
    // public function handle(CryptoPurchase $event): void
    // {
    //     $quoting = CurrencyHistory::whereDate("date", now())
    //         ->where("currency_id", "=", $event->cryptoWallet->currency_id)
    //         ->first(["quoting"]);
    //     $userWallet = Wallet::where("user_id", "=", $event->cryptoWallet->user_id)->first();
    //     $debit = $quoting->quoting * $event->cryptoWallet->quantity;
    //     $userWallet->quantity = $userWallet->quantity - $debit;
    //     $userWallet->save();
    // }

    public function handle(CryptoPurchase $event): void
    {
        // Recherche du taux de change dans CurrencyHistory
        $quoting = CurrencyHistory::whereDate("date", now())
            ->where("currency_id", "=", $event->cryptoWallet->currency_id)
            ->first(["quoting"]);

        // Vérification si $quoting est null
        if ($quoting !== null) {
            $userWallet = Wallet::where("user_id", "=", $event->cryptoWallet->user_id)->first();
            $debit = $quoting->quoting * $event->cryptoWallet->quantity;
            $userWallet->quantity = $userWallet->quantity - $debit;
            $userWallet->save();
        } else {
            // Gérez le cas où $quoting est null
            // Vous pouvez enregistrer un message d'erreur, lancer une exception ou prendre d'autres mesures appropriées.
        }
    }
}
