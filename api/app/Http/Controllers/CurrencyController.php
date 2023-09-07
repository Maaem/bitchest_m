<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return CurrencyResource::collection(
                Currency::with([
                    "currencyHistories" => function (HasMany $query) {
                        $query->orderBy("date", "desc");
                    },
                ])->get(),
            );
        } catch (\Exception $exception) {
        }
        return $exception;
    }

    public function show(Currency $currency)
    {
        try {
            return new CurrencyResource(
                Currency::with("currencyHistories")->findOrFail($currency->id),
            );
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
