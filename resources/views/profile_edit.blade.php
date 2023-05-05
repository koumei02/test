@extends('layouts.app')
@section('content')
<main class="py-4">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-header">
                    プロフィール編集
                </div>
                
                <div class="card-body">
                    <div class="card-body">
                        <form action="{{route('auto.update', ['auto' => Auth::id()])}}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <input type="file" name="icon">

                            <label for='number' >年齢</label>
                                <input type='number' class='form-control w-25' name='age'>
                            <label for='type' class='mt-2'>性別</label>
                            <select name='gender' class='form-control w-50'>
                                <option value='' >選択してください</option>
                                <option value='0' >男性</option>
                                <option value='1' >女性</option>
                                <option value='2' >その他</option>
                            </select>

                            </select>
                            <label for='comment' class='mt-2'>コメント</label>
                                <textarea class='form-control' name='comment' ></textarea>
                                <!-- ここにオールド関数入れる -->
                            <label for='number' class='mt-2' >身長</label>
                                <input type='number' class='form-control w-25' step="0.1" min="0" name='height'>


                            <label for='number' class='mt-2' >目標体重</label>
                                <input type='number' class='form-control w-25' step="0.1" min="0" name='target_weight'>
                            <label for='number' class='mt-2'>目標体脂肪率</label>
                                <input type='number' class='form-control w-25' step="0.1" min="0" name='target_fat'>

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