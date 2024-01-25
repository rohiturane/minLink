<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvoice extends Model
{
    use HasFactory;
    protected $table = 'user_invoices';

    protected $fillable = [
        'user_id', 'invoice_id', 'invoice_no', 'customer_name', 'uuid', 'payload',
        'html_content', 'status', 'total_amount','date', 'customer_mobile', 'customer_taxid'
    ];
}
