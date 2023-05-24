
@extends('layouts.app')
@section('content')
</head>
<body>
<div class="container">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">体重・体脂肪記録 編集</div>
                    <div class="m-4 ml-5">

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


                        <form action="{{ route('master.update',['master'=>$weights['id']])}}" method="post">
                           @csrf
                           @method('patch')
                           <fieldset>
                           <label for='date' class='mt-2'>記録日</legend><br>
                                <input type="date" name="date" class="border border-primary my-20" value="{{ $weights['date'] }}">
                           </fieldset>
                           <fieldset>
                           <label class='mt-2'>体重</label><br>
                                <input type="number" class="border border-primary" name='weight' id="weight" step="0.1" min="0" value="{{ $weights['weight'] }}"> 
                           </fieldset>
                           <fieldset>
                           <label class='mt-2'>体脂肪率</legend><br>
                                <input type="number" id="fat" step="0.1" min="0" class="border border-primary my-20" name='fat' value="{{ $weights['fat'] }}"> 
                           <label for='comment' class='mt-2'>コメント</label>
                                <textarea class='form-control' name='comment' >{{ $weights['comment'] }}</textarea>

                        </div>

                        <div>
                                <button type='submit' class='btn btn-primary w-15 mt-3 mr-auto'>編集</button>
                        </div>
                     </form>
             </div>
        </div>
</div>

<style>
  input[type="number"] {
   width: 80px;
   border: none;
  }
  input[type="text"] {
   width: 80px;
   border: none;
  }
  button {
   border: none;
   background-color: #008CBA;
   color: white;
   padding: 10px;
   border-radius: 5px;
   
  }
 </style>
@endsection