@extends("layouts.apps")

	

	@section("style")

	<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

	@endsection	

		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2">

					<div class="breadcrumb-title pe-3">Codes</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Gestion d'utilisation des codes élèves</li>
							</ol>
						</nav>
					</div>

				</div>

				<!--end breadcmb-->

			   <div class="card card_table_mobile_responsive">
				<div style="font-size:15px;margin-top:30px;margin-left:3%"><br/><br/></div>
				  <form method="post" id="stat_vente" action="{{ route('gestion.postcsvstats') }}">
					 @csrf
		
                     </form>

						<div class="table-responsive p-3">

						<div class="d-flex justify-content-center w-100 loading"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

							<table id="example"  class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center">

								<thead>

									<tr>
                                       <th scope="col">Code élève</th>
									    <th scope="col">Date de création</th>
										<th scope="col">Client(nom)</th>
										 <th>E_mail(client)</th>
                                         <th scope="col">Date d'utilisation client</th>
										  <th scope="col">status</th>
                                          <th scope="col">Ambassadrice/partenaire</th>


										</tr>

								</thead>

								<tbody>
                                      @foreach($data as $val)
								      <tr>
                                      <td data-label="Code élève" style="">{{ $val['code_promo']  }}</td>
                                         <td data-label="Date création" style="">{{ $val['date_created']  }}</td>
										 <td data-label="Code élève" style="">{{ $val['client']  }}</td>
                                         <td data-label="Date création" style="">{{ $val['email']  }}</td>
                                         <td data-label="Date d'utilisation"> {{ $val['date_utilisation'] }}</td>
                                         <td data-label="Status" style="color:red;font-weight:bold">{{ $val['status'] }}</td>
                                         <td data-label="Ambassadrice/partenaire">{{  $val['nom_ambassadrice']  }}</td>
                                      
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

		

		<!--end page wrapper -->

		@endsection

		

		@section("script")

		<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

	<script>

		$(document).ready(function() {

			$('#example').DataTable({
				"initComplete": function(settings, json) {
					$(".loading").remove()
					$("#example").removeClass('d-none')
				}
			});

		  } );

	</script>

	@endsection

	