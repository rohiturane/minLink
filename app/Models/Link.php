<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'code', 'url', 'type', 'title', 'description', 'tags', 'password', 'archived',
        'disabled', 'user_id', 'domain_id', 'expires_at'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function link_visits()
    {
        return $this->hasMany(LinkVisit::class);
    }
}
