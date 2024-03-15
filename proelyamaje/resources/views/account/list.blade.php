@extends("layouts.apps")

	@section("style")
		<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
		<link href="{{asset('admin/assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	@endsection	

		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2" style="margin-top:10px;">

					<div class="breadcrumb-title pe-3">Utilisateurs</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Liste des comptes</li>
							</ol>
						</nav>
					</div>
					<div class="responsive_button ms-auto"><a href="{{ route('account.users')  }}" class="btn btn-primary radius-5 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i><span class="responsive_button_text">Ajouter un compte</span></a></div>

				</div>

				<!--end breadcrumb-->

				<div class="filter_responsive card card_table_mobile_responsive">

					<div class="card-body">
						
						<div class="d-flex justify-content-center w-100 loading"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

						<div class="d-none filter_research_invoice d-flex fact{{ Auth()->user()->is_admin }}" style="color:black">
							<select class="dropdown_filter type_dropdown input_form_type" name="type_user">
								<option value="">Type d'utilisateur</option>
								<option value="Super Admin">Super Admin</option>
								<option value="Ambassadrice">Ambassadrice</option>
								<option value="Partenaire">Partenaire</option>
							</select>

							
						</div>


						<div class="table-responsive">
							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered">

								<thead>

									<tr>

										<!-- <th scope="col"></th> -->

										<th scope="col">Date de création</th>

										<th scope="col">Nom</th>

										<th scope="col">E-mail</th>

										<th scope="col">Téléphone</th>

										<th scope="col">Type de compte</th>

										<th scope="col">Online</th>

										<th scope="col">IBAN / Swift</th>

										<th scope="col">Accès</th>

										<th scope="col">Actions</th>

										<th scope="col">ID</th>


									

									</tr>

								</thead>

								<tbody>

								 @foreach($users as $resultat)

									<tr>
										<!-- <td>
											<div>
												<input class=" me-3" type="checkbox" value="" aria-label="...">
											</div>
										</td> -->
										<td data-label="Date de création">
											{{ \Carbon\Carbon::parse($resultat->created_at)->format('d/m/Y à H:i' )}}</h6>
										</td>

										<td data-label="Nom"> {{ $resultat->name }}  {{ $resultat->username}}</td>

										<td data-label="E-mail">{{ $resultat->email }}</td>

										<td data-label="Téléphone">{{ $resultat->telephone }} </td>

										<td data-label="Status de compte" class="{{ $resultat->attribut }}">{{ $resultat->attribut }}</td>

										<td data-label="Online">
											@if($resultat->acces_account == "en ligne actuelement")
												<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>En ligne actuellement</div>
											@elseif($resultat->acces_account == "compte activé")
												<div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class="bx bxs-circle align-middle me-1"></i>{{ $resultat->acces_account }}</div>
											@else
												<div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class="bx bxs-circle align-middle me-1"></i>{{ $resultat->acces_account }}</div>
											@endif
										</td>

										<td data-label="IBAN / Swift">
											<span>{{ $resultat->iban ?? '' }}</span><br>
											<span>{{ $resultat->swift ?? '' }}</span>
										</td>

										<td data-label="Accès"><button  class="{{ $resultat->actif}} " data-id1="{{ $resultat->id }}" title="désactiver le compte"></button></td>

									   

										<td data-label="Actions">

											<div class="d-flex order-actions">

												<a href="edit/{{ $resultat->id}}/{{ $resultat->remember_token}}" title="Modifier les informations" class=""><i class='bx bxs-edit'></i></a>

												

												 <a class="dropdown-item" title="Suivre l'activité" href="ambassadrice/{{ $resultat->id}}"><span><i class='bx bxs-show'></i></span></a>

												

												

												<span class="list_delete" data-id2="{{ $resultat->id }}"><span class="dropdown-item" href="" class="{{ $resultat->id }}"><i class='bx bxs-trash' style="color:red"></i></span></span>

											</div>

										</td>

										<td data-label="ID">{{ $resultat->id}}</td>

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
			<script src="{{asset('admin/assets/assets/plugins/select2/js/select2.min.js')}}"></script>

			<script>

				$(document).ready(function() {

					$('#example').DataTable({
						"order": [[9, 'desc']],
						"initComplete": function(settings, json) {
							$(".loading").remove()
							$("#example").removeClass('d-none')
							// $('#example').DataTable().columns(8).visible(false);
							$("#example_length select").addClass('filter_length')
							$(".filter_research_invoice").appendTo('.dataTables_length')
							$(".filter_research_invoice").removeClass('d-none')


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
					$('#example').DataTable().column(9).visible(false)

					$('.type_dropdown').on('change', function(e){
						var type_user = $('.type_dropdown').val();
						$('.type_dropdown').val(type_user);
						$('#example').DataTable()
						.column(4).search(type_user)
						.draw();
					})


				} );

			</script>
		@endsection

	