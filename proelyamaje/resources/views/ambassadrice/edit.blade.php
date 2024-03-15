@extends("layouts.apps_ambassadrice")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Modifier les informations de l'élève</div>
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
                <div class="card-body p-3">
                                    <button type="button" class="btn btn-light d-flex justify-content-around align-items-center " style="width:150px; padding:10px 25px; margin-bottom:20px;">
                                        <i class="bx bx-chevron-left" style="font-size:15px;"></i>
                                        <a href="{{ route('ambassadrice.listeleve') }}">
                                           Retour
                                         </a>
                                    </button>
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                                        </div>
                                        <h5 class="mb-0 text-primary" style="color:black"> Informations  </h5>
                                    </div>
                                    <hr>
                                   <form method="post" id="forms_ambassadrice_edit"  class="row -g-3" action="/ambassadrice/edit/{{ $user->id}}">
                                      @csrf
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Nom de l'élève *</label>
                                            <input type="text" name="account_name" id="account_name"  value="{{ $user->nom}}" class="form-control" value="{{ $user->nom }}" required>
                                            <div><span class id="error_name"></span></div>
                         
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Prénom de l'élève *</label>
                                            <input type="text" id="account_username" name="account_username" class="form-control" value="{{ $user->prenom }}" required>
                                            <div><span  id="error_username"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Adresse e-mail *</label>
                                            <input type="email" id="account_email" name="account_email" value="{{ $user->email  }}" class="form-control" required>
                                            <div><span class id="error_email"></span></div>    
                                        </div>
                                        
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Numéro de téléphone *</label>
                                            <input type="text"  id="account_phone" name="account_phone" value="{{ $user->telephone   }}" class="form-control" >
                                            <div><span class id="error_phone"></span></div>
                                        </div>
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Adresse *</label>
                                            <input type="text" class="form-control" id="account_address" name="account_address" placeholder="" value="{{ $user->adresse   }}" class="form-control" >
                                            <div><span class id="error_address"></span></div>
                                        </div>
                                        
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Code postal </label>
                                            <input type="number" class="form-control" id="account_codep" name="account_codep" placeholder="" value="{{ $user->code_postal  }}" placeholder="" value="{{ $user->code_postal  }}" class="form-control">
                                            <div><span class id="error_codep"></span></div>
                                        </div>
                                        
                                    
                                        
                                        <div class="col-12 d-flex justify-content-center">
                                            <button type="button" id="submit_customer_edit" class="btn" style="margin-top:20px;width:250px;height:40px;color:white;text-align:center;border-radius:5px;background-color:black">Modifier</button>
                                        </div>
                                    </form>
                                </div>
				</div>


           <div class="a" role="alert" id="alert_email" style="width:100%;padding:0.5%;text-align:center;margin-top:30px;color:black;border-radius:3px;">
	      {{ $message}}
          </div>





			</div>
		</div>
		<!--end page wrapper -->
		@endsection
	   