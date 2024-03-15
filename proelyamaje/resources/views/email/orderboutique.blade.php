@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Bonjour, </h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p>Nous avons reçu une ou des commandes à préparer en magasin : le <strong>{{ $date }}</strong></p>
                        <p>Voici les N° de commandes suivant à traiter {{  $datas_ids_commandes }}</p>
                        <p>Veuillez Préparez ces commandes en magasin pour permettre au clients de venir les recupérer</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection

