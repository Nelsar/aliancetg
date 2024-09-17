<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin;
use App\Events\User\UserEvent;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data, string $adminEmail): ?bool
    {
        $subject = "Пользователь создан Администратором для сайта ";
        $password = $data['password'];

        $user = new User();

        $user->parent_id = $data['parent_id'];
        if($phone = User::find($data['parent_id'])) {
            $user->phone_invite = $phone->phone;
        }

        $user->admin_id = $data['admin_id'];
        if($phone = Admin::find($data['admin_id'])) {
            $user->phone_invite = $phone->phone;
        }

        $user->phone = $data['phome'];
        $user->iin = $data['iin'];
        $user->email = $data['email'];
        $user->birthday = $data['birthday'];
        $user->status = $data['status'];
        $user->gender = $data['gender'];

        $user->password = Hash::make($password);

        event(new UserEvent($adminEmail, $subject, $user, $password));

        return $user->save();
    }

    public function updateUser(User $user, array $data, string $adminEmail): ?string 
    {
        $subject = "Пользователь обновлен Администратором для сайта ";
        $password = $data['password'];
        $m = '';

        if (isset($password)) {
            $m = ' Пароль отправлен на эту почту ' . $adminEmail;
            $user->password = Hash::make($password);
            event(new UserEvent($adminEmail, $subject, $user, $password));
        }

        $user->parent_id = $data['parent_id'];
        if ($phone = User::find($data['parent_id'])) {
            $user->phone_invite = $phone->phone;
        }

        $user->admin_id = $data['admin_id'];
        if ($phone = Admin::find($data['admin_id'])) {
            $user->phone_invite = $phone->phone;
        }

        if (isset($data['phone'])) {
            $user->phone = $data['phone'];
            if ($user->children->count() > 0) {
                foreach ($user->children as $child) {
                    $child->update(['phone_invite' => $data['phone']]);
                }
            }
        }

        $user->iin = $data['iin'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->birthday = $data['birthday'];
        $user->status = $data['status'];
        $user->gender = $data['gender'];

        $user->update();

        return $m;
    }

    public function deleteUser(User $user): ?bool
    {
        if ($user->children->count() > 0) {
            foreach ($user->children as $child) {
                $child->update(['phone_invite' => null, 'parent_id' => 0]);
            }
        }

        $user->delete();

        return true;
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
}