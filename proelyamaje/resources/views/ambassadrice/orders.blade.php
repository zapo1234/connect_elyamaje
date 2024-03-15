@extends("layouts.apps")

	

	@section("style")

	<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

	@endsection	

		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3">Ambassadrices</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Commandes élèves</li>
							</ol>
						</nav>
					</div>


					<div class="ms-auto">

						<div class="btn-group">

							

							

							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>

								<a class="dropdown-item" href="javascript:;">Another action</a>

								<a class="dropdown-item" href="javascript:;">Something else here</a>

								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>

							</div>

						</div>

					</div>

				</div>

				<!--end breadcrumb-->

			  

				<div class="filter_responsive card card_table_mobile_responsive">

			

						<div class="d-flex justify-content-center w-100 loading mt-3"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

						<div class="table-responsive p-3">


							<div class="filter_research_invoice d-flex fact{{ Auth()->user()->is_admin }}" style="color:black">

								<select class="d-none dropdwon_filter type_dropdown input_form_type" name="type_user">
									<option value="">Type d'utilisateur</option>
									<option value="2">Ambassadrice</option>
									<option value="4">Partenaire</option>
								</select>

								<select class="d-none dropdwon_filter status_order input_form_type" name="type_user">
									<option value="">Status</option>
									<option value="processing">En cours</option>
									<option value="lpc_ready_to_ship">Prêt à expédier</option>
									<option value="Doli-payé">Payé</option>

								</select>

							</div>

							<table id="example" class="mt-3 d-none table_mobile_responsive table table-striped table-bordered" style="margin-top: 15px !important;border: 1px solid #dee2e6; width:100%;text-align:center;">

								<thead>

									<tr>

									    <th scope="col">Date d'achat</th>

									    <th scope="col">Id-commande</th>

									    <th scope="col">Nom</th>

										<th scope="col">Prénom</th>

										<th scope="col">E-mail</th>

										<th scope="col">Status(commande)</th>

										<th scope="col">Code_promo</th>

										<th scope="col">Comission(20%)</th>

										<th scope="col">Type</th>


										

									</tr>

								</thead>

								<tbody>

								  @foreach($users as $resultat)

								  <tr>

								   <td data-label="Date d'achat">Achat réalisé le <br/>{{ $resultat->datet }}</td>

								  <td data-label="Id-commande">
								  	<span class="badge bg-dark">{{ $resultat->id_commande }}</span>
								</td>

                                  <td data-label="Nom">{{ $resultat->customer }}</td>

                                    <td data-label="Prénom">{{ $resultat->username}}</td>

                                   <td data-label="E-mail">{{ $resultat->email }}</td>

                                    <td data-label="Status(commande)"><span class="{{ $resultat->status }}">{{ $resultat->status }}</span></td>

                                    <td data-label="Code Promo">{{ $resultat->code_promo }}</td>

                                     <td data-label="Comission(20%)">{{ number_format($resultat->somme, 2, ',', '') }} € </td>

                                     <td data-label="Type">{{ $resultat->is_admin }} </td>


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

		

		

		 <div class="form_validatecode" style="display:none;">

         <form method="post" id="form_codelive" action="/ambassadrice/activate/code_live">

            @csrf

         <h3 style="font-size:17px;text-align:center;text-transform:uppercase">Programmer un live  pour <span id="nommer"></span> </h3>

           <div id="error_codelive"></div>

            <div style="margin-left:10%"><br/>

            Date de live <input type="datetime-local" id="search_dates" name="search_dates" min="2022-02-01T08:30"  required><br/><br/>

         <button type="button" class="annuler" style="width:100px;background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;margin-left:3%">Annuler</button>  

         <button type="submit" class="validate" style="width:100px;background-color:#00FF00;color:black;border:2px solid #00FF00;margin-left:20%;border-radius:15px;font-weight:bold">valider</button> <br/><br/>

        <input type="hidden" id="id_code" name="id_code"><input type="hidden" id="name_email" name="name_email">

         </div></form>

     </div>  

     



         <div class="form_validateactive" style="display:none;">

         <form method="post" id="form_activelive" action="/ambassadrice/activate">

            @csrf

         <h3 style="font-size:17px;text-align:center;text-transform:uppercase">Forcer l'activation du live après la demande<span id="nommers"></span> </h3><br/>

         <button type="button" class="annuler" style="background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;margin-left:8%">Annuler</button>  

         <button type="button" class="activate_codelive" style="background-color:#00FF00;color:black;border:2px solid #00FF00;margin-left:20%;border-radius:15px;font-weight:bold">Oui</button> <br/><br/> 

        <input type="hidden" id="id_codes" name="id_codes"><input type="hidden" id="names_email" name="names_email">

         </form>

     </div>  

     

		

		<!--end page wrapper -->

		@endsection

		

  <div id="paks" style="display:none;width:100%;height:4000px;background-color:black;opacity:0.8;position:absolute;z-index:3;"></div>  

		@section("script")

		<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
      	<script src="{{asset('admin/assets/assets/plugins/select2/js/select2.min.js')}}"></script>


	<script>

		$(document).ready(function() {

			$('#example').DataTable({
				"initComplete": function(settings, json) {
					$(".loading").remove()
					$("#example").removeClass('d-none')
					$('#example').DataTable().columns(8).visible(false);
					$("#example_length select").addClass('filter_length')
					$(".filter_research_invoice").appendTo('.dataTables_length')
					// $(".status_order").appendTo('.dataTables_length')
					$(".type_dropdown").removeClass('d-none')
					$(".status_order").removeClass('d-none')


					$("#example_length select").appendTo('.dataTables_length')
					$(".dataTables_length label").remove()

					$("select").select2({
						width: '180px'
					});
					$(".filter_length").select2({
						width: '80px'
					});
				}
		  	});

			$('.type_dropdown').on('change', function(e){
				var type_user = $('.type_dropdown').val();
				var status_order = $('.status_order').val();
				$('.type_dropdown').val(type_user);
				$('#example').DataTable()
				.column(8).search(type_user)
				.column(5).search(status_order)
				.draw();
         	})

			 $('.status_order').on('change', function(e){
				var status_order = $('.status_order').val();
				var type_user = $('.type_dropdown').val();
				$('.status_order').val(status_order);
				$('#example').DataTable()
				.column(8).search(type_user)
				.column(5).search(status_order)

				.draw();
         	})
		});




	</script>


	@endsection

	