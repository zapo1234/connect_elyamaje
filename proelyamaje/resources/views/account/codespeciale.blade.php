@extends("layouts.apps")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Codes promos</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Créer un code spécifique</li>
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
						  
						</div> -->
						
						
						<div class="card border-top border-0 border-4 border-primary">
                            <div class="card-body p-5">

                                @if (session('succes'))
                                <div class="alert alert-success border-0 bg-success alert-dismissible fade show" style="position:absolute;text-align:center;top:5px;margin-left:45%">
                                    <div class="text-white">sss{{ session('succes') }}</div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                @elseif(session('failed'))
                              
                                @endif
                                                        
                                @if (session('errors'))
                                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show" style="position:absolute;text-align:center;top:5px;margin-left:45%">
                                    <div class="text-white">{{ session('errors') }}</div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>      
                                @elseif(session('failed'))
                           
                                 @endif    

                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                                        </div>
                                        <h5 class="mb-0 text-primary" style="color:black"> Informations  </h5>
                                    </div>
                                    <hr>
                                    <form  method="post" id="forms_account"   action="/account/create/code"  class="row g-3">
                                          @csrf
                                        <div class="col-md-6">
                                            <label for="inputState" class="form-label">Ambassadrice(*)</label>
                                            <select id="ambassadrice" name="ambassadrice" class="form-select" >
                                               <option value="">choisir</option>
                                               @foreach($list as $k => $val)
                            
                                                @foreach($val as $m =>$vals)
                
                                                 <option value="{{ $m }}">{{ $vals }}</option>
		                      
                                                @endforeach
                                                @endforeach
                                                
                                            </select>
                                        </div>

                                        
                                        <div class="col-md-6">
                                            <label for="inputState" class="form-label">Partenaire(*)</label>
                                            <select id="partenaire" name="partenaire" class="form-select" >
                                               <option value="">choisir</option>
                              
                                               @foreach($lists as $ks => $valc)
                            
                                                 @foreach($valc as $ms =>$valss)
		                                           <option value="{{ $ms }}">{{ $valss }}</option>
		                     
		                                          @endforeach
                                                  @endforeach
                                                
                                            </select>
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Name(nom de l'élève) *</label>
                                            <input type="text" name="nom" id="nom" class="form-control"  required>
                                            <div><span class id="error_name"></span></div>
                         
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">E-mail(email) *</label>
                                            <input type="text" name="email" id="email" class="form-control"  required>
                                            <div><span class id="error_name"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Réduction élève *</label>
                                            <input type="number" name="reduction" id="reduction" class="form-control" required>
                                            <div><span class id="error_username"></span></div>    
                                        </div>
                                        
                                         <div class="col-md-6">
                                            <label for="inputPassword" class="form-label">Commission Ambassadrice *</label>
                                            <input type="number"  id="commission" name="commission" class="form-control"  required>
                                        </div>
                                        
                                        
                                        
                                         <div><span class id="error_live"></span></div>
                                        
                                        <div class="col-12">
                                            <button type="submit"  id="submit_account" class="btn btn-primary px-5">créer le code</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
						
					<!-- </div>
				</div> -->


          





			</div>
		</div>
		<!--end page wrapper -->
		@endsection
	