@extends('layouts.app')
@extends('layouts.aside')
@section('content')
    <main class="py-4">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-header">
                    編集
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="error">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>



                        <form action="{{ route('food.update',['food'=>$foods['id']])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <label for='date' class='mt-2'>日付</label>
                                <input type='date' class='form-control' name='date' id='date' value='{{$foods["date"]}}'>
                                <input type="file" name="image" required>
                            <label for='menu' class='mt-2'>料理名</label>
                                <textarea class='form-control' name='menu' >{{$foods["menu"]}}</textarea>
                            <label for='number' >カロリー</label>
                                <input type='comment' class='form-control' name='calorie' value='{{$foods["calorie"]}}'>
                            <label for='comment' class='mt-2'>材料</label>
                                <textarea class='form-control' name='material' >{{$foods["material"]}}</textarea>
                            <label for='comment' class='mt-2'>レシピ</label>
                                <textarea class='form-control' name='recipe' >{{$foods["recipe"]}}</textarea>

                            <div>
                                <button type='submit' class='btn btn-primary w-15 mt-3 mr-auto'>編集</button>
                            </div>

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection