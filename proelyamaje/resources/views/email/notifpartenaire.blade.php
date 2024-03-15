@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Notification de paiment chez Elyamaje</h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p> Bonjour Chère  <strong>{{ $libelle }},</strong> <br/> Vous avez cummulé une cagnotte de <strong></strong>{{ $montant }}  </strong> à ce jour {{ $date }} ,  </p>
                        <h3>Choisir un moyen de paiment pour votre facture</h3>
                        <p>Cliquer le bouton continuer pour valider votre choix</p>
                        <p style="width:fit-content;"><a style="padding:15px;background-color:#000000;display:block;text-decoration:none; color:#ffffff" href="{{ route('partenaire.paiementuser', ['code_amba' => $code_amba, 'token'=>$token]) }}">Continuez ici</a></p>
                        <p>L'équipe Elya Maje</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection

	