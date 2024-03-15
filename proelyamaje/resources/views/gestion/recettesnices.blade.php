@extends("layouts.apps")

		
<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2">

					<div class="breadcrumb-title pe-3">Recettes Mensuelles(chiffre depuis le 21 Janvier 2023)</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 pe-3">
                                <li class="breadcrumb-item active" aria-current="page">Suivi de point mensuel</li>
                            </ol>
                        </nav>
                    </div>


				</div>

				
				
                  <div class="card card_table_mobile_responsive">

					<div class="card-body">

						<div class="d-flex justify-content-center w-100 loading"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

						<div class="table-responsive">

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered">

								<thead>
                                    <tr>

										<th scope="col">Date </th>

										<th scope="col">Chriffre </th>
                                
                                    </tr>

								</thead>

								<tbody>

                                @foreach($data as $resultat)
								  <tr>

                                 <td data-label="Période" style="font-size:25px">{{ $resultat['mss'] }}</td>
                                  <td data-label="Chiffre" style="font-size:25px;">{{ $resultat['montant'] }} €</td>
                    
                                </tr>

                               @endforeach

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

	