<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Food;
use App\Weight;
use App\Profile;
use App\Favorite;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('food');
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
        // dd(Auth::id());
        $fooding = new Food;
        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/images', $file_name);

        $fooding->date = $request -> date;
        $fooding->menu = $request -> menu;
        $fooding->calorie = $request -> calorie;
        $fooding->material = $request -> material;
        $fooding->recipe = $request -> recipe;
        $fooding->image = $file_name;
        $fooding->user_id = Auth::id();

    //    $date = $request -> date;
    //    $menu = $request -> menu;
    //    $calorie = $request -> calorie;
    //    $material = $request -> material;
    //    $recipe = $request -> recipe;
    //    $image = $file_name;
    //    $user_id = Auth::id();


        // Food::create([
        //     'date'=>$date,
        //     'menu'=>$menu,
        //     'calorie'=>$calorie,
        //     'recipe'=>$recipe,
        //     'material'=>$material,
        //     'image'=>$image->storeAs('public/images', $file_name),
        //     'user_id'=>$user_id,
        // ]);
        $fooding->save();

        return redirect('auto');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 他人のマイページ
    public function show(int $id) {
        $profiling = new Profile;  
        $weighting = new Weight;
        $fooding = new Food;

        $other_p = Profile::find($id);
        // $other_w = Weight::where();
        // $other_f = Food::>where('user_id', $id)->get();
        // $pro = $profiling->where('user_id', $id)->get();
        $pro = $profiling->find($id);
        // dd($pro);
        $body = $weighting->where('user_id', $id)->get();
        $eat = $fooding->where('user_id', $id)->get();

        $eat  = $fooding 
        ->join('users', 'foods.user_id', 'users.id')
        ->join('profiles', 'foods.user_id', 'profiles.user_id')->get();

        $eat = $fooding->orderBy('date', 'desc')->get();
        
        $body  = $weighting 
        ->join('users', 'weights.user_id', 'users.id')
        ->join('profiles', 'weights.user_id', 'profiles.user_id')->get();
        
        $body  = $weighting->orderBy('date', 'desc')->get();



        return view('account', [
            'profile' => $pro,
            'weight' => $body,
            'food' => $eat,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Weight::find($id);
        $delete->delete();

        return redirect()->route('auto.show',['auto' => Auth::id()]);

    }
    public function ajaxlike(Request $request)
    {
        $id = Auth::user()->id;
        $food_id = $request->food_id;
        $like = new Favorite;
        $food = Food::findOrFail($food_id);

        // 空でない（既にいいねしている）なら
        if ($like->like_exist($id, $food_id)) {
            //likesテーブルのレコードを削除
            $like = Favorite::where('food_id', $food_id)->where('user_id', $id)->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new Favorite;
            $like->food_id = $request->food_id;
            $like->user_id = Auth::user()->id;
            $like->save();
        }

        //loadCountとすればリレーションの数を○○_countという形で取得できる（今回の場合はいいねの総数）
        $foodLikesCount = $food->loadCount('like')->likes_count;

        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。笑
        $json = [
            'foodLikesCount' => $foodLikesCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    }
    
}
