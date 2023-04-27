<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Food;

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
    public function show($id)
    {
        //
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
        //
    }
}
