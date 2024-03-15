@extends("layouts.apps")

		
<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2">

					<div class="breadcrumb-title pe-3">Partenaires</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Liste des partenaires</li>
							</ol>
						</nav>
					</div>
					<div class="responsive_button ms-auto d-flex justify-content-end">
						<a href="{{ route('account.users')  }}" class="btn btn-primary radius-5 mt-2 mt-lg-0" >
							<i class="bx bxs-plus-square"></i><span class="responsive_button_text">Ajouter un compte</span>
						</a>
					</div>
				</div>

				<!--end breadcrumb-->

			  

				<div class="card card_table_mobile_responsive">

					<div class="card-body">

						<div class="table-responsive">

							<div class="d-flex justify-content-center w-100 loading"> 
								<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
							</div>

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered dataTable no-footer">

								<thead class="table-light">

									<tr>

										<th scope="col">Date d'activation</th>

										<th scope="col">Partenaire</th>

										<th scope="col">E-mail</th>

										<th scope="col">Téléphone</th>

										<th scope="col">Adresse</th>

										<th scope="col">Statistique(ventes)</th>

										<th scope="col">Gérés les factures</th>

										

									

									</tr>

								</thead>

								<tbody>

								  @foreach($datas as $resultat)

								   <tr>

                                 <td data-label="Date d'activation">{{ \Carbon\Carbon::parse($resultat['date'])->format('d/m/Y H:i:s' )}}</td>

                                <td data-label="Partenaire" style="color:#8A2BE2;font-weight:bold;font-size:16px;">{{ $resultat['name'] }} {{ $resultat['username'] }}</td>

                                 <td data-label="E-mail">{{ $resultat['email']}}  </td>

                                <td data-label="Téléphone">{{ $resultat['telephone']}}</td>

                               <td data-label="Adresse">{{ $resultat['addresse'] }}</td>

              

                               	<td data-label="Statistique(ventes)">  
							   		<a style="color:white" href ="{{ route('account.userambassadrice', ['id' => $resultat->id])}}">
							   			<button type="button" class="p-1 px-1 btn btn-outline-success">Statistique ventes</button>
									</a>
								</td>

                               	<td data-label="Gérés les factures">
									<a style="color:white" href="{{ route('ambassadrice.idfacture', ['id' => $resultat->id])}}">	
										<button type="button" class="p-1 px-1 btn btn-outline-info">Gérer factures</button>
									</a>
								</td>  

                 

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
			});

		</script>

	@endsection
