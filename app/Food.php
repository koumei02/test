<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $fillable = ['date', 'menu', 'recipe', 'user_id', 'material', 'calorie' ,'image'];
    public function like()
        {
            return $this->hasMany('App\Favorite'); //1対多の関係：likeが1でuserが多
        }
}
