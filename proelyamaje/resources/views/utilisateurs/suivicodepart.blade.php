
@extends("layouts.apps_utilisateurs")

	

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
								<li class="breadcrumb-item active" aria-current="page">Statistique (taux de transformation)</li>
							</ol>
						</nav>
					</div>

				</div>

				<!--end breadcrumb-->

			  

				<div class="card card_table_mobile_responsive">

				<div style="font-size:15px;margin-top:30px;margin-left:3%"> Export csv Historique menseul pour les  codes élèves <br/></div>
				   <div>
                     <form method="post" id="stat_vente" action="{{ route('utilisateurs.postambacsveleve') }}">
					 @csrf
				     <select  name="ambassadrice"  id="ambassadrice" class="form-select" aria-label="Default select example" style="width:250px;float:left;margin-left:2%" required>
				     <option value="">Chosir le Partenaire </option>
				     @foreach($result_name as $key => $name)  
				     <option value="{{ $key }}"> {{ $name  }} </option>
				     @endforeach
			
                    </select>

                     <select  name="annee"  id="annee" class="form-select" aria-label="Default select example" style="width:250px;float:left;margin-left:2%" required>
				     <option value="">Chosir Année </option>
					 <option selected>Choisir l'année</option>
					 <option value="2022">2022</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                      <option value="2025">2025</option>
                      <option value="2026">2026</option>
				     </select>


				       <button id="class" type="submit" style="margin-left:2%;background-color:black;width:250px;height:40px;color:white;border-radius:5px;border:2px solid black"> Export csv </button>
				      </form>

				     </div>

						<div class="table-responsive p-3">

						<div class="d-flex justify-content-center w-100 loading"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

							<table id="example"  class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center">

								<thead>

									<tr>
                                    <th scope="col">Période</th>
									    <th scope="col">Nom</th>
                                        <th scope="col">Nombre code crée</th>
                                        <th scope="col">code utilisé</th>


										</tr>

								</thead>

								<tbody>
                                    @foreach($result as $val)
                                     <tr>
                                      <td data-label="Nom" style="color:blue">{{ $val['periode'] }}</td>
                                       <td data-label="Status compte">{{ $val['name']  }}</td>
                                        <td data-label="Status compte">{{ $val['nombre']  }}</td>
                                      
                                       <td data-label="Nombre(code crée)">{{ $val['use']  }}</td>

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

	