@extends("layouts.apps_utilisateurs")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Modifier La commande</div>
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
			  
				<div class="card">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
						  
							</div>
						  <div class="ms-auto"><a href="{{ route('utilisateurs.list')  }}" class="btn btn-primary radius-30 mt-2 mt-lg-0" style="border-radius:5px">Lister des commandes</a></div>
						</div>
						
						
						<div class="card border-top border-0 border-4 border-primary">
						    
                                <div class="card-body p-5">
                                    
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                                        </div>
                                        <h5 class="mb-0 text-primary" style="color:black"> Informations sur des commandes </h5>
                                    </div>
                                    <hr>
                                   
                                  <form method="post" id="forms_edit_caisse"  action="/editcaisse">
                    
                          @csrf
                       <div class="form-row">
                           
                                        <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Date d'enregsit *({{ $data->datet }})</label>
                    <input type="date" name="date_vente"  class="form-control form-control-user" name="account_promo" id="account_promo" placeholder="">
                   <div><span class id="error_code"></span></div>
                   </div>
                      
                    <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Code promo/code-live *</label>
                    <input type="text"  class="form-control form-control-user" name="account_promo" id="account_promo"  value="{{ $data->code_promo }}" readonly required placeholder="">
                   <div><span class id="error_code"></span></div>
                   </div>
                   
                   <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputPassword4">Montant *(Hors taxe facturé)</label>
                   <input type="text" class="form-control" id="account_montant" name="account_montant" value="{{ number_format($data->somme, 2, '.', '') }}" required>
                  <div><span class id="error_montant"></span></div>        
                   
                 </div>
                  
                 
                 <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputPassword4">Ref-facture -dolibar *</label>
                   <input type="text" class="form-control" id="ref_facture" name="ref_facture" value=" {{ $data->ref_facture  }}" required>
                  <div><span class id="error_montant"></span></div>        
                   
                 </div>
                 
                 <div><input type="hidden" name="id_order" bame="id_order" value="{{ $data->id   }}"></div>
          
          </div>
          
          <div><span class id="error_live"></span></div>
          
          
          </div>
          
          <div class="row">
            <button type="submit" id="submit_codepromo" style="background-color:black;color:white;text-align:center;width:300px;height:35px;border:2px solid black;margin-left:5%;border:2px solid black;border-radius:5px;">Modifier la commande</button>
          </div>
                                   
                                   
                                </div>
                            </div>
						
					</div>
				</div>


           @if (session('error'))
         <div class="alert alert-danger" role="alert" id="alert_email" style="width:300px;height:60px;text-align:center;margin-top:-130px;margin-left:45%">
	      {{ session('error') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif
                                 
          @if (session('errors'))
         <div class="alert alert-danger" role="alert" id="alert_email" style="width:300px;height:55px;text-align:center;margin-top:-130px;margin-left:35%">
	      {{ session('errors') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif 





			</div>
		</div>
		<!--end page wrapper -->
		@endsection
	