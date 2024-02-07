<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        $data = $request->validated();

        $userAlreadyExists = User::where('email', $data['email'])->first();

        if ($userAlreadyExists) {
            throw new ConflictHttpException('User already exists');
        }

        $user = User::create(array_merge($data, ['role' => 'ADMIN']));

        return response()->json($user, 201);
    }
}
