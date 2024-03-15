<!doctype html>
<html class="html_login" lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	 <link rel="icon" type="image/png" href="{{asset('admin/img/Logo_elyamaje.png')}}" />
	<!--plugins-->
	<link href="{{ asset('admin/assets/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	
	<link href="{{ asset('admin/assets/assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('admin/assets/assets/js/pace.min.js') }}"></script>
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
	<!--wrapper-->
	<div class="wrapper">
		<div class="authentication-header"></div>
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							
						</div>
						<div class="card">
							<div class="card-body">
								<div class="p-4 rounded">
									
									<div class="d-flex justify-content-center align-items-center w-100">
										<img id="imj" src="{{asset('admin/img/logo_elyamaje_horiz.png')}}" width="200px" height="auto">
                          			</div>
									<div class="login-separater text-center mb-4">
										
									</div>
									<div class="form-body">
										<form  method="POST" class="row g-3" id="form_id" action="{{ route('login') }}">
										    @csrf
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label" style="font-weight:500;">Votre Identifianttt </label>
												<input type="email" class="form-control p-3" id="inputEmailAddress" name="email" placeholder="Entrez votre adresse e-mail">
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label"  style="font-weight:500;">Mot de passe </label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0 p-3" id="inputChoosePassword" name="password"  placeholder="Mot de passe"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>
											
											<div class="col-12 mt-4">
												<div class="d-flex flex-wrap gap-3 justify-content-center">
													<button type="submit" class="btn btn-primary p-2" style="min-width:200px"><i class="bx bxs-lock-open"></i>Connexion</button>
													<div class="w-100 d-flex justify-content-center">
														<a href="{{ route('auth.passwords.reset')}}">Mot de passe oublié ?</a>
													</div>
												</div>
												@if (session('error'))
                                       <div class="alert alert-danger" role="alert"  id="alert1" style="text-align:center">
	                                  {{ session('error') }}
                                       </div>
                                       @elseif(session('failed'))
                                       @endif
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{ asset('admin/assets/assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('admin/assets/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="{{asset('admin/assets/assets/js/app.js')}}"></script>
</body>

</html>