<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--favicon-->
        <link rel="icon" type="image/png" href="{{asset('admin/img/Logo_elyamaje.png')}}" />
        <!-- loader-->
        <link href="{{ asset('admin/assets/assets/css/pace.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('admin/assets/assets/js/pace.min.js') }}"></script>
        <!-- Bootstrap CSS -->
        <link href="{{ asset('admin/assets/assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/assets/assets/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/assets/assets/css/icons.css') }}" rel="stylesheet">

        <title>Elyamaje Logiciel Saas</title>
    </head>
    <body>
            @section("wrapper")
            <div class="page-content h-100">
                <div class="confirm_choice_paiement">
                    <div class="check_div">
                        <i class="bx bx-check"></i>
                    </div>
                    <span>Nous confirmons votre choix de paiement par <strong>{{$paiement_type ?? ''}}</strong></span>
                </div>
            </div>
    </body>
</html>

	