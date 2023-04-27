<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['age', 'gender', 'user_id', 'comment', 'target_weight', 'target_fat', 'icon', 'height'];
}
