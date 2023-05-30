@extends('layouts.app')
@section('content')
    <div class="w-75 mx-auto">
        <div class="card-body">
            <div class="card-body">
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'></th>
                            <th scope='col'>ユーザー名</th>
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
                            @if($profile == null)
                            <th scpoe='col'><img src="{{ asset('storage/icons/'.$pro['icon']) }}" width="50%" height="50%" alt="アイコン"></th>
                            <th scope='col'>{{ $user['name'] }}</th>

                            <th scpoe='col'>{{ $pro['age'] }}</th>
                            @if ($pro['gender'] == 1)
                                    <th scope='col'>男性</th>
                                @elseif ($pro['gender'] == 2)
                                    <th scope='col'>女性</th>
                                @elseif ($pro['gender'] == 3)
                                    <th scope='col'>その他</th>
                                @endif
                            <th scpoe='col'>{{ $pro['comment'] }}</th>
                            <th scpoe='col'>{{ $pro['height'] }}cm</th>
                            <th scpoe='col'></th>
                            <th scpoe='col'>{{ $pro['target_weight'] }}kg</th>
                            <th scpoe='col'></th>
                            <th scpoe='col'>{{ $pro['target_fat'] }}%</th>

                            <th><form action ="{{route('masteraccount.destroy',['masteraccount'=>$pro['id']])}}" method='POST'>
                                @method('delete')
                                @csrf
                                <button>このユーザーのアカウントを削除する</button>
                            </form></th>

                            @else
                            <th scpoe='col'><img src="{{ asset('storage/icons/'.$profile['icon']) }}" width="50%" height="50%" alt="アイコン"></th>
                            <th scope='col'>{{ $user['name'] }}</th>

                            <th scpoe='col'>{{ $profile['age'] }}</th>
                            @if ($profile['gender'] == 1)
                                    <th scope='col'>男性</th>
                                @elseif ($profile['gender'] == 2)
                                    <th scope='col'>女性</th>
                                @elseif ($profile['gender'] == 3)
                                    <th scope='col'>その他</th>
                                @endif
                            <th scpoe='col'>{{ $profile['comment'] }}</th>
                            <th scpoe='col'>{{ $profile['height'] }}cm</th>
                            <th scpoe='col'>{{ $profile['weight'] }}kg</th>
                            <th scpoe='col'>{{ $profile['target_weight'] }}kg</th>
                            <th scpoe='col'>{{ $profile['fat'] }}%</th>
                            <th scpoe='col'>{{ $profile['target_fat'] }}%</th>
                            <th><form action ="{{route('masteraccount.destroy',['masteraccount'=>$profile['id']])}}" method='POST'>
                                @method('delete')
                                @csrf
                                <button>このユーザーのアカウントを削除する</button>
                            </form></th>
                            @endif
                        </tr>
                        <tr>
                        </tr>    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex" >
        <div class="eat_table">
            <div class="mx-auto">
                <div class="card-body">
                    <div class="card-body">
                        <table class='table'>
                            <!-- ここに登録情報を表示する -->
                            <tbody>
                                <p class="text-center">食事記録</p>
                            @foreach($food as $mypage_eat)
                            <tr>
                                <th scpoe='col'>{{ $mypage_eat['date'] }}</th>
                            </tr>
                            <tr>
                                <th scpoe='col'>{{ $mypage_eat['menu'] }}</th>
                                <th scpoe='col'><img src="{{ asset('storage/images/'.$mypage_eat['image']) }}" width="300" height="200" alt="アイコン"></th>
                            </tr>
                            <tr> 
                                <th scpoe='col'>{{ $mypage_eat['material'] }}</th>
                                <th scpoe='col'>{{ $mypage_eat['recipe'] }}</th>
                            </tr>
                            <tr>
                                <th><form action ="{{route('master.destroy',['master'=>$mypage_eat['id']])}}" method='POST'>
                                    @method('delete')
                                    @csrf
                                    <button>このツイートを削除する</button>
                                </form></th>
                            </tr>    
                            @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-md-4 pr-5">
            <div class="card-body">
                <div class="card-body">
                    <table class='table'>
                        <!-- ここに登録情報を表示する -->
                        <tbody>
                            <p class="text-center">体重・体脂肪記録</p>
                        @foreach($weight as $mypage_body)
                            <tr>
                                <th scpoe='col'>{{ $mypage_body['date'] }}</th>
                                <th scpoe='col'>{{ $mypage_body['weight'] }}kg</th>
                                <th scpoe='col'>{{ $mypage_body['fat'] }}%</th>
                            </tr>
                            <tr>
                                <th><form action ="{{route('mastersub.destroy',['mastersub'=>$mypage_body['id']])}}" method='POST'>
                                    @method('delete')
                                    @csrf
                                    <button>この体重・体脂肪率を削除する</button>
                                </form></th>
                            </tr>
                        @endforeach    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
        .eat_table{
            margin-left:450px;
        }
        .image{
            width:100px;
        }
        .favtable{
            margin-left:150px;
        }
</style>
