<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaypalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'payer_email',
        'payer_name',
        'amount',
        'paypal_fee', // This is correct here
        'currency',
        'status',
        'paypal_created_at'
    ];

    protected $casts = [
        'paypal_created_at' => 'datetime'
    ];

    // You can add accessor methods for convenient calculations
    public function getNetAmountAttribute()
    {
        return $this->amount - $this->paypal_fee;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
