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
                        <p>L'ambassadrice <strong>{{ $name_ambassadrice }}</strong> a mis à jour ses coordonnées bancaires  <strong>{{ $date  }}</strong></p>
                        <p>Vous pouvez  consulter directement  ses coordonnées dans la gestion de facture depuis la plateforme(ERP CONNECT).</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection
