@extends('layouts.aside')
@extends('layouts.app')
@section('content')
    <div class="col-md-5 mx-auto">
        <div class="card-body">
            <div class="card-body">
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'></th>
                            <th scope='col'>年齢</th>
                            <th scope='col'>性別</th>
                            <th scope='col'>コメント</th>
                            <th scope='col'>身長</th>
                            <th scope='col'>現体重</th>
                            <th scope='col'>目標体重</th>
                            <th scope='col'>現体脂肪率</th>
                            <th scope='col'>目標体脂肪率</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- ここに登録情報を表示する -->
                        <tr>
                            <th scpoe='col'><img src="{{ asset('storage/icons/'.$profile['icon']) }}"  class="img-fluid" alt="アイコン"></th>
                            <th scpoe='col'>{{ $profile['age'] }}</th>
                            <th scpoe='col'>{{ $profile['gender'] }}</th>
                            <th scpoe='col'>{{ $profile['comment'] }}</th>
                            <th scpoe='col'>{{ $profile['height'] }}</th>
                            <th scpoe='col'></th>
                            <th scpoe='col'>{{ $profile['target_weight'] }}</th>
                            <th scpoe='col'></th>
                            <th scpoe='col'>{{ $profile['target_fat'] }}</th>
                            <!-- latest()->first()で最新所法を取得して現体重、現体脂肪率を記入する-->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5 mx-auto">
        <div class="card-body">
            <div class="card-body">
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>日付</th>
                            <th scope='col'>写真</th>
                            <th scope='col'>メニュー</th>
                            <th scope='col'>レシピ</th>
                        </tr>
                    </thead>
                    <!-- ここに登録情報を表示する -->
                    <tbody>
                    @foreach($food as $mypage_eat)
                        <tr>
                            <th scpoe='col'>{{ $mypage_eat['date'] }}</th>
                            <th scpoe='col'><img src="{{ asset('storage/images/'.$mypage_eat['image']) }}" class="img-fluid" alt="アイコン"></th>
                            <th scpoe='col'>{{ $mypage_eat['menu'] }}</th>
                            <th scpoe='col'>{{ $mypage_eat['recipe'] }}</th>

                            <th><form action="{{ route('auto.destroy', ['auto' => $mypage_eat['id']]) }}" method="post">
                                @method('delete')
                                @csrf
                                <button class='btn btn-danger'>削除</button>
                            </form></th>
                           

                        </tr>
                    @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5 mx-auto">
        <div class="card-body">
            <div class="card-body">
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>日付</th>
                            <th scope='col'>体重</th>
                            <th scope='col'>体脂肪率</th>
                        </tr>
                    </thead>
                    <!-- ここに登録情報を表示する -->
                    <tbody>
                    @foreach($weight as $mypage_body)
                        <tr>
                            <th scpoe='col'>{{ $mypage_body['date'] }}</th>
                            <th scpoe='col'>{{ $mypage_body['weight'] }}</th>
                            <th scpoe='col'>{{ $mypage_body['fat'] }}</th>
                        </tr>
                        <th><form action="{{ route('food.destroy', ['food' => $mypage_body['id']]) }}" method="post">
                            @method('delete')
                            @csrf
                            <button class='btn btn-danger'>削除</button>
                        </form></th>


                    @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5 mx-auto">
        <div class="card-body">
            <div class="card-body">
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>日付</th>
                            <th scope='col'>写真</th>
                            <th scope='col'>メニュー</th>
                            <th scope='col'>レシピ</th>
                        </tr>
                    </thead>
                    <!-- ここに登録情報を表示する -->
                    <tbody>
                    
                    @foreach($favorites as $mypage_fav)
                        <tr>
                            
                            <th scpoe='col'>{{ $mypage_fav['date'] }}</th>
                            <th scpoe='col'><img src="{{ asset('storage/images/'.$mypage_fav['image']) }}" class="img-fluid" alt="アイコン"></th>
                            <th scpoe='col'>{{ $mypage_fav['menu'] }}</th>
                            <th scpoe='col'>{{ $mypage_fav['recipe'] }}</th>
                        </tr>
                    @endforeach    

                    
                </table>
            </div>
        </div>
    </div>

@endsection