<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $table = 'licenses';

    protected $fillable = [
        'uuid', 'project_id', 'user_id', 'access_code', 'host','is_used','request_payload'
    ];

   
}