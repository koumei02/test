@extends('layouts.aside')
@extends('layouts.app')
@section('content')


<div class="search">
    <h5 class="mb-3">検索</h5>
    
    
    <ul class="nav flex-column">
      <form method="get" action="">

        <li class="nav-item">
          <div class='d-flex'>
            <input type='date' class='start-form' name='s-date' id='date' value=""/>
            <p>~</p>
            <input type='date' class='end-form' name='e-date' id='date' value=""/>
          </div>
        </li>
        <li class="nav-item">
          <input type="text" name="name" placeholder="ユーザー名を入力">
        </li>
        <br>
        <li class="nav-item">
          <select name="gender">
            <option value="">性別</option>
            <option value="0">男性</option>
            <option value="1">女性</option>
          <option value="2">その他</option>
          </select>
        </li>
        <li class="nav-item">
          <div class='d-flex'>
            <input type="number" name="age" placeholder="年齢（下限）">
              <p>～</p>
            <input type="number" name="age" placeholder="年齢（上限）">
          </div>
        </li>
        <button type="submit">検索</button>
      </form>
    </ul> 
  </div>
  </div> 

<div class="col-md-5 mx-auto">
    <div class="card-body">
        <div class="card-body">
            <table class='table'>
                        <!-- ここに登録情報を表示する -->
                        <tbody>
                            <div class="card">
                                <div class="card-haeder p-3 w-100 d-flex">
                                    <div class="ml-2 d-flex flex-column">
                                        @foreach($food as $timeline_eat)
                                        <a href="{{ route('food.show',['food'=>$timeline_eat['user_id']]) }}">
                                            <img src="{{ asset('storage/icons/'.$timeline_eat['icon'])  }}" class="rounded-circle" width="50" height="50">
                                        </a>
                                        <p class="mb-0">{{ $timeline_eat['name'] }}</p>
                                        <p>{{ $timeline_eat['date'] }}</p>
                                        <p><img src="{{ asset('storage/images/'.$timeline_eat['image'])  }}"  width="300" height="150"></p>
                                        <p>{{ $timeline_eat['menu'] }}</p>
                                        <p>レシピ<br>{{ $timeline_eat['recipe'] }}</p>
                                        @if($favorite->like_exist(Auth::user()->id,$timeline_eat['id']))
                                        <p class="favorite-marke">
                                        <button class="js-like-toggle loved" href="" data-foodid="{{ $timeline_eat['id'] }}"><i class="fas fa-heart"></i></button>
                                        </p>
                                        @else
                                        <p class="favorite-marke">
                                        <button class="js-like-toggle" href="" data-foodid="{{ $timeline_eat['id'] }}"><i class="fas fa-heart"></i></button>
                                        </p>
                                        @endif
                                        @endforeach
                                        
                                    </div>
                                </div>    
                        </tbody>
                        </div>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5 mx-auto">
        <div class="card-body">
            <div class="card-body">
                <table class='table'>
                    <!-- <thead> -->
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <div class="ml-2 d-flex flex-column">
<!-- 
                                    <tr>
                                        <th scope='col'>日付</th>
                                        <th scope='col'>体重</th>
                                        <th scope='col'>体脂肪率</th>
                                    </tr>
                                </thead> -->
                                <!-- ここに登録情報を表示する -->
                                <!-- <tbody> -->
                                @foreach($weight as $timeline_body)
                                <p class="mb-0">{{ $timeline_body['name'] }}</p>

                                    <p>日付　{{ $timeline_body['date'] }}</p>
                                    <p>体重　{{ $timeline_body['weight'] }}</p>
                                    <p>体脂肪率　{{ $timeline_body['fat'] }}</p>
                                    <!-- <tr>
                                        <th scpoe='col'>{{ $timeline_body['date'] }}</th>
                                        <th scpoe='col'>{{ $timeline_body['weight'] }}</th>
                                        <th scpoe='col'>{{ $timeline_body['fat'] }}</th>
                                    </tr> -->
                                @endforeach    
                            </div>
                        </div>
                    </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
      <style>
        .search{
            margin-left:500px;
        }

        .loved i {
        color: red !important;
        }
    </style>


@endsection
