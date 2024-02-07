<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use VanOns\Laraberg\Traits\RendersContent;

class Invoice extends Model
{
    use RendersContent;
    protected $table = 'invoices';
    protected $contentColumn = 'html_content';
    protected $fillable = [
        'title', 'html_content', 'status', 'created_by', 'updated_by', 'uuid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}