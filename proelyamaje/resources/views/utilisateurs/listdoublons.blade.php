@extends("layouts.apps_utilisateurs")
	
	@section("style")
		<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
	@endsection	

		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Historique des eventuels doublons détéctés dans dolibar !</div>
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
		
									    <th style="font-size:14px;font-weight:300">Date de récupération</th>
								
										<th style="font-size:14px;font-weight:300">Code client</th>
									    
                                        <th style="font-size:14px;font-weight:300">Nom du client</th>

                                        <th style="font-size:14px;font-weight:300">id</th>

									
										
									</tr>
								</thead>
								<tbody>
								   @foreach($data_donnes as $resultat)
								   <tr>
                                    <td data-label="Date de récupération">{{ $resultat['date'] }} </td>
								  <td data-label="Code client" style="font-size:15px;font-weight:bold;">{{ $resultat['code_client'] }}</td>
								  <td data-label="Nom du client"> {{  $resultat['nom'] }} </td>
								  <td data-label="Nom du client"> {{  $resultat['id'] }} </td>

								  
								  </tr>
								
								   
								  @endforeach
								  
								</tbody>
							</table>
							
                       
							
							
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
				"order": [[3, 'desc']],
				"columnDefs": [
				{ "orderable": false, "targets": 0 },
				{ "sorting": false, "targets": 0 },
				{ "orderable": false, "targets": 1 },
				{ "sorting": false, "targets": 1 },
				{ "orderable": false, "targets": 2 },
				{ "sorting": false, "targets": 2 }

				],
				"initComplete": function(settings, json) {
					$(".loading").remove()
					$("#example").removeClass('d-none')
				}
			});

			$('#example').DataTable().columns(3).visible(false);
		  } );
	</script>

	@endsection
	