<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id', 'platform', 'device', 'browser', 'location', 'crawler', 'referrer', 'ip'
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
