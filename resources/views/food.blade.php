@extends('layouts.app')
@section('content')
    <main class="py-4">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-header">
                    食事記録
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <form action="{{ route('food.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for='date' class='mt-2'>日付</label>
                                <input type='date' class='form-control' name='date' id='date'>
                            <label for='comment' class='mt-2'>料理名</label>
                                <textarea class='form-control' name='menu' ></textarea>
                                <input type="file" name="image">
                            <label for='number' >カロリー</label>
                                <input type='comment' class='form-control' name='calorie'>
                            <label for='comment' class='mt-2'>材料</label>
                                <textarea class='form-control' name='material' ></textarea>
                            <label for='comment' class='mt-2'>レシピ</label>
                                <textarea class='form-control' name='recipe' ></textarea>

                            <div>
                                <button type='submit' class='btn btn-primary w-15 mt-3 mr-auto'>登録</button>
                            </div>

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection