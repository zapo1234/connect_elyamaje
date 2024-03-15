@extends("layouts.apps_utilisateurs")



	@section("style")


	@endsection	

		@section("wrapper")

		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3"></div>
					<div class="ms-auto">

					</div>
				</div>

				@if (session('error'))
					<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
						<div class="text-white">{{ session('error') }}</div>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@elseif(session('success'))
					<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
						<div class="text-white">{{ session('success') }}</div>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif


				<!-- MODAL VALIDATION -->
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
					<div class="modal-dialog modal-dialog-centered" role="document">                
                        <div class="modal-content bouton_content">
                            <div class="modal-body">
                                <h2 class="text-center">Voulez vous supprimer cette Question/Réponse</h2>

                            </div>
							<input hidden  type="text" id="routeDeleteQR" value="{{route('faqAdminDelete')}}">
							<div class="p-2 d-flex justify-content-center">
								<button  type="button" data-bs-dismiss="modal" style="width:100px;background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;">Annuler</button>
								<button onclick="deleteQR()" id="modalConfirmationDeletQ" data-id = "" type="submit" style="width:100px;background-color:#00FF00;color:black;border:2px solid #00FF00;margin-left:10px;border-radius:15px;font-weight:bold">Supprimer</button>
							</div>
						</div>
					</div>
				</div>


				<div class="col-xl-12 mx-auto">
                    <h6 class="mb-0 text-uppercase">FAQs</h6>
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <div class="p-4 border rounded">
                                <form class="row g-3" method="post" action="{{route('faqAdminPost')}}">
                                   @csrf
                                   
                                   @foreach($dataQuestions as $key => $dataQuestion)
                                    
                                   <div class="row mb-3" id="element_parent_{{$dataQuestion['id']}}">
                                        <div class="col-11">
                                            <div class="row">
                                                    <div class="col-1 d-flex align-items-center justify-content-center mt-2">
                                                        <label for="question_{{$dataQuestion['id']}}" class="form-label">Q {{$key+1}}</label>
                                                    </div>
                                                    <div class="col-10">
                                                        <input type="text" class="form-control" id="question_{{$dataQuestion['id']}}" name="question_{{$dataQuestion['id']}}" required="" 
                                                            placeholder="Votre question ..." value="{{$dataQuestion['question']}}" disabled>
                                                    </div>

                                                    <div class="col-1 d-flex align-items-center justify-content-center">
                                                        <a href="javascript:void(0)" class="" style="margin-right: 4%;"> 
                                                            <i onclick="editeQuestion({{$dataQuestion['id']}})" style="font-size: 20px;" class="bx bxs-edit col-6" id="icone_Q_id_{{$dataQuestion['id']}}"></i> 
                                                        </a>
                                                    </div>
                                            </div>

                                            {{-- reponse --}}

                                            <div class="row mt-1">
                                                <div class="col-1 d-flex align-items-center justify-content-center mt-2">
                                                    <label for="reponse_{{$dataQuestion['id']}}" class="form-label">R {{$key+1}}</label>
                                                </div>

                                                <div class="col-10">
                                                    <textarea class="form-control" id="reponse_{{$dataQuestion['id']}}" name="reponse_{{$dataQuestion['id']}}" rows="2" required disabled>{{$dataQuestion['reponse']}}</textarea>

                                                </div>

                                                <div class="col-1 d-flex align-items-center justify-content-center text-center">
                                                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-center" style="margin-right: 4%;"> 
                                                        <i onclick="editeResponse({{$dataQuestion['id']}})" style="font-size: 20px;" class="bx bxs-edit" id="icone_R_id_{{$dataQuestion['id']}}"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-1 d-flex align-items-center justify-content-center text-center">

                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="javascript:void(0)" class="">
                                                    <i onclick="deleteQuestionReponse({{$dataQuestion['id']}})" style="font-size: 20px;" class="fadeIn animated bx bx-trash" id="icone_Q_id_d{{$dataQuestion['id']}}"></i> 
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                    @endforeach()



                                    {{-- ajouter une question --}}


                                    <div class="col-md-12">
                                        <label for="question" class="form-label">Question *</label>
                                        <input type="text" class="form-control" id="question" name="question" placeholder="Votre question ..." >
                                        <div id="Nom" class="invalid-feedback">Champs obligatoire</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="reponse" class="form-label">Réponse *</label>
                                        <textarea class="form-control" id="reponse" name="reponse" rows="3" placeholder="Votre Réponse ..."></textarea>
                                    </div>
                                    
                            
                                      
    
    
    
                                    <div class="col-12 d-flex justify-content-center">
                                        <button id="id_submit_btn" type="submit" class="btn btn-primary px-5">Ajouter</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

				
	

				<div class="card">



				</div>
			</div>
		</div>

	

		

		<!--end page wrapper -->

		@endsection

			

		@section("script")


	<script>

		// edite faq
		function editeQuestion(id_question){
			$("#question_"+id_question).removeAttr("disabled");
		}

		function editeResponse(id_response){
			$("#reponse_"+id_response).removeAttr("disabled");
		}
		// delete

		function deleteQuestionReponse(id){

			$("#modalConfirmationDeletQ").attr("data-id", id);
			$("#exampleModal").modal('show')

		}
		function deleteQR(){

			id = $("#modalConfirmationDeletQ").attr('data-id');
			urlFunctionDelet = $("#routeDeleteQR").val();
			elementPrent = document.getElementById('element_parent_'+id);

			$.ajax({
				url: urlFunctionDelet,
				method: 'POST',
				data:{id:id},
				headers: {
					'X-CSRF-TOKEN': $('input[name="_token"]').val()
				},                       
				success: function(response) {

					if (response) {
						elementPrent.remove();
					}
					$("#exampleModal").modal('hide');

				},
				error: function(xhr, status, error) {
					console.error(status);

				}
			});

		}

	</script>



	@endsection

	