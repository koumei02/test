@extends('layouts.aside')
@extends('layouts.app')
@section('content')


    <div class="col-md-5 mx-auto">
            <div class="card-body">
                <div class="card-body">
                    <table class='table'>
                        <!-- ここに登録情報を表示する -->
                        <tbody>
                        @foreach($food as $mypage_eat)
                            <tr>
                                <th scpoe='col'>{{ $mypage_eat['date'] }}</th>
                                <th scpoe='col'><img src="{{ asset('storage/images/'.$mypage_eat['image']) }}"  class="img-fluid" alt="アイコン"></th>
                                <th scpoe='col'>{{ $mypage_eat['menu'] }}</th>
                                <th scpoe='col'>{{ $mypage_eat['recipe'] }}</th>
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
                    @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
