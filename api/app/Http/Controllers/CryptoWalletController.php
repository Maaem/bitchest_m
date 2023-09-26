<?php

namespace App\Http\Controllers;

use App\Events\CryptoPurchase;
use App\Http\Requests\StoreCryptoWalletRequest;
use App\Models\CryptoWallet;
use App\Services\CryptoWalletServices;
use App\Services\CurrencyHistoryServices;
use App\Services\WalletService;
use Illuminate\Support\Facades\Response;

class CryptoWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected CryptoWalletServices $cryptoWalletServices,
        protected CurrencyHistoryServices $currencyHistoryServices,
        protected WalletService $walletService,
    ) {
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
            $quotingForSell = $this->currencyHistoryServices->getQuotingAtCurrentDate(
                $cryptoWallet->currency_id,
            );
            $deletedCrypto = $this->cryptoWalletServices->deleteCrypto($cryptoWallet);

            $capitalGainAtCurrentDate = $this->walletService->creditUserWallet(
                $quotingForSell,
                $deletedCrypto,
            );
            $amountOfPurchaseDate = $this->cryptoWalletServices->calculatePurchaseAmount(
                $deletedCrypto,
            );
            $capitalGain = $this->cryptoWalletServices->calculateCapitalGain(
                $capitalGainAtCurrentDate,
                $amountOfPurchaseDate,
            );
            $this->cryptoWalletServices->fillCapitalGainValue($deletedCrypto, $capitalGain);
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

}
