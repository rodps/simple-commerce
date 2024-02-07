<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Services\UserService;

class CreateUserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function __invoke(CreateUserRequest $request)
    {
        $data = $request->validated();

        $response = $this->userService->create($data);

        return response()->json($response, 201);
    }
}
