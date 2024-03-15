@extends("layouts.apps")
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">TOP 3 des produits les plus vendus </div>
					<div class="ms-auto"><a href="{{ route('account.users')  }}" class="btn btn-primary radius-5 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Ajouter un compte</a></div>
				</div>
				<!--end breadcrumb-->
				
				<div class="cards_mobile">
				    <h1 style="font-size:16px">Données prise en compte depuis le 16 septembre 2022</h1>
				    <div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative" style="margin-bottom:35px;font-size:20px;color:black">
							<i class="bx bxs-user"></i> {{ $name }}
							
							</div>
				    
				    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
			         <div class="col">
						<div class="card radius-10 overflow-hidden" style="width:320px;margin-left:-2%">
						
							<div class="card-body" style="height:230px">
							   
								<div class="d-flex align-items-center">
									<div>
									    
									    <p class="mb-0" style="font-size:16px">
										
										 <p> <span class="tt" style="padding-top:20px;font-size:14px;color:#0E5AAF;font-weight:400;"> Top 3 des produits vendus (lives)   </p>
										 
									      <h5 class="mb-0" style="margin-top:10px;font-size:14px;color:#000;font-weight:500;margin-top:20px;">{{ $top_live1  }}</h5>
										
											<h5 class="mb-0" style="margin-top:10px;font-size:14px;color:#000;font-weight:500;margin-top:20px;">{{ $top_live2  }}</h5>
											
											<h5 class="mb-0" style="margin-top:10px;font-size:14px;color:#000;font-weight:500;margin-top:20px;">{{ $top_live3 }}</h5>
									    
									   </div>
									
				
								</div>
							</div>
						
						</div>
					</div>
					</div>
					
					</div>
					
					
					 <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
			         <div class="col">
						<div class="card radius-10 overflow-hidden" style="width:320px;margin-left:-2%">
							
							 
							<div class="card-body" style="height:230px">
							   
								<div class="d-flex align-items-center">
									<div>
									    
									    <p class="mb-0" style="font-size:16px">
										
										 <p> <span class="tt" style="padding-top:20px;font-size:14px;color:#0E5AAF;font-weight:400;">Top 3 des produits vendus (code élève)  </p>
										 
								        	<h5 class="mb-0" style="margin-top:10px;font-size:14px;color:#000;font-weight:500;margin-top:20px;">{{ $top_promo1  }}</h5>
										
											<h5 class="mb-0" style="margin-top:10px;font-size:14px;color:#000;font-weight:500;margin-top:20px;">{{ $top_promo2  }}</h5>
											
											<h5 class="mb-0" style="margin-top:10px;font-size:14px;color:#000;font-weight:500;margin-top:20px;">{{ $top_promo3 }}</h5>
									
									
									   </div>
									
				
								</div>
							</div>
						
						</div>
					</div>
					</div>
					
					
					
					
					</div>
				
				
			  
				<div class="card" id="account_body">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
							<i class="bx bxs-user"></i> {{ $name }}
							
							</div>
						  
						</div>
						<div class="table-responsive">
						    
						    <div>Top3 des produits lives </div>
						    
							<table class="table mb-0">
								<thead class="table-light">
									<tr>
										<th>Produit 1</th>
										<th>Produit 2</th>
										<th>Produit 3</th>
									
									</tr>
								</thead>
								<tbody>
						         <tr>
						            <td>{{ $top_live1 }}</td> 
						            <td>{{ $top_live2  }}</td>
						            <td>{{  $top_live3 }}</td>
						             
						         </tr>
								 
								 
								</tbody>
							</table>
							
							<div style="margin-top:40px">Top3 des produits code élèves </div>
							
							<table class="table mb-0">
								<thead class="table-light">
									<tr>
										<th>Produit 1</th>
										<th>Produit 2</th>
										<th>Produit 3</th>
									
									</tr>
								</thead>
								<tbody>
						         <tr>
						            <td>{{ $top_promo1}}</td> 
						            <td> {{ $top_promo2 }}</td>
						            <td> {{ $top_promo3 }}</td>
						         </tr>
								 
								 
								</tbody>
							</table>
							
							<div class="affiche" style="margin-left:70%;margin-top:20px">   </div>           
                             <div id="resultat"></div><!--resultat ajax- access-->
                             <div="pak" style="display:none"></div>
							
							
						</div>
					</div>
				</div>


			</div>
		</div>
		<!--end page wrapper -->
		@endsection
	