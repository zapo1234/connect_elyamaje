@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Bonjour chere ambassadrice {{ $name }}  </h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p>Vous avez demandé à faire un live le <strong> {{ $date_finish1 }} </strong>, votre demande a bien été prise en compte et sera validée sous peu.</p>
                        <p>Une fois cette demande validée par notre équipe, il ne vous restera plus qu'à activer votre live prévue le <strong>{{ $date_finish1 }}</strong> depuis votre accès ambassadrice.</p>
                        <p>Un bouton fera son apparition 3 heures avant le debut de votre live sur votre espace ambassadrice pour activer le code parainage live.</p>
                        <p>Pour rappel: Afin de paramétrer votre live à la date souhaitée sur notre plateforme, merci de faire la demande de live 6 heures avant la date et heure prévue, pendant les jours ouvrés</p>
                        <p>L'équipe Elya Maje</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection