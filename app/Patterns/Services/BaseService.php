<?php

namespace App\Patterns\Services;

use App\Exceptions\GeneralException;

/**
 * Class BaseService
 *
 *
 */
abstract class BaseService implements ServiceInterface
{
    public $user;
    function loggedInUser()
    {

        $this->user = auth('api')->user();
        if ($this->user)
            return  $this->user;

        throw new GeneralException(
            'The provided credentials are incorrect.',
            401
        );
    }
}
