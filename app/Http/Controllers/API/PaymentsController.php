<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Patterns\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentsController extends Controller
{
    function __construct(PaymentService $service)
    {
        $this->service  = $service;
    }
    function index(Request $request)
    {

        $data = $this->service->index($request);
        return Response::apiResponse('success',  $data);
    }

    function store(StorePaymentRequest $request)
    {
        $data = $this->service->create($request);
        return Response::apiResponse('success',  $data);
    }
}
