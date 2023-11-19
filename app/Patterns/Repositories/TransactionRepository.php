<?php

namespace App\Patterns\Repositories;

use App\Http\Resources\Transactions\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class TransactionRepository extends BaseRepository
{
    function __construct()
    {
        $this->makeModel();
        $this->skipPresenter(false);
        $this->setPresenter(TransactionResource::class);
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transaction::class;
    }



    public function report($request)
    {

        $this->model = $this->model->select(
            DB::raw('MONTH(due_on) as month'),
            DB::raw('YEAR(due_on) as year'),
            DB::raw('SUM(CASE WHEN transactions.status = "1" THEN payments.amount ELSE 0 END) as paid'),
            DB::raw('SUM(CASE WHEN transactions.status = "2" THEN payments.amount  ELSE 0 END) as outstanding'),
            DB::raw('SUM(CASE WHEN transactions.status = "3" THEN payments.amount ELSE 0 END) as overdue')
        )
            ->leftJoin('payments', 'transactions.id', '=', 'payments.transaction_id')
            ->whereBetween('due_on', [$request->start_date, $request->end_date])
            ->groupBy('month', 'year');
        // ->groupBy(DB::raw('YEAR(due_on)'), DB::raw('MONTH(due_on)'));
        return  $this->paginate();
    }
}
