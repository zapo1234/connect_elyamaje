@extends("layouts.apps_utilisateurs")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Ajouter une commande</div>
					<div class="ms-auto">
						<div class="btn-group">
							
							
            <div class="ms-auto"><a href="{{ route('utilisateurs.list')  }}" class="btn btn-primary radius-30 mt-2 mt-lg-0" style="border-radius:5px">Lister des commandes</a></div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
			  
				
						
						
						<div class="card border-top border-0 border-4 border-primary">
						    
                                <div class="card-body p-5">
                                    
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                                        </div>
                                        <h5 class="mb-0 text-primary" style="color:black"> Informations sur des commandes </h5>
                                    </div>
                                    <hr>
                                   
                                   <!--forms--ici-->
                                   <form method="post" id="forms_codepromo"  action="{{ route('createcodepromo') }}">
                    
                          @csrf
                       <div class="form-row">
                           
                    <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Date *</label>
                    <input type="date" name="date_vente" class="form-control form-control-user"  name="account_promo" id="account_promo" required placeholder="">
                   <div><span class id="error_promo"></span></div>
                   </div>
                      
                    <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Code élève *</label>
                    <input type="text"  class="form-control form-control-user"  name="account_promo" id="account_promo" required placeholder="">
                   <div><span class id="error_promo"></span></div>
                   </div>
                   
                   <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputPassword4">Montant *(Hors taxe facturé)</label>
                   <input type="text" class="form-control" id="account_montant" name="account_montant" required><br/>
                   
                  <div><span class id="error_montant"></span></div>        
                   
                 </div>
                  
                 
                 <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputPassword4">Ref-facture -dolibar *</label>
                   <input type="text" class="form-control" id="ref_facture" name="ref_facture" required>
                  <div><span class id="error_facture"></span></div>        
                   
                 </div>
           
          
          </div>
          
          <div><span class id="error_live"></span></div>
          
          
          </div>
          
          <div class="row d-flex justify-content-center">
            <button class="mb-5 btn btn-dark px-5" style="width:auto" type="button" id="submit_codepromo" >Enregistrer la commande</button>
          </div>
	
	    </form>
                                   
                                   
                                </div>
                            </div>
			


           @if (session('error'))
         <div class="alert alert-danger" role="alert" id="alert_email" style="width:300px;height:60px;text-align:center;margin-top:-130px;margin-left:45%">
	      {{ session('error') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif
                                 
          @if (session('errors'))
         <div class="alert alert-danger" role="alert" id="alert_email" style="width:300px;height:55px;text-align:center;margin-top:-130px;margin-left:45%">
	      {{ session('errors') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif 





			</div>
		</div>
		<!--end page wrapper -->
		@endsection
	