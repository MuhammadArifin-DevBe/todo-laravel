<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// singular
class Todo extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_done'
    ];
}
