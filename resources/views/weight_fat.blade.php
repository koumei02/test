@extends('layouts.app')
@extends('layouts.aside')
@section('content')
</head>
<body>
<div class="container">
        <div class="col-md-8">
            <div class="card">
               <br><br>
                <div class="card-header">体重・体脂肪記録</div>
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


                        <form action="{{ route('auto.store')}}" method="post">
                           @csrf
                           <fieldset>
                           <label for='date' class='mt-2'>記録日</legend><br>
                                <input type="date" name="date" class="border border-primary my-20">
                           </fieldset>
                           <fieldset>
                           <label class='mt-2'>体重</label><br>
                                <input type="number" class="border border-primary" name='weight' id="weight" step="0.1" min="0"> 
                           </fieldset>
                           <fieldset>
                           <label class='mt-2'>体脂肪率</legend><br>
                                <input type="number" id="fat" step="0.1" min="0" class="border border-primary my-20" name='fat'> 

                        </div>

                        <div>
                                <button type='submit' class='btn btn-primary w-15 mt-3 mr-auto'>登録</button>
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