@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Vos nouveaux accès Connect chez Elyamaje</h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p> Bonjour  </p>
                        <p>Vous avez effectué  une demande de réinitialisation de votre mot de pass.</p>
                        <p>Votre nouveau mot de pass est : <strong>{{ $pass }}</strong>
                        <p style="width:fit-content;"><a style="padding:15px;background-color:#000000;display:block;text-decoration:none; color:#ffffff" href="https://connect.elyamaje.com/login">Continuez ici</a></p>
                        <p>L'équipe Elya Maje</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection

	