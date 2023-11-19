<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Patterns\Services\UserService;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    function __construct(public UserService $service)
    {
        // $this->service  = $service;
    }
    function login(StoreUserRequest $request)
    {

        $data = $this->service->login($request);
        return Response::apiResponse('success',  $data);
    }
}
