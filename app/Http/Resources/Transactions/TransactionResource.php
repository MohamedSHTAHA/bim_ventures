<?php

namespace App\Http\Resources\Transactions;

use App\Http\Resources\BaseResource;
use App\Http\Resources\Payments\PaymentResource;
use App\Http\Resources\Users\UserResource;
use Carbon\Carbon;

class TransactionResource extends BaseResource
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
            'status' => $this->status,
            'payer_id' => $this->payer_id,
            'creator_id' => $this->creator_id,

            'payer' => $this->whenLoaded('payer', function () {
                return new UserResource($this->payer);
            }),
            'creator' => $this->whenLoaded('creator', function () {
                return new UserResource($this->creator);
            }),

            'payments' => $this->whenLoaded('payments', function () {
                return PaymentResource::collection($this->payments);
            }),
            'due_on' =>   Carbon::parse($this->due_on)->format('d-m-Y'),
            'vat' => $this->vat,
            'is_vat_inclusive' => $this->is_vat_inclusive,
        ];
    }
}
