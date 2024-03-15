@extends('layouts.emailp')

@section('content')
<div class="container">
    <!-- Sidebar - Brand -- Mail à la première création de code promo>
    <div class="row justify-content-center">
    <h1>  <!-- Sidebar - Brand -->
    <a href="https://elyamaje.com"><img src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";
					height="auto"; style="margin-top:20px;margin-left:15%";></a>       </h1>
   
    <p><strong>Message de votre {{ $valu['libelle'] }} Elyamaje</strong> </p>
    <p>Cher élève</p>
    <br/>
    <strong>{{ $valu['nom_ambassadrice'] }}</strong> vous a attribué un code éleve, vous donnant acces à 10% de réduction sur tous les produits elyamaje.<br/>
    <p>Voici votre code élève <strong>{{ $valu['code_promo'] }} pour effectuer vos achats</strong>, celui est valable une seule fois lors de votre premère commande.</p>
    <p></p>
    <div>Merci de visiter notre boutique pour effectuer vos achats 
    
    <a href="https://www.elyamaje.com">Visiter la boutique elyamaje</a></button>
    
    <p>L'equipe Elya Maje</p>
    </div>
    
    </div>
</div>
@endsection


