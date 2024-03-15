@extends('layouts.master')

@section('account')
<!-- Custom styles for this template-->
    <link href="{{asset('admin/css/account.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3">Suivi des cartes Bancaires utilisées  </h1>
       <span id="codecss{{ Auth()->user()->is_admin }}"><a href="{{ route('ambassadrice.account') }}" id="code{{ Auth()->user()->is_admin }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="background-color:black;color:white;border:2px solid black;"><i
                class="fas fa-download fa-sm text-white-50"></i>Créer un code promo élève</a></span>
    </div>

    <!-- Content Row --model mobile-->
    <div class="row" id="cards">
   
      <div class="h3" style="margin-top:20px;">Code spécifiques  </div>
      
      
    
   </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4" id="account_body">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m">  <span class="r" style="color:green;font-size:14px"> {{ $message  }}  </span></h6>
                    
                    
                </div>
                <!-- Card Body -->
                <div id="cards_content">
                 <table class="table table-striped" id="table_orders">
                 <thead>
                  <tr>
                <th></th>
                 <th scope="col" style="color:black;font-size:16px;font-weight:300"><i class="fa fa-calendar" aria-hidden="true"></i> Date création</th>
                 
                <th scope="col">Identité</th>
                 <th scope="col">code_promo</th>
                 <th scope="col">Id-commande</th>
                  </tr>
               </thead>
             <tbody>
             
            <tr>
                
                <td></td>
                
            </tr>
           
  </tbody>
  
  </table>  
                       
    <div class="lin"></div>
            <div id="resultat"></div><!--resultat ajax- access-->
            <div="pak" style="display:none"></div>
            
           

        </div>

       </div>
    </div>

</div>
@endsection
