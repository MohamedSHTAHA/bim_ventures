<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Patterns\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionsController extends Controller
{
    function __construct(TransactionService $service)
    {
        $this->service  = $service;
    }
    function index(Request $request)
    {

        $data = $this->service->index($request);
        return Response::apiResponse('success',  $data);
    }

    function store(StoreTransactionRequest $request)
    {

        $data = $this->service->create($request);
        return Response::apiResponse('success',  $data);
    }


    function report(Request $request)
    {

        $data = $this->service->report($request);
        return Response::apiResponse('success',  $data);
    }
}
