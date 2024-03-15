@extends('layouts.emailp')

@section('content')
<div class="container">
    <!-- Sidebar - Brand  Mail contenant update d'un edit de formulaire de code promo -->
    
    <div class="row justify-content-center">
    <h1>  <!-- Sidebar - Brand -->
    <a href="https://elyamaje.com"><img src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";
					height="auto"; style="margin-top:20px;margin-left:15%";></a>       </h1>
   
    <p><strong>Message {{ $libelle }} Elyamaje</strong> </p>
    <p>Cher élève {{ $nom_eleve }} <br/> <!-- Utilisiation de la variable name de l'élève à la place de la variable email -->
     <strong>{{ $nom_ambassadrice }}</strong> vous a attribué un code éleve vous donnant acces à 10% sur les produits elyamaje .<br/> <!-- Utilisiation de la variable name de l'élève à la place de la variable email -->
     Voici votre code élève <strong>{{ $code_promo }} pour effectuer vos achats</strong>, celui est valable une seule fois lors de votre premère commande. 
     </p>
    
    <div> Merci de bien visiter notre boutique <button type="button" style="background-color:black;width:250px;padding:1%;border:2px solid black;color:white;"><a href="https://elyamaje.com">Visiter la boutique elyamaje</a></button></div>
    
    <p>L'equipe Elya Maje</p>
    </div>
</div>
@endsection


