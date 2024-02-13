<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'uuid',
        'user_id'
    ];

   public function user()
   {
        return $this->belongsTo(User::class);
   }
}