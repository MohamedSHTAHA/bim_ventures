<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Amount Yes The total amount of the transaction
    // Payer Yes The customer who will pay the given amount
    // Due on Yes The date on which the customer should pay
    // VAT Yes The VAT percentage
    // Is VAT inclusive Yes Is the VAT amount included in the entered amount
    protected $fillable = [
        'amount',
        'transaction_id',
        'creator_id',
        'paid_on',
        'details'
    ];


    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id','id');
    }
}
