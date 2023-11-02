<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageInformation extends Model
{
    protected $table = 'page_informations';

    protected $fillable = [
        'page_slug', 'html_content', 'meta_title', 'meta_description'
    ];
}