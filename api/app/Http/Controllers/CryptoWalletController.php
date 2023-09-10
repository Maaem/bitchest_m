<?php

namespace App\Http\Controllers;

use App\Events\CryptoProfits;
use App\Events\CryptoPurchase;
use App\Events\CryptoSale;
use App\Http\Requests\StoreCryptoWalletRequest;
use App\Models\CryptoWallet;
use App\Models\Currency;
use App\Models\CurrencyHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CryptoWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCryptoWalletRequest $request)
    {
        try {
            $data = CryptoWallet::create($request->validated());
            CryptoPurchase::dispatch($data);
            return Response::json(
                [
                    "message" => "L'opération s'est déroulée avec succès",
                    "status" => \Illuminate\Http\Response::HTTP_OK,
                ],
                \Illuminate\Http\Response::HTTP_CREATED,
            );
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CryptoWallet $cryptoWallet)
    {
        try {
            // Vous pouvez maintenant accéder aux données spécifiques aux transactions de crypto-monnaie
            $cryptoCurrency = $cryptoWallet->currency;
            $purchaseDate = $cryptoWallet->purchase_date;
            $purchasePrice = $cryptoWallet->purchase_price;
            $salePrice = $cryptoWallet->sale_price;
            $profit = $cryptoWallet->profit;

            // Vous pouvez les inclure dans la réponse JSON
            return Response::json(
                [
                    "crypto_name" => $cryptoCurrency->crypto_name,
                    "purchase_date" => $purchaseDate,
                    "purchase_price" => $purchasePrice,
                    "sale_price" => $salePrice,
                    "profit" => $profit,
                ],
                \Illuminate\Http\Response::HTTP_OK
            );
        } catch (\Exception $exception) {
            return $exception;
        }
    }





    public function delete(CryptoWallet $cryptoWallet)
    {
        try {
            $quotingForSell = CurrencyHistory::whereDate("date", now())
                ->where("currency_id", "=", $cryptoWallet->currency_id)
                ->firstOrFail();
            $cryptoToDeleted = CryptoWallet::where("currency_id", "=", $cryptoWallet->currency_id)
                ->where("user_id", "=", $cryptoWallet->user_id)
                ->get()
                ->each(function ($item) {
                    $item->delete();
                });
            $ids = $cryptoToDeleted->map(function ($item) {
                return $item->id;
            });
            $benef = CryptoSale::dispatch($quotingForSell, $cryptoToDeleted);
            $diff = CryptoProfits::dispatch($cryptoToDeleted);
            $capital_gain = $benef[0] - $diff[0];
            $withTrashed = CryptoWallet::onlyTrashed()
                ->whereIn("id", $ids)
                ->get();
            $withTrashed->each->update(["capital_gain" => $capital_gain]);
            return Response::json(
                [
                    "message" => "L'opération s'est déroulée avec succès",
                    "status" => \Illuminate\Http\Response::HTTP_OK,
                ],
                \Illuminate\Http\Response::HTTP_CREATED,
            );
        } catch (\Exception) {
        }
    }
}
