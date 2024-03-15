@extends(
	Auth()->user()->is_admin == 1 ? "layouts.apps" : (Auth()->user()->is_admin == 2 ? 
	"layouts.apps_ambassadrice" : (Auth()->user()->is_admin == 3 ? "layouts.apps_utilisateurs" : "layouts.apps_ambassadrice"))
)

	
	@section("style")

	<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
  

	@endsection	

		@section("wrapper")

		<!--start page wrapper -->

			<div class="page-wrapper">
				<div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-sm-flex align-items-center mb-3 justify-content-between">
                        <div class="breadcrumb-title pe-3">Commande Dolibarr  <span style="color:black;font-size:18px;font-weight:bold">N° {{ $id }} </span></div>

						@if (\Session::has('success'))
							
						@endif
						@if (\Session::has('error'))
							<!-- <div class="col-md-6 alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
								<div class="d-flex align-items-center">
									<div class="font-35 text-danger"><i class="bx bxs-check-circle"></i>
									</div>
									<div class="ms-3">
										<h6 class="mb-0 text-danger">Erreur</h6>
										<div>{!! \Session::get('error') !!}</div>
									</div>
								</div>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
							<div class="col-md-1"></div> -->
						@endif
                    </div>
                    <!--end breadcrumb-->

                    <div class="row row-cols-1 row-cols-lg-1">
                        <div class="col flex-column d-flex col-lg-4">
                                    <div class="card h-100 radius-10">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center h-100">
                                            <div class="d-flex flex-column align-items-center text-center">
                                            <img class="rounded-circle p-1 bg-primary" src="{{ asset('admin/uploads/default_avatar.png' )}}" ;="" style="width:110px;height:110px">
                                                <div class="mt-3">
                                                    <h4>{{ $user_info['nom'] ?? ''}}</h4>
                                                    <p class="text-secondary mb-1">Distributeur Elyamaje</p>
                                                    <p class="text-muted font-size-sm">{{ $user_info['adresse'] ?? ''}}</p>
                                                </div>
                                            </div>
                                            <hr class="my-4 w-100"> 

                                            <ul class="list-group list-group-flush w-100">
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0"><svg  style="margin-right:15px" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8833ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail text-primary"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>Email</h6>
                                                    <span class="text-secondary">{{ $user_info['email'] ?? 'Non renseigné'}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0"><svg style="margin-right:15px" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8833ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone text-primary"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>Téléphone</h6>
                                                    <span class="text-secondary">{{  $user_info['phone'] ?? 'Non renseigné'}}</span>
                                                </li>
                                            </ul>
											
                                            
												
											 
                                        </div>
                                    </div>
                                </div>


                                <div class="col d-flex col-lg-8">
                                    <div class="card card_table_mobile_responsive radius-10 w-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h5 class="mb-4">Détails des produits <span class="text-success total_amount"></span></h5>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-center">
                                                <div class="spinner-border loading_products" role="status"> 
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
               
                                            <div class="d-none table-responsive">
                                                
                                                <table id="example" class="table_mobile_responsive table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                            <tr>
                                                            <th scope="col">Produit</th>
                                                                <th scope="col">Quantitée</th>
                                                                <th scope="col">P.U (HT)</th>
                                                                <th scope="col">Total (HT)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($user_order as $value)
                                                            <tr>

                                                                <td data-label="Produit"> {{ $value['libelle'] }}</td>
                                                                <td data-label="Quantitée">
                                                                <span >{{ $value['quantite'] }}</span>
                                                            </td>
                                                                <td data-label="P.U (HT)">{{ $value['subprice'] }} €</td>
                                                                <td data-label="Total (HT)">{{ $value['total_ht'] }} €</td>
                                                            </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                   
                       
                        </div>
                    </div>
                </div>
			</div>


	@section("script")

    <script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

	<script>
        $(document).ready(function() {
			$('#example').DataTable({
                scrollY: '59vh',
                scrollCollapse: true,
                pageLength: 25,
                "initComplete": function(settings, json) {
                    $("#example_wrapper .row:last-child").css('margin-top', '5px')
                    $(".loading_products").addClass('d-none')
                    $(".table-responsive").removeClass('d-none')
                    $(".dataTables_scrollHeadInner").css('width', '100%')

                }
            })
        })
	</script>

	@endsection
		
	