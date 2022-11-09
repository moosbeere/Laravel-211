<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'name',
        'preview_image',
        'full_image',
        'shortDesc',
        'desc',
    ];
}
