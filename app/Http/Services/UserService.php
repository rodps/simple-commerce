<?php

namespace App\Http\Services;

use App\Models\User;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserService
{
    public function create(array $data)
    {
        $userAlreadyExists = User::where('email', $data['email'])->first();

        if ($userAlreadyExists) {
            throw new ConflictHttpException('User already exists');
        }

        return User::create(array_merge($data, ['role' => 'ADMIN']));
    }
}