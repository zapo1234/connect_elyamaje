@extends('layouts.email')

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
                        <div>
                        <h1 style="font-size:14px">Point de votre activité pour la période de <strong>{{  $periode  }}</strong></h1>
                        <p>Bonjour chère  <strong>{{ $status  }}</strong></p>
                        <p>Voici les statistiques de votre activité</p>
                       </div>

                        <div class="corps" style="width:100%;">
                        <div style="float:left;width:30%;height:100px;border:1px solid #eee;padding:5%;border-radius:5px;font-size:18px;margin-left:3%">Nombre de code élève crée:<br/><br/>
                        <div style="font-size:24px;font-weight:bold;"> {{ $nombre_code_create  }} </div></div>
                        <div style="float:left;width:30%;height:100px;border:1px solid #eee;margin-left:3%;padding:5%;border-radius:5px;font-size:18px">code utilisé  via vos élèves:<br/><br/>
                        <div style="font-size:24px;font-weight:bold;"> {{ $nombre_code_use }}</div></div>
                        </div>
                        </td>
                       </tr>
                        <tr style="height:50px;">
                        <td>
                        <p style="width:80%;margin-left:2%;">La meilleur commande pour les code élèves à été réalisée par l'elève : <br/><strong>{{ $nom_great_eleve }}</strong> pour un montant <strong> {{ $montant_great_eleve }} €</strong> </p>
                        </td>
                        </tr>
                        <tr style="height:50px">
                        <td>
                        <p style="width:80%;margin-left:2%;">La meilleur commande pendant vos lives ont été réalisé par la cliente : <br/><strong>{{  $nom_great_eleve  }}</strong> pour un montant <strong>{{ $montant_great_eleve  }}  €</strong> </p>
                       </td>
                       </tr>
                       <tr>
                        <td>
                        <p style="margin-top:20px;width:100%;text-align:center;background-color:black;color:white;font-wieght:bold;">L'equipe elyamaje vous remercie pour votre fidélité</p>
                       </td>
                      </tr>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection