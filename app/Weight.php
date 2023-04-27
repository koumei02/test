<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    protected $fillable = ['date', 'weight', 'fat', 'user_id', 'comment'];
}
