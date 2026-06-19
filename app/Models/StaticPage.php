<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $fillable = [
        'page_name',
        'meta_title',
        'meta_description',
        'json_ld',
    ];

    protected $casts = [
        'json_ld' => 'array',
    ];
}
