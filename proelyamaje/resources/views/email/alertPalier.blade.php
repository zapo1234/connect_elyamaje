@extends('layouts.emailp')

@section('content')

<table style="color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="border-style:solid; border-width:1px; border-color:#edeff1;" width="auto" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                        <h1>Bonjour {{ $name}} {{ $username}}</h1>
                        <a href="{{  route('ambassadrice.user')   }}">
                            <img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px"; height="auto"; style="margin-top:20px;";>
                        </a>   
                        
                        @if($empty)
                            <p>Une modifications de la configuration de palier à eu lieu par un administrateur et l'un de vos paliers se retrouve sans produits : 
                                @if(count($palier) >= 1)
                                    @foreach($palier as $d)
                                        <span>{{ $d }}</span>
                                    @endforeach
                                @endif
                            </p>
                            <p>Veuillez modifier vos paliers live.</p>
                        @else 
                            <p>Une modifications de la configuration de palier à eu lieu par un administrateur et l'un des produits que vous avez choisis n'est plus disponible</p>
                        @endif
                       
                        <p>L'équipe Elya Maje</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection
