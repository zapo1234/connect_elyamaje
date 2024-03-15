@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Création de votre compte utilisateur Chez Elyamaje</h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img  src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p>Bonjour </p>
                        <p>Vous êtes utilisateur interne chez elyamaje</p>
                        <p>L'adresse de la plateforme est la suivante :</p>
                        <p><strong>https://connect.elyamaje.com/login</strong></p>
                        <br/>Votre identifiant et mot de passe sont les suivants :<br/><br/>
                        <p>Login : <strong>  {{ $email }} </strong></p>
                        <p>Mot de passe : <strong> {{ $password_creat }}</strong><br/><br/></p>
                        <p>Celui-ci peut bien sûr être redéfini en cliquant sur "mot de passe oublié".</p>
                        <p>À retenir :</p>
                        <p>Une vidéo explicative détaillée sera mise à disposition sur notre YouTube (en privé) afin que vous compreniez comment la plateforme fonctionne en profondeur.<br/><br/></p>
                        <p>N.B : Si vous rencontrez un problème pour vous connecter, merci de vous rendre cette adresse :</p>
                        <p>https://connect.elyamaje.com/logout.</p>
                        <br/>
                        <p>Cordialement.</br/><br/></p>
                          -- -- -- -- -- -- -- 
                        <p>Majeri Mourad - Directeur Technique </p>
                        <p>Tel +33 (0) 7 77 38 85 96</p>
                        <p>Tel +33 (0) 4 91 84 77 50</p>
                        <p>Elya Maje - 18 rue Melchior Guinot - 13002 Marseille - France</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection