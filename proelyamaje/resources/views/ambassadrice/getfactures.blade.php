@extends("layouts.apps")


		@section("wrapper")
		<div class="page-wrapper">
			<div class="page-content" style="position:relative">

      @if (session('error'))
         
         <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
              <div class="d-flex align-items-center">
                  <div class="font-35 text-white"><i class="bx bxs-message-square-x"></i>
                  </div>
                  <div class="ms-3">
                      <h6 class="mb-0 text-white">Erreur</h6>
                      <div class="text-white"> {{ session('error') }} </div>
                  </div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
         @elseif(session('failed'))
                               
         @endif
       
       
       
       @if (session('success'))
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
              <div class="d-flex align-items-center">
                  <div class="font-35 text-white"><i class="bx bxs-check-circle"></i>
                  </div>
                  <div class="ms-3">
                      <h6 class="mb-0 text-white">Success</h6>
                      <div class="text-white">{{ session('success') }}</div>
                  </div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
         @elseif(session('failed'))
                               
         @endif

      <div class="page-breadcrumb d-sm-flex align-items-center mb-3">

    

        <div class="breadcrumb-title pe-3">Factures</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Régénération facture</li>
							</ol>
						</nav>
					</div>

        
			</div>


      <div class="d-flex justify-content-center row row-cols-1 row-cols-lg-2 row-cols-xl-2">
			    

					<div class="col">
						<div class="card radius-10 overflow-hidden">
							<div class="card-body" style="height:300px">
								<div class="d-flex align-items-center">
									<div class="w-100">
										<p class="mb-3 text-left" style="font-size:16px">Ambassadrice
                          <form method="post" id="form_getfacture" action="{{ route('ambassadrice.post_factures') }}">
                                  @csrf
                                  Chosir l'ambassadrice : <select class="mb-3" id="ambassadrice" name="ambassadrice" style="height:40px;border-color:#eee;" required>
                                                              <option value="">choisir</option>
                                                          @foreach($list as $k => $val)
                                                          
                                                            @foreach($val as $m =>$vals)
                                              
                                                          <option value="{{ $m }}">{{ $vals }}</option>
                                                        
                                                      @endforeach
                                                      @endforeach
                                                      
                                                      </select>
                                                      
                                          <select class="form mb-3"  id="datea_from" name="datea_from"  style="height:40px; border-color:#eee;" required>
                                          <option value="">Mois</option>
                                          <option value="1">Janvier</option>
                                          <option value="2">Février</option>
                                          <option value="3">Mars</option>
                                            <option value="4">Avril</option>
                                              <option value="5">Mai</option>
                                            <option value="6">Juin</option>
                                              <option value="7">Juillet</option>
                                            <option value="8">Aout</option>
                                          <option value="9">Septembre</option>
                                        <option value="10">Octobre</option>
                                    <option value="11">Novembre</option>
                                      <option value="12">Décembre</option>
                                
                              </select>

                                
                                
                                  <select class="form mb-3"  id="datea_annee" name="datea_annee"  style="height:40px; border-color:#eee;" required>
                                          <option value="">Annee</option>
                                          <option value="2022">2022</option>
                                          <option value="2023">2023</option>
                                          <option value="2024">2024</option>
                                          <option value="2025">2025</option>
                                          <option value="2026">2026</option>
                                          <option value="2027">2027</option>
                                          
                                </select>

                                <button type="submit" style="width:200px;height:40px;background-color:black;color:white;font-weight:bold;border-radius:5px"  id="ambassadrice_f">Mise à jour </button>

                                  </form>
                              
                           
									
									</div>
								</div>
							</div>
							<div class="" id="chart"></div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 overflow-hidden">
							<div class="card-body"  style="height:300px">
								<div class="d-flex align-items-center">
									<div class="w-100">
										<p class="mb-0 text-left" style="font-size:16px">Partenaire
										</p><div class="mt-3 d-flex align-items-center">
                      <form method="post" id="form_getfactures" action="{{ route('ambassadrice.post_factures') }}">
                            @csrf
                            Chosir le partenaire : <select class="mb-3" id="partenaire" name="partenaire" style="height:40px;border-color:#eee;" >
                                                      <option value="">choisir</option>
                                                      
                                                      @foreach($lists as $ks => $valc)
                                                    
                                                      @foreach($valc as $ms =>$valss)
                                                  <option value="{{ $ms }}">{{ $valss }}</option>
                                                
                                                  @endforeach
                                                      @endforeach
                                                
                                                </select>
                                                
                                    <select class="form mb-3"  id="date_p" name="datep_from"  style="height:40px; border-color:#eee;">
                                    <option value="">Mois</option>
                                    <option value="1">Janvier</option>
                                    <option value="2">Février</option>
                                    <option value="3">Mars</option>
                                      <option value="4">Avril</option>
                                        <option value="5">Mai</option>
                                      <option value="6">Juin</option>
                                        <option value="7">Juillet</option>
                                      <option value="8">Aout</option>
                                    <option value="9">Septembre</option>
                                  <option value="10">Octobre</option>
                              <option value="11">Novembre</option>
                                <option value="12">Décembre</option>
                          
                        </select>

                          
                          
                            <select class="form mb-3"  id="datep_annee" name="datep_annee"  style="height:40px; border-color:#eee;">
                                    <option value="">Annee</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    
                          </select>

                          <button type="submit" style="width:200px;height:40px;background-color:black;color:white;font-weight:bold;border-radius:5px" id="paternaire_f">Mise à jour</button>

                            </form>
									</div>
									
									</div>
								</div>
							</div>
							<div class="" id="chart"></div>
						</div>
					</div>
			  </div>
        </div>
		
			  <div class="row">
			   
			   <div class="row">



      
       
   
  
   
   
     
			   
			   
			   
			   
			   
			   
			   
			   
			  </div><!--end row-->
			  
			  
			 
				
				</div>
			  </div><!--end row-->


			 
		@endsection
		
