@extends("layouts.apps")

@section("style")
	<link href="{{asset('admin/assets/assets/plugins/highcharts/css/highcharts.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" />
    
    <link href="{{asset('admin/assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />
	
	@endsection

		@section("wrapper")
		<div class="page-wrapper">
			<div class="page-content">
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Lister les paniers lives</div>
				</div>
				
			  
			  
			
			    
			  <div class="card card_table_mobile_responsive">

				<div class="card-body">

					<div class="d-lg-flex align-items-center mb-4 gap-3">

						<div class="position-relative">
							
							
							</div>
						  <div class="ms-auto"> </div>
						</div>
						<div class="table-responsive">
						
						
						    
		         @foreach($list as $vc)
		         <form method="post" action="{{ route('ambassadrice.savenewpanier', ['id'=>$vc['id']]) }}">
		          @csrf
                 <input type="text"  class="form-control nom"  name="panier"  required placeholder="Libéllé" value="{{ $vc['panier_title'] }}">
                 <input type="text" class="form-control prenom"  name="montant_mini"   value="{{ $vc['mont_mini'] }}">
                 <input type="text" class="form-control email"  name="montant_max" value="{{  $vc['mont_max']  }}">
                 
                 @endforeach
                 
                 <h2>Produit</h2>
                 <select class="multiple-select" data-placeholder="Choose anything" multiple="multiple" name="data1[]" >
                                 @foreach($data_selected as $vals)
                                 
                                 <option value="{{$vals['id_product']}}%%%dar,{{ $vals['id_variations'] }}v@@@,{{ $vals['label'] }}" {{ $choix }}>{{ $vals['label'] }}</option>
                                 
                                 
                                 @endforeach
                                 
                                 
                                
                                 @foreach($donnes as $vad)
                                 
                                 <option value="{{$vad['ids_product']}}%%%dar,{{ $vad['id_variations'] }}v@@@,{{ $vad['libelle'] }}">{{ $vad['libelle'] }}</option>
                                 
                                 
                                 @endforeach
                            
                                 
                                 
                                 
                                </select>
                
                
                
                
                   <h2>Categoris</h2>
                 <select class="multiple-select" data-placeholder="Choose anything" multiple="multiple" name="data12[]">
                                 @foreach($data_selected_categoris as $valc)
                                 
                                 <option value="{{$valc['rowid']}},{{ $valc['label'] }}" {{ $choix }}>{{ $valc['label'] }}</option>
                                 
                                 
                                 @endforeach
                                 
                                 
                                
                                 @foreach($donnes_array as $van)
                                 
                                 <option value="{{$van['rowid']}},{{ $van['label'] }}">{{ $van['label'] }}</option>
                                 
                                 
                                 @endforeach
                            
                                 
                                 
                                 
                                </select>
                
						    
								<div class="d-flex justify-content-start m-3">
									<button type="submit" id="class" value="" style="width:200px;height:45px;background-color:black;border-radius:5px;border:2px solid black;color:white;">Modifier</button>
								</div>
							
								<div class="affiche" style="margin-top:20px">          
                            
						
						</div>
						
					</form>
					
					
						<div class="table-responsive">
							<table class="table_mobile_responsive table table-striped table-bordered dataTable no-footer">
								<thead class="table-light">
									<tr>
									    <!-- <th></th> -->
									    <th scope="col">Titre panier </th>
										<th scope="col">montant mini</th>
										<th scope="col">montant max</th>
										<th scope="col">Produits liées</th>
										<th scope="col">Actions</th>
									
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
											</div>
										</td> -->
										<td data-label="Titre panier">{{ $values['panier_title'] }}</td>	
										
										<td data-label="Montant Mini"> {{ $values['mont_mini']  }} </td>
										<td data-label="montant max" style="color:green;font-weight:bold;">{{ $values['mont_max']   }}</td>
										<td data-label="Produits liées" style="color:black;font-weight:bold"> 
										
									
										    
										    @foreach($values['libelle'] as $vl)
										    
										     {{ $vl }}<br/>
										    
										    @endforeach
										    
										    
										</td>
						
										<!-- <td><button  class=" " data-id1="" title="désactiver le compte"></button></td> -->
									   
										<td data-label="Actions">
											<div class="d-flex order-actions">
												<a href="/ambassadrice/lister/pannier/{{ $values['id'] }}" title="Modifier les informations" class=""><i class='bx bxs-edit'></i></a>
												
												 <a class="dropdown-item" title="Suivre l'activité" href=""><span class=""><i class='bx bxs-show'></i></span></a>
												
											
											</div>
										</td>
									</tr>
									
							    @endforeach
								</tbody>
					
					
					
					
					
					</div>
				</div>
						    
						</div><!--content1-->
							
							
							
						</div>
					
				
				</div>
		</div>
		@endsection
		
	@section("script")
	
	
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{asset('admin/assets/assets/plugins/select2/js/select2.min.js')}}"></script>
  
	<script type="text/javascript">
    $(document).ready(function() {
        $('select').selectpicker();
    });
    
    
    $('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
		$('.multiple-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
    
    
    
    
    
</script>

	
	@endsection