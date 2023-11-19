<?php

namespace App\Patterns\Services;

use App\Exceptions\GeneralException;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use App\Patterns\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 *
 *
 */
class UserService extends BaseService
{

    function __construct(UserRepository $repository)
    {
        $this->repository  = $repository;
    }
    function login(StoreUserRequest $request)
    {
        // dd(User::all());
        $user = $this->repository->scopeQuery(function ($query) use ($request) {
            return $query->where('email', $request->email);
        })->first();
        // $user = $this->repository->firstByField('email', $request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new GeneralException(
                'The provided credentials are incorrect.',
                401
            );
        }

        return collect($user)->put('token' , $user->createToken('TAHA')->plainTextToken);
    }
}
