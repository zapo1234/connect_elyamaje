@extends('layouts.emailp')

@section('content')

<table style="font-family:math;color:#000000" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table style="max-width:700px;border-style:solid; border-width:1px; border-color:#c9c9c9;" width="100%" border="0" cellspacing="0" cellpadding="25">
                <tr>
                    <td align="center">
                       
                        <a href="">
                            <img src="https://www.connect.elyamaje.com/admin/img/Logo_elyamaje.png" width="150px"; height="auto"; style="margin-top:10px;";>
                        </a>     
                        </br>
                        <h1 style="font-size:14px"> <strong>{{  $titre  }}</strong></h1>
                        <p>{{ $libelle  }}  <strong>{{ $eleve  }}</strong></p>
                        <p>{{ $sujet  }}</p>
                       <tr style="height:30px;">
                        <td>
                        <p style="width:80%;margin-left:2%;">{{!! $messages !!}}</p>
                        </td>
                        </tr>
                        <tr style="height:30px">
                        <td><p style="margin-top:20px;width:100%;text-align:center;">{{ $footer }}  <strong> {{ $name_ambassadrice }} </strong></p>
                       </td>
                      </tr>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection