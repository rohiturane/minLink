<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    
    protected $fillable = [
        'title', 'html_content', 'status', 'created_by', 'updated_by', 'uuid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}