@extends('layouts.master')

@section('account')
<!-- Custom styles for this template-->
    <link href="{{asset('admin/css/account.css')}}" rel="stylesheet">
     <link href="{{asset('admin/css/apiorders.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3">Mise à jour des stocks dans dolibar  ! </h1>
        
         @if (session('success'))
         <div class="alert alert-success" role="alert" id="alert_emails" style="width:300px;height:55px;text-align:center;margin-top:-30px;padding:0.5%">
	      {{ session('success') }}
          </div>
        @elseif(session('failed'))
                           
        @endif
        
        <form method="post" action="">
        @csrf
        <button type="button" id="buttoncodepromo" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="background-color:green;color:white;border:2px solid green;"><i
                class="fas fa-download fa-sm text-white-50"></i>Export</button>
        
            </form>
        
        
    </div>

    <!-- Content Row --Mobile -->
    <div class="row" id="cards">
        
      

        
   </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4" id="account_body">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m"> <span class="recher">Mettre à jour vos stocks </span></h6>
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
                <div id="cards_content">
                 
             
           

        </div>

       </div>
               <div id="resultats"></div><!--resutat requete ajax-->
       <div id="pak" style="display:none"></div>
       <div class="form_api_codepromo" style="display:none">
       <form method="post" id="transfers_coupon_api" action="/datas/coupons">
             @csrf
           <h2>Transférez vos articles dolibar </h2>
           <div id="error_code"></div>
           
          <button type="button" class="annuler">Annuler</button>
          <button type="submit"  id="transfers_codepromo" class="envoi"><i class="fas fa-download fa-sm text-white-50"></i> Transférer</button>
         </form>
           
       </div><!--.form_api-->
       
       
       <div class="forms_csv" style="display:none">
       
       
       
       
    </div>
    
   
        
        
        


</div>
@endsection