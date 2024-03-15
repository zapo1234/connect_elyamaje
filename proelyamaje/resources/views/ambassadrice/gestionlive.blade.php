@extends("layouts.apps_ambassadrice")



@section("style")


	<link href="{{asset('admin/assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/assets/plugins/highcharts/css/highcharts.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" />

	<style>

	    #pak{position: fixed;top: 0;left: 0;width:100%;height: 100%;background-color: black;z-index:2;opacity: 0.8;display:none;}

	    .xxxxdavxxx{color:green}

	    /* .form_live{display:none;background-color:white;border:2px solid white;border-radius:10px;position:fixed;z-index:5;width:25%;height:190px;padding:2%;top:200px;left:33%; */

           /* font-size:16px;color:black} */
           .annulergx{    
				color: #fff;
				background-color: #fd3550;
				border:none;
				padding: 10px;
				font-size:13px;
				border-radius:5px
			}

           .gestionxx{
				color: #fff;
				background-color: #15ca20;
				border:none;
				border-color: #15ca20;
				font-size:13px;
				border-radius:5px
			}

            .nonexx{display:none;} 

			@media (max-width: 575.98px) { 
          	h1{text-align:center;}  
            h5{text-align:center;}  
           .choix{color:black;}
		}
   </style>
	@endsection
		@section("wrapper")
			<div class="page-wrapper">
				<div class="page-content">
					<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
						<div class="breadcrumb-title pe-3">Lives</div>
						<div class="ps-3">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb mb-0 pe-3">
									<li class="breadcrumb-item active" aria-current="page">Gérer vos lives</li>
								</ol>
							</nav>
						</div>
					</div>
					<div class="row row-cols-12 row-cols-lg-12row-cols-xl-12">
						<div class="col">
							<div class="card radius-15 col-md-12 overflow-hidden">
								<div class="card-body col-md-12">
									<div class="w-100 h-100 d-flex justify-content-center align-items-center">
										<div class="w-100 d-flex flex-column justify-content-center align-items-center">
											<h3 class="text-center mb-0 card-title">Live démandé<br/><span class="tt" style="font-size:20px;color:#0E5AAF;font-weight:800;"></span></h3>
											<div class="mt-3 text-center {{ $css  }}" style="text-align:center;color:#000;font-weight:bold;font-size:16px">{{ $message  }} <br/> {{ $heure1  }}</div>
												<div class="mt-3" style="font-size:16px">{{ $status  }}</div>
													@if($message != "Aucune demande enregistrée !" && $actif != 2)
														<div class="d-flex w-100 justify-content-center">
															<button type="button" style="margin-left:0px; width:auto;font-size:1em" data-id2="{{ $token_id  }}" class="btn btn-primary px-2 {{ $but2  }} ">Modifier la date</button>
															<button type="button" style="margin-left:10px;width:auto;font-size:1em" class="btn btn-outline-dark px-2 {{ $but1 }}" data-id1="{{ $token_id  }}">Annuler le live</button>
															<!-- <button class="{{ $but1 }}" data-id1="{{ $token_id  }}" style="margin-left:5px">Annuler le live</button> -->
														</div>
													@endif	
												</div>
											</div>
										</div>	
									</div>
								</div>
								<div class="" id="chart"></div>
							</div>
								@if (session('success'))
								<div class="alert alert-success" role="alert" id="alert_email" style="width:330px;height:90px;text-align:center;margin-top:50px;margin-left:12%; border:2px solid green">
									{{ message_response }}
								</div>
								@elseif(session('success'))
								@endif  
						<div class="col">
							<div class="card radius-15 overflow-hidden">
								<div class="card-body">
									<div class="d-flex align-items-center p-2">
										<div class="w-100">
											<h3 class="text-center mb-0 card-title">Vos cadeaux de live choisis<br/><span class="tt" style="font-size:20px;color:#0E5AAF;font-weight:800;"></span></h3>
											<span class="tt" style="text-align:center;padding-top:20px;font-size:20px;color:#0E5AAF;font-weight:600;"> </span></p>
											<h5 class="mb-0" style="margin-top:10px;font-size:24px;color:#000;font-weight:600;margin-top:18px;"></h5>
											<div class="text-danger w-100 text-center choix" style="width:300px;color:black;">
												<i class='bx bx-error' style="color:red"></i> 
												Vous pouvez modifier les choix des cadeaux jusqu'au début du live.<br/>Une fois le live lancé, vous ne pouvez plus changer les paliers
											</div>
											<form method="post"  action="{{ route('ambassadrice.updatepanierlive') }}" style="margin-top:20px;">
												@csrf				 
												@foreach($liste_choix as $key => $valu)
												<div class="h " style="font-size:16px;color:black;font-weight:bold;margin-bottom:5px;border-bottom:3px solid black;width:150px"> 
													{{ $key }}
												</div>
												<select class="w-100 multiple-select" data-placeholder="Choose anything" multiple="multiple" name="id_token[]" required>
													@foreach($valu as $val)
													<option value="{{$val['data']['token']}}" {{ $val['data']['choix'] }}>{{ $val['data']['libelle'] }}</option>
													@endforeach
												</select><br/>
												@endforeach
												@if(isset($actif))
													@if($actif != 2)
														<div class="w-100 d-flex justify-content-center">
															<button type="submit" class="validate" style="width:300px;height:40px;background-color:black;color:white;border:2px solid black;border-radius: 0.25rem;">Mettre à jour</button>
														</div>
													@endif
												@else
													<div class="w-100 d-flex justify-content-center">
														<button type="submit" class="validate" style="width:300px;height:40px;background-color:black;color:white;border:2px solid black;border-radius: 0.25rem;">Mettre à jour</button>
													</div>
												@endif
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div><!--end row-->
						<div class="{{ $formcss }} modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-body p-4">
										<form method="post" id="form_live_valide" action="{{ route('anullive') }}">
											@csrf
											<h3 style="font-size:17px;text-align:center">Êtes vous sûr de vouloir annuler votre live ?</h3>
											<p class="text-center">Vous avez 24h avant le début du live pour demander son annulation.</p>
											<div class="d-flex flex-wrap w-100 gap-3 justify-content-center">
											<button type="submit" class="validates btn btn-primary">Confirmer l'annulation du live</button> <br/> 
													<button type="button" class="annuler btn btn-outline-dark" data-bs-dismiss="modal"><i class="bx bx-arrow-back"></i>Retour</button>   
												<input type="hidden" id="id_token_liv" name="id_token_liv" readonly>
												<input type="hidden" id="actif_id" name="actif_id" readonly>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>


						<!-- <div class="{{ $formcss }}" style="display:none">

							<form method="post" id="form_live_valide" action="/ambassadrice/annul/live">

								@csrf

							<h3 style="font-size:17px;text-align:center">Voulez vous vraiment annulez le live ? <br/>NB : cette action ne s'effectueras  pas pendant un live y'a 24h</h3>

							<button type="button" class="annuler" style="background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;margin-left:3%">Annuler</button>  

							<button type="submit" class="validate" style="background-color:#00FF00;color:black;border:2px solid #00FF00;margin-left:20%;border-radius:15px;font-weight:bold">valider</button> <br/> 

							<input type="hidden" id="id_token_liv" name="id_token_liv" readonly>

							<input type="hidden" id="actif_id" name="actif_id" readonly>

							</form>

						</div>  -->
							<div class="{{ $formscc }} modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-body p-3">
											<form method="post" id="" action="{{ route('edit.choix') }}">
												@csrf
												<h3 style="font-size:17px;text-align:center">Vous êtes sur le point de modifier votre date de live.<br/></h3>
												<p class="text-center">Sélectionnez une nouvelle date</p>
												<div class="mb-3 d-flex w-100 justify-content-center">
													<input type="datetime-local" id="search_dates" name="search_dates" min="2022-09-01T08:30"  style="height:50px;width:250px" required><br/><br/>
												</div>
												<div class="d-flex flex-wrap w-100 gap-3 justify-content-center">
													<button type="submit" class="validates btn btn-primary">Valider la modification</button> <br/> 
													<button type="button" class="annuler btn btn-outline-dark" data-bs-dismiss="modal"><i class="bx bx-arrow-back"></i>Annuler</button>  
													<input type="hidden" id="id_token_ss" name="id_token_ss" readonly>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
					<div id="{{ $pak }}"></div>
				</div>	
			</div>
		@endsection

	@section("script")

	

	<script>

		let dateInput = document.getElementById("search_dates");
		var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
    	var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, new Date().toISOString().lastIndexOf(":"));
    	dateInput.min = localISOTime

	    $(document).ready(function()
	    {
			search_dates
	        $('.annulergx').click(function()

	        {

	            // $('#pak').css('display','block');

	            // $('.form_live').css('display','block');

	            $('.form_live').modal('show');


	            // recupérer le token en cours .

	            

	              var id= $(this).data('id1');

	               $('#id_token_liv').val(id);

	            

	        });

	        

	        // $('.validate').click(function()

	        // {

	        //     $('#form_live_valide').submit();

	        // });

	        

	        // $('.validates').click(function()

	        // {

	        //     $('#form_live_valides').submit();

	        // });

	        

	        

	        

	         $('.gestionxx').click(function()

	         {

	            //  $('#pak').css('display','block');

	             $('.form_edit_choix').modal('show');

	             

	             // recupérer le token en cours .

	            

	              var id= $(this).data('id2');

	               $('#id_token_ss').val(id);

	         });

	        

	        

	        

	        $('.annuler').click(function()

	        {

	            

	            $('#pak').css('display','none');

	            $('.form_live').css('display','none');

	            $('.form_edit_choix').css('display','none');

	        });

	        

	         $('#pak').click(function()

	        {

	            

	            $('#pak').css('display','none');

	            $('.form_live').css('display','none');

	             $('.form_edit_choix').css('display','none');

	        });

	        

	    });

	    

	</script>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{asset('admin/assets/assets/plugins/select2/js/select2.min.js')}}"></script>



	<script type="text/javascript">

    $(document).ready(function() {

        $('select').selectpicker();

    });

    

    

    $('.single-select').select2({

			theme: 'bootstrap4',

			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',

			placeholder: $(this).data('placeholder'),

			allowClear: Boolean($(this).data('allow-clear')),

		});

		$('.multiple-select').select2({

			theme: 'bootstrap4',

			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',

			placeholder: $(this).data('placeholder'),

			allowClear: Boolean($(this).data('allow-clear')),

			maximumSelectionLength: 4,

		});

    

    

    

    

    

</script>

	

	



	@endsection