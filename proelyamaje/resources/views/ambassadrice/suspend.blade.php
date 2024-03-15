@extends('auth.layouts.app')

@section('content')
<div class="row justify-content-center" style="margin-left:10%;">

    <div class="col-xl-8 col-lg-7 col-md-1">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card">
                <!-- Nested Row within Card Body -->
 
                    <div class="col-lg-10"><br/>
					<img id="imj" src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";
					height="auto">
                        <div class="p-5">
                            <div class="text-center">
                                <div class="titre" style="font-size:20px;text-transform:uppercase;margin-top:-30px;">Service Saas</div>
                                
                                <div class="alert alert-danger" role="alert"  id="alert1" style="width:350px;height:90px;border:2px solid red">
	                            Votre compte est restreint temporairement <br/>Contactez Elyamaje !
                                </div>
                                <div> <button style="background-color:black;color:white;text-align:center;width:225px;height:40px;border:2px solid black;color:white;margin-left:10%"><a href="{{ route('logout') }}" style="color:white">Continuer ici </a></button></div>
                            </div>
                            
                            
                                
                               
                        
                              
        </div>

    </div>

</div>


@endsection


