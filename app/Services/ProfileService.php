<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin;

class ProfileService
{
    public function getNameAndEmailUsers(array $data): bool|string
    {
        $user = User::where('phone', $data['phone'])->first();
        $admin = Admin::where('phone', $data['phone'])->first();

        if ($user) {
            return "{$user->name} | {$user->email}";
        }

        if ($admin) {
            return "Администратор | {$admin->email}";
        }

        return false;
    }
}