@extends('layouts.emailp')



@section('content')

<div class="container">


    <a href="https://elyamaje.com"><img src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";

					height="auto"; style="margin-top:20px;margin-left:15%";></a>       </h1>

   

     Bonjour Mourad.

     <p> Voici {{ $valu['code_promo'] }}</p>

    

    

    </div>

</div>

@endsection





