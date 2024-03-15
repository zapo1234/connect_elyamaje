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

					<div class="breadcrumb-title pe-3">Lister les commande enregsitrées !</div>

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

			  

				<div class="card card_table_mobile_responsive">

				

						<div class="table-responsive p-3">

							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>

							<table id="example" class="table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;">

								<thead>

									<tr>

									    <th ><i class="fa fa-calendar" aria-hidden="true"></i>Date de création</th>

										<th scope="col">Nom client</th>

										<th scope="col">E-mail</th>

										<th scope="col"> code_promo </th>

                                         <th scope="col"> Somme </th>

                                         <th scope="col">Réf _dolibar</th>

                                      <th scope="col">Utilisateurs</th>

                                      <th>Action</th>

									</tr>

								</thead>

								<tbody>

								    @foreach($users as $resultat)

                                    <tr>

                                    <td data-label="Date de création">enregistrer le <br/>{{ $resultat->datet }}</td>

                                      <td data-label="Nom">{{ $resultat->nom }}</td>

                                         <td data-label="E-mail">{{ $resultat->email }}</td>

                                          <td data-label="Code Promo">{{ $resultat->code_promo }}</td>

                                      <td data-label="Somme">{{ number_format($resultat->somme, 2, ',', '') }} € </td>

                                        <td data-label="Réf _dolibar">{{ $resultat->ref_facture }}</td>

                                          <td data-label="Utilisateurs"> {{$resultat->utilisateur }}</td>

              

             

                          <td data-label="Action">  <a class="" href="/orders/caisse/edit/{{ $resultat->id}}"><i class='fas fa-pen' style='font-size:12px'></i>Modifier</a> </td> 

                                    

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

	