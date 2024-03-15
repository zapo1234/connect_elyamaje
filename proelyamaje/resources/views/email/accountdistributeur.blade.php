@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Votre 1 ère commande à été valide par Elyamaje</h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p>Bonjour <strong></strong> Elyamaje vous as crée un compte client sur sa boutique </p>
                        <p>Activer votre compte sur notre boutique ! </p>
                        <p><button type="button" style="background-color:black;width:250px;padding:1%;border:2px solid black;color:white;border-radius:5px"><a href="https://www.elyamaje.com/wp-login.php?action=lostpassword">Activer votre compte</a></button></div>  </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection