
@extends("layouts.apps")

	@section("style")

	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('admin/css/Ambassadrice/css_superAdmin.css')}}" rel="stylesheet" />
	@endsection	
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">

                
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
                    <h6 class="mb-0 text-uppercase">FAQs Pour Ambassadrice && Partenaires</h6>
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <div class="p-4 border rounded">
                                <form class="row g-3" method="post" action="{{route('faqAdminPost')}}">
                                   @csrf
                                   
                                   @foreach($dataQuestions as $key => $dataQuestion)
                                    
                                   <div class="row mb-3" id="element_parent_{{$dataQuestion->id}}">
                                        <div class="col-11">
                                            <div class="row">
                                                    <div class="col-1 d-flex align-items-center justify-content-center mt-2">
                                                        <label for="question_{{$dataQuestion->id}}" class="form-label">Q {{$key+1}}</label>
                                                    </div>
                                                    <div class="col-10">
                                                        <input type="text" class="form-control" id="question_{{$dataQuestion->id}}" name="question_{{$dataQuestion->id}}" required="" 
                                                            placeholder="Votre question ..." value="{{$dataQuestion->question}}" disabled>
                                                    </div>

                                                    <div class="col-1 d-flex align-items-center justify-content-center">
                                                        <a href="javascript:void(0)" class="" style="margin-right: 4%;"> 
                                                            <i onclick="editeQuestion({{$dataQuestion->id}})" style="font-size: 20px;" class="bx bxs-edit col-6" id="icone_Q_id_{{$dataQuestion->id}}"></i> 
                                                        </a>
                                                    </div>
                                            </div>

                                            {{-- reponse --}}

                                            <div class="row mt-1">
                                                <div class="col-1 d-flex align-items-center justify-content-center mt-2">
                                                    <label for="reponse_{{$dataQuestion->id}}" class="form-label">R {{$key+1}}</label>
                                                </div>

                                                <div class="col-10">
                                                    <textarea class="form-control text_area" id="reponse_{{$dataQuestion->id}}" name="reponse_{{$dataQuestion->id}}" rows="2" required disabled>{{$dataQuestion->reponse}}</textarea>
                                                </div>

                                                <div class="col-1 d-flex align-items-center justify-content-center text-center">
                                                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-center" style="margin-right: 4%;"> 
                                                        <i onclick="editeResponse({{$dataQuestion->id}})" style="font-size: 20px;" class="bx bxs-edit" id="icone_R_id_{{$dataQuestion->id}}"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-1 d-flex align-items-center justify-content-center text-center">

                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="javascript:void(0)" class="">
                                                    <i onclick="deleteQuestionReponse({{$dataQuestion->id}})" style="font-size: 20px;" class="fadeIn animated bx bx-trash" id="icone_Q_id_d{{$dataQuestion->id}}"></i> 
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


            </div>
      </div>

  
    @section("script")
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{asset('admin/js/js_calculPoint.js')}}"></script>

 @endsection

@endsection






	