<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function index(Request $request)
    {

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
                //詳細画面の表示。
                $profiling = new Profile;  
                $weighting = new Weight;
                $fooding = new Food;
        
                $pro = $profiling->find($id);
                // dd($pro);
                $body = $weighting->where('user_id', $id)->get();
                $eat = $fooding->where('user_id', $id)->get();
                
                $eat  = $fooding 
                ->join('users', 'foods.user_id', 'users.id')->where('foods.user_id', $id);
        
                $e_list = $eat->orderBy('date', 'desc')->get();
                
                $body = $weighting 
                ->join('users', 'weights.user_id', 'users.id')->where('weights.user_id', $id);
                $w_list = $body->orderBy('date', 'desc')->get();
        
                return view('account_check', [
                    'profile' => $pro,
                    'weight' => $w_list,
                    'food' => $e_list,
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int  $id)
    {
        //
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
