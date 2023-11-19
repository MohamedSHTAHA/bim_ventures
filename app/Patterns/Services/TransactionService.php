<?php

namespace App\Patterns\Services;

use App\Exceptions\GeneralException;
use App\Http\Resources\Transactions\ReportResource;
use App\Models\User;
use App\Patterns\Repositories\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class UserService
 *
 *
 */
class TransactionService extends BaseService
{

    function __construct(TransactionRepository $repository)
    {
        $this->repository  = $repository;
        $this->loggedInUser();
    }
    function index($request)
    {
        return  $this->repository->with(['payer','creator','payments'])->scopeQuery(function ($query) use ($request) {
            return $query->when($this->user->type  == User::TYPE_CUSTOMER, fn ($q) => $q->where('payer_id', $this->user->id));
        })->paginate();
    }


    function create($request)
    {
        if ($this->user->type != User::TYPE_ADMIN) {
            throw new GeneralException(
                'must be admin to create transaction',
                401
            );
        }
        //TODO:Can be use DTO PATTERN
        $data = $request->validated();
        $data['creator_id'] = $this->user->id;
        $data['due_on'] = Carbon::parse($request->due_on);

        return  $this->repository->create($data);
    }

    function report(Request $request) {
        $this->repository->setPresenter(ReportResource::class);

        return  $this->repository->report($request);

    }
}
