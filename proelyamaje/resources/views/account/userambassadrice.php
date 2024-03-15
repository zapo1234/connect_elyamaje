@extends('layouts.master')

@section('account')
<!-- Custom styles for this template-->
    <link href="{{asset('admin/css/account.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3">Ambassadrice :</h1>
       <span id="error_delete"></span> <a href="{{ route('account.users') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="background-color:black;color:white;border:2px solid black;"><i
                class="fas fa-download fa-sm text-white-50"></i>Créer un compte</a>
    </div>

    <!-- Content Row --model mobile-->
    <div class="row" id="cards">
    <button style="background-color:black;color:white;border:2px solid black;margin-left:50%;border-radius:15px;"><i class="fas fa-download fa-sm text-white-50"></i><a href ="{{ route('account.users')  }}" style="color:white;">Créer un compte</a></button><br/>
      <div class="h3" style="margin-top:20px;">Lister des codes promo élèves </div>
      
      
        

        
   </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4" id="account_body">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m"><i style="font-size:13px" class="fa">&#xf044;</i> Listes des codes promo élèves  <span class="recher"></span></h6>
                    
                    
                </div>
                <!-- Card Body -->
                <div id="cards_content">
                 <table class="table table-striped" id="table_orders">
                 
</table>  
                       
            <div id="resultat"></div><!--resultat ajax- access-->
            <div="pak" style="display:none"></div>
            
           

        </div>

       </div>
    </div>

</div>
@endsection
