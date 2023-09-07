<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param LoginStoreRequest $request
     * @return Response
     */
    public function login(LoginStoreRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            return response(
                ["message" => "Utilisateur authentifié", "status" => 201, "user" => $user->role],
                Response::HTTP_OK,
            );
        }
        return response(["message" => "Les informations sont incorrectes.", "status" => 401], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard("web")->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return response(["message" => "Utilisateur déconnecter", "status" => 200], 200);
    }
}
