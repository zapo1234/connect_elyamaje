@extends("layouts.apps")
	
	@section("style")
	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	<style type="text/css">
	h1{display:none;}
	</style>
	@endsection	
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Gestion des factures</div>
				</div>
				<!--end breadcrumb-->
				
				

				   <div class="card card_table_mobile_responsive">

						<div class="table-responsive p-3">

							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>
							
							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered dataTable no-footer" style="width:100%;text-align:center;font-size:14px">
								<thead>
										<tr style="font-weight:300">
									    <th style="font-size:14px;font-weight:300">Période</th>
									    <th style="font-size:14px;font-weight:300">Montant(TTC)</th>
									    <th style="font-size:14px;font-weight:300">Utilisateur</th>
										<th style="font-size:14px;font-weight:300" >Status</th>
										<th>(pdf)</th>
									
										
									</tr>
								</thead>
								<tbody>
		                  @foreach($users as $resultat)
							<tr class="{{ number_format($resultat['somme'], 2, '.', '') }}">
									<th scope="row" style="font-size:20px;color:#000;font-weight:bold">{{ $resultat['mois'] }} {{ $resultat['annee']   }}</th>
									<td data-label="Montant(TTC)">{{ number_format($resultat['somme'], 2, ',', '') }} € </td>
									<td>{{ $resultat['name'] }}</td>
									<td data-label="Utilisateur" style="position:relative;" class="amba2" data-label="Status">
										@if($resultat['status'] == "non payée" OR str_contains($resultat['status'], "facture provisoire"))
											<span class="badge badge_border-danger">{{ $resultat['status']}}</span>
										@else
											<span class="badge badge_border-success">payé</span>
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="{{ $resultat['id'] }}" class="show_detail_paid bi bi-info-circle-fill" viewBox="0 0 16 16">
												<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
											</svg>
											<div id="detail_paid_{{ $resultat['id'] }}" class="detail_paid">
												{{ $resultat['status']}}
											</div>
										@endif
									</td>
									<td data-label="Status" class="">
										<a href="invoice/pdf/{{ $resultat['id_ambassadrice']}}/{{ $resultat['id_mois'] }}"> 
											<i class="bx bx-file" style="color:red"></i> pdf
										</a> 
									</td>
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
				"ordering": false,
				"initComplete": function(settings, json) {
					$(".loading").remove()
					$("#example").removeClass('d-none')
				}
			});
		});
	</script>

	@endsection
	