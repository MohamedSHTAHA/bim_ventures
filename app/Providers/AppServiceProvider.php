<?php

namespace App\Providers;

use App\Models\Payment;
use App\Observers\PaymentObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! app()->environment('production')) {
            ini_set('display_errors', 'on');
        }

        JsonResource::withoutWrapping();

        Payment::observe(PaymentObserver::class);

        Response::macro('apiResponse', function ($message = "", $data = [], $statusCode = 200, $meta = []) {

            return response(array_merge([
                'success' => in_array($statusCode, [200, 201, 202]),
                'statusCode' => $statusCode,
                'data' => $data,
                'message' => $message,
            ], $meta), $statusCode);

        });
    }
}
