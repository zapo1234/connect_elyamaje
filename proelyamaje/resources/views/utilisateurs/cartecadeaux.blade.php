@extends("layouts.apps_utilisateurs")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Générés des Bon d'achat pour des clients </div>
					<div class="ms-auto">
            <div class="ms-auto"><a href="{{ route('utilisateurs.list')  }}" class="btn btn-primary radius-30 mt-2 mt-lg-0" style="border-radius:5px">Lister des transferts</a></div>
					</div>
				</div>
				<!--end breadcrumb-->
			  
				
					<div class="card border-top border-0 border-4 border-primary">
						    
                                <div class="card-body p-5">
                                    
                                    <div class="card-title d-flex align-items-center">
                                        <div>
                                        </div>
                                        <h5 class="mb-0 text-primary" style="color:black">Créer le numéro de bon pour la cliente</h5>
                                    </div>
                                    <hr>
                                   
                                  <form method="post" id="forms_edit_caisse"  action="/Utilisateur/cartescado">
                    
                               @csrf
                              <div class="form-row">
                           
                                        <div class="form-group col-md-6" style="margin-top:20px;">
                         <label for="inputEmail4">Date date d'enregistrement </label>
                    <input type="date"   class="form-control form-control-user" name="date"  placeholder="" required>
                   <div><span class id="error_code"></span></div>
                   </div>
                      
                    <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4"> E-mail</label>
                    <input type="text"  class="form-control form-control-user" name="mail" required>
                   <div><span class id="error_code"></span></div>
                   </div>
                   
                   <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Rentrer la carte cadeaux si elle existe deja(NB: le faire pour une ancienne cliente)</label>
                    <input type="text"  class="form-control form-control-user" name="card" >
                   <div><span class id="error_code"></span></div>
                   </div>
                   
                    <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Montant(attribué) </label>
                    <input type="text"  class="form-control form-control-user" name="amount" required>
            
                   <div><span class id="error_code"></span></div>
                   </div>
                      
                   <div class="" style="margin-left:15%;margin-top:20px">
                  <button type="submit" id="submit_codepromo" class="btn btn-dark px-5" style="width:auto;width:300px;">Créer</button>
                 </div>
                 
                   
                 </div>
                 
                 
                 <div><input type="hidden" name="id_order" bame="id_order" value=""></div>
          
          </div>
          
          <div><span class id="error_live"></span></div>
          
          
          </div>
          
        </div>
     </div>
				


           @if (session('error'))
         <div class="alert alert-danger" role="alert" id="alert_email" style="width:300px;height:70px;text-align:center;margin-top:-220px;margin-left:60%">
	      {{ session('error') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif
                                 
          @if (session('succes'))
         <div class="alert alert-success" role="alert" id="alert_email" style="width:300px;height:70px;text-align:center;margin-top:-220px;margin-left:60%">
	      {{ session('succes') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif 

	</div>
		</div>
		<!--end page wrapper -->
		@endsection
		
	@section("script")
	<script src="/admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="/admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script>
	let dateInput = document.getElementById("search_dates");
     dateInput.min = new Date().toISOString().slice(0,new Date().toISOString().lastIndexOf(":"));
	</script>

	@endsection	
	