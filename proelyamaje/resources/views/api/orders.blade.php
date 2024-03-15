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
        <h1 class="h3">Gérer les données des commandes élève </h1>
        <form method="post" action="/data/society/orders">
        @csrf
        <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="background-color:black;color:white;border:2px solid black;"><i
                class="fas fa-download fa-sm text-white-50"></i>Export csv tiers</a></button>
        
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="background-color:black;color:white;border:2px solid black;"><i
                class="fas fa-download fa-sm text-white-50"></i>Transférer des orders Api</button>
            </form>
    </div>

    <!-- Content Row --Mobile -->
    <div class="row" id="cards">
        <form method="post" action="">
    <button type="button" style="background-color:black;color:white;border:2px solid black;margin-left:50%;border-radius:15px;"><i class="fas fa-download fa-sm text-white-50"></i> Transférer Api commandes</button>
    </form>
      <div class="h3" style="margin-top:20px;">Listing des commande via api </div>
      
       

        
   </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4" id="account_body">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m"><i style="font-size:13px" class="fa">&#xf044;</i> Suivi de commandes journalières récentes<span class="recher"></span></h6>
                
                     
                        <input type="search" id="search_origine" class="form-control" placeholder="filtrer en fonction de l'origine" />
                        <button type="button" class="btn btn-primary">
                   <i class="fas fa-search"></i>
                  </button>
                    
                    <span style="font-size:20px; padding-left:-5%;color:black;">Total(ttc) :200000 Eur</span>
                
                </div>
                <!-- Card Body -->
                <div id="cards_content">
                 
                 <table class="table table-striped" style="height:600px;">
                 <thead>
                  <tr>
                
                 <th scope="col" style="color:black;font-size:16px;font-weight:300"><i class="fa fa-calendar" aria-hidden="true"></i>  Date </th>
                <th scope="col">Nom</th>
                 <th scope="col">E-mail</th>
                 <th scope="col">Statuts commande</th>
                 <th scope="col">Adresse</th>
                  <th scope="col">Origine</th>
                 <th scope="col"><i class="fas fa-phone"></i> Téléphone</th>
                 <th scope="col">Total(cout)</th>
                 <th scope="col"> infos </th>
                  </tr>
               </thead>
             <tbody>
             
             @foreach($datas as $resultat)
               
             <tr>
               <th scope="row">Réalisée le  <br/> {{ $resultat['date_created'] }}</th>
              <td>{{ $resultat['Nom_client'] }}</td>
               <td>{{ $resultat['email'] }}</td>
                <td><div class="{{ $resultat['css'] }}">{{ $resultat['status'] }}</div> </td>
              <td>{{ $resultat['adresse'] }}</td>
              <td> <span class="{{ $resultat['origine'] }}"> {{ $resultat['origine'] }} </span></td>
              <td>{{ $resultat['phone'] }}</td>
              <td> {{ $resultat['total'] }}  €</td>
              <td> <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            
                            <a class="dropdown-item" href="#"><i class='far fa-paper-plane' style='font-size:12px'></i>   envoyer</a>
                            <a class="dropdown-item" href="#">Détails</a>
                            
                        </div>
                        
                    
                    </div></td>
             </tr>
            
           @endforeach
           
    </tbody>
  </table>  
                       
            
           </div>

       </div>
    </div>

</div>

         <div class="resultat"></div><!--resultat ajax- access-->
            <div="pak" style="display:none"></div>
            


@endsection
