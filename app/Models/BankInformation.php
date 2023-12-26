<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank', 'ifsc', 'branch', 'center', 'district', 'state', 'address'
    ];
}
