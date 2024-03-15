@extends("layouts.apps_utilisateurs")
	
	@section("style")
	<link href="/admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	@endsection	
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Suivi de commandes réalisées </div>
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
						  
						</div>
						<div class="table-responsive">
							
							<table id="example" class="table table-striped table-bordered" style="width:100%;text-align:center;">
								<thead>
									<tr>
									    <th>Date d'achat</th>
									    <th>Id-commande</th>
									    <th>Nom</th>
										<th>Prénom</th>
										<th>E-mail</th>
										<th>Status(commande)</th>
										<th>Code_promo</th>
										<th>Comission(20%)</th>
										
									</tr>
								</thead>
								<tbody>
								  @foreach($users as $resultat)
								  <tr>
								   <td>Achat réalisé le <br/>{{ $resultat->datet }}</td>
								  <td><button style="background-color:#0E5AAF;border-color:#0E5AAF;color:white">{{ $resultat->id_commande }}</button></td>
                                  <td>{{ $resultat->customer }}</td>
                                    <td>{{ $resultat->username}}</td>
                                   <td>{{ $resultat->email }}</td>
                                    <td>{{ $resultat->status }}</td>
                                    <td>{{ $resultat->code_promo }}</td>
                                     <td>{{ number_format($resultat->somme, 2, ',', '') }} € </td>
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
	