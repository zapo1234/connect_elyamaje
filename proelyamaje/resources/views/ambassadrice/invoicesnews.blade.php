<!DOCTYPE html>
<html>
<head>
    <title>Facture Elyamaje</title>
    
    <style type="text/css">
    
    #table_orders th{width:30%;height:50px;text-align:center;color:black;border:1px solid #eee}
    #table_orders{width:90%;margin-left:7%;margin-top:-80px;}
    #table_orders td{width:30%;text-align:center;border:1px solid black;}
    #total{margin-left:70%;margin-top:40px;border:2px solid black;}
    .aei{display:none;}
     .xxxx {display:none; } #tab{display:none;} #tabsc{display:none;}
     .footertab{display:none;}
    </style>
    
    <script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('admin/js/sb-admin-2.min.js')}}"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
         
    <script type="text/javascript">
      
          alert('zapo');
      
    </script>
    
</head>
<body>
    
    <div class="content" style="margin-left:5%"></div>
    <div class="content" style="margin-left:3%">
     <table id="headers" style="padding:1%;border:1px solid black;width:270px;height:150px;padding:0.5%;">
     <tr>
                       <td> Entreprise </td>
                       <td>{{ $denomination }}</td>
                       </tr>
                      <tr>
                       <td>Adresse </td>
                       <td> {{ $adresse }} {{ $code_postal }}<br/>{{ $ville  }}</td>
                       </tr>
                       <tr>
                       <td>Tél</td>
                       <td>{{ $telephone }}</td>
                       </tr>
                       <tr>
                       <td>Mail </td>
                       <td>{{ $email }}</td>
                       </tr>
                       
                       <tr>
                       <td>Siret</td>
                       <td>{{ $siret }}</td>
                       </tr>
                       
                   </tr> 
         
     </table>
        
        
    </div>
    
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4" id="account_body">
                <!-- Card Header - Dropdown -->
                <div class="content1">
                <table class="tab1" style="margin-left:60%; margin-top:20px;width:270px;height:150px;padding:0.5%;text-align:center;font-size:15px;">
                   <tr>
                       <td style="font-size:20px;text-transform:uppercase;margin-boottom:15px;"> Client <br/></td>
                      
                       </tr>
                      
                          <td ><span class="c" style="font-size:18px;color:black;font-weight:bold;">Elyamaje</span><br/>
                          
                          16 Boulevard Gueidon,<br/>
                          13013 Marseille <br/><br/>
                          Téléphone : 04 91 84 77 50
                         
                     </tr> 
                    
                </table>
                    
                </div>
                
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div style="font-size:22px">Date de facture<br/></div>
                 <div style="font-size:22px;font-weigt:bold;color:#000;"> Période: {{ $periode }}</div>  
                 
                 <div style="font-size:22px;font-weigt:bold;color:#000;">N °facture {{ $numero_facture  }} </div> 
                 
                 
                 {{ $status }} <br/>{{ $codecards }}
            
                    
                </div>
                <div class="footer{{ $foot  }}" style="font-size:13px;color:black;font-weigt:bold;position:absolute;width:90%;height:50px;font-size:15px;top:1040px;text-align:center;left:2%">
                {{ $denomination   }} - N° siret {{ $siret }} - domiciliée au {{  $adresse  }} {{ $code_postal   }} - {{ $ville  }}  -- 1
               </div><!--footer page 1-->
                <!-- Card Body... -->
                <div id="cards_content">
                 <table class="table table-striped" id="table_orders" style="margin-top:90px">
                 <thead>
                  <tr>
                  <th>Nature commission</th>
                  <th>Nombre vente</th>
                  <th>Total généré(HT) </th>
                  </tr>
               </thead>
             <tbody>
             
             <tr>
             <td> Commission élève </td>
              <td> {{ $nombre_vente_eleve }} </td>
              <td> {{ $somme_eleve}} €</td>
             </tr>
            
             <tr>
             <td>Commission Lives</td>
              <td> {{ $nombre_vente_live }} </td>
              <td> {{ $somme_live  }} €</td>
             </tr>

           
  </tbody>
   </table> 
   
   
   <div class="titr" style="text-align:center;font-size:18px;margin-top:10px;">{{ $titre  }}</div>
   
   <table class="table table-striped" id="table_orders" style="margin-top:10px">
                 <thead>
                
               </thead>
             <tbody>
             
            @foreach($chaine_array_refunded as $resultats)
             <tr class="refunded" style="background-color:#eee;">
              <td>{{ $resultats['datet'] }}</td>
               <td>{{ $resultats['id_commande']  }}</td>
               <td> {{ $resultats['customer'] }} </td>
              <td> {{ number_format($resultats['total_ht'], 2, ',', '') }}</td>
              <td> {{ number_format($resultats['somme'], 2, ',', '') }} €</td>
             
               
            </tr>
            
          @endforeach
           
  </tbody>
  
   </table> 
   
   
   
    <table id="total" style="margin-top:20px">
     <tr>
       <td style="font-size:18px;color:black;font-weight:bold">{{ $ht }}</td>  
       <td style="font-size:18px;padding-left:2%;color:#000;"> {{ number_format($somme, 2, ',', '') }} € </td>
    </tr>
    
        <tr>
       <td style="font-size:18px;color:black;font-weight:bold">{{ $tva }}</td>  
       <td class="{{ $css1 }}" style="font-size:18px;color:black;font-weight:bold">{{ number_format($som, 2, ',', '') }} €</td>  
    </tr>
    
     </tr>
    
        <tr>
       <td style="font-size:18px;color:black;font-weight:bold">{{ $ttc }}</td>  
       <td class="{{ $css1 }}" style="font-size:20px;color:#000;font-weight:bold">{{ number_format($sommetc, 2, ',', '') }}  €</td>  
    </tr>
       
   </table>
   
   
    <table id="total" class=" {{ $css }}">
     <tr>
       <td style="font-size:20px;color:black;font-weight:bold">{{ $details  }}</td>  
       <td  class=" {{ number_format($somme_refunded1, 2, ',', '') }}" style="font-size:25px;padding-left:2%;color:#000;"> {{ number_format($somme_refunded1, 2, ',', '') }} € </td>
    </tr>
       
   </table>
   
   
   <table id="total" class="{{ $css  }}">
     <tr>
       <td style="font-size:20px;color:black;font-weight:bold">{{ $final  }}</td>  
       <td style="font-size:20px;padding-left:2%;color:#000;"> {{ number_format($somme_reel_final, 2, ',', '') }} € </td>
    </tr>
       
   </table>
   
   
   <div style="margin-left:55%;margin-top:10px;"> {{$lecture}} </div>
   
   <div class="footer{{ $foot }}" id="{{ $csscount }}" style="color:black;font-weigt:bold;position:absolute;width:90%;height:50px;top:1040px;font-size:15px;text-align:center;left:2%">
     {{  $denomination }} - N° siret {{ $siret }} - domiciliée au {{  $adresse  }} {{ $code_postal   }} - {{ $ville  }}  -- 2
   </div>
   
    <div class="footer{{ $foot }}" id="{{ $csscounts }}" style="color:black;font-weigt:bold;position:absolute;width:90%;height:50px;top:2080px;font-size:15px;text-align:center;left:2%">
     {{  $denomination }} - N° siret {{ $siret }} - domiciliée au {{  $adresse  }} {{ $code_postal   }} - {{ $ville  }}  -- 2
   </div>
         
                     
</body>
</html>