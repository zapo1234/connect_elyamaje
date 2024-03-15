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

					<div class="breadcrumb-title pe-3">Codes promos</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Statistique (taux conversion)</li>
							</ol>
						</nav>
					</div>

				</div>

				<!--end breadcrumb-->

		            <div class="card card_table_mobile_responsive">

		

						<div class="table-responsive p-3">

						<div class="d-flex justify-content-center w-100 loading"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

							<table id="example"  class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center">

								<thead>

									<tr>

									    <th scope="col">Nom</th>
                                         <th scope="col">Status compte</th>

										<th scope="col">Code crée</th>

										<th scope="col">code utilisé</th>

										<th scope="col">conversion</th>

										</tr>

								</thead>

								<tbody>

								     @for($i=0; $i< count($array_list2); $i++)

								     

								     <tr>

								     <td data-label="Nom" style="color:blue">{{ $array_list2[$i][0] }}</td>

							           <td data-label="Status compte">{{ $array_list2[$i][3] }}</td>

								        <td data-label="Nombre(code crée)">{{ $array_list2[$i][4] }}</td>

								         <td data-label="Nombre(code commission généré)">{{ $array_list2[$i][5] }}</td>

								         <td data-label="Taux(conversion élève)">{{ number_format($array_list2[$i][5]*100/$array_list2[$i][4], 0, ',', '') }} %</td> 

								     </tr>

								     @endfor

								   

								   

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

	