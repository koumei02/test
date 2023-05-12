<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';
    public function like(){
        return $this->belongsTo('App\user', 'user_id', 'id'); //多対1の関係:userが多でlikeが1
        return $this->belongsTo('App\Food', 'food_id', 'id'); //多対1の関係:userが多でlikeが1
        // ※ 1つの投稿にいいね機能をつけるのは1つだが、他の投稿に同じユーザーがいいねするので多対1になる
    }
    public function like_exist($user_id, $food_id){
        return Favorite::where('user_id',$user_id)->where('food_id',$food_id)->exists();
        // ※exists()はlikeテーブル内にuser_idのカラムと$user_idのカラムで一致してるものがないか、
        //   food_idのカラムと$food_idのカラムで一致してるものがないかをチェックしてくれるもの
    }
}
