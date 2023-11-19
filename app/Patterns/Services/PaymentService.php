<?php

namespace App\Patterns\Services;

use App\Exceptions\GeneralException;
use App\Models\Transaction;
use App\Models\User;
use App\Patterns\Repositories\PaymentRepository;
use App\Patterns\Repositories\TransactionRepository;
use Carbon\Carbon;

/**
 * Class UserService
 *
 *
 */
class PaymentService extends BaseService
{

    function __construct(PaymentRepository $repository, TransactionRepository $transactionRepository)
    {
        $this->repository  = $repository;
        $this->transactionRepository  = $transactionRepository;
        $this->loggedInUser();
        if ($this->user->type != User::TYPE_ADMIN) {
            throw new GeneralException(
                'must be admin ',
                401
            );
        }
    }
    function index($request)
    {
        return  $this->repository->with(['transaction', 'creator'])->paginate();
    }


    function create($request)
    {

        $transaction = $this->transactionRepository
            ->skipPresenter(true)
            ->with(['payments:amount,transaction_id'])->find($request->transaction_id);

        if ($transaction->amount < ($transaction->payments->sum('amount') + $request->amount)) {
            throw new GeneralException(
                'The sum of payments must be or less >>>' . $transaction->amount - $transaction->payments->sum('amount'),
                422
            );
        }
        //TODO:Can be use DTO PATTERN
        $data = $request->validated();
        $data['creator_id'] = $this->user->id;
        $data['paid_on'] = Carbon::parse($request->paid_on);

        if ($transaction->amount == $transaction->payments->sum('amount') + $request->amount)
            $transaction->update(['status' => Transaction::STATUS_PAID]);

        return  $this->repository->create($data);
    }
}
