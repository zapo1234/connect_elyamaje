@extends('layouts.emailp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <h1>  <!-- Sidebar - Brand -->
    <a href="{{  route('ambassadrice.user')   }}"><img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";
					height="auto"; style="margin-top:20px;margin-left:15%";></a>       </h1>
   
   
    <p>Bonjour  Chère Patenaire<br/>
     Elyamaje as actualisé  en ce jour  votre solde de bon d'achat N° BON : <strong>{{ $code }}</strong></p>
     
     <table>
    <tr style="padding:2%">
     <td>Date</td> 
      <td>Attribution</td> 
    </tr> 
    <tr>
        <td>Solde existant</td>
        <td>{{ $montant_apis }}  €</td>
    </tr>
    
    <tr>
        <td>Date</td>
        <td>Attribution(€)</td>
    </tr>
    
      <tr>
        <td>{{ $date }}</td>
        <td> + <strong>{{ $somme }} € </strong></td>
    </tr>
    
     </table>
     <table style="margin-top:5px">
         <tr style="padding:2%;">
             <td>Date</td>
             <td>Solde actualisé</td>
         </tr>
         <tr>
            <td>{{ $date}}</td>
            <td> Solde actualisé <strong>{{ $solde }} € </strong></td>
         </tr>
     </table>
    
    
    <div>Merci de bien visiter notre Boutique Elyamaje en ligne <a href ="https://elyamaje.com">Boutique</a></div>
    
    </div>
</div>
@endsection
