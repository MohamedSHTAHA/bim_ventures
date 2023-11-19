<?php

namespace App\Http\Requests\Payment;

use App\Http\Requests\BaseRequest;
use App\Models\Transaction;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'transaction_id' => 'required|exists:transactions,id,status,!=,' . Transaction::STATUS_PAID,
            'transaction_id' =>Rule::exists('transactions', 'id')->where(function ($query) {
                $query->where('status', '!=', Transaction::STATUS_PAID);
            }),
            'details' => 'min:3|max:255',
            'amount' => 'required|min:1',
        ];
    }
}
