@extends("layouts.apps_ambassadrice")

		

	@section("style")

	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	<style type="text/css">
     #nocss{display:none;}
	 #yescss{display:block;}
	 #yesm{display:block;}
	 #nows{display:none}
	 #title{margin-top:10px;width:300px;margin-left:3%}
	 #sujet{margin-top:10px;width:300px;margin-left:3%;}
	 #messages{padding:1%;text-align:center;width:300px;}
	 #noyes{display:none;}
	 
	 
	</style>

	@endsection	

		

		@section("wrapper")

		<!--start page wrapper -->
        
		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb.-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2" style="margin-top:10px">

					<div class="breadcrumb-title pe-3" style="font-size:13px;margin-top:10px;">Créer des modéles de messages pour vos élèves</div>

					<div class="responsive_button ms-auto d-flex justify-content-end">
					<button type="button" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal" class="renvoi_code" style="border-radius:5px;background-color:black;color:white;border:2px solid #000;position:fixed;top:70px;border:2px solid black">Crée un modéle</button>
					</div>

				</div>
				
				<!--partie affichage mobile code promo.-->

				
                    <div class="card card_table_mobile_responsive">
                    <div class="alert alert-success" role="alert" id="{{ $css }}">
                     <br/> {{ $messages  }}
                   </div>
                   
				   <div class="alert alert-danger" role="alert" id="{{ $csss }}">
                      {{$messa  }}
                    </div>

				   <div class="" style="height:250px;overflow-y:scroll;background-color:white;">
				    On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour 'Lorem Ipsum' vous conduira vers de nombreux sites qui n'en sont encore qu'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement
				    (histoire d'y rajouter de petits clins d'oeil, voire des phrases embarassantes).
				
				   </div>
                     <div class="table-responsive p-3">

							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>
							
							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;">

								<thead>

								<tr>
									    <th scope="col" style="font-size:14px;font-weight:300">Date-création</th>
									    <th scope="col" style="font-size:14px;font-weight:300">Titre du contact</th>
									    <th scope="col" style="font-size:14px;font-weight:300">Sujet de message</th>
										<th scope="col" style="font-size:14px;font-weight:300">Action</th>
										
									</tr>

								</thead>

								<tbody>

								  @foreach($result as $val)

								  <tr>
                                  <td data-label="Date de création">{{ $val['date'] }}</td>
									<td data-label="Titre" class="">{{ $val['titre'] }}</td>
									<td data-label="Sujet" class="">{{ $val['sujet'] }}</td>
									<td data-label="Action"><button type="button" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModalss" class="edit-model"  data-id1="{{ $val['id']}}"  style="border-radius:5px;background-color:black;color:white;border:2px solid #000"><i class="bx bxs-edit"></i></button></td>
	 
								</tr>

								 @endforeach

								</tbody>

						  </table>


				<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true";style="width:20%;height:130px;padding:2%;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                <form method="post" id="renvoi_code" action="{{ route('ambassadrice.modelss') }}">
                                                 @csrf
                                                    
                                           <h5 class="modal-title" style="font-size:12px;text-transform:uppercase;text-align:center;padding:2%;">Créer des modéles de contacts pour l'elève</h5>
											<div>		
                                            <input type="text" id="title" name="title" class="form-control"  aria-describedby="emailHelp" placeholder="Titre de votre modèle" required><br/>
                                            </div>

											<div>		
                                            <input type="text" id="sujet" name="sujet" class="form-control"  aria-describedby="emailHelp" placeholder="Sujet de votre message" required><br/>
                                            </div>

                                            <div>
                                             
                                            <div class="form-group">
											<div style="font-weight:bold;font-size:16px;margin-left:2%">Bonjour chère élève,</div>
                                           <textarea id="messages"  name="messages" class="form-control"  rows="3" placeholder="Contenu de votre message" required></textarea>
                                           </div>

                                           </div>
                                                         
                                              <div style="margin:3%">
                                                    <button style="margin-left:25%;" type="sumit" style="" class="btn btn-dark" id="renvois">Enregistrer le modéle</button>
													<input type="hidden" id="line-id" name="line-id"></div>
                                                        
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
				              </div>
				              
				              
				              
				              	<div class="modal fade" id="exampleVerticallycenteredModalss" tabindex="-1" aria-hidden="true";style="width:20%;height:130px;padding:2%;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                <form method="post" id="r" action="{{ route('ambassadrice.modeledits') }}">
                                                 @csrf
                                                    
                                           <h5 class="modal-title" style="font-size:12px;text-transform:uppercase;text-align:center;padding:2%;">Editer le modèle de contact</h5>
											<div>		
                                            <input type="text" name="titless" id="titless" class="form-control"  aria-describedby="emailHelp" placeholder="Titre du modèle" required><br/>
                                            </div>

											<div style="margin-top:10px">		
                                            <input type="text"  name="sujets" id="sujets" class="form-control"  aria-describedby="emailHelp" placeholder="Sujet de votre message" required><br/>
                                            </div>

                                            <div>
                                             
                                            <div class="form-group" style="margin-top:10px">
											<div style="font-weight:bold;font-size:14px">Bonjour chère élève,</div>
                                           <textarea  name="messagess" id="messagess" class="form-control"  rows="3" placeholder="Contenu de votre message" required></textarea>
                                           <input type="hidden" name="line-id" id="line-ids">
                                           </div>

                                           </div>
                                                         
                                              <div style="margin:3%">
                                                    <button style="margin-left:30%;" type="sumit" style="" class="btn btn-dark" id="renvois">Modifier le modéle</button>
													</div>
                                                        
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
				              </div>



							    
				              </div>
				              
				              <div id="pak"></div>

		
    <!--end page wrapper -->

		@endsection

		

		@section("script")

		<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

		<script>

		$(document).ready(function() {

			$('#example').DataTable({
				"paging":   false,
				"bFilter": false,
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

			$('#messages').keyup(function(){
               $('#messages').hmtl('Bonjour')
 
			});


		$('.edit-model').click(function() {
           var id = $(this).data('id1');
           $('#line-id').val(id);
		  
           $.ajax({
		     url: "{{ route('ambassadrice.modeledit') }}",
		    method: 'GET',
		    data: {id:id},
		}).done(function(data) {
            
		    var res =  JSON.parse(data).zap
		    var titre = JSON.parse(data).titre
		    var sujet = JSON.parse(data).sujet
		    var messages = JSON.parse(data).messages
		    var ids = JSON.parse(data).id
		 
		    $('#line-ids').val(ids);
			$('#sujets').val(sujet);
			$('#messagess').val(messages);
			$('#titless').val(titre);
			
		});

    });
    

		} );

		</script>

		@endsection
	

		

	