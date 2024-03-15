@extends("layouts.apps_ambassadrice")

		

	@section("style")

	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	<style type="text/css">
     #nocss{display:none;}
	 #yescss{display:block;}
	</style>

	@endsection	

		

		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb.-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2" style="margin-top:10px">

					<div class="breadcrumb-title pe-3">Lister les  élèves crées</div>

					

				</div>

				<!--end breadcrumb-->

				

				<!-- <div class="cards_mobile">

				    <h1 style="font-size:17px;margin-left:5%">Lister les élèves crées </h1>

				    

				    <form style="margin-bottom:20px" action="/ambassadrice/customer/account">

				     @csrf

				    <input type="text" class="form-control" id="search_name" name="search_name" style="width:220px" aria-describedby="emailHelp" placeholder="Nom de l'élève..">

				     <button  type="sumbit" value="envoyer" id="envoyer2" style="position:absolute;top:148px;left:70%;height:35px;background-color:black;color:white;border:2px solid black;border-radius:5px;">Rechercher</button></form>

				    </form>

				     @foreach($users_mobile as $resultat)

				     <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">

			         <div class="col">

						<div class="card radius-10 overflow-hidden" style="width:320px;margin-left:-2%">

							

							 

							<div class="card-body" style="height:230px">

							   

								<div class="d-flex align-items-center">

									<div>

									    

									    <p class="mb-0" style="font-size:16px">Elève crée le  {{ \Carbon\Carbon::parse($resultat->datet)->format('d/m/Y')}}

										

										 <p> <span class="tt" style="padding-top:20px;font-size:15px;color:#0E5AAF;font-weight:500;">{{ $resultat->nom }} {{ $resultat->prenom }}</p>

										 

										 <p><i class="bx bx-envelope" style="color:black;font-size:16px"></i> {{ $resultat->email  }}</p>

										 

									   <p><i class="bx bx-phone" style="color:black;font-size:16px"></i> {{ $resultat->telephone  }}</p>

									   

									   <p class="x" style="margin-left:5%;margin-bottom:20px;width:150%">

								          <a href="add/{{ $resultat->id}}"><button type="button" style="border-radius:5px;background-color:#0DAA41;color:white;border:2px solid #0DAA41;height:35px;"> <i class="bx bx-plus-circle" style="color:white;font-size:14px"></i>   Code supplémentaire</button></a>

								     

								            <a  href="edit/{{ $resultat->id}}"><button type="button" style="border-radius:5px;background-color:black;color:white;border:2px solid black;height:35px">Modifier fiche</button></a>

								       </p>

										

									

									   

									</div>

									

				

								</div>

							</div>

						

						</div>

					</div>

					</div>

					

					@endforeach

				

				<div class="affiche" style="margin-left:5%;margin-top:20px"> {{ $users_mobile->links() }}  </div>  

				</div> -->
				
				<!--partie affichage mobile code promo-->

				
                    <div class="card card_table_mobile_responsive">
                    <div class="alert alert-success" role="alert" id="{{ $css }}">
                     {{ $message  }}
                   </div>
                     <div class="table-responsive p-3">

							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>
							
							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;">

								<thead>

								<tr>
									    <th scope="col" style="font-size:14px;font-weight:300">Date-création</th>
									    <th scope="col" style="font-size:14px;font-weight:300">Nom</th>
										<th scope="col" style="font-size:14px;font-weight:300">E-mail</th>
										<th scope="col" style="font-size:14px;font-weight:300">Téléphone</th>
										<th scope="col" style="font-size:14px;font-weight:300">Ajouter un code</th>
										<th scope="col" style="font-size:14px;font-weight:300">Renvoyer un code</th>
										
										<th scope="col" style="font-size:14px;font-weight:300">Action</th>
										
									</tr>

								</thead>

								<tbody>

								  @foreach($users as $resultat)

								  <tr>

								  <td data-label="Date de création">élève crée le <br/>{{ \Carbon\Carbon::parse($resultat->datet)->format('d/m/Y')}}</td>
									<td data-label="Nom" class="{{$resultat->code_promo  }}">{{ $resultat->nom}}  {{ $resultat->prenom}}</td>
									<td data-label="E-mail">{{ $resultat->email }}</td>
									<td data-label="Téléphone">{{ $resultat->telephone ?? "Non renseigné" }}</td>
									<td data-label=""> <a href="add/{{ $resultat->id}}"><button type="button" style="border-radius:5px;background-color:black;color:white;border:2px solid #000">Envoyer un code promo à cet élève</button></a></td>
									<td data-label=""> <button type="button" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal" class="renvoi_code" data-id="{{ $resultat->id}}" style="border-radius:5px;background-color:black;color:white;border:2px solid #000">Renvoyer le code</button></td>
									<td data-label="Action">   <a  href="edit/{{ $resultat->id}}"><i class="bx bxs-edit"></i></a> </td>   
								</tr>

								 @endforeach

								</tbody>

						  </table>

							<div id="resultat"></div><!--resultat ajax- access-->

                             <div="pak" style="display:none"></div>

							</div>

				            </div>

							<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true";style="width:20%;height:80px">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        
                                                          <form method="post" id="renvoi_code" action="/ambassadrice/customer/account">
                                                          @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Renvoyer le code à l'éléve</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="sumit" style="" class="btn btn-dark" id="renvois">Renvoyer</button>
															<input type="hidden" id="line-id" name="line-id">
                                                        </div>
                                                    </div>
                                                    </form>
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

			$('.renvoi_code').click(function()
			{
				var id = $(this).data('id');
				$('#line-id').val(id);

			});

			$('#renvoi').click(function()
			{
               $('#renvoi_code').submit();
			});

		  } );

	</script>

	@endsection

	

		

	