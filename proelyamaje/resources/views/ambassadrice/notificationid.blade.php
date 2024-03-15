@extends('layouts.master')

@section('account')
<!-- Custom styles for this template-->
    <link href="{{asset('admin/css/account.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3">Suivi de commande client </h1>
       <span id="error_delete"></span> <a href="{{ route('ambassadrice.account') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="background-color:black;color:white;border:2px solid black;"><i
                class="fas fa-download fa-sm text-white-50"></i>Créer un code promo élève</a>
    </div>

    <!-- Content Row --model mobile-->
    <div class="row" id="cards">
    <button style="background-color:black;color:white;border:2px solid black;margin-left:50%;border-radius:15px;"><i class="fas fa-download fa-sm text-white-50"></i><a href ="{{ route('ambassadrice.account')  }}" style="color:white;">Créer un code promo élève</a></button><br/>
      <div class="h3" style="margin-top:20px;">Détails de la commande <strong> N°{{ $users['id_commande'] }} </strong></div>
      
      
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="" style="border:1px solid #eee" width="500px" height:"180px">
                <div class="card-body" id="list">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text">
                             Réalisée le <br/>{{ $users['datet']}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users['customer'] }}</br/>
                                <div>Code Promo</div>
                                <span class="der" style="color:green"> {{ $users['code_promo'] }}</span><br/>
                               <span class="dscom" style="padding-left:60%;">{{ number_format($users['somme'], 2, ',', '') }} € </span>
                               
                               
                            
                              </div>        
                        </div>
                        <div class="col-auto">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    

    
   </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4" id="account_body">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m"><i style="font-size:13px" class="fa">&#xf044;</i> Détails de la commande  N°{{ $users['id_commande']   }}<span class="recher"></span></h6>
                    
                    
                </div>
                <!-- Card Body -->
                <div id="cards_content">
                 <table class="table table-striped" id="table_orders">
                 <thead>
                  <tr>
                
                 <th scope="col" style="color:black;font-size:16px;font-weight:300"><i class="fa fa-calendar" aria-hidden="true"></i> Date d'achat</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                 <th scope="col">E-mail</th>
                 <th scope="col"><i class="fas fa-phone"></i> Téléphone</th>
                  <th scope="col"> code_promo</th>
                  
                  </tr>
               </thead>
             <tbody>
             
             
             <tr>
               <th scope="row">Achat réalisé le <br/>{{ $users['datet'] }}</th>
              <td>{{ $users['customer'] }}</td>
               <td>{{ $users['email']}}</td>
              <td>{{ $users['telephone'] }}</td>
              <td>{{ $users['code_promo'] }}</td>
             
               <td> <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            
                    </div>    </td>  
                 
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