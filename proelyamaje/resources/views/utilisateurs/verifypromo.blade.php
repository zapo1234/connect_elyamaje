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

					<div class="breadcrumb-title pe-3">Suivi de code élève</div>

					<div class="ms-auto">

						<div class="btn-group">

					
							<button type="button" class="p-2 px-3 verificode" style="background-color:black;color:white;width:auto;">vérifier le code élève</button>
						

						</div>

					</div>

				</div>

				<!--end breadcrumb-->

	
				<div class="card card_table_mobile_responsive">

			

				

				@if (session('error'))

				<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
					<div class="text-white">{{session('error')}}</div>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>

	         

              

              @elseif(session('failed'))

                           

               @endif

         

             @if (session('success'))

             <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
					<div class="text-white">{{session('success')}}</div>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>

             @elseif(session('failed'))

                           

             @endif

				

				
				
				

					<div class="table-responsive p-3">
				
							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>

							

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;margin-top:50px">

								<thead>

									<tr>

									    <th scope="col" style="font-size:14px;font-weight:300">Date-création</th>

									    <th scope="col" style="font-size:14px;font-weight:300">Nom</th>

										<th scope="col" style="font-size:14px;font-weight:300">E-mail</th>

										<th scope="col" style="font-size:14px;font-weight:300">Téléphone</th>

										<th scope="col" style="font-size:14px;font-weight:300">Code-promo</th>

										<th scope="col" style="font-size:14px;font-weight:300">Status</th>

									

										

									</tr>

								</thead>

								<tbody>

								  @foreach($users as $resultat)

								  <tr>

								    <td data-label="Date de Création">code crée le <br/>{{ \Carbon\Carbon::parse($resultat->datet)->format('d/m/Y')}}</td>

                                  <td data-label="Nom" class="{{$resultat->code_promo  }}">{{ $resultat->nom}}  {{ $resultat->prenom}}</td>

                                  <td data-label="E-mail">{{ $resultat->email }}</td>

                                  <td data-label="Téléphone">{{ $resultat->telephone ?? "Non renseigné" }}</td>

                                  <td data-label="Code Promo">{{ $resultat->code_promo }}</td>

                                <td class="status_mobile" data-label="Status"style="text-align:center">
									<span class="status_{{ $resultat->css}} badge bg-light-danger text-danger w-100">{{ $resultat->notification }}</span>
									<!-- <div class="{{ $resultat->css}}"></div>  -->
									<!-- <span class="der{{ $resultat->css }}" style="text-aglin:center"> {{ $resultat->notification }} </span> -->
								</td>

								 

								   </tr>

								 @endforeach

								</tbody>

							

							</table>

							

                             <div id="resultat"></div><!--resultat ajax- access-->

                             <div="pak" style="display:none"></div>

							

							

						</div>

				

				

				

				

				

				

		</div>

		

		<!-- <div class="form_verifycodes" style="display:none;">

    

     </div>   -->


	 	<!-- Modal -->
		<div class="modal fade" id="form_verifycodes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content p-3">
			<form method="post" id="form_verifcode" action="{{ route('utilisateurs.verifypromo') }}">
				@csrf

				<h3 style="font-size:17px;text-align:center;text-transform:uppercase">Vérifier les codes élèves <span id="nommer"></span> </h3>

				<div id="error_codelive"></div>

				<div>

				<input type="text" size="45" class="form-control" placeholder="code(NB tapez le code en miniscule)" name="code_verify"  aria-describedby="basic-addon1">

				</div>

				<div class="w-100 mt-2 d-flex justify-content-center">

					<button type="button" data-bs-dismiss="modal" class="annuler" style="background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;">Annuler</button>  
					<button type="submit" class="validateadd" style="background-color:#00FF00;color:black;border:2px solid #00FF00;margin-left:15px;border-radius:15px;font-weight:bold">Vérifier</button> <br/> 

				</div>
			</form>
			</div>
		</div>
		</div>
     



	   <div="pak" style="display:none"></div>



		

		<!--end page wrapper -->

		@endsection

		

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

		  $(".verificode").on('click', function(){
			$("#form_verifycodes").modal('show')
		  })



	</script>


	@endsection

	

		

	