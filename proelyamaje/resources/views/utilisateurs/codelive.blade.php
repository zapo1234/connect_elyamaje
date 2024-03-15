@extends("layouts.apps_utilisateurs")


@section("style")


<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

@endsection	

	@section("wrapper")

	<!--start page wrapper -->

	<div class="page-wrapper">

		<div class="page-content">

			<!--breadcrumb-->

			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

				<div class="breadcrumb-title pe-3">Ambassadrices</div>
				<div class="ps-3">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 pe-3">
							<li class="breadcrumb-item active" aria-current="page">Programmer des lives</li>
						</ol>
					</nav>
				</div>


			</div>

			<!--end breadcrumb-->

		  

			<div class="card card_table_mobile_responsive">

				<div class="card-body" style="position: absolute;left:50%">

					<div class="d-lg-flex align-items-center mb-4 gap-3">

						<div class="position-relative">

							

					<div class="" style="color:green;font-size:15px;font-weight:bold;">{{ $message  }}</div>  <div class=""  id="alert1" style="color:red;font-size:15px;font-weight:bold;">

					 {{ $message_error }}</div>

							

							

							</div>

						

						</div>

					  

					</div>

					<div class="table-responsive p-3">

						<div class="d-flex justify-content-center w-100 loading"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

						<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;">

							<thead>

								<tr>

									<th scope="col" style="font-size:14px;font-weight:300">Picture</th>
									<th scope="col" style="font-size:14px;font-weight:300">Nom</th>
									<th scope="col" style="font-size:14px;font-weight:300">E-mail</th>
									<th scope="col" style="font-size:14px;font-weight:300">N° de phone</th>
									<th style="min-width:249.84px"  scope="col" style="font-size:14px;font-weight:300">Status</th>
									<th scope="col" style="font-size:14px;font-weight:300">Nombre live(réalisé)</th>
									<th scope="col" style="font-size:14px;font-weight:300">Programmer le live</th>
									<th scope="col" style="font-size:14px;font-weight:300">Forcer le live</th>
									<!-- <th scope="col" style="font-size:14px;font-weight:300">Historique live</th> -->

									

								</tr>

							</thead>

							<tbody>

							  @foreach($userlives as $resultat)
								<tr>
									<td data-label="Picture">
										@if(file_exists('admin/uploads/'.$resultat['img_select']))
											<img class="img-profile rounded-circle" src="{{ asset('admin/uploads/'.$resultat['img_select'] )}}" ;="" height="auto" style="width:42px;height:42px;border-radius:30px;">
										@else 
											<img class="img-profile rounded-circle" src="{{ asset('admin/uploads/default_avatar.png' )}}" ;="" height="auto" style="width:42px;height:42px;border-radius:30px;">
										@endif
									</td>
									<td data-label="Nom"><span class="" id="nx{{  $resultat['id'] }}" style="font-size:16px;color:black;font-weight:200;"> {{ $resultat['name'] }} </span></td>
									<td data-label="E-mail"><span class="mois" style="font-size:15px;color:#617FB8;font-weight:400;padding-left:3%;">  <i class="fas fa-phone"></i><span id="nxs{{ $resultat['id'] }}"> {{ $resultat['email'] }}</span></span></td>
									<td data-label="N° de téléphone"><span class="mois" style="">  <i class="fas fa-phone"></i>  {{ $resultat['telephone'] }}</span></td>
									<td data-label="Status"> 
										<div class="h" style="font-size:13px;color:#000;font-weight:600;">
											
											@if($resultat['status'])

												@if($resultat['css'] == "demandecode")
													@if($resultat['status'] != "Live demandé le  10/02/2020 à 20:00")
														<div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>{{ $resultat['status'] }} </div>
													@endif	
												@else 
													<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>{{ $resultat['status'] }} </div>
												@endif	
											@endif	
										</div>
									</td>
									<td data-label="Nombre live(réalisé)">{{ $resultat['nbres_live'] }}</td>
									<td style="vertical-align:middle" data-label="Programmer le live"><button type="button" class="validatecode" data-live="{{ $resultat['css'] == 'demandecode' ? $resultat['date_after'] : ''}}" data-id1="{{ $resultat['id']  }}" style="width:150px;margin-left:5%;background-color:#20E9CE;border:3px solid #20E9CE;border-radius:5px;color:black;">Programmer</button></td>
									<td style="vertical-align:middle" data-label="Forcer le live"><button  class="activatelive" data-id2="{{ $resultat['id']  }}" style="width:130px;margin-left:3%;color:black;cursor:pointer;border-radius:5px;background-color:black;border:2px solid black;color:white">Forcer le live</button></td>
									<!-- <td style="vertical-align:middle" data-label="Historique live"><a href ="{{ route('ambassadrice.livehistorique', ['id' => $resultat['id']]) }}"><button style="width:130px;margin-left:3%;color:black;cursor:pointer;border-radius:5px;background-color:black;border:2px solid black;color:white">Voir historique</button></a></td> -->
							 

							  </tr>

							  @endforeach

							   

							   

							</tbody>

						

						</table>

						

						 <div id="resultat"></div><!--resultat ajax- access-->

						 <div="pak" style="display:none"></div>

						

						

					</div>

				</div>

			</div>





		</div>

	</div>

	

	
	<!-- Modal -->
	<div class="modal fade" id="form_validatecode" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<form method="post" id="form_codelive" action="{{ route('index_codelive') }}">
						@csrf

						<h3 style="font-size:17px;text-align:center;text-transform:uppercase">Programmer un live  pour <span id="nommer"></span> </h3>

						<div id="error_codelive"></div>

						<div ><br/>

						<div class="w-100 d-flex justify-content-center">
							<input style="height:38px;" type="datetime-local" id="search_dates" name="search_dates" min="2022-02-01T08:30"  required><br/><br/>
						</div>

						<div class="mt-2 w-100 d-flex justify-content-center">
							<button type="button" data-bs-dismiss="modal" class="annuler" style="height:28px;width:100px;background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;">Annuler</button>  
							<button type="submit" class="validate" style="height:28px; width:100px;background-color:black;color:white;border:2px solid black;margin-left:10px;border-radius:15px;font-weight:bold">valider</button> <br/><br/>
						</div> 

						<input type="hidden" id="id_code" name="id_code"><input type="hidden" id="name_email" name="name_email">

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="form_validateactive" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<form method="post" id="form_activelive" action="{{ route('ambassadrice.activate_forcer') }}">
						@csrf
						<h3 style="font-size:17px;text-align:center;text-transform:uppercase">Forcer l'activation du live après la demande<span id="nommers"></span> </h3><br/>
						<div class="mt-2 w-100 d-flex justify-content-center">
							<button type="button" data-bs-dismiss="modal" class="annuler"style="height:28px;width:100px;background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;">Annuler</button>  
							<button type="button" class="activate_codelive" style="height:28px; width:100px;background-color:black;color:white;border:2px solid black;margin-left:10px;border-radius:15px;font-weight:bold">Oui</button> <br/><br/> 
						</div>
						<input type="hidden" id="id_codes" name="id_codes"><input type="hidden" id="names_email" name="names_email">

					</form>
				</div>
			</div>
		</div>
	</div>
 


 

	

	<!--end page wrapper -->

	@endsection

	

<!-- <div id="paks" style="display:none;width:100%;height:4000px;background-color:black;opacity:0.8;position:absolute;z-index:3;"></div>   -->

	@section("script")


	<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

<script>

	$(document).ready(function() {

		$('#example').DataTable({
			"initComplete": function(settings, json) {
				$(".loading").remove()
				$("#example").removeClass('d-none')
			}
		});

	


	  } );

	  $(".validatecode").on("click", function(){
			$("#form_validatecode").modal('show')
			var date_live = $(this).attr('data-live')
			if(date_live){
				$("#search_dates").val(date_live)
			} else {
				$("#search_dates").val("")
			}
		})

		$(".activatelive").on("click", function(){
			$("#form_validateactive").modal('show')
		})

	
</script>

@endsection

