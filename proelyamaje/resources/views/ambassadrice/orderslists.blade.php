@extends("layouts.apps_ambassadrice")

		

	@section("style")

	<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

	@endsection	

		

		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Lister les ventes du mois actuel</div>
					<div class="ms-auto">
						<div class="d-flex justify-content-end m-2">
							<a href="{{ route('ambassadrice.account') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ><i
							class="fas fa-download fa-sm text-white-50"></i>Créer un code promo élève</a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->


				<div class="card card_table_mobile_responsive">


				 
			

				<div class="table-responsive p-3">

				<div class="d-flex justify-content-center w-100 loading"> 
						<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
					</div>

							

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered">
								<thead>
									<tr>
										<th scope="col">Nom</th>
                                        <th scope="col">Prénom</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col"><i class="fas fa-phone"></i> Téléphone</th>
                                        <th scope="col"> code_promo</th>
                                        <th scope="col"> Montant </th>
                                        <th scope="col"> Montant_tva </th>
									</tr>
								</thead>
								<tbody>

		
								     @foreach($users as $resultat)

								     <tr>

                                    <td data-label="Nom">{{ $resultat->customer }}</td>

                                     <td data-label="Prénom">{{ $resultat->username}}</td>

                                     <td data-label="E-mail">{{ $resultat->email }}</td>

                                      <td data-label="Téléphone">{{ $resultat->telephone }}</td>

                                        <td data-label="code_promo">{{ $resultat->code_promo }}</td>

                                           <td data-label="Montant">{{ number_format($resultat->somme, 2, ',', '') }} € </td>

                                               <td data-label="Montant_tva">{{ number_format($resultat->some_tva, 2, ',', '') }} € </td>

                                               

                                             </tr>

								 @endforeach

								</tbody>

							

							</table>

							

                             <div id="resultat"></div><!--resultat ajax- access-->

                             <div="pak" style="display:none"></div>

							

							

						</div>

				

				

				

				

				

				

		</div>

		

		

	



		

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

	</script>

	@endsection

	

		

	