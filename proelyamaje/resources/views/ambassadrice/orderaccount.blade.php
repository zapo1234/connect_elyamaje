@extends("layouts.apps_ambassadrice")

		

	@section("style")

	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

	@endsection	

		

		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2" style="margin-top:10px">

					<div class="breadcrumb-title pe-3">Codes promos</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Achats code parrainage</li>
							</ol>
						</nav>
					</div>

					

				</div>

				<!--end breadcrumb-->

				

				<!-- <div class="cards_mobile">

				    <h1 style="font-size:17px">Lister des ventes de code parrainnage</h1>

				    <form style="margin-bottom:20px">

				    <input type="text" class="form-control" id="account_nom" name="account_nom"  style="width:230px" aria-describedby="emailHelp" placeholder="Nom de l'élève">

				     <button  type="sumbit" value="envoyer" id="envoyer2" style="position:absolute;top:148px;left:72%;height:35px;background-color:black;color:white;border:2px solid black;border-radius:5px;">Rechercher</button></form>

				    </form>

				    

				     @foreach($users as $resultat)

				     <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">

			         <div class="col">

						<div class="card radius-10 overflow-hidden" style="width:320px">

							

							 

							<div class="card-body" style="height:200px">

							   

								<div class="d-flex align-items-center">

									<div>

										<p class="mb-0" style="font-size:16px">

										<p>Achat réalisé le {{ $resultat->datet }}</p>

										 <p>Elève  <span class="tt" style="padding-top:20px;font-size:15px;color:#0E5AAF;font-weight:500;">{{ $resultat->customer }}  {{ $resultat->username  }}</p>

									     <p>Tel : {{ $resultat->telephone }}</p>

										<h5 class="mb-0" style="font-size:18px;color:black;font-weight:500;margin-top:10px;">Code : {{ $resultat->code_promo }}</h5>

										

										<p style="margin-top:10px"> 

										 <span class="dscom" style="padding-left:5%;">commission + {{ number_format($resultat->somme, 2, ',', '') }} € </span>

									

										</p>

									

										

									</div>

									

				

								</div>

							</div>

						

						</div>

					</div>

					</div>

					

					@endforeach

				

				<div class="affiche" style="margin-left:5%;margin-top:20px">   </div>  

				</div>partie affichage mobile code promo -->

				

				

			  

				<div class="card card_table_mobile_responsive">

			

				

				

				

				<div class="table-responsive p-3">

							
							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;">

								<thead>

									<tr>

									   

										  <th scope="col" style="color:black;font-size:16px;font-weight:300"><i class="fa fa-calendar" aria-hidden="true"></i> Date d'achat</th>

                                          <th scope="col">Nom</th>

                                          <th scope="col">E-mail</th>

                                          <th scope="col"> Téléphone</th>

                                          <th scope="col"> code_promo</th>

                                          <th scope="col"> Commission </th>

                                          <th scope="col"> Total_commande </th>

									

									</tr>

								</thead>

								<tbody>

								    

								     @foreach($users as $resultat)

                                     <tr>

                                    <td data-label="Date d'achat">Achat réalisé le <br/>{{ $resultat->datet }}</td>

                                      <td data-label="Nom">{{ $resultat->customer }}  {{ $resultat->username  }}</td>

                                     <td data-label="E-mail">{{ $resultat->email }}</td>

                                    <td data-label="Téléphone">{{ $resultat->telephone }}</td>

                                     <td data-label="Code Promo">{{ $resultat->code_promo }}</td>

                                     <td data-label="Commission">{{ number_format($resultat->somme, 2, ',', '') }} € </td>

                                      <td data-label="Total commande">{{ number_format($resultat->total_ht, 2, ',', '') }} € </td>

								    

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

	

		

	