@extends("layouts.apps_ambassadrice")



		@section("wrapper")

		<div class="page-wrapper">

			<div class="page-content">
			<div class="activity_live">
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div style="font-size: 25px" class="mb-3 breadcrumb-title pe-3">Statistiques</div>
				</div>
			

			<!-- <h1> Statistique   </h1> -->

				<h2 style="font-size:18px">Données prise en compte depuis le 16 septembre 2022</h2>


				<div class="row row-cols-1 row-cols-lg-3">
					<div class="col">
						<div class="card radius-10">
							<div class="card-body p-4">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Panier Moyen/ventes code élève</p>
										<h4 class="font-weight-bold">{{ $panier_montant_code }}  €</h4>
										<!-- <p class="text-success mb-0 font-13">Analytics for last week</p> -->
									</div>
									<div class="widgets-icons bg-gradient-cosmic text-white"><i class="fadeIn animated bx bx-euro font-30"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body p-4">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Panier Moyen /ventes lives</p>
										<h4 class="font-weight-bold">{{   $panier_montant_live }}  €</h4>
										<!-- <p class="text-success mb-0 font-13">Analytics for last week</p> -->
									</div>
									<div class="widgets-icons bg-gradient-cosmic text-white"><i class="fadeIn animated bx bx-euro font-30"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card radius-10">
							<div class="card-body p-4">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Taux de conversion(code élève)</p>
										<h4 class="font-weight-bold">{{   $taux }}  %</h4>
										<!-- <p class="text-success mb-0 font-13">Analytics for last week</p> -->
									</div>
									<div class="widgets-icons bg-gradient-cosmic text-white  font-30">%
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
	
			      

			    
		<div class="row">
			<div class="col-12 col-xl-6 d-flex">
					<div class="card radius-10 w-100 ">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h5 class="mb-1">Produits les plus achetés</h5>
									<span style="color: rgba(255, 154, 178, 1);font-weight: 600;">CODE LIVE</span>
								</div>
							</div>
						</div>

						<div class="p-2">

							@foreach($list_data_live as $vc)
								<div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
									<div style="min-width:40px" class="bg-light-primary product-img me-2">
										<i style="color: #ff6270fc" class="bx bxs-shopping-bag font-20"></i>
									</div>
									<div class="">
										<h6 class="mb-0 font-13">{{ $vc['name'] }}</h6>
										<p class="mb-0">{{ $vc['quantity'] }} vendu</p>
									</div>
									<div class="ms-auto">
										<h6 style="min-width:90px" class="text-end mb-0">{{ $vc['price'] }} €</h6>
									</div>
								</div>
							@endforeach
												
						</div>
					</div>
					
				 </div>


				 <div class="col-12 col-xl-6 d-flex">
					<div class="card radius-10 w-100 ">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h5 class="mb-1"> Produits les plus achetés.</h5>
									<span style="color: rgba(255, 154, 178, 1);font-weight: 600;">CODE ÉLÈVES</span>
								</div>

							</div>
						</div>

						<div class="p-2">

							@foreach($list_code_promo as $vb)
								<div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
									<div style="min-width:40px" class="bg-light-primary product-img me-2">
										<i style="color: #ff6270fc" class="bx bxs-shopping-bag font-20"></i>
									</div>
									<div class="">
										<h6 class="mb-0 font-13">{{ $vb['name'] }}</h6>
										<p class="mb-0">{{ $vb['quantity'] }} vendu</p>
									</div>
									<div class="ms-auto">
										<h6 style="min-width:90px" class="text-end mb-0">{{ $vb['price'] }} €</h6>
									</div>
								</div>
							@endforeach
							 
							</div>					
						</div>
					
				 </div>
			</div>


				 
			    </div>

		</div>

		@endsection
