@extends("layouts.apps")

		
<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2">

					<div class="breadcrumb-title pe-3">Ambassadrices</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 pe-3">
                                <li class="breadcrumb-item active" aria-current="page">Liste des ambassadrices</li>
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

				

				<!-- <div class="cards_mobile">

				    

				    <div class="d-lg-flex align-items-center mb-4 gap-3">

					@foreach($datas as $resultat)

				    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">

			         <div class="col">

						<div class="card radius-10 overflow-hidden" style="width:320px;margin-left:-2%">

						

							<div class="card-body" style="height:230px">

							   

								<div class="d-flex align-items-center">

									<div>

									    

					

										

										 <p style="color:black;font-weight:300;font-size:22px;">{{ $resultat['name'] }} {{ $resultat['username'] }} </p>

										 

									      <h5 class="mb-0" style="margin-top:10px;font-size:20px;color:black;font-weight:400px;margin-top:20px;"><i class="bx bx-phone" style="color:black;font-size:16px"></i> {{ $resultat['telephone']  }}</h5>

										

										  <p style="margin-left:4%;margin-top:20px"><button type="button" class=" btn-success" style="border-radius:5px;"><a style="color:white" href ="/account/ambassadrice/{{ $resultat->id}}">Statistique ventes</a></button> 

										 <button type="button"  style="border-radius:5px;background-color:red;border:2px solid red"><a style="color:white" href ="/ambassadrice/list/top3/{{ $resultat->id}}">Top 3 produits</a></button>

                                         <button type="button" class="btn-info" style="border-radius:5px;margin-top:10px;"><a style="color:white" href="/ambassadrice/factures/{{ $resultat->id }}">Gérer factures</a></button></p>

									   </div>

									

				

								</div>

							</div>

						

						</div>

					</div>

					</div>

					@endforeach

					</div>

				

				

				

				</div> -->

				

				

				

				

			  

				<div class="card card_table_mobile_responsive">

					<div class="card-body">

						<div class="d-flex justify-content-center w-100 loading"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

						<div class="table-responsive">

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered">

								<thead>

									<tr>

										<th scope="col">Date d'activation</th>

										<th scope="col">Ambassadrice</th>

										<th scope="col">Adresse</th>

										<th scope="col">Statistique(ventes)</th>

										<th scope="col">TOP 3 des produits(vendus)</th>

										<th scope="col">Gérés les factures</th>
									</tr>

								</thead>

								<tbody>

								  @foreach($datas as $resultat)

            

                                <tr>

                                 <td data-label="Date d'activation">{{ \Carbon\Carbon::parse($resultat['date'])->format('d/m/Y H:i:s' )}}</td>

                                <td data-label="Ambassadrice" style="color:#8A2BE2;font-weight:bold;font-size:16px;">{{ $resultat['name'] }} {{ $resultat['username'] }}</td>

                                <td data-label="Adresse">{{ $resultat['addresse'] }}</td>

                               <td data-label="Statistique(ventes)">  
							   		<a class="text-success" href ="{{ route('account.userambassadrice', ['id' =>  $resultat->id]) }}">		
										<button type="button" class="p-1 px-1 btn btn-outline-success">
											Statistique ventes
										</button>
									</a>
							</td>

                               <td data-label="TOP 3 des produits(vendus)">
									<a href ="{{ route('ambassadrice.top3produits', ['id' =>  $resultat->id]) }}">
										<button type="button" class="p-1 px-1 btn btn-outline-danger">
											Lister
										</button>
									</a>
								</td>
								
                             <td data-label="Gérés les factures"> 
							 	<a href="{{ route('ambassadrice.idfacture', ['id' =>  $resultat->id]) }}">	
									<button type="button" class="p-1 px-1 btn btn-outline-info">
										Gérer factures
									</button>
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

	} );

	</script>



	@endsection

	