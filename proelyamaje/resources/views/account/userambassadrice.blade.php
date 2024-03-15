@extends("layouts.apps")
	
	@section("style")
	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	@endsection	
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Suivi d'activité des ventes </div>
					
				</div>
				<!--end breadcrumb-->
			  
				<div class="card card_table_mobile_responsive">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
								<span><i class="bx bxs-user"></i>  {{ strtoupper($name)  }}</span>
								
								<div style="color:black">  <span class="cc">Commission mensuelle/cours : <span class="ct"> {{ number_format($gains, 2, ',', '') }} € </span></span>     <span class="cc">Vente mensuelle en cours : {{ $ventes   }}</span>   
								
								
								  <span class="cc"> Nombres de code élève crées : {{ $nombres  }} </span>   <span class="cc"> Ventes total : <span class="ct">{{ $total }}</span></span>
								
								
								
								</div>
							
							</div>
						  
						</div>
						<div class="table-responsive">
							
							<table id="example" class="table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;">
								<thead>
									<tr>
										<th scope="col">Date(commande)</th>
										<th scope="col">Code</th>
										<th scope="col">Customer(client)</th>
										<th scope="col">Téléphone</th>
										<th scope="col">E-mail</th>
										<th scope="col">Commission(gains)</th>
									</tr>
								</thead>
								<tbody>
								    @foreach($user as $resultat)
									<tr>
										<td data-label="Date(commande)">{{ $resultat['datet'] }}</td>
										<td data-label="Code"> {{ $resultat['code_promo'] }}</td>
										<td data-label="Customer(client)"> {{ $resultat['customer']  }}</td>
										<td data-label="Téléphone"> {{ $resultat['telephone']   }}</td>
										<td data-label="E-mail"> {{  $resultat['email'] }} </td>
										<td data-label="Commission(gains)"> {{ number_format($resultat['somme'], 2, ',', '') }} € </td>
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
			$('#example').DataTable();
		  } );
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>
	@endsection
	