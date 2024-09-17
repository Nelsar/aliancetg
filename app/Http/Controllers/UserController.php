<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\Auth\RegisterRequest;



class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:все-пользователи', ['only' => ['index','show']]);
        $this->middleware('permission:создание-пользователя', ['only' => ['create','store']]);
        $this->middleware('permission:редактирование-пользователя', ['only' => ['edit','update', 'updateUserStatus']]);
        $this->middleware('permission:удаление-пользователя', ['only' => ['destroy']]);
    }
    public function store(Request $request)
    {
        $data = $request->validated();

        try{

            $adminEmail = config('mail.from.address');
            $m = ' Логин и Пароль отправлен на эту почту ' . $adminEmail;
            $this->userService->createUser($data, $adminEmail);

        } catch(\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }

        return redirect()->route('admin.users.index')->with('success', config('sessionmessages.successfully_added') . $m);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!$this->userService->checkPhoneInvite($data['phone_invite'])) {
            return response()->json([
                'error' => [
                    'message' => 'Номер пригласившего не найден!',
                ]
            ], 422);
        }

        try {
            $this->userService->registerUser($data);

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
}
