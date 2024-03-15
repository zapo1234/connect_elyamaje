@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Bonjour {{ $email}} </h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p>Votre live a démarré, Votre code parrainage live est actif.</p>
                        <p></p>
                        <p>Il peut dès à présent être utilisé sur notre boutique par vos filleuls pour effectuer leur achats et recevoir leurs cadeaux</p>
                        <p></p>
                        <p>Celui-ci sera désactivé le lendemain à minuit</p>
                        <p>L'équipe Elya Maje</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection


