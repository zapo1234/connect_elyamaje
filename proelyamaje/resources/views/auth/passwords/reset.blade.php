<!DOCTYPE html>
<html class="html_login" lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('admin/assets/assets/images/favicon-32x32.png') }}" type="image/png" />
	<!-- loader-->
	<link href="{{ asset('admin/assets/assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('admin/assets/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/assets/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,800;1,400;1,500&display=swap" rel="stylesheet">
	<link href="{{ asset('admin/assets/assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/assets/assets/css/icons.css') }}" rel="stylesheet">
	<title>Elyamaje Logiciel Saas</title>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-header"></div>
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box" style="max-width:480px;">
				<div class="card-body">
					<div class="p-3 rounded">
						<div class="text-center">
							 <img id="imj" src="{{ asset('admin/assets/assets/images/icons/lock_black.png') }}" width="80px";
							 
				             	height="auto">
                          
						</div>
						<form method="POST" id ="form_reset" action="/sendmail">
                        @csrf
						<h4 class="mt-4 font-weight-bold" style="text-align:center">Mot de passe  oublié  ?</h4>
						<p class="text-center ">Renseignez votre adresse e-mail, vous recevrez un mail de réinitialisation de votre mot de passe.</p>
						<div class="mb-5">
							<label class="form-label"></label>
							<input type="email" name="email" class="form-control p-3" placeholder="Adresse e-mail"  required/>
						</div>
						
						@if (session('error'))
                                <div class="alert alert-danger" role="alert" id="alertss">
	                            {{ session('error') }}
                            </div>
                                @elseif(session('failed'))
                           
                             @endif
                             
                             
                             @if (session('success'))
                                <div class="alert alert-success" role="alert" id="alertss1">
	                            {{ session('success') }}
                            </div>
                                @elseif(session('failed'))
                           
                             @endif
						
						
						
						<div class="d-grid justify-content-center gap-4">
							<button type="submit" class="btn btn-primary p-2" style="max-width:330px;">Réinitialiser mon mot de passe</button> 
							<a href="{{ route('login') }}" class="btn btn-outline-dark p-2 " style="max-width:330px;"><i class='bx bx-arrow-back me-1' ></i>Retour à la connexion</a>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>

</html>