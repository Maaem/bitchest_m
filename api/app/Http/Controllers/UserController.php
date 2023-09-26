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
    /**
     * Create the controller instance.
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService)
    {
        $this->authorizeResource(User::class, "user");
    }

    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection|\Exception
     */
    public function index(): AnonymousResourceCollection|\Exception
    {
        try {
            return UserResource::collection($this->userService->getAllUsers());
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreUserRequest $request
     * @return JsonResponse|\Exception
     */
    public function store(StoreUserRequest $request): JsonResponse|\Exception
    {
        try {
            $this->userService->createUser($request);
            return Response::json(
                [
                    "message" => "L'opération s'est déroulée avec succès",
                    "status" => \Illuminate\Http\Response::HTTP_OK,
                ],
                \Illuminate\Http\Response::HTTP_OK,
            );
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * Display the specified resource.
     * @param User $user
     * @return UserResource|\Exception
     */
    public function show(User $user): UserResource|\Exception
    {
        try {
            return UserResource::make($this->userService->getUser($user));
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse|\Exception
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse|\Exception
    {
        try {
            $this->userService->updateUser($request, $user);
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

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * @return JsonResponse|\Exception$
     */
    public function destroy(User $user): JsonResponse|\Exception
    {
        try {
            $this->userService->deleteUser($user);
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