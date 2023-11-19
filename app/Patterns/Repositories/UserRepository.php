<?php

namespace App\Patterns\Repositories;

use App\Http\Resources\Users\UserResource;
use App\Models\User;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class UserRepository extends BaseRepository
{
    function __construct()
    {
        $this->makeModel();
        $this->skipPresenter(false);
        $this->setPresenter(UserResource::class);
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}
