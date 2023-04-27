<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $fillable = ['date', 'menu', 'recipe', 'user_id', 'material', 'calorie' ,'image'];
}
