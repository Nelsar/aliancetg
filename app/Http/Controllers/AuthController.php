<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdatePasswordRequest;


class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
        $this->middleware('auth:user-api', [
            'except' => ['login', 'register']
        ]);
    }

    public function login(LoginRequest $request)
    {
        $getrequest = $request->validated();
        $email = $this->authService->checkEmailIinPhone($getrequest['email']);

        if(!$email) {
            return response()->json([
                'message' => 'Такого Email, Номера тел, ИИН не существует!',
                'errors' => [
                    'email' => ['Такого Email, Номера тел, ИИН не существует!']
                ]
            ], 422);
        }

        $getrequest['email'] = $email;

        if(!$this->authService->checkStatus($getrequest)) {
            $this->logout();

            return response()->json([
                'message' => 'Ваш акаунт был Деактивирован Администратором сайта',
            ]);
        }

        if(!$token = $this->authService->login($getrequest)) {
            return response()->json(['message' => 'Неавторизованный'], 401);
        }

        return response()->json($this->authService->respondWithToken($token));
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!$this->authService->checkPhoneInvite($data['phone_invite'])) {
            return response()->json([
                'error' => [
                    'message' => 'Номер пригласившего не найден!',
                ]
            ], 422);
        }
        
        try {
            $this->authService->registerUser($data);

        } catch (\Exception $e) {
            return response()->json([
                'message' => config('sessionmessages.an_error_has_occurred'),
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => config('sessionmessages.successfully_registered'),
        ], 201);
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $getrequest = $request->validated();
        $user = Auth::user();

        try {
            $this->authService->updateUser($user, $getrequest);
        } catch(\Exception $e) {
            return response()->json([
                'message' => config('sessionmessages.an_error_has_occurred'),
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => config('sessionmessages.successfully_updated'),
        ], 201);
    }

    public function passwordUpdate(UpdatePasswordRequest $request): JsonResponse
    {
        $getrequest = $request->validated();

        try{
            if ($this->authService->passwordCheckAndUpdate($getrequest)) {
                return response()->json([
                    'message' => 'Пароль успешно обновлено!'
                ]);
            }

        } catch(\Exception $e) {
            return response()->json([
                'message' => config('sessionmessages.an_error_has_occurred'),
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Неправильный пароль!'
        ], 400);
    }

    public function me(): JsonResponse
    {
        return response()->json([
            'user' => new UserResource(Auth::user())
        ], 200);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json(['message' => config('sessionmessages.successfully_logged_out')]);
    }
}
