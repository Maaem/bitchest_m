<?php

namespace App\Http\Controllers;

use App\Http\Resources\WalletRessource;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function show()
    {
        try {
            return WalletRessource::make(Wallet::where("user_id", \Auth::user()->id)->first());
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
