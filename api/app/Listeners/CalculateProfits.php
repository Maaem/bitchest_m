<?php

namespace App\Listeners;

use App\Events\CryptoProfits;
use App\Models\CurrencyHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculateProfits
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
    public function handle(CryptoProfits $event)
    {
        $purchaseDate = $event->cryptoToDeleted->map(function ($item) {
            return $item->created_at->format("Y-m-d");
        });
        $numberOfCurrency = $event->cryptoToDeleted->map(function ($item) {
            return $item->quantity;
        });
        $quotingAtPurchaseDate = CurrencyHistory::whereIn("date", $purchaseDate)
            ->where("currency_id", $event->cryptoToDeleted->first()->currency_id)
            ->get()
            ->map(function ($item) {
                return $item->quoting;
            });
        $results[] = [];
        if (count($numberOfCurrency) === count($quotingAtPurchaseDate)) {
            $longueur = count($numberOfCurrency);
            for ($i = 0; $i < $longueur; $i++) {
                array_push($results, $numberOfCurrency[$i] * $quotingAtPurchaseDate[$i]);
            }
            $results = array_sum($results);
        } else {
            $quantity = $numberOfCurrency->reduce(function ($val, $acc) {
                return $val + $acc;
            });
            $results = $quotingAtPurchaseDate->map(function ($val) use ($quantity) {
                return $val * $quantity;
            });
            $results = $results[0];
        }
        return $results;
    }
}
