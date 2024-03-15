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
                        <p>Nous avons reçu une ou des commandes de distributeurs en attente de traitement :  <strong>{{ $date }}</strong></p>
                        <p>Voici les N° de commandes suivantes à traiter {{  $datas_ids_commandes }}</p>
                        <p>Veuillez Préparer ces commandes distributeurs dans les meilleurs délai et changer le statut une fois celle ci pretes afin d'avertir le distributeur.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection

