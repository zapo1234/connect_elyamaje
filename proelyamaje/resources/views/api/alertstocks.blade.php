@extends("layouts.apps")
	
	@section("style")
	<link href="/admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	@endsection	
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Gestion des alerts se stocks de produits Dolibarr ! </div>
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
			  
				<div class="card">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
								
								
								</div>
							
							</div>
						  <div class="ms-auto">
						      
						      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal" style="margin-left:80%">Lancer une alerte</button>
                                            <!-- Modal -->
                                           
                                            <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                             <form method="post" action="/api/stocks/post">
                                                             @csrf
                                                            <h5 class="modal-title">Déclencher l'alerte de stocks dolibarr !</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"></div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">Lancer ! </button>
                                                        </div>
                                                        
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   
						      
						      
						  </div>
						</div>
						<div class="table-responsive">
							
							 <form method="post" id="updatemutiple" action="/api/commande/updatemutiple">
                          <div style="margin-left:2%;color:black;width:85%;"><button class="update_button" style="width:200px;background-color:black;color:white;text-align:center;height:40px;margin-left:2%;margin-top:20px;border-radius:5px;padding:1%;cursor:pointer;margin-bottom:10px;">Commande mutiple</button> <span style="padding-left:10%">    Date commande(Multiple) <input type="date" name="date_commande" id="date_c"></span></div>
                        @csrf
                 <div style="margin-left:2%;color:black;"> Date commande(Multiple) <input type="date" name="date_commande" id="date_c"></div>
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
									    <th></th>
										<th>Réf produit</th>
										<th>Produit en stocks</th>
										<th>Quantité en stocks</th>
										<th>Téléphone</th>
										<th>Actions</th>
										
									</tr>
								</thead>
								<tbody>
								    @foreach($data as $resultat)
									<tr>
									  <td><input type="checkbox" name="checkids[]" class="vals" value="{{ $resultat['product_id'] }}"></td>
                                     <td>{{ $resultat['ref'] }}</td>
                                     <td>{{ $resultat['product'] }}</td>
                                      <td>{{ $resultat['quantite_restant']  }}</td>
                                      <td><div class="p{{ $resultat['css'] }}" data-id1="{{ $resultat['product_id'] }},{{ $resultat['product']}}" style=""> {{ $resultat['action'] }} </div></td>
									</tr>
								@endforeach
								   
								   
								</tbody>
							
							</table>
							</form>
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
	<script src="/admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="/admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
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
	