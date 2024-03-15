@extends("layouts.apps_ambassadrice")

	

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

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2" style="margin-top:10px;">

					<div class="breadcrumb-title pe-3">Factures</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Historique des factures</li>
							</ol>
						</nav>
					</div>
					

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

				

				<!-- <div class="cards_mobile">

				    <h2 style="font-size:15px;text-transform:uppercase">Lister vos factures mensuelles</h2>

				    

				    <form style="margin-bottom:20px" action="/ambassadrice/factures/account">

				     @csrf

				      	<select id="date_from" name="date_from" class="form-select" aria-label="Default select example" style="width:200px;" required>

                       <option selected value="0">Choisir la période</option>

                       <option value="13">Toutes les factures</option>

                       <option value="1">Janvier</option>

                       <option value="2">Février</option>

                       <option value="3">Mars</option>

                       <option value="4">Avril</option>

                       <option value="5">Mai</option>

                       <option value="6">Juin</option>

                       <option value="7">Juillet</option>

                       <option value="8">Aout</option>

                       <option value="9">Septembre</option>

                       <option value="10">Octobre</option>

                       <option value="11">Novembre</option>

                       <option value="12">Décembre</option>

                       </select>

				     <button  type="sumbit" value="envoyer" id="envoyer2" style="position:absolute;top:50px;left:65%;height:35px;background-color:black;color:white;border:2px solid black;border-radius:5px;">Rechercher</button></form>

				    </form>

				    

				    

				      @foreach($users as $resultat)

				     <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">

			         <div class="col">

						<div class="card radius-10 overflow-hidden" style="width:310px;margin-left:-2%">

							

							 

							<div class="card-body" style="height:350px">

							   

								<div class="d-flex align-items-center">

									<div>

										<p class="mb-0" style="font-size:16px">

										 

										  <p><span class="tt" style="font-size:20px;color:#000;font-weight:bold"> {{ $resultat['mois']}} {{ $resultat['annee'] }}</p>

										 

										 <p> Status : <span class="vu{{ $resultat['css']}}">{{ $resultat['status']}}</span></p>

										 <p>Télécharger votre facture <a style="padding-left:10%"  class="ax{{ $resultat['nbrslive']}}{{ $resultat['nbrseleve']}}" href="invoice/pdf/{{ $resultat['id_ambassadrice']}}/{{ $resultat['id_mois'] }}/{{ $resultat['annee']}}"><i class="bx bx-file" style="font-size:18px;color:red;padding-top:2px;"></i></a></p>   

										 

										

										 

										<p>Total <span class="code" style="color:black;font-size:20px;font-weight:bold;padding-left:5%">  {{ number_format($resultat['somme'], 2, ',', '') }} €  </span></p>

										

										<p style="font-size:15px;color:#000;font-weight:bold">Details:</p>

										 <p style="color:black;"><span class="ds"> {{ $resultat['nbrslive'] }} ventes lives</p>

										<p style="color:black"><span class="ds"> {{ $resultat['nbrseleve']  }} ventes élèves</span></p>

                                       

                                        

										

										

	                                       

										

									</div>

									

				

								</div>

							</div>

						

						</div>

					</div>

					</div>

					

					@endforeach

					

					  <div class="affiche" style="margin-left:5%"> {{ $users->links() }}  </div> 

					</div> -->

					

					  

					

				   <div class="card card_table_mobile_responsive">
<!-- 
					<div class="card-body">

						<div class="d-lg-flex align-items-center mb-4 gap-3">

							<div class="position-relative">

								

					

							</div>

							

							</div>

						  

						</div> -->

						<div class="table-responsive p-3">

							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;font-size:14px">

								<thead>

									<tr style="font-weight:300">

									    <th scope="col" style="font-size:14px;font-weight:300">Période</th>

									    <th scope="col" style="font-size:14px;font-weight:300">Montant(TTC)</th>

									    <th scope="col" style="font-size:14px;font-weight:300">Utilisateur</th>

										<th scope="col" style="font-size:14px;font-weight:300">Nombre ventes/lives</th>

										<th scope="col" style="font-size:14px;font-weight:300">Nombre ventes/code élève</th>

										<th scope="col" style="font-size:14px;font-weight:300">Nombre live/mesuel</th>

										<th scope="col" style="font-size:14px;font-weight:300" >Status</th>

										<th scope="col">Pdf</th>

									

										

									</tr>

								</thead>

								<tbody>

		                  @foreach($users as $resultat)

                          <tr class="{{ number_format($resultat['somme'], 2, '.', '') }}">

                         <td data-label="Période" scope="row" style="font-size:20px;color:#000;font-weight:bold">{{ $resultat['mois'] }} {{ $resultat['annee']   }}</td>

                       <td data-label="Montant(TTC)">{{ number_format($resultat['somme']+$resultat['somme']*$resultat['tva']/100, 2, ',', '') }} € </td>

                        <td data-label="Utilisateur">{{ $resultat['name'] }}</td>

                        <td data-label="Nombre ventes/lives" class="">{{ $resultat['nbrslive']  }} </td>

                        <td data-label="Nombre ventes/code élève" class="">{{ $resultat['nbrseleve'] }}</td>

                           <td data-label="Nombre live/mesuel" class="">{{ $resultat['nbrsfois'] }}</td>

						<td style="position:relative;" class="amba" data-label="Status">
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
						<!-- <span class="{{ $resultat['css'] }}"><span class="img{{ $resultat['css']}}"><img src="https://prodev.elyamaje.com/admin/img/check-circle-solid.png" width="23px" height="23px"></span> {{ $resultat['status']}}</span> -->
						</td>

               <td data-label="PDF"><a class="aa{{ $resultat['nbrslive'] }}{{ $resultat['nbrseleve']}}" href="invoice/pdf/{{ $resultat['id_ambassadrice']}}/{{ $resultat['id_mois'] }}/{{ $resultat['annee']  }}"> <i class="bx bx-file" style="color:red"></i> pdf</a> </td>

                

                        

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
				"ordering": false,
				"initComplete": function(settings, json) {
					$(".loading").remove()
					$("#example").removeClass('d-none')
					
				}
			});

		  } );

	</script>



	@endsection

	