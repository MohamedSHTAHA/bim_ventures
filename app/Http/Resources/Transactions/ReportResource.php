<?php

namespace App\Http\Resources\Transactions;

use App\Http\Resources\BaseResource;
use App\Http\Resources\Payments\PaymentResource;
use App\Http\Resources\Users\UserResource;
use Carbon\Carbon;

class ReportResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "month" => $this->month,
            "year" => $this->year,
            "paid" => (float) $this->paid,
            "outstanding" => (float) $this->outstanding,
            "overdue" => (float) $this->overdue,
        ];
    }
}
