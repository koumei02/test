<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Weight;
use App\Profile;
use App\Food;
use App\Favorite;
use App\User;


class MasterController extends Controller
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
            $w_query->orWhere('name', 'LIKE', "%{$keyword}%");
        };
        // 日付検索
        $from = $request->input('s-date');
        $until = $request->input('e-date');
        if (isset($from) && isset($until)) {
            $query = $query->whereBetween("date", [$from, $until]);
            $w_query = $query->whereBetween("date", [$from, $until]);
        }
        $min = $request->input('age');
        $age = explode("~",$min);
        if (!empty($min)) {
            $query = $query->whereBetween("age", [$age[0], $age[1]]);
            $w_query = $query->whereBetween("age", [$age[0], $age[1]]);
        }
        $gen = $request->input('medium');
        if (!empty($gen)) {
            $query->where("gender", $gen);
            $w_query->where("gender", $gen);
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
        return view('mypagecreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profiling = new Profile;
            $file_name = $request->file('icon')->getClientOriginalName();
            $request->file('icon')->storeAs('public/icons', $file_name);
    
            $profiling->icon = $file_name;
            $profiling->comment = $request->comment;
            $profiling->gender = $request->gender;
            $profiling->age = $request->age;
            $profiling->height = $request->height;
            $profiling->target_weight = $request->target_weight;
            $profiling->target_fat = $request->target_fat;
            $profiling->user_id =Auth::id();
    

            $profiling->save();

            return redirect('auto');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int  $id)
    {
        $profiling = new Profile;  
        $weighting = new Weight;
        $fooding = new Food;
// $pro = Weight::where('user_id',$id)->first();
        $pro = $profiling->find($id);
        $profile= Profile::join('weights','profiles.user_id','weights.user_id')
        ->join('users','profiles.user_id','users.id')->select('users.name','weights.*','profiles.*','weights.comment as wcomment')->where('profiles.user_id',$id)->orderby('weights.date','desc')->first();
        // dd($pro);
        $user = User::where('id',$id)->first();
    
        // dd($pro);
        $body = $weighting->where('user_id', $id)->orderBy('date', 'desc')->get();
        $eat = $fooding->where('user_id', $id)->orderBy('date', 'desc')->get();

        return view('account_check', [
            'profile' => $profile,
            'weight' => $body,
            'food' => $eat,
            'user' => $user,
            'pro' => $pro,
        ]);    

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int  $id)
    {
        $weights=Weight::find($id);
        return view('weightedit',[
            'weights'=>$weights,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateWeight $request, int  $id)
    {
        $weights=Weight::find($id);
        $weights->date=$request->date;
        $weights->weight=$request->weight;
        $weights->fat=$request->fat;
        $weights->comment=$request->comment;
        $weights->user_id=Auth::id();
        $weights->save();

        return redirect()->route('auto.show',['auto'=>Auth::id()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $food = new Food;
        $destory = $food->find($id);
        // $delete = DB::table('foods')->find($id);
        $destory->delete();

        return redirect()->route('auto.index');

    }
}
