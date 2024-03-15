@extends("layouts.apps_ambassadrice")

@section("style")

<style>
#noaffiche{display:none}
</style>

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

		
					<div class="alert alert-success border-0 bg-success alert-dismissible fade show" id="{{ $css }}">
						<div class="text-white">{{ $message }}</div>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				



				<div class="col-xl-12 mx-auto">
                    <h5 class="mb-2 text-uppercase">Formulaire de contact</h5>
                    <div class="card">
                        <div class="card-body">
							<div class="w-100">
								<p class="text-left">Une question concernant l'utilisation de notre application ? Besoin d'un renseignement ? Contactez-vous !</p>
								<form method="post" action ="{{ route('ambassadrice.postaideforms') }}">
									@csrf
									<select  class="form-select" name="choix" aria-label="Default select example" style="" required>
											<option selected value="">Sélectionnez un motif de contact</option>
											<option value="1">Demande de live</option>
											<option value="2">Mon code n'est pas actif (pendant mon live)</option>
											<option value="3">Commission</option>
											<option value="4">Paiement de facture</option>
											<option value="5">Autre...</option>
										</select>
									<div class="col-12" style="margin-top:10px;">
										<textarea class="form-control" id="repons" name="repons" rows="5" placeholder="Expliquez votre demande ..." required></textarea>
										NB : Vous avez au maximum 500 caractères. <span id="txt"></span>
									</div>
										
									<div class="col-12 d-flex justify-content-center mt-2">
											<button id="id_submit_btn" type="submit" class="btn btn-primary px-5">Envoyer</button>
										</div>
                                </form>
                            
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

        //
        $('#repons').keyup(function(){
          //alert('zapo');
          var count_txt = $('#repons').val();
		  var nombre = count_txt.length;
          var max_txt = 500;
          var result = 500 - nombre;
		  if(nombre > 0){
           $('#txt').html('il vous reste'+result+'caractères');
		  }else{
			 $('#repons').onkeypress = function(e){
                e.preventDefault();
			 };
		  }

      });

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

	