<?php


namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService
{
    /**
     * @var UserRepository
     */
    protected UserRepository $repository;

    /**
     * AuthService constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all($limit = null)
    {
        return is_null($limit) ? $this->repository->all() : $this->repository->paginate($limit);
    }

    /**
     * @param $user
     *
     * @return User|null
     */
    public function create($user): ?User
    {
        return $this->repository->create($user);
    }

    public function createUserWithRoles($user, $roles)
    {
        $user = $this->repository->create($user);

        return $user->assignRole($roles);
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function update($user, $id)
    {
        return $this->repository->update($user, $id);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
