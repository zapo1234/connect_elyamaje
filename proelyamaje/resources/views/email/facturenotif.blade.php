@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Bonjour {{ $name }}</h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p>Le paiement de votre comission du mois de  <strong>{{ $mois  }} {{ $annee  }}</strong> d'un montant de {{ $somme }} € chez Elyamaje vient d'etre effectué</p>
                        <p>Consultez l'historique de vos factures sur notre plateforme : https://www.connect.elyamaje.com</p>
                        <p>Merci pour votre confiance</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection





