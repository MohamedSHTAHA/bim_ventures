<?php

namespace App\Http\Resources\Payments;

use App\Http\Resources\BaseResource;
use App\Http\Resources\Transactions\TransactionResource;
use App\Http\Resources\Users\UserResource;
use Carbon\Carbon;

class PaymentResource extends BaseResource
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
            'id' => $this->id,

            'amount' => $this->amount,
            'transaction_id' => $this->transaction_id,
            'creator_id' => $this->creator_id,
            'paid_on' =>   Carbon::parse($this->paid_on)->format('d-m-Y'),
            'details' => $this->details,

            'transaction' => $this->whenLoaded('transaction', function () {
                return new TransactionResource($this->transaction);
            }),
            'creator' => $this->whenLoaded('creator', function () {
                return new UserResource($this->creator);
            }),
        ];
    }
}
