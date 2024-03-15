@extends("layouts.apps")


	@section("style")
	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	@endsection	
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Programmer des lives</div>
					<div class="ps-3">
						<nav class="flex-wrap justify-content-center align-items-center d-flex" aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Historique des lives</li>
								
							</ol>
							<div>
								@if(file_exists('admin/uploads/'.$user['img_select']))
									<img class="img-profile rounded-circle" src="{{ asset('admin/uploads/'.$user['img_select'] )}}" ;="" height="auto" style="width:42px;height:42px;border-radius:30px;">
								@else 
									<img class="img-profile rounded-circle" src="{{ asset('admin/uploads/default_avatar.png' )}}" ;="" height="auto" style="width:42px;height:42px;border-radius:30px;">
								@endif
								<span style="font-size:12px;margin-left:5px;">{{$user['name'] && $user['username'] ? $user['name']." ".$user['username'] : "" }}</span>
							</div>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->

					
				   <div class="card card_table_mobile_responsive">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
								
					
							</div>
							
							</div>
						  
						</div>
						<div class="table-responsive p-3" style="white-space: inherit !important">

						
							
							<table id="example" class="table_mobile_responsive table table-striped table-bordered" >
								<thead>
									<tr style="font-weight:300">
									    <th class="col-md-2" style="font-size:14px;font-weight:300">Infos Live</th>
										@for($i = 1; $i <= 4; $i++)
											<th class="col-md-2">
												@if(isset($list_panier_montant["panier.$i"]))
													Panier {{ $i }} - <span class="text-success">{{$list_panier_montant["panier.$i"]}}</span>
												@else
													Panier {{ $i }}
												@endif
											</th>
										@endfor
									</tr>
								</thead>
								<tbody>
									@foreach($data as $key => $value)
										<tr>
											<td data-label="Infos Live">{{ $key }}</td>
											@for($i = 1; $i <= 4; $i++)
												<td data-label="Panier {{ $i }}">
													@if(isset($value["panier.$i"]))
														<!-- <ul> -->
															@foreach($value["panier.$i"] as $product)
																<span>{{$product['libelle'] }} </span><br>
															@endforeach
														<!-- </ul> -->
													@else
														Aucun produit
													@endif
												</td>
											@endfor
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
		
		
		  
     
             
		<!-- <div id="paks" style="display:none;width:100%;height:4000px;background-color:black;opacity:0.8;position:absolute;z-index:3;"></div>   -->
		
		<!--end page wrapper -->
		@endsection
		
		
			  @section("script")
			  <script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
			  <script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
		  <script>
			  $(document).ready(function() {
				  $('#example').DataTable();
				} );
		  </script>
		  
		  @endsection
	