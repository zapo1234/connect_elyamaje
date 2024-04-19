@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Bonjour Chère Ambassadrice</h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        vous a attribué un code promotionnel. Grâce à ce code, vous avez accès à 10% de reduction sur tous les produits du site <a href="elyamaje.com">elyamaje.com</a>.<br/><br/>
                      Voici votre code élève <strong>{{ $code }}</strong> pour effectuer vos achats. <br><br>
                      Ce code est valable une seule fois lors de votre première commande.<br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection