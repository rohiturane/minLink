<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title', 'slug', 'category', 'html', 'tags', 'featured_image', 'meta_title', 'meta_description', 'author_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class ,'author_id');
    }
}