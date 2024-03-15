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
					<div class="breadcrumb-title pe-3">Historique des lives pour des Ambassadrices sur les deux derniers mois !</div>
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
		
									    <th scope="col" style="font-size:14px;font-weight:300">Nom de l'Ambassarice</th>
								
										<th scope="col" style="font-size:14px;font-weight:300">Date de live(réalisée ou en cours)</th>
									
										
									</tr>
								</thead>
								<tbody>
								   @foreach($data_uniques as $resultat)
								   <tr>
										<td data-label="Nom de l'Ambassarice"style="font-size:15px;font-weight:bold;">{{ $resultat['nom_ambassadrice'] }}</td>
										<td data-label="Date de live(réalisée ou en cours)"> {{  $resultat['date_chaine'] }} à {{ $resultat['heure_chaine'] }} </td>
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
		
  		<div id="paks" style="display:none;width:100%;height:4000px;background-color:black;opacity:0.8;position:absolute;z-index:3;"></div>  
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
	