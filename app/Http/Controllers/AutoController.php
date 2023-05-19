<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
            $query->orWhere('name', 'LIKE', "%{$keyword}%")
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

        $profile = $pro->where('user_id',Auth::id())->get();
        $user = Auth::user()->toArray();
// dd($profile);
        if($user['role'] == 0){
            return view('timeline',[
                'weight' => $body,
                'food' => $foodlist,
                'favorite' => $fav,
                'from'=> $from,
                'until' => $until,
                'keyword' => $keyword,
            ]);
    
        }else{
            return view('master_timeline',[
                'weight' => $body,
                'food' => $foodlist,
                'favorite' => $fav,
                'from'=> $from,
                'until' => $until,
                'keyword' => $keyword,
            ]);

        }
        
        // // return view('timeline', compact('id','recipe','menu'));
        // $profile = $pro->where('user_id',Auth::id())->get();
        // //上記コードでprofileテーブルからログインしてる人の値が取れているかddで確認
        // if(!empty($profile)){ //empryページ遷移しなかったらif($profile == null)でやってみてください
        //   return view('profile_edit');
        // }else{
        //   return view('timeline',[
        //       'weight' => $body,
        //       'food' => $eat,
        //       'favorite' => $fav,
        //       'from'=> $from,
        //       'until' => $until,
        //       'keyword' => $keyword,
        //   ]);
        // }
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
        // weightsテーブルから引っ張ってくる必要委があるからjoinをする？
        // $p_list = $profiling->orderby('created_at','desc')->first();
        // Profile::orderby('created_at','desc')->first();
        $body = $weighting->where('user_id', Auth::id())->get();
        $eat = $fooding->where('user_id', Auth::id())->get();
        $favorites = $fav->where('user_id', Auth::id())->get();
        
        $eat  = $fooding 
        ->join('users', 'foods.user_id', 'users.id')->where('foods.user_id', Auth::id());

        $e_list = $eat->orderBy('date', 'desc')->get();

        // $e_list  = $fooding
        // ->join('users', 'foods.user_id', 'users.id')->where('foods.user_id', Auth::id());


        $w_list  = $weighting 
        ->join('users', 'weights.user_id', 'users.id')->where('weights.user_id', Auth::id());

        $f_list = $fav
        ->join('foods', 'favorites.food_id', 'foods.id')->where('favorites.user_id', Auth::id());
        $favorites = $f_list->orderBy('favorites.created_at', 'desc')->get();

        $pro= Profile::join('weights','profiles.user_id','weights.user_id')->where('weights.user_id',Auth::id())->orderby('weights.created_at','desc')->first();
        // dd($pro);


        return view('mypage', [
            'profile' => $pro,
            'weight' => $body,
            'food' => $e_list,
            'favorites' => $favorites,
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
        $pro = $profiling->find($id);
        // dd($pro);
        // $gender_s
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
        if(empty($profile)){
            $file_name = $request->file('icon')->getClientOriginalName();
            $request->file('icon')->storeAs('public/icons', $file_name);
    
            $profiling->icon = $file_name;
            $profiling->comment = $request->comment;
            $profiling->gender = $request->gender;
            $profiling->age = $request->age;
            $profiling->height = $request->height;
            $profiling->target_weight = $request->target_weight;
            $profiling->target_fat = $request->target_fat;
            $profiling->user_id = Auth::id();
    

            $profiling->save();
    
        }
        else{
            $file_name = $request->file('icon')->getClientOriginalName();
            $request->file('icon')->storeAs('public/icons', $file_name);

            $profile->icon = $file_name;
            $profile->comment = $request->comment;
            $profile->gender = $request->gender;
            $profile->age = $request->age;
            $profile->height = $request->height;
            $profile->target_weight = $request->target_weight;
            $profile->target_fat = $request->target_fat;
            $profile->user_id = Auth::id();
    
            $profile->save();

        }

    
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
        $delete = Food::find($id);
        $delete->delete();

        return redirect()->route('auto.show',['auto' => Auth::id()]);

    }
}
