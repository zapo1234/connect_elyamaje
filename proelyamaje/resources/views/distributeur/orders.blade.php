@extends(
	Auth()->user()->is_admin == 1 ? "layouts.apps" : (Auth()->user()->is_admin == 2 ? 
	"layouts.apps_ambassadrice" : (Auth()->user()->is_admin == 3 ? "layouts.apps_utilisateurs" : "layouts.apps_ambassadrice"))
)

	

	@section("style")

	<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
    <style type="text/css">
      td,th{text-align:center;} td{font-size:20px;}
	  .validetransfert{display:none}
	  #noaffiche{display:none}
    </style>

	@endsection	

		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3">Commandes Distributeurs</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Commande Dolibarr à valider comme commande dans woocomerce !</li>
							</ol>
						</nav>
					</div>
					<div><button type="button" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModals"  class="imports-order" style="width:150px;height:45px;border-radius:5px;color:white;padding:1.5%;background-color:black;border:2px solid black;margin-left:120%">Importer des commandes</button> </div>


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

			  

				<div class="filter_responsive card card_table_mobile_responsive">

				<div class="alert alert-success" role="alert" id="{{$css}}">
                     {{ $message  }}
                   </div>
						<div class="table-responsive p-3">


							<table id="example" class="mt-3 d-none table_mobile_responsive table table-striped table-bordered" style="margin-top: 15px !important;border: 1px solid #dee2e6; width:100%;text-align:center;">

								<thead>

									<tr>

									    <th scope="col">Date de création</th>
                                        <th scope="col">Réf-commmande</th>
                                        <th scope="col">Id-commande</th>
                                        <th scope="col">total_ht</th>
                                        <th scope="col">total_ttc</th>

										<th scope="col">Transfert</th>
                                        <th scope="col">Détails(commande)</th>
										<th scope="col">Status</th>

									 </tr>

								</thead>

								<tbody>

								@foreach($orders as $value)

								  <tr>

								   <td data-label="Date d'achat">Commande enregistrée le <br/>{{ $value['date_create']  }}</td>

								  <td data-label="Id-commande">
								  	<span class="">{{ $value['ref_commande'] }}</span>
								</td>

                                <td data-label="Réf-commande">
								  	<span class="badge bg-dark">{{ $value['order_id'] }}</span>
								</td>


                                  <td data-label="total_ht" style="font-size:18px">{{ $value['total_ht'] }} €</td>

                                    <td data-label="total_ttc" style="font-size:18px"> {{ $value['total_ttc'] }} €</td>

                                   <td data-label="Transfert"> <button type="button"  data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal" class="{{ $value['css'] }}" data-id="{{ $value['order_id']}}"  style="width:150px;height:40px;border-radius:5px;color:white;padding:1.5%;background-color:black;border:2px solid black;">Tranférer la commande</button></td>
                                   <td data-label="Détails(commande)"> <a href ="{{ route('distributeur.ordersiddistributeur', ['id' => $value['order_id']]) }}"><button style="width:150px;height:40px;color:white;cursor:pointer;border-radius:5px;background-color:black;border:2px solid black;color:white;padding: 1.5%;">Détails commande</button></a></td>
                                   <td data-label="Status">{{  $value['user']  }}</td>

                                 </tr>
                               @endforeach
                                   </tbody>

							
                                 </table>

							

                             <div id="resultat"></div><!--resultat ajax- access-->

                             <div="pak" style="display:none"></div>

							

							

						</div>

					</div>

				</div>





			</div>

		</div>

		

        <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true";style="width:20%;height:80px">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        
                                                          <form method="post" id="envoi_orders" action="/distributeur/orders/transfert">
                                                          @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Transférer la commande vers woocomerce</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="button" style="" class="btn btn-dark" id="envoi_order">Envoyer</button>
															<input type="hidden" id="order-id" name="order-id">
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
     


										<div class="modal fade" id="exampleVerticallycenteredModals" tabindex="-1" aria-hidden="true";style="width:20%;height:80px">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        
                                                          <form method="post" id="orders_import" action="">
                                                          @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Mise à jours des commandes dsitributeurs dolibar</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="button" style="" class="btn btn-dark" id="renvoi_order_dol">Import</button>
															<input type="hidden" id="status-order" name="status-order">
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
     

		

		<!--end page wrapper -->

		@endsection

		

  <div id="paks" style="display:none;width:100%;height:4000px;background-color:black;opacity:0.8;position:absolute;z-index:3;"></div>  

		@section("script")

		<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
      	<script src="{{asset('admin/assets/assets/plugins/select2/js/select2.min.js')}}"></script>


	<script>

		$(document).ready(function() {

			$('.buttontransfert').click(function(){
                var id = $(this).data('id');
				$('#order-id').val(id);
            });

           $('#envoi_order').click(function(){
              
			   $('#envoi_orders').submit();

           });

            $('.imports-order').click(function(){
		
             var token ="$2y$10wr3TnLUiPIyY5etJDv8vzBy9mQDdfI75OFVHCKEzKQ.rO";
				 $('#status-order').val(token);
            });


			$('#renvoi_order_dol').click(function(){
              
			  $('#orders_import').submit();

		  });
            
            
            $('#example').DataTable({
				"initComplete": function(settings, json) {
					$(".loading").remove()
					$("#example").removeClass('d-none')
					$('#example').DataTable().columns(8).visible(false);
					$("#example_length select").addClass('filter_length')
					$(".filter_research_invoice").appendTo('.dataTables_length')
					// $(".status_order").appendTo('.dataTables_length')
					$(".type_dropdown").removeClass('d-none')
					$(".status_order").removeClass('d-none')


					$("#example_length select").appendTo('.dataTables_length')
					$(".dataTables_length label").remove()

					$("select").select2({
						width: '180px'
					});
					$(".filter_length").select2({
						width: '80px'
					});
				}
		  	});

			$('.type_dropdown').on('change', function(e){
				var type_user = $('.type_dropdown').val();
				var status_order = $('.status_order').val();
				$('.type_dropdown').val(type_user);
				$('#example').DataTable()
				.column(8).search(type_user)
				.column(5).search(status_order)
				.draw();
         	})

			 $('.status_order').on('change', function(e){
				var status_order = $('.status_order').val();
				var type_user = $('.type_dropdown').val();
				$('.status_order').val(status_order);
				$('#example').DataTable()
				.column(8).search(type_user)
				.column(5).search(status_order)

				.draw();
         	})


		});
     



	</script>


	@endsection

	