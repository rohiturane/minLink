<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'user_invoice_id', 'transaction_no', 'payment_platform', 'payment_platform_ref_no', 
        'status', 'amount', 'payment_payload', 'uuid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
