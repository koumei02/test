@extends('layouts.app')
@section('content')
<main class="py-4">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-header">
                    プロフィール登録
                </div>
                
                <div class="card-body">
                    <div class="card-body">
                        <form action="{{route('master.store')}}" method="post" enctype="multipart/form-data">
                            
                            @csrf
                            <input type="file" name="icon">

                            <label for='number' >年齢</label>
                                <input type='number' class='form-control w-25' name='age' value ="">
                            <label for='type' class='mt-2'>性別</label>
                            <select name='gender' class='form-control w-50'>
                                <option value='0' >選択してください</option>
                                    <option value='1' >男性</option>
                                    <option value='2' >女性</option>
                                    <option value='3' >その他</option>


                            </select>

                            </select>
                            <label for='comment' class='mt-2' >コメント</label>
                                <textarea class='form-control' name='comment' value =""></textarea>
                                <!-- ここにオールド関数入れる -->
                            <label for='number' class='mt-2' >身長</label>
                                <input type='number' class='form-control w-25' step="0.1" min="0" name='height' value ="">


                            <label for='number' class='mt-2' >目標体重</label>
                                <input type='number' class='form-control w-25' step="0.1" min="0" name='target_weight' value ="">
                            <label for='number' class='mt-2'>目標体脂肪率</label>
                                <input type='number' class='form-control w-25' step="0.1" min="0" name='target_fat' value ="">

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