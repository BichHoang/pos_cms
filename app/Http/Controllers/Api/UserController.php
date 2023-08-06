<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $users = $this->userService->all($limit);

        return $this->sendResponseSuccess(
            [
                'users' => $users,
            ], __('common.success')
        );
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->create($data);

        return $this->sendResponseSuccess(
            ['user' => $user], __('common.created')
        );
    }

    public function show($id)
    {
        try {
            $user = $this->userService->show($id);

            return $this->sendResponseSuccess(
                ['user' => $user],
            );
        } catch (Exception $ex) {
            return $this->sendResponseError([
                'message' => $ex->getMessage(),
            ], __('common.not_found'), 404);
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $request->validated();
            $user = $this->userService->update($user, $id);

            return $this->sendResponseSuccess(
                ['user' => $user], __('common.updated')
            );
        } catch (Exception $ex) {
            return $this->sendResponseError([
                'message' => $ex->getMessage(),
            ], __('common.not_found'), 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->delete($id);

            return $this->sendResponseSuccess(
                [], __('common.deleted')
            );
        } catch (Exception $ex) {
            return $this->sendResponseError([
                'message' => $ex->getMessage(),
            ], __('common.not_found'), 404);
        }
    }

    public function createUser(CreateUserRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->createUserWithRoles($data, $request->get('roles', ['user']));

        return $this->sendResponseSuccess(
            ['user' => $user], __('common.created')
        );
    }
}
