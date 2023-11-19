<?php

use App\Exceptions\GeneralException;
use App\Http\Controllers\API\PaymentsController;
use App\Http\Controllers\API\TransactionsController;
use App\Http\Controllers\API\UsersController;
use App\Models\Transaction;
use App\Patterns\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [UsersController::class, 'login'])->middleware('guest:api');


Route::group(['middleware' => 'auth:api'], function () {



    Route::group(['prefix' => 'transactions'], function () {

        Route::get('/', [TransactionsController::class, 'index']);
        Route::post('/store', [TransactionsController::class, 'store']);
        Route::get('/report', [TransactionsController::class, 'report']);

    });

    Route::group(['prefix' => 'payments'], function () {

        Route::get('/', [PaymentsController::class, 'index']);
        Route::post('/store', [PaymentsController::class, 'store']);
    });
});


Route::get('/test', function (Request $request) {

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');


    // return $reports = Transaction
    //     ::select(
    //         DB::raw('MONTH(due_on) as month'),
    //         DB::raw('YEAR(due_on) as year'),
    //         DB::raw('SUM(CASE WHEN transactions.status = "1" THEN transactions.amount ELSE 0 END) as sum_transactions_paid'),
    //         DB::raw('SUM(CASE WHEN transactions.status = "2" THEN transactions.amount ELSE 0 END) as sum_transactions_outstanding'),
    //         DB::raw('SUM(CASE WHEN transactions.status = "3" THEN transactions.amount ELSE 0 END) as sum_transactions_overdue'),
    //         DB::raw('SUM(CASE WHEN transactions.status = "1" THEN payments.amount ELSE 0 END) as sum_payments_paid'),
    //         DB::raw('SUM(CASE WHEN transactions.status = "2" THEN payments.amount ELSE 0 END) as sum_payments_outstanding'),
    //         DB::raw('SUM(CASE WHEN transactions.status = "3" THEN payments.amount ELSE 0 END) as sum_payments_overdue')
    //     )
    //     ->leftJoin('payments', 'transactions.id', '=', 'payments.transaction_id')
    //     ->whereBetween('due_on', [$startDate, $endDate])
    //     ->groupBy('month', 'year')
    //     ->get();
    // // Generate monthly reports using a single query
    return  $reports = Transaction
        ::select(
            DB::raw('MONTH(due_on) as month'),
            DB::raw('YEAR(due_on) as year'),
            DB::raw('SUM(CASE WHEN transactions.status = "1" THEN payments.amount ELSE 0 END) as sum_payments_paid'),
            DB::raw('SUM(CASE WHEN transactions.status = "2" THEN payments.amount ELSE 0 END) as sum_payments_outstanding'),
            DB::raw('SUM(CASE WHEN transactions.status = "3" THEN payments.amount ELSE 0 END) as sum_payments_overdue'),

        )
        ->leftJoin('payments', 'transactions.id', '=', 'payments.transaction_id')
        ->whereBetween('due_on', [$startDate, $endDate])
        ->groupBy('month', 'year')
        // ->groupBy(DB::raw('YEAR(due_on)'), DB::raw('MONTH(due_on)'))
        ->get();
    // return  $transactions = DB::table('transactions')
    // ->select('transactions.*')
    // ->selectRaw('SUM(payments.amount) AS total_payments')
    // ->leftJoin('payments', 'transactions.id', '=', 'payments.transaction_id')
    // ->groupBy('transactions.id')
    // ->havingRaw('SUM(payments.amount) < transactions.amount')
    // ->whereDate('transactions.due_on', '<', Carbon::now())

    // ->get();
    // if (1)
    //     throw new GeneralException('Dont know what youre trying todo....', 412);

    // $data = $userRepository->find(5656);
    // return Response::apiResponse(data: $data);

    // $data = $userRepository->paginate();
    // // return Response::apiResponse(data: $data, meta: ['links' => new PaginationResource($data)]);
    // return Response::apiResponse(data: $userRepository->paginate());
});
