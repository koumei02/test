<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateWeight;
use App\Http\Requests\CreateProfile;
use Illuminate\Http\Request;
use App\Weight;
use App\Profile;
use App\Food;
use App\Favorite;

class AutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $weighting = new Weight;
        $fooding = new Food;
        $fav = new Favorite;
        $pro = new Profile;
        
        $body = $weighting->all()->toArray();
        
        $eat  = $fooding 
        ->join('users', 'foods.user_id', 'users.id')
        ->join('profiles', 'foods.user_id', 'profiles.user_id')
        ->select('foods.id', 'date', 'menu', 'recipe', 'material', 'calorie', 'image', 'foods.user_id');
        
        $body  = $weighting 
        ->join('users', 'weights.user_id', 'users.id')
        ->join('profiles', 'weights.user_id', 'profiles.user_id');
        // 日付検索した後も順番変更する必要あり
        $foodlist = $eat->orderBy('date', 'desc')->get();
        $weightlist  = $body->orderBy('date', 'desc')->get();
        $w_items  = $body->orderBy('date', 'desc')->get();
        $items = $eat->orderBy('date', 'desc')->get();
        
        //テーブル結合
        $query = Food::query();
        $query->join('users', function ($query) use ($request) {
            $query->on('users.id', '=', 'foods.user_id');
        })->join('profiles', function ($query) use ($request) {
            $query->on('users.id', '=', 'profiles.user_id');
        })->select('users.*','foods.*','profiles.*','foods.id as foodid');
        //テーブル結合
        $w_query = Weight::query();
        $w_query->join('users', function ($query) use ($request) {
            $query->on('users.id', '=', 'weights.user_id');
        })->join('profiles', function ($query) use ($request) {
            $query->on('users.id', '=', 'profiles.user_id');
        })->select('users.*','weights.*','profiles.*','weights.id as weightid');
        // キーワード検索
        $keyword = $request->input('keyword');
        if(!empty($keyword)) {
            $query->orWhere('name', 'LIKE', "%{$keyword}%")
            ->orWhere('menu', 'LIKE', "%{$keyword}%");
        };
        // 日付検索
        $from = $request->input('s-date');
        $until = $request->input('e-date');
        if (isset($from) && isset($until)) {
            $query = $query->whereBetween("date", [$from, $until]);
        }
        $min = $request->input('age');
        $age = explode("~",$min);
        if (!empty($min)) {
            $query = $query->whereBetween("age", [$age[0], $age[1]]);
        }
        $gen = $request->input('medium');
        if (!empty($gen)) {
            $query->where("gender", $gen);
        }
        $items = $query->get();
        $w_items = $w_query->get();
        $profile = $pro->where('user_id',Auth::id())->first();
        $user = Auth::user()->toArray();


        if($user['role']== 0 && $profile == null ){
            return view('mypagecreate');
        }elseif($user['role']== 0){
            return view('timeline',[
                'weight' => $weightlist,
                'food' => $foodlist,
                'favorite' => $fav,
                'from'=> $from,
                'until' => $until,
                'keyword' => $keyword,
                'items' => $items,
                'w_items' => $w_items,
                'min' =>$min,
                'gen' => $gen,
            ]);
        }else{
            return view('master_timeline',[
                'weight' => $weightlist,
                'food' => $foodlist,
                'favorite' => $fav,
                'from'=> $from,
                'until' => $until,
                'keyword' => $keyword,
                'items' => $items,
                'w_items' => $w_items,
                'min' =>$min,
                'gen' => $gen,
            ]);

        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('weight_fat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //登録作業を書く箇所。
        $weighting = new Weight;
        //左側が入力したテーブル。右側がコントローラに入力する。 
        $weighting->date = $request ->date;
        $weighting->weight = $request ->weight;
        $weighting->fat = $request ->fat;
        $weighting->comment = $request ->comment;
        $weighting->user_id = Auth::id();
        $weighting->save();

        return redirect('auto');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //詳細画面の表示。
        $profiling = new Profile;  
        $weighting = new Weight;
        $fooding = new Food;
        $fav = new Favorite;
        
        $pro = $profiling->find($id);
        $body = $weighting->where('user_id', Auth::id())->get();
        $eat = $fooding->where('user_id', Auth::id())->get();
        $favorites = $fav->where('user_id', Auth::id())->get();
        
        $eat  = $fooding 
        ->join('users', 'foods.user_id', 'users.id')->select('users.*','foods.*','users.id as useid')->where('foods.user_id', Auth::id());

        $e_list = $eat->orderBy('date', 'desc')->get();
        $w_list  = $weighting 
        ->join('users', 'weights.user_id', 'users.id')->where('weights.user_id', Auth::id());

        $f_list = $fav
        ->join('foods', 'favorites.food_id', 'foods.id')->where('favorites.user_id', Auth::id());
        $favorites = $f_list->orderBy('favorites.created_at', 'desc')->get();

        $pro= Profile::join('weights','profiles.user_id','weights.user_id')->select('weights.*','profiles.*','weights.comment as wcomment')->where('profiles.user_id',$id)->orderby('weights.date','desc')->first();
        $profile = $profiling->find($id);

        return view('mypage', [
            'pro' => $pro,
            'weight' => $body,
            'food' => $e_list,
            'favorites' => $favorites,
            'profile' => $profile,
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
        //編集のフォームを表示させる。プロフィール画面
        $profiling = new Profile;
        $pro = $profiling->where('user_id', $id)->first();
        if($pro == null){
            return view('mypagecreate');
        }
        return view('profile_edit', [
            'pro'=> $pro,
        ]);


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
        //編集処理を行う。保存について
        $profiling = new Profile;
        $profile = $profiling->find($id);
            $file_name = $request->file('icon')->getClientOriginalName();
            $request->file('icon')->storeAs('public/icons', $file_name);

            $profile->icon = $file_name;
            $profile->comment = $request->comment;
            $profile->gender = $request->gender;
            $profile->age = $request->age;
            $profile->height = $request->height;
            $profile->target_weight = $request->target_weight;
            $profile->target_fat = $request->target_fat;
            $profile->user_id = $id;
    
            $profile->save();
    
        return redirect('auto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //削除処理。投稿内容の削除。
        $destory = Food::find($id);
        $destory->delete();

        return redirect()->route('auto.show',['auto' => Auth::id()]);

    }
}

