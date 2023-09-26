<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Wallet;
use App\Services\UserService;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, "user");
    }


    public function index()
    {
        try {
            return UserResource::collection(User::all());
        } catch (AuthorizationException $exception) {
            return $exception;
        }
    }

    
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->validated());
            $user->wallet()->create(["quantity" => 100000]);
            return Response::json(
                [
                    "message" => "L'opération s'est déroulée avec succès",
                    "status" => \Illuminate\Http\Response::HTTP_OK,
                ],
                \Illuminate\Http\Response::HTTP_OK,
            );
        } catch (ValidationException $exception) {
            return Response::json([
                "message" => $exception,
                "status" => \Illuminate\Http\Response::HTTP_OK,
            ]);
        }
    }

    public function show(User $user)
    {
        try {
            return new UserResource(User::query()->findOrFail($user->id));
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $validateData = $request->validated();
            $user->update($validateData);
            return Response::json(
                [
                    "message" => "L'utilisateur a bien été modifié'",
                    "status" => \Illuminate\Http\Response::HTTP_OK,
                ],
                \Illuminate\Http\Response::HTTP_OK,
            );
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return Response::json(
                [
                    "message" => "L'opération à été un succès",
                    "status" => \Illuminate\Http\Response::HTTP_OK,
                ],
                \Illuminate\Http\Response::HTTP_OK,
            );
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}