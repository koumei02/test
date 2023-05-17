<?php

namespace App\Http\Controllers;

use App\Master;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Weight;
use App\Profile;
use App\Food;
use App\Favorite;


class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weighting = new Weight;
        $fooding = new Food;
        $pro = new Profile;
        
        
        $body = $weighting->all()->toArray();
        
        $eat  = $fooding 
        ->join('users', 'foods.user_id', 'users.id')
        ->join('profiles', 'foods.user_id', 'profiles.user_id');
        
        
        $body  = $weighting 
        ->join('users', 'weights.user_id', 'users.id')
        ->join('profiles', 'weights.user_id', 'profiles.user_id')->get();
        // 日付検索した後も順番変更する必要あり
        $foodlist = $eat->orderBy('date', 'desc')->get();
        $body  = $weighting->orderBy('date', 'desc')->get();
        
        
        
        $query = Food::query();
        //テーブル結合
        $query->join('users', function ($query) use ($request) {
            $query->on('users.id', '=', 'foods.user_id');
        })->join('profiles', function ($query) use ($request) {
            $query->on('users.id', '=', 'profiles.user_id');
        });
            
        // キーワード検索
        $keyword = $request->input('keyword');
        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('menu', 'LIKE', "%{$keyword}%");
        };
        
        
        // 日付検索
        $q = Food::query();
        $from = $request->input('s-date');
        $until = $request->input('e-date');
        if (isset($from) && isset($until)) {
            $query = $q->whereBetween("date", [$from, $until]);
            $eat = $query->get();     
        }
        
        $p = Profile::query();
        $min = $request->input('s-age');
        $max = $request->input('e-age');
        if (isset($min) && isset($max)) {
            $query = $p->whereBetween("age", [$min, $max]);
            $pro = $query->get();     
        }

        
        return view('timeline',[
            'weight' => $body,
            'food' => $foodlist,
            'favorite' => $fav,
            'from'=> $from,
            'until' => $until,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function show(Master $master)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function edit(Master $master)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Master $master)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function destroy(Master $master)
    {
        //
    }
}
