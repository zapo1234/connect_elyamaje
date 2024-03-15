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

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2" style="margin-top:10px">

				<div class="breadcrumb-title pe-3">Codes promos</div>
				<div class="ps-3">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 pe-3">
							<li class="breadcrumb-item active" aria-current="page">Liste de vos codes promos Élèves</li>
						</ol>
					</nav>
				</div>

					<div class="ms-auto">

						<div class="responsive_button ms-auto d-flex justify-content-end">
							<a href="{{ route('ambassadrice.account') }}" class="btn btn-primary radius-5 mt-2 mt-lg-0" >
								<i class="bx bxs-plus-square"></i><span class="responsive_button_text">Créer un code promo Élève</span>
							</a>
						</div>

					</div>

				</div>

				<!--end breadcrumb-->

				
 
				<!-- <div class="cards_mobile">

				    

				   

				    

				     @foreach($users_mobile as $resultat)

				     <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">

			         <div class="col">

						<div class="card radius-10 overflow-hidden" style="width:320px;margin-left:-2%">

							

							 

							<div class="card-body" style="height:150px">

							   

								<div class="d-flex align-items-center">

									<div>

										<p class="mb-0" style="font-size:16px">Code créé le  {{ \Carbon\Carbon::parse($resultat->datet)->format('d/m/Y')}}

										

										 <p>Elève  <span class="tt" style="padding-top:20px;font-size:15px;color:#0E5AAF;font-weight:500;">{{ $resultat->nom }} {{ $resultat->prenom }}</p>

									   

										<h5 class="mb-0" style="font-size:18px;color:black;font-weight:500;margin-top:10px;">{{ $resultat->code_promo }}</h5>

										

										<p> 

										

										<span class="der{{ $resultat->css }}" style="color:green"> {{ $resultat->notification }} </span><br/>

                                        <span class="ds{{ $resultat->css }}"></span>

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
                     <span id="error_delete"></span> 
				 
				 <div class="card card_table_mobile_responsive">
                    <div class="alert alert-success" role="alert" id="{{ $css }}">
                     {{ $message  }}
                   </div>
				

				<div class="table-responsive p-3">

							
							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered"  style="width:100%;text-align:center;">
                               <thead>
                                    <tr>
									  <th scope="col" style="font-size:14px;font-weight:300">Date-création</th>
                                         <th scope="col" style="font-size:14px;font-weight:300">Nom</th>
                                          <th scope="col" style="font-size:14px;font-weight:300">E-mail</th>

										<th scope="col" style="font-size:14px;font-weight:300">Téléphone</th>

										<th scope="col" style="font-size:14px;font-weight:300">Code-promo</th>
										<th scope="col" style="font-size:14px;font-weight:300">Relancer un élève</th>
										
										<th scope="col" style="font-size:14px;font-weight:300">Status</th>

                                  </tr>

								</thead>

								<tbody>

								  @foreach($users as $resultat)
								

								  <tr>

									<td data-label="Date de création">code crée le <br/>{{ \Carbon\Carbon::parse($resultat->datet)->format('d/m/Y')}}</td>

									<td data-label="Nom" class="{{$resultat->code_promo  }}">{{ $resultat->nom}}  {{ $resultat->prenom}}</td>

									<td data-label="E-mail">{{ $resultat->email }}</td>

									<td data-label="Téléphone">{{ $resultat->telephone ?? "Non renseigné" }}</td>

									<td data-label="Code promo">{{ $resultat->code_promo }}      <button type="button" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal" class="renvoi_code" data-id="{{ $resultat->id}}" style="border-radius:5px;background-color:black;color:white;border:2px solid #000;">Renvoyer le code</button></td>
									
									<td data-label="Relancez votre elève"> <button type="button" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModalss" class="data-eleve" data-id2="{{ $resultat->id}}" style="border-radius:5px;background-color:black;color:white;border:2px solid #000; width:10em;">Relancer l'élève</button></td>

									<td data-label="utilisé" class="status_mobile" style="text-align:center">
										@if($resultat->css == "com")
										<img src="https://www.connect.elyamaje.com/admin/img/check-circle-solid.png" style="width:18px;height:18px">
											<span class="">{{ $resultat->notification }}</span>
										@endif
									</td>

								 

								   </tr>

							
								 @endforeach

								</tbody>

							

							</table>

							

                             <div id="resultat"></div><!--resultat ajax- access-->

                             <div="pak" style="display:none"></div>

							

							

						</div>

				
						<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true";style="width:20%;height:80px">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        
                                                          <form method="post" id="renvoi_code" action="/ambassadrice/customer/list">
                                                          @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Renvoyer le code à l'éléve</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="sumit" style="" class="btn btn-dark" id="renvois">renvoyer</button>
															<input type="hidden" id="line-id" name="line-id">
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
				

				
										<div class="modal fade" id="exampleVerticallycenteredModalss" tabindex="-1" aria-hidden="true";style="width:20%;height:80px">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        
                                                          <form method="post" id="renvoi_code" action="{{ route('ambassadrice.modelenvois')}}">
                                                          @csrf
                                                        <div>
                                                            <div class="modal-title" style="margin-left:3%;font-size:16px;text-transform:uppercase;margin-top:10px;">Envoyer le message à l'élève</div>
                                                         
                                                         
                                                         <div style="margin-left:3%">Titre du message 
                                                            <select class="form-select" id="choix_message" aria-label="Default select example">
                                                                <option selected value="">Choisir</option>
                                                                  @foreach($data_messages as $values)
                                                                 
                                                                  <option value="{{ $values['id'] }},{{ $amba }},{{ $values['titre'] }},{{ $values['sujet']}}">{{ $values['titre'] }}</option>
                                                                   @endforeach
                                                                  
                                                                  </select></div>
                                                                  
                                                                  <div id="result1" style="margin-left:3%;margin-top:10px;font-size:16px"><span id="text-sta"></span>  <spand id="name_custom" style="font-weight:bold;color:black"></span></div>
                                                                  <div id="result2" style="margin-left:3%"></div>
                                                                  
                                                                  <div id="footer_name" style="margin-left:3%;margin-top:25px;text-transform:uppercase"><span id="txt-amba"></span>  <span id="amba-name" style="margin-left:5%;"></span></div>
                                                                  
				
                                                        <div class="" style="margin-left:3%;margin-bottom:30px;margin-top:10px;">
                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="sumit" style="" class="btn btn-dark" id="renvois">Envoyez le message</button>
															<input type="hidden" id="line-ids" name="line-ids">
															<input type="hidden" id="line-idss" name="line-idss">
															<input type="hidden" id="line-customs" name="line-customs">
															<input type="hidden" id="line-amba" name="line-amba">
															<input type="hidden" id="line-libelle" name="line-libelle">
															<input type="hidden" id="line-message" name="line-message">
															<input type="hidden" id="line-style" name="line-style">
															<input type="hidden" id="line-sujet" name="line-sujet">
                                                            <input type="hidden" id="line-email" name="line-email">
															<input type="hidden" id="line-titre" name="line-titre">
                                                        </div>
                                                    </div>
                                                    </form>
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
			
			
			$('.data-eleve').click(function(){
			    
			    var id = $(this).data('id2');
			     $('#line-ids').val(id);
			    
			});
			
			
			
			$('#choix_message').change(function(){
			    
			    
			    var choix = $('#choix_message').val();
			    var s = choix.split(',');
			     var name = s[1];
			     var id = s[0];
				 var sujet = s[3];
				 var titre = s[2];
			     // recupérer les info de lélève
			     var codeline = $('#line-ids').val();
			     
			       $.ajax({
		     url: "{{ route('ambassadrice.modeleaffiche') }}",
		     method: 'GET',
		    data: {id:id,name:name,codeline:codeline},
	     	}).done(function(data) {
            
		               var res =  JSON.parse(data).libelle
		               var name_c =  JSON.parse(data).name_customers
		               var name_amba =  JSON.parse(data).name_amba
		               var message_model =  JSON.parse(data).message_model
		                var style =  JSON.parse(data).styles
						var sujet =  JSON.parse(data).sujet
						var email =  JSON.parse(data).email
						var titre =  JSON.parse(data).titre
		               
		               $('#text-sta').text(res);
		               $('#name_custom').text(name_c);
		               $('#result2').html(message_model);
		               $('#txt-amba').text(style);
		               $('#amba-name').text(name_amba);

					   // recupérer les variable 
                        $('#line-libelle').val(res);
                        $('#line-customs').val(name_c);
						$('#line-amba').val(name_amba);
						$('#line-message').val(message_model);
						$('#line-style').val(style);
						$('#line-sujet').val(sujet);
						$('#line-email').val(email);
						$('#line-titre').val(titre);
		               
	    	});
			     
		 });

		});

		</script>

		@endsection
	

		

	