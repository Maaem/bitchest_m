<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientController extends Controller
{
    /**
     * Display user's wallets with aggregate quantity for each currency
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Exception
    {
        try {
            return UserResource::collection(
                User::with([
                    "wallet",
                    "cryptoWallets" => function (HasMany $query) {
                        $query
                            ->select([
                                "user_id",
                                "currency_id",
                                \DB::raw("SUM(quantity) as quantity"),
                            ])
                            ->groupBy(["user_id", "currency_id"]);
                    },
                    "cryptoWallets.currency",
                ])
                    ->where("id", \Auth::user()->id)
                    ->get(),
            );
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /***
     * Display user's wallet with data for one currency only
     * @param Currency $currency
     * @return \Exception|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(
        Currency $currency,
    ): \Exception|\Illuminate\Http\Resources\Json\AnonymousResourceCollection {
        try {
            return UserResource::collection(
                User::with([
                    "wallet",
                    "cryptoWallets" => function (HasMany $query) use ($currency) {
                        return $query->where("currency_id", $currency->id);
                    },
                    "cryptoWallets.currency",
                ])
                    ->where("id", \Auth::user()->id)
                    ->get(),
            );
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
