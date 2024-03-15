@extends("layouts.apps_utilisateurs")



	@section("style")

	<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

	<style>

	 

	</style>

	@endsection



		@section("wrapper")

		<div class="page-wrapper">

			<div class="page-content">

			<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
				<div class="breadcrumb-title pe-3">Paliers live</div>

			</div>

			
		

			  

				

			  

			  

			  <!-- <div class="row">

			    

						<div class="card-body" style="width:100%">

						<h2 style="font-size:24px;border-bottom:2px solid #eee;">   </h2> -->

						
						<div class="card card_table_mobile_responsive">

						<div class="card-body">

							<div class="d-lg-flex align-items-center mb-4 gap-3">

								<div class="position-relative">
								

							

							</div>

						  <div class="ms-auto"> </div>

						</div>

						<div class="table-responsive p-3">

							<table id="example" class="table_mobile_responsive table table-striped table-bordered dataTable no-footer">

								<thead class="table-light">

									<tr>

									    <!-- <th scope="col"></th> -->

									    <th scope="col">Titre panier </th>

										<th scope="col">montant mini</th>

										<th scope="col">montant max</th>

										<th scope="col">Produits liées</th>

										<th scope="col">Catégories liées</th>

					
								

										<!-- <th scope="col">Actions</th> -->


									

									</tr>

								</thead>

								<tbody>

								 @foreach($datas as $values)

									<tr>

										<!-- <td>

											<div class="d-flex align-items-center">

												<div>

													<input class="me-3" type="checkbox" value="" aria-label="...">

												</div>
										</td> -->

										<td data-label="Titre panier">{{ $values['panier_title'] }}</td>	

										

										<td data-label="Montant Mini"> {{ $values['mont_mini']  }} </td>

										<td data-label="Montant Max" style="color:green;font-weight:bold;">{{ $values['mont_max']   }}</td>

										

										  <td data-label="Produits liées">

										    

										    @foreach($values['libelle'] as $vl)

										    

										      {{ $vl }}<br/>,

										    

										    @endforeach

										    

										    </td>

										    

										    <td data-label="Catégories liées">  @foreach($values['libelle_categories'] as $vls)

										    

										      {{ $vls }}<br/>,

										    

										    @endforeach        </td>

										    

										    

										   

						

										<!-- <td ><button  class=" " data-id1="" title="désactiver le compte"></button></td> -->

									   


									</tr>

									

							    @endforeach

								</tbody>

							</table>

							

							<div class="affiche" style="margin-left:70%;margin-top:20px"> </div>           

                             <div id="resultat"></div><!--resultat ajax- access-->

                             <div="pak" style="display:none"></div>

							

							

						</div>

					</div>

				</div>

						    

					

							

							

							

						</div>

					

				

				</div>

		</div>

		@endsection

		

		@section("script")

		<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>


	@endsection