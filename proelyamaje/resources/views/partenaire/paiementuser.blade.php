<!doctype html>

<html lang="en">



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

	<link href="{{ asset('admin/assets/assets/css/app.css') }}" rel="stylesheet">

	<link href="{{ asset('admin/assets/assets/css/icons.css') }}" rel="stylesheet">

	<title>Elyamaje Logiciel Saas</title>

</head>



<body>

	<!--wrapper-->

	<div class="wrapper">

		<div class="authentication-header"></div>

		<div class="section-authentication-signin d-flex align-items-center justify-content-center mt-0 my-lg-0">

			<div class="container-fluid">

				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">

					<div class="col mx-auto">

						<div class="mb-4 text-center">

							

						</div>

						<div class="card">

							<div class="card-body">

								<div class="p-4 rounded">

									

									<div class="d-grid">

										<a class="btn my-4 shadow-sm btn-white" href="javascript:;"> <span class="d-flex justify-content-center align-items-center">

                              <img id="imj" src="https://www.erp.elyamaje.com/admin/img/Logo_elyamaje.png" width="95px";

				             	height="auto">

                               

                              

											</span>

										</a> 

									</div>

									<div class="login-separater text-center mb-4">

										 <h2 style="font-size:16px">Notification de paimement de votre facture chez elyamaje.</h2>

										 

										 <div>Valider votre choix de paimement </div>

									</div>

									<div class="form-body d-flex flex-column align-items-center row g-3">

										<!-- <form  method="POST" class="d-flex flex-column align-items-center row g-3" id="form_id" action="">

										    @csrf -->

										<button id="bank_transfer" class="paiement_type w-75 paieimenty1" style="height:35px;background-color:black;border:2px solid black;color:white;border-radius:5px" >Virement Bancaire</button> 	
										<button id="purchase_coupon" class="paiement_type w-75 paieimenty2" style="height:35px;background-color:black;border:2px solid black;color:white;border-radius:5px;" >Un bon d'achat</button>

											

										<!-- </form> -->

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


	<!-- Modal confirmation choix paiement-->
	<div class="modal fade" id="modalPaiementUser" tabindex="-1" role="dialog" aria-labelledby="modalPaiementUserTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalPaiementUserTitle">Choix du paiement</h5>
			</div>
				<form  method="POST" class="d-flex flex-column align-items-center w-100" id="form_id" action="/notification/choix/paiments"> 
						@csrf 
					<div class="modal-body d-flex justify-content-center">
						<input name="token" type="hidden" value="{{ $token ?? '' }}">
						<input name="code_amba" type="hidden" value="{{$code_amba ??  ''}}">
						<input id="paiement_selected" name="paiement_type" type="hidden" value="">
					</div>
					<div class="modal-footer w-100">
						<button type="button" class="btn btn-primary"data-bs-dismiss="modal">Annuler</button>
						<button type="submit" class="btn btn-primary">Oui</button>
					</div>
				</form>
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


	<!--app JS-->
	<script src="{{ asset('admin/assets/assets/js/app.js') }}"></script>

</body>



</html>