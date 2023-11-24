<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $table = 'ads';

    protected $fillable = [
        'ads_slug', 'image', 'external_html', 'status', 'link'
    ];
}