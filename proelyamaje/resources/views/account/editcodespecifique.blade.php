@extends('layouts.master')

@section('account')
<!-- Custom styles for this template-->
    <link href="{{asset('admin/css/account.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3">Gérer les modifications </h1>
        <a href="{{ route('account.list') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="background-color:black;color:white;border:2px solid black;"><i
                class="fas fa-download fa-sm text-white-50"></i>Lister des utilisateurs</a>
    </div>

    <!-- Content Row Mobile forms create account-->
    <div class="row" id="cards">
     <h6 class="m">Modification des données </h6>
        <!-- Earnings (Monthly) Card Example -->
        
        
        
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4" id="account_body">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m"><i style="font-size:13px" class="fa">&#xf044;</i></h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                        
                    
                    </div>
                </div>
                <!-- Card Body -->
                <div id="cards_content" style="width:800;margin-left:10%">
                   
                   <h1>{{ $resultat->status }}  {{ $resultat->name  }}</h1>
                   
                   
                    <form method="post" id="forms_codespeciales"  action="/account/list/codespecifique/{{ $resultat->id}}">
                    
                          @csrf
                       
                       
                     <label for="inputEmail4">Nom élève </label>
                    <input type="text"  class="form-control form-control-user"  name="nom" id="nom" required placeholder="" value="{{  $resultat->nom_eleve  }}">
                  
                       <label for="inputEmail4">Email (élève)</label>
                    <input type="text"  class="form-control form-control-user"  name="email" id="email" required placeholder=""  value="{{ $resultat->email  }}">
                    
                    
                    <label for="inputEmail4">Reduction (élève)</label>
                    <input type="text"  class="form-control form-control-user"  name="reduction" id="reduction" required placeholder=""  value="{{ $resultat->pourcentage  }} ">
                        
                        
                        <label for="inputEmail4">Commission</label>
                    <input type="number"  class="form-control form-control-user"  name="commission" id="commission" required placeholder=""  value="{{ $resultat->commission }}">
                    <input type="hidden" name="code_specifique"  value="{{  $resultat->code_promos  }}">
                  
            <button type="submit" id="" style="margin-top:50px;margin-left:15%;background-color:black;border:2px solid black;width:230px;color:white;padding:2%">Modifier </button>
          </div>
	
	    </form>
        
         @if (session('succes'))
         <div class="alert alert-succes" role="alert" id="alert_email" style="width:350px;height:85px;text-align:center;margin-top:-150px;margin-left:60%;border:2px solid green">
	      {{ session('succes') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif
                                 
          @if (session('errors'))
         <div class="alert alert-danger" role="alert" id="alert_email" style="width:350px;height:85px;text-align:center;margin-top:-150px;margin-left:60%;border:2px solid red">
	      {{ session('errors') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif                      
                                 
       

       </div>
    </div>

</div>
@endsection