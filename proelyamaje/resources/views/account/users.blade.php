@extends("layouts.apps")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Utilisateurs</div>
                    <div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Créer un compte</li>
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
                                                <option value="rien">Choisir</option>
		                                      <option value="Admin">Admin </option>
		                                      <option value="Ambassadrice">Ambassadrice</option>
		                                       <option value="Partenaire">Partenaire</option>
		                                      <option value="Utilisateur">Utilisateur </option>
                                                
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputLastName" class="form-label">Siret (société)</label>
                                            <input type="text" class="form-control" id="siret" name="siret">
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
                                                  <option value="User-marseille">Utilisateur Marseille</option>
		                                          <option value="User-nice">Utilisateur Nice</option>
		                   
                                             </select>
                         
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Nom *</label>
                                            <input type="text" name="account_name" id="account_name" class="form-control"  required>
                                            @error('account_name')
                                                <div class="alert alert_update_profil border-0 border-start border-5 border-danger alert-dismissible fade show">
                                                    <div>{{ $message }}</div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Prénom *</label>
                                            <input type="text" name="account_username" id="account_username" class="form-control" required>
                                            @error('account_username')
                                                <div class="alert alert_update_profil border-0 border-start border-5 border-danger alert-dismissible fade show">
                                                    <div>{{ $message }}</div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @enderror   
                                        </div>
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Email *</label>
                                            <input type="email"  id="account_email" name="account_email" class="form-control"  required>
                                            @error('account_email')
                                                <div class="alert alert_update_profil border-0 border-start border-5 border-danger alert-dismissible fade show">
                                                    <div>{{ $message }}</div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @enderror  
                                        </div>
                                        
                                        
                                          <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Téléphone</label>
                                            <input type="text" name="account_phone" id="account_phone" class="form-control"  >
                                            <div><span class id="error_phone"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Adresse *</label>
                                            <input type="text" class="form-control" id="account_address" name="account_address" >
                                            <div><span class id="error_address"></span></div>
                                        </div>
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Code postal *</label>
                                            <input type="number" id="account_codep" name="account_codep" class="form-control" >
                                            @error('account_codep')
                                                <div class="alert alert_update_profil border-0 border-start border-5 border-danger alert-dismissible fade show">
                                                    <div>{{ $message }}</div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @enderror  
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
                                        
                                        <div style="position: relative" class="col-12">
                                            <button type="submit"  id="submit_account" class="btn btn-primary px-5">créer le compte</button>

                                            @if (\Session::has('success'))
                                                <div class="d-flex justify-content-center w-100" style="position:absolute; z-index:1; top:0px">
                                                    <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2 w-100"
                                                    style="background-color:white">
                                                        <div class="d-flex align-items-center">
                                                            <div class="font-35 text-success"><i class="bx bxs-check-circle"></i>
                                                            </div>
                                                            <div class="ms-3">
                                                                <h6 class="mb-0 text-success">Success</h6>
                                                                <div>{!! \Session::get('success') !!}</div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                </div>
                                            @elseif(\Session::has('error'))
                                                <div class="d-flex justify-content-center w-100" style="position:absolute; z-index:1; top:0px">
                                                    <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2 w-100"
                                                    style="background-color:white">
                                                        <div class="d-flex align-items-center">
                                                            <div class="font-35 text-danger"><i class="bx bxs-message-square-x"></i>
                                                            </div>
                                                            <div class="ms-3">
                                                                <h6 class="mb-0 text-danger">Erreur</h6>
                                                                <div>{!! \Session::get('error') !!}</div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                      
                                    </form>
                                </div>
                            </div>
						
					<!-- </div> -->
				<!-- </div> -->
			</div>
		</div>
		<!--end page wrapper -->
		@endsection
	