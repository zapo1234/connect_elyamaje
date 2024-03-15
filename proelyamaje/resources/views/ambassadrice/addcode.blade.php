@extends("layouts.apps_ambassadrice")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Ajouter un code promo pour l'élève</div>
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
			  
								
						<div class="card border-top border-0 border-4 border-primary">
                                <div class="card-body">
                                    <button type="button" class="btn btn-light d-flex justify-content-around align-items-center " style="width:150px; padding:10px 25px; margin-bottom:20px;">
                                        <i class="bx bx-chevron-left" style="font-size:15px;"></i>
                                        <a href="{{ route('ambassadrice.listeleve') }}">
                                           Retour
                                         </a>
                                    </button>
                                    <div class="card-title d-flex align-items-center">
                                        <div>
                                        </div>

                                        @if($message_type)
                                            <div class="alert w-100 border-0 border-start border-5 border-{{$message_type}} alert-dismissible fade show py-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="font-35 text-{{$message_type}}"><i class="bx bxs-message-square-x"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h6 style="text-transform:capitalize" class="mb-0 text-{{$message_type}}">{{$message_type != "success" ? "Alerte" : "Succès" }}</h6>
                                                        <div>{{$message_lecture}} {{ $message_lectures }}</div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        
                                    </div>
                                    <hr>
                                   <form method="post" id="forms_ambassadrice_edit"  class="row -g-3" action="/ambassadrice/add/{{ $user->id}}">
                                      @csrf
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Nom de l'élève *</label>
                                            <input type="text" name="account_name" id="account_name"  value="{{ $user->nom}}" class="form-control" value="{{ $user->nom }}" redonly>
                                            <div><span class id="error_name"></span></div>
                         
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Prénom de l'élève *</label>
                                            <input type="text" id="account_usernane" name="account_username" class="form-control" value="{{ $user->prenom }}" readonly>
                                            <div><span class id="error_name"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Adresse e-mail *</label>
                                            <input type="email" id="account_email" name="email" value="{{ $user->email  }}" class="form-control" readonly>
                                            <div><span class id="error_username"></span></div>    
                                        </div>
                                        
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Numéro de téléphone *</label>
                                            <input type="text"  id="account_phone" name="account_phone" value="{{ $user->telephone   }}" class="form-control"  redonly>
                                            <div><span class id="error_phone"></span></div>
                                        </div>
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Adresse de élève</label>
                                            <input type="text" class="form-control" id="account_addres" name="account_address" placeholder="" value="{{ $user->adresse   }}" class="form-control"  readonly>
                                            <div><span class id="error_address"></span></div>
                                        </div>
                                        
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Code postal</label>
                                            <input type="number" class="form-control" id="account_codep" name="account_codep" placeholder="" value="{{ $user->code_postal  }}" placeholder="" value="{{ $user->code_postal  }}" class="form-control"  readonly>
                                            <div><span class id="error_codep"></span></div>
                                        </div>
                                        
                                    
                                        
                                        <div class="col-12 d-flex justify-content-center">
                                             <button type="submit" id="" class="btn" style="margin-left:2%;background-color:black;color:white;border:2px solid #eee;width:250px;height:45px;border:2px solid black;margin-top:20px;border-radius:5px;">Ajouter un code promo</button>
                                    </form>
                                </div>
                            </div>
						
					


           <div class="a" role="alert" id="alert_email" style="width:100%;padding:0.5%;text-align:center;margin-top:30px;color:black;border-radius:3px;">
	    
          </div>





			</div>
		</div>
		<!--end page wrapper -->
		@endsection
	