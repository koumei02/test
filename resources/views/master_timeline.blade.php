@extends('layouts.app')
@section('content')


<div class="search">
            <form action="{{ route('auto.index') }}" method="GET">   
                @csrf
                <div class="nav-item">
                    <div class='d-flex'>
                        <label for="">日付
                            <input type="date" class='start-form' name='s-date' id='date' value="{{ $from  }}" placeholder="">
                            ～
                            <input type="date" class='end-form' name='e-date' id='date' value="{{ $until }}" placeholder="">
                        </label>

                    </div>
                    <div clas="center-block">
                        <div class="form-group">
                            <div>
                                <label for="">キーワード
                                    <div>
                                        <input type="text" name='keyword' value="{{ $keyword }}">
                                    </div>
                                </label>
                            </div>      
                            <div class="nav-item">
                                <div class='d-flex'>
                                    <label for="">年代
                                        <select name="age" data-toggle="select">
                                            <option value="">選択</option>
                                            <option value="10~19">10代</option>
                                            <option value="20~29">20代</option>
                                            <option value="30~39">30代</option>
                                            <option value="40~49">40代</option>
                                            <option value="50~59">50代</option>
                                            <option value="60~69">60代</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label for="">性別
                                    <form>
                                        <select name="medium" data-toggle="select">
                                            <option value="">性別</option>
                                            <option value="1">男性</option>
                                            <option value="2">女性</option>
                                            <option value="3">その他</option>
                                        </select>
                                    </form>
                                </label>
                            </div>

                            <div>
                                <input type="submit" class="btn" value="検索">
                            </div>
                        </div> 
                    </div>       
                </div>    
        </form>
      
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
                                    @foreach($items as $timeline_eat)
                                        <a href="{{ route('master.show',['master'=>$timeline_eat['user_id']]) }}">
                                            <img src="{{ asset('storage/icons/'.$timeline_eat['icon'])  }}" class="rounded-circle" width="50" height="50">
                                        </a>
                                        <p class="mb-0">{{ $timeline_eat['name'] }}</p>
                                        <p>{{ $timeline_eat['date'] }}</p>
                                        <p><img src="{{ asset('storage/images/'.$timeline_eat['image'])  }}"  width="300" height="150"></p>
                                        <p>{{ $timeline_eat['menu'] }}</p>
                                        <p>レシピ<br>{{ $timeline_eat['recipe'] }}</p>
                                        <form action ="{{route('master.destroy',['master'=>$timeline_eat['foodid']])}}" method='POST'>
                                            @method('delete')
                                            @csrf
                                            <button>削除</button>
                                        </form>
                                    @endforeach
                                </div>            
                            </div>
                        </div>    
                    </tbody>
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
                                @foreach($w_items as $timeline_body)
                                    <a href="{{ route('master.show',['master'=>$timeline_body['user_id']]) }}">
                                        <img src="{{ asset('storage/icons/'.$timeline_body['icon'])  }}" class="rounded-circle" width="50" height="50">
                                    </a>
                                    <p>{{ $timeline_body['name'] }}</p>
                                    <p>日付 {{ $timeline_body['date'] }}</p>
                                    <p>体重 {{ $timeline_body['weight'] }}</p>
                                    <p>体脂肪率 {{ $timeline_body['fat'] }}</p>
                                    <form action ="{{route('mastersub.destroy',['mastersub'=>$timeline_body['weightid']])}}" method='POST'>
                                        @method('delete')
                                        @csrf
                                        <button>削除</button>
                                     </form>
                                @endforeach    
                            </div>
                        </div>
                    </div>
                </table>
            </div>
        </div>
    </div>
@endsection
