@extends("layouts.apps_utilisateurs")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Cloture de caisse Dolibar </div>
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
                                        <h5 class="mb-0 text-primary" style="color:black"> Transférer les fonds de caisse </h5>
                                    </div>
                                    <hr>
                                   
                                  <form method="post" id="forms_edit_caisse"  action="/utilisateur/caisse/cloture">
                    
                               @csrf
                              <div class="form-row">
                           
                                        <div class="form-group col-md-6" style="margin-top:20px;">
                         <label for="inputEmail4">Date date d'enregistrement </label>
                    <input type="date"   class="form-control form-control-user" name="date_transfer"  placeholder="" required>
                   <div><span class id="error_code"></span></div>
                   </div>
                      
                    <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4"> DE Bank(tunel) *</label>
                    <input type="text"  class="form-control form-control-user" name="compte1"  value="{{ $libelle1 }}" readonly>
                   <div><span class id="error_code"></span></div>
                   </div>
                   
                   
                    <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Vers   Bank(tunel) *</label>
                    <input type="text"  class="form-control form-control-user" name="compte2"  value="{{ $libelle2  }}" readonly>
            
                   <div><span class id="error_code"></span></div>
                   </div>
                   
                 
                   
                   <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputPassword4">Montant *(transférer)</label>
                   <input type="text" class="form-control"  name="montant_transfer" value="" required>
                  <div><span class id="error_montant"></span></div>        
                   
                 </div>
                 
                 
                 <div><input type="hidden" name="id_order" bame="id_order" value=""></div>
          
          </div>
          
          <div><span class id="error_live"></span></div>
          
          
          </div>
          
          <div class="row d-flex justify-content-center w-100 mb-2">
            <button type="submit" id="submit_codepromo" class="btn btn-dark px-5" style="width:auto">Transférer</button>
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
	