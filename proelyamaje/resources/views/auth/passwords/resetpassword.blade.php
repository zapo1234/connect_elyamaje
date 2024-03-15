<!DOCTYPE html>
<html class="html_login" lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="admin/assets/assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="/admin/assets/assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="/admin/assets/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/admin/assets/assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="/admin/assets/assets/css/app.css" rel="stylesheet">
	<link href="/admin/assets/assets/css/icons.css" rel="stylesheet">
	<title>Elyamaje Logiciel Saas</title>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-header"></div>
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
					<div class="p-5 rounded">
						<div class="text-center">
							 <img id="imj" src="https://www.connect.elyamaje.com/admin/img/Logo_elyamaje.png" width="95px";
				             	height="auto">
                          
						</div>
						<form method="post" id ="reset_password" action="/updatepassword">
                        @csrf
                        
                        <input type="hidden" name="tokens" value="{{ $token }}">
                        
						<h4 class="mt-5 font-weight-bold" style="font-size:110%;width:98%;text-align:center">Reinitialiser votre mot de passe</h4>
					
						<div class="my-4">
							<label class="form-label"></label>
							<input type="email" name="emails" class="form-control form-control-lg" placeholder="votre email"  required/>
						</div>
						
							<div class="my-4">
							<label class="form-label"></label>
							<input type="password" name="password" class="form-control form-control-lg" placeholder="Nouveau password"  required/>
						</div>
						
						
							<div class="my-4">
							<label class="form-label"></label>
							<input type="password" name="password-confirm" class="form-control form-control-lg" placeholder="confirmer password "  required/>
						</div>
						
						
						@if (session('errors'))
                                      <div class="alert alert-danger" role="alert" id="alerts" style="text-aligne:center;width:250px;text-align:center;margin-left:5%;margin-top:20px;">
	                                  {{ session('errors') }}
                                     </div>
                                     @elseif(session('failed'))
                           
                                     @endif
                             
                             
                                  @if (session('success'))
                                  <div class="alert alert-success" role="alert" id="alerts" style="text-align:center;width:250px;text-align:center;margin-left:5%;margin-top:20px;">
	                            {{ session('success') }}
                                 </div>
                                @elseif(session('failed'))
                           
                                 @endif
						
						
						<div class="d-grid gap-2" style="margin-top:50px;">
							<button type="submit" class="btn btn-primary btn-lg">Reinitialiser</button> <a href="{{ route('login') }}" class="btn btn-white btn-lg"><i class='bx bx-arrow-back me-1'></i>connexion</a>
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