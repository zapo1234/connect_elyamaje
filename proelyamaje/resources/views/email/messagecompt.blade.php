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
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p>Bonjour chère Ambassadrice,</p>
                        <p>Nous vous envoyons ce mail afin de vous informer qu'une plateforme "Ambassadrice" a été créée dans le but que vous gêneriez les codes de réduction pour vos élèves et activiez vos codes de parrainage pour les lives vous-même.
                        <p>L'adresse de la plateforme est la suivante :</p>
                        <p><strong>https://connect.elyamaje.com/login</strong></p>
                        <br/>Votre identifiant et mot de passe sont les suivants :<br/><br/>
                        <p>Login : <strong>  {{ $email }} </strong></p>
                        <p>Mot de passe : <strong> {{ $password_creat }}</strong><br/><br/></p>
                        <p>Celui-ci peut bien sûr être redéfini en cliquant sur "mot de passe oublié".</p>
                        <p>À retenir :</p>
                        <p>Pour créer des codes élèves, il faut au préalable disposer de l'adresse mail de votre élève, nom et prénom, afin que celui-ci reçoive son code de réduction directement</p>
                        <p>Les autres champs du formulaire sont optionnels.<br/></p>
                        <p>Pour les lives, il suffit de demander un live depuis le formulaire afin que celui-ci soit programmé. Puis le jour du live, vous pourrez lancer votre code parrainage 3 h avant le live afin d'activer celui-ci.</p>
                        <p>Une vidéo explicative détaillée sera mise à disposition sur notre YouTube (en privé) afin que vous compreniez comment la plateforme fonctionne en profondeur.<br/><br/></p>
                        <p>N.B : Si vous rencontrez un problème pour vous connecter, merci de vous rendre cette adresse :</p>
                        <p>https://connect.elyamaje.com/logout.</p>
                        <br/>
                        <p>De notre côté, nous ne pourrons plus générer les codes, néanmoins si vous rencontrez des problèmes, vous pourrez toujours nous contacter afin que l'on vous vienne en aide.</p>
                        <p>De futures évolutions de la plateforme sont à venir : Historique de facture, envoie de code élevé par sms, Statistiques sur plusieurs mois...etc.  Nous vous tiendrons au courant de leurs disponibilités.</p>
                        <p>N'hésitez pas à nous contacter si vous avez besoin de renseignements.<br/></p>
                        <p>Cordialement.</br/><br/></p>

                        -- 
                        
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