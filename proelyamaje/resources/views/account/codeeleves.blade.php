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
								<li class="breadcrumb-item active" aria-current="page">Liste des codes spécifiques</li>
							</ol>
						</nav>
					</div>
					
					<div class="responsive_button ms-auto d-flex justify-content-end">
						<a href="{{ route('account.codespeciale')  }}" class="btn btn-primary radius-5 mt-2 mt-lg-0" >
							<i class="bx bxs-plus-square"></i><span class="responsive_button_text">Crée un code</span>
						</a>
					</div>


				</div>

				<!--end breadcrumb-->

			  

				<div class="card card_table_mobile_responsive">

						<div class="table-responsive p-3">

							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>


						<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="border-top: 1px solid #dee2e6; border-left: 1px solid #dee2e6;border-bottom: 1px solid #dee2e6;width:100%;text-align:center;">

								<thead>

									<tr>

									    <!-- <th scope="col"></th> -->

										<th scope="col">Date(création)</th>

										<th scope="col">Nom</th>

										<th scope="col">Email(élève)</th>

										<th scope="col">Status</th>

										<th scope="col">Code</th>

										<th scope="col">Commission</th>

										<th scope="col">Réduction(gains)</th>

									</tr>

								</thead>

								<tbody>

								    @foreach($users as $resultat)

                                    <tr>

										<!-- <td><input type="checkbox" value="{{ $resultat->id }}"></td> -->

										<td data-label="Date(création)" scope="row">{{ \Carbon\Carbon::parse($resultat->created_at)->format('d/m/Y')}}</td>

										<td data-label="Nom">{{ $resultat->nom }}</td>

										<td data-label="Email(élève)">{{ $resultat->email }}</td>

										<td data-label="Status" class="{{ $resultat->status  }}">{{ ucfirst($resultat->status) }}</td>

										<td data-label="Code" >{{ $resultat->code_promos }}</td>

										<td data-label="Commission">{{ $resultat->commission }}</td>

										<td data-label="Réduction(gains)">{{ $resultat->pourcentage }}</td>

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

	