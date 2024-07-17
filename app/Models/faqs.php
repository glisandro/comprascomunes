<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class faqs extends Model
{
    use HasFactory;
    use HasTags;

    protected $guarded = [];

    /*protected $casts = [
        'tags' => 'array',
    ];*/
}
