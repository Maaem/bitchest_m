<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Http\Resources\WalletResource; // Assurez-vous d'importer la ressource appropriée
use App\Http\Resources\WalletRessource;
use App\Models\Wallet;
use App\Models\CryptoWallet;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    public function show()
    {
        try {
            // Récupérer les données du portefeuille de l'utilisateur
            $userWallet = Wallet::where("user_id", Auth::user()->id)->first();

            if (!$userWallet) {
                return response()->json(['message' => 'Portefeuille introuvable.'], 404);
            }

            // Récupérer les données liées aux crypto-monnaies
            $cryptoWallets = CryptoWallet::where("user_id", Auth::user()->id)->get();

            // Vous pouvez maintenant inclure les données de crypto-monnaie dans la réponse
            $userWallet->cryptoWallets = $cryptoWallets;

            // Utilisez la ressource pour formater la réponse JSON
            return new WalletRessource($userWallet);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Une erreur s\'est produite lors de la récupération des données.'], 500);
        }
    }
}

