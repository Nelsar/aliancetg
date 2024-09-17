<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin;
use App\Events\User\UserEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\Guard;

class AuthService
{
    public function login(): ?string
    {
        return Auth::attempt() ? Auth::getToken() : null;
    }
    
    public function checkStatus(array $credentials): bool
    {
        $token = $this->login($credentials);
        $user = $this->respondWithToken($token);

        if ($user['user']['status'] == 1) {
            return true;
        }

        return false;
    }

    public function respondWithToken(?string $token): ?array
    {
        return $token
            ?[
                'user' => Auth::user(),
                'access_token' =>$token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ]
            : ['error' => 'Неавторизованный'];
    }

    public function registerUser(array $data): ?User
    {
        $adminEmail = config('mail.from.address');
        $subject = "Зарегистрировался новый Пользователь для сайта ";
        $user = new User();

        $parentId = 0;
        $adminId = 0;
        $parent = User::where('phone', 'LIKE', '%' . $data['phone_invite'] . '%')->first();
        $admin = Admin::where('phone', 'LIKE', '%' . $data['phone_invite'] . '%')->first();

        if ($parent) {
            $parentId = $parent->id;
        }

        if ($admin) {
            $adminId = $admin->id;
        }

        $user->phone_invite = $data['phone_invite'];
        $user->phone = $data['phone'];
        $user->name = $data['name'];
        $user->birthday = $data['birthday'];
        $user->gender = $data['gender'];
        $user->iin = $data['iin'];
        $user->email = $data['email'];
        $user->parent_id = $parentId;
        $user->admin_id = $adminId;
        $user->password = Hash::make($data['password']);

        event(new UserEvent($adminEmail, $subject, $user, $data['password']));

        $user->save();

        return $user;
    }

    public function checkPhoneInvite(string $phone): bool
    {
        $user = User::where('phone', 'LIKE', '%' . $phone . '%')->first();
        $admin = Admin::where('phone', 'LIKE', '%' . $phone . '%')->first();

        if ($user) {
            return true;
        }

        if ($admin) {
            return true;
        }

        return false;
    }

    public function updateUser(User $user, array $data): ?User
    {
        if (isset($data['phone']) && $user->phone != $data['phone']) {
            $user->phone = $data['phone'];
            if ($user->children->count() > 0) {
                foreach ($user->children as $child) {
                    $child->update(['phone_invite' => $data['phone']]);
                }
            }
        }

        if (isset($data['name']) && $user->name != $data['name']) {
            $user->name = $data['name'];
        }

        if (isset($data['birthday']) && $user->birthday != $data['birthday']) {
            $user->birthday = $data['birthday'];
        }

        if (isset($data['gender']) && $user->gender != $data['gender']) {
            $user->gender = $data['gender'];
        }

        if (isset($data['iin']) && $user->iin != $data['iin']) {
            $user->iin = $data['iin'];
        }

        $user->update();

        return $user;
    }

    public function passwordCheckAndUpdate(array $data): ?bool
    {
        $user = User::findOrFail(Auth::id());

        if(Hash::check($data['old_password'], $user->password)) {
            $user->fill([
                'password' => Hash::make($data['new_password']),
            ])->save();

            return true;
        }

        return false;
    }
    

}

