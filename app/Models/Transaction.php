<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    const STATUS_PAID = '1';
    const STATUS_OUTSTANDING = '2';
    const STATUS_OVERDUE = '3';

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
        'status',
        'payer_id',
        'creator_id',
        'due_on',
        'vat',
        'is_vat_inclusive',
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id','id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'transaction_id','id');
    }
}
