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

					<div class="breadcrumb-title pe-3">Lister les transferts de fonds liquides !</div>

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

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;">

								<thead>

									<tr>

									    <th scope="col"><i class="fa fa-calendar" aria-hidden="true"></i>Date de transfert</th>

                                       <th scope="col">Boutique</th>

                                       <!-- <th scope="col">Caissière</th> -->

                                       <th scope="col"> Notification </th>

                                         <th scope="col"> montant</th>

                                         

                                      <th scope="col">Action</th>

									</tr>

								</thead>

								<tbody>

								 @foreach($lists as $resultat)

									<tr>

										<td data-label="Date de transfert">

										

												<div class="ms-2">

													<h6 class="mb-0 font-14">{{ \Carbon\Carbon::parse($resultat['date'])->format('d/m/Y' )}}</h6>

												</div>

											</div>

										</td>

										<td data-label="Boutique"> Boutique {{ $resultat['lieu'] }}</td>

										<!-- <td data-label="Caissière"></td> -->

										<td data-label="Notification"><p>{{ $resultat['description'] }} </p></td>

										<td data-label="Montant">{{ $resultat['montant'] }} €</td>

										<td class="mb-3" data-label="Action"></td>

									   

										

									</tr>

									

								@endforeach	

								</tbody>	

							

							</table>

							

                             <div id="resultat"></div><!--resultat ajax- access-->

                             <div="pak" style="display:none"></div>

							

							

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

	