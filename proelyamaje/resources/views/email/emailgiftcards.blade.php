@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Bonjour  Chère Patenaire</h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p>Elyamaje vous attribue en ce jour  <strong>{{ $date }}</strong> </p>
                        <p>Vous bénéficiez d'une somme de {{ $somme }} € sur le N° BON de bon achat suivant <strong>{{ $code_number  }}</strong></p>
                        <p>Solde à ce jour <strong> : {{ $somme }} €</strong></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection

