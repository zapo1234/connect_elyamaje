@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Notification de paiement chez Elyamaje</h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>       
                        <p>Bonjour </p><br>
                        <p>{{ $status }} <strong>{{ $infos_name }}</strong> à plus de 200 euros dans sa cagnote, et souhaite un paiement de sa facture par le canal ci-dessous. !</p><br>
                        <div class="form_validateactive">
                            <strong>Par un {{  $libelle    }}</strong><br>
                        </div>  
                        <p>L'équipe Elya Maje</p><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection

	