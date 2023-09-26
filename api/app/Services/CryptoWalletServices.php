<?php

namespace App\Services;

use App\Http\Requests\StoreCryptoWalletRequest;
use App\Models\CryptoWallet;
use App\Models\CurrencyHistory;
use Illuminate\Database\Eloquent\Collection;

class CryptoWalletServices
{
    public function __construct(
        protected CryptoWallet $cryptoWallet,
        protected CurrencyHistory $currencyHistory,
    ) {
    }

    public function purchaseCurrency(StoreCryptoWalletRequest $request)
    {
        return $this->cryptoWallet::create($request->validated());
    }

    public function deleteCrypto(CryptoWallet $cryptoWallet)
    {
        return $this->cryptoWallet->sellCrypto($cryptoWallet);
    }

    public function getId($cryptoToDeleted)
    {
        return $cryptoToDeleted->map(function ($item) {
            return $item->id;
        });
    }

    public function calculateCapitalGain(array $benef, array $diff): array
    {
        $longueur = count($benef);
        $capital_gain = [];
        for ($i = 0; $i < $longueur; $i++) {
            array_push($capital_gain, $benef[$i] - $diff[$i]);
        }
        return $capital_gain;
    }

    public function fillCapitalGainValue($deletedCrypto, $capital_gain): void
    {
        $deletedCrypto->each(function (CryptoWallet $item, $key) use ($capital_gain) {
            $item->update(["capital_gain" => $capital_gain[$key]]);
        });
    }

    private function getPurchasedDate(
        Collection|CryptoWallet $deletedCrypto,
    ): \Illuminate\Support\Collection {
        return $deletedCrypto->map(function ($item) {
            return $item->created_at->format("Y-m-d");
        });
    }

    private function getQuantityForDeletedItem(
        Collection|CryptoWallet $deletedCrypto,
    ): array|\Illuminate\Support\Collection {
        return $deletedCrypto->map(function ($item) {
            return $item->quantity;
        });
    }

    private function getQuotingAtPurchasedDate(
        \Illuminate\Support\Collection $dates,
        $deletedCrypto,
    ) {
        return $this->currencyHistory->getQuotingForDates($dates, $deletedCrypto);
    }

    public function calculatePurchaseAmount($deletedCrypto)
    {
        $dates = $this->getPurchasedDate($deletedCrypto);
        $quantityCurrencies = $this->getQuantityForDeletedItem($deletedCrypto);
        $quotingAtPurchaseDate = $this->getQuotingAtPurchasedDate($dates, $deletedCrypto);
        $results = [];
        if (count($quantityCurrencies) === count($quotingAtPurchaseDate)) {
            $longueur = count($quantityCurrencies);
            for ($i = 0; $i < $longueur; $i++) {
                array_push($results, $quantityCurrencies[$i] * $quotingAtPurchaseDate[$i]);
            }
        } else {
            $quantity = $quantityCurrencies->reduce(function ($val, $acc) {
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
