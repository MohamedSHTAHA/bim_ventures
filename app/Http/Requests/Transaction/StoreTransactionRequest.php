<?php

namespace App\Http\Requests\Transaction;

use App\Http\Requests\BaseRequest;
use App\Models\User;

class StoreTransactionRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payer_id' => 'required|exists:users,id,type,' . User::TYPE_CUSTOMER,
            'due_on' => 'required|date|date_format:d-m-Y|after_or_equal:now',
            'vat' => 'required|min:0|max:99',
            'is_vat_inclusive' => 'required|boolean',
            'amount' => 'required|min:1',
        ];
    }
}
