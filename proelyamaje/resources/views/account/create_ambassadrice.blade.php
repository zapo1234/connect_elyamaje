@extends("layouts.apps")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Ambassadrices</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Créer ambassadrice</li>
							</ol>
						</nav>
					</div>

					<div class="ms-auto"><a href="{{ route('account.list')  }}" class="btn btn-primary radius-30 mt-2 mt-lg-0" style="border-radius:5px">Lister des utilisateurs</a></div>
				</div>
				<!--end breadcrumb-->
			  
				<!-- <div class="card">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
						
							</div>
						  <div class="ms-auto"><a href="{{ route('account.list')  }}" class="btn btn-primary radius-30 mt-2 mt-lg-0" style="border-radius:5px">Lister des utilisateurs</a></div>
						</div> -->
						
						
						<div class="card border-top border-0 border-4 border-primary">
                                <div class="card-body p-5">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                                        </div>
                                        <h5 class="mb-0 text-primary" style="color:black"> Informations  </h5>
                                    </div>
                                    <hr>
                                    <form  method="post" id="forms_account"  action="{{ route('account.create') }}" enctype="multipart/form-data" class="row g-3">
                                          @csrf
                                        <div class="col-md-6">
                                            <label for="inputState" class="form-label">Type de compte(*)</label>
                                            <select id="account_type" name="account_type" class="form-select" required>
		                                      <option value="Ambassadrice">Ambassadrice</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputLastName" class="form-label">Siret(société)</label>
                                            <input type="password" class="form-control" id="siret" name="siret">
                                           <div><span class id="error_name"></span></div>
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="inputState" class="form-label">Status de société(*)</label>
                                            <select id="account_societe" name="account_societe" class="form-control">
                                             <option value="rien">choisir</option>
		                                    <option value="SASU">SASU </option>
		                                      <option value="SARL">SARL</option>
		                                       <option value="SAS">SAS</option>
		                                          <option value="EI">EI</option>
		                   
                                             </select>
                         
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Name(nom de l'utilisateur) *</label>
                                            <input type="text" name="account_name" id="account_name" class="form-control"  required>
                                            <div><span class id="error_name"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Username(prénom de l'utilisateur) *</label>
                                            <input type="text" name="account_username" id="account_username" class="form-control" required>
                                            <div><span class id="error_username"></span></div>    
                                        </div>
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Email(identifiant) *</label>
                                            <input type="email"  id="account_email" name="account_email" class="form-control"  required>
                                        </div>
                                        
                                        
                                          <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Téléphone *</label>
                                            <input type="text" name="account_phone" id="account_phone" class="form-control"  required>
                                            <div><span class id="error_phone"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Adresse  *</label>
                                            <input type="text" class="form-control" id="account_address" name="account_address" >
                                            <div><span class id="error_address"></span></div>
                                        </div>
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">code postal *</label>
                                            <input type="number" id="account_codep" name="account_codep" class="form-control" >
                                            <div><span class id="error_codep"></span></div>
                                        </div>
                                        
                                        
                            
                                        <div class="col-md-6">
                                            <label for="inputZip" class="form-label">Ville</label>
                                            <input type="text" class="form-control" id="account_ville" name="account_ville">
                                            <div><span class id="error_ville"></span></div>
                                        </div>
                                        
                                        
                                         <div class="col-md-6">
                                            <label for="inputZip" class="form-label">Code-reduction</label>
                                            <input type="text" class="form-control" id="reduction" name="reduction">
                                            <div><span class id="error_ville"></span></div>
                                        </div>
                                        
                                        
                                       <div class="form-group col-md-6" id="live"><!--ajouter un champs code_live-->
                                       
                                       
                                        <div class="col-md-6">
                                            <label for="inputZip" class="form-label">Depense-mini(live)</label>
                                            <input type="text" class="form-control" id="depense-min" name="depense-mini">
                                            <div></div>
                                        </div>
           
                                       
                                       </div>
          
                                         <div class="form-group col-md-6">
                                        <label for="inputPassword4">Upload file(picture) * recommandé(png,jpeg,jpeg moins de 1MO) </label>
                                         <input type="file" class="form-control" id="file" name="file" placeholder="">
                                         <div><span class id="error_ville"> </span></div>
           
                                         </div>
                                        
                                        
                                         <div><span class id="error_live"></span></div>
                                        
                                        <div class="col-12">
                                            <button type="submit"  id="submit_account" class="btn btn-primary px-5">créer le compte</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
						
					<!-- </div> -->
				<!-- </div> -->


            @if (session('error_email'))
         <div class="alert alert-danger" role="alert" id="alert_email" style="width:300px;height:55px;text-align:center;margin-top:-30px;">
	      {{ session('error_email') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif
                                 
          @if (session('errors'))
         <div class="alert alert-danger" role="alert" id="alert_email" style="width:300px;height:55px;text-align:center;margin-top:-30px;">
	      {{ session('errors') }}
          </div>
        @elseif(session('failed'))
                           
                                 @endif





			</div>
		</div>
		<!--end page wrapper -->
		@endsection
	