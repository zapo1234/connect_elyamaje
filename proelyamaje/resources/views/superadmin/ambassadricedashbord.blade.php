
text/x-generic ambassadricedashbord.blade.php ( HTML document, UTF-8 Unicode text )
@extends("layouts.apps")

	@section("style")
	<link href="{{ asset('admin/assets/assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
	<style>
	#txt {cursor:pointer}
	.live-infos{
  width: 475px; 
  height:255px;
  overflow: hidden;
  position: relative;
  background-color:white;
  transition: 0.3s;
  margin-top:5px;
  padding:2%;
  
}


.live-infos:hover{
	overflow-y: auto;
}
ul.winners{
  position: absolute;
  top: 0;
  width: 100%;
  list-style-type: none;
  padding: 0;
  margin: 0;
  /* overflow-y:scroll; */
}
ul.winners li{
  /*height: 50px;*/
  /* border-bottom: 1px #eee solid; */
  font-size: 1rem;
  color: black;
  /* margin-bottom: 15px; */
}
.mentions{
  display: block;
  margin: 10px 0;
  font-size: 1.2rem;
  
}  
	    
.blue{ color:blue;}
.rouge{color:red;}

.vert{color:#15ca20;}
.actuel {colorl:#000;font-weight:bold;}

#checkdate{display:none;margin-bottom:20px;}
#result{margin-left:6%;margin-top:20px;font-weight:18px;}
	</style>

	@endsection

		@section("wrapper")
		<div class="page-wrapper">
			<div class="page-content">
			<div class="page-breadcrumb d-sm-flex align-items-center mb-2" style="margin-top:10px;">
				<div class="breadcrumb-title pe-3">Dashbord</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Activité</li>
							</ol>
						</nav>
					</div>

            </div>


			<div class="row row-cols-1 row-cols-lg-4">
					<div class="col">
						<div class="card radius-10 overflow-hidden bg-gradient-cosmic">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Nombre code élève crées</p>
										<p class="mb-2 text-white"></p>
										<h5 class="mb-0 text-white">{{ $nombre_eleve }}</h5>
									</div>
									<div class="ms-auto text-white"><i class="fadeIn animated bx bx-user font-30"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card radius-10 overflow-hidden bg-gradient-cosmic">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Nombre de live réalisé<br/>Depuis le 10/05/2023 </p>
										<p class="mb-2 text-white"></p>
										<h5 class="mb-0 text-white">{{ $nombre_live  }}</h5>
									</div>
									<div class="ms-auto text-white">
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="col">
						<div class="card radius-10 overflow-hidden bg-gradient-cosmic">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Produit moyen(commande) </p>
										<p class="mb-2 text-white">KPI Activité ambassadrice</p>
										<h5 class="mb-0 text-white">{{ $kpi_product }} <span class="test" style="font-size:14px">produit/commande</span></h5>
									</div>
									<div class="ms-auto text-white">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 overflow-hidden bg-gradient-cosmic-inverse">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										
										<p class="mb-0 text-white">Total chiffre d'affaire Généré </p>
										<p><span id="annee" style="color:white;font-size:15px"></span></p>
										<p class="mb-2 text-white">
											<form id="checkdate"><select id="date_years" name="date_years" class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                                           <option selected>Choisir l'année</option>
                                           <option value="2022">2022</option>
                                           <option value="2023">2023</option>
                                          <option value="2024">2024</option>
                                           <option value="2025">2025</option>
                                          <option value="2026">2026</option>
                       
                                           </select></form>
										</p>
										<h5 class="mb-0 text-white" id="result">{{ $somme_general }} euros</h5>
									</div>
									<div class="ms-auto text-white" id="txt"> <i class="fadeIn animated bx bx-filter-alt"></i>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>

			
                 <div class="row mb-3" style="margin-bottom:25px !important">
					<div class="col-12 col-lg-6">
						<div class="card radius-10 w-100 h-100">
							<div class="card-body h-100">
								<div class="d-flex align-items-center">
									<div>
										<h5 class="mb-1">TOP 3 des produits les plus vendus</h5>
									</div>
									<div class="font-22 ms-auto">
										<!-- <i class="bx bx-dots-horizontal-rounded."></i> -->
									</div>
								</div>
								<div class="progress-wrapper">
										<div class="d-flex align-items-center">
											<div class="text-secondary">{{ $product1 }}</div>
											<div class="text-success ms-auto pe-4">{{ $product1_somme }}€</div>
										</div>
										<div class="progress mt-2" style="height:3px;">
											<div class="progress-bar" role="progressbar"  style="width: {{$product1_somme == $max_product_somme ? 100 : (100/ $max_product_somme) * ($product1_somme) }}%"></div>
										</div>
									</div>
									<div class="progress-wrapper mt-3">
										<div class="d-flex align-items-center">
											<div class="text-secondary">{{ $product2 }}</div>
											<div class="text-success ms-auto pe-4">{{ $product2_somme }}€</div>
										</div>
										<div class="progress mt-2" style="height:3px;">
											<div class="progress-bar" role="progressbar"  style="width: {{$product2_somme == $max_product_somme ? 100 : (100/ $max_product_somme) * ($product2_somme) }}%"></div>
										</div>
									</div>
									<div class="progress-wrapper mt-3">
										<div class="d-flex align-items-center">
											<div class="text-secondary">{{ $product3 }}</div>
											<div class="text-success ms-auto pe-4">{{ $product3_somme }}€</div>
										</div>
										<div class="progress mt-2" style="height:3px;">
											<div class="progress-bar" role="progressbar" style="width: {{$product3_somme == $max_product_somme ? 100 : (100/ $max_product_somme) * ($product3_somme) }}%"></div>
										</div>
									</div>
								
							</div>

						</div>
				 	</div>
					<div class="col-12 col-lg-6 commission_mensuelle_progress" style="height:400px">
						<div class="card radius-10 w-100 h-100">
								<div class="card-body h-100">
									<div class="d-flex align-items-center">
											<div>
												<h5 class="mb-1">Live programmé Ambassadrice</h5>
											</div>
											<div class="font-22 ms-auto">
												<!-- <i class="bx bx-dots-horizontal-rounded."></i> -->
											</div>
										</div>
									<div class="mt-4" id="chart6"></div>
									<div class="d-flex align-items-center" style="overflow-y:auto;margin-top:-30px">
									<div class="live-infos">
											<ul class="winners">
												@foreach($x_data as $key =>$resultat) 
													@foreach($resultat as $ks =>$values)
														
														@foreach($values as $kl => $val)
															<li class="mb-2" style="border-bottom:3px solid#e9ecef; font-size:15px;color:black;padding-left:-3%"> <span class="dd" style="font-weight:bold;"> {{ $kl }} </span> <span class="{{ $ks }}"> {{  $val  }} </span></li>
														@endforeach
													@endforeach
												@endforeach
											</ul>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>

                    <div class="col-12 col-lg-6 commission_mensuelle_progress" style="margin-left:1%;width:50%;">
						<div class="card radius-10 w-100 h-100">
								<div class="card-body h-100">
									<div class="d-flex align-items-center">
											<div>
												<h5 class="mb-1">Top 3 des cadeaux choisis par Ambassadrice(Live ventes)</h5>
											</div>
											<div class="font-22 ms-auto">
												<!-- <i class="bx bx-dots-horizontal-rounded..."></i> -->
											</div>
										</div>
									<div class="d-flex align-items-center" style="overflow-y:auto;height:630px">
									<div class="live" style="margin-top:850px">
										@foreach($result_top_dons as $val)
										     
                                            <div class="choix" data-id="{{ $val['ambassadrice']}}" style="width:550px;height:30px;color:black;cursor:pointer">{{ $val['ambassadrice']  }} </div>
											<div class="product{{ $val['ambassadrice'] }}" style="border-bottom:1px solid #eee;">
												<div> {{ $val['product1']  }}    <span class="ds" style="color:black;font-weight:bold"> {{ $val['total'] }} ventes</span></div>
										
                                              <div> {{ $val['product2'] }}       <span class="ds" style="color:black;font-weight:bold"> {{ $val['total2'] }}  ventes</span></div>

												<div> {{ $val['product3'] }}     <span class="ds" style="color:black;font-weight:bold"> {{ $val['total3']  }}   ventes</span></div>
									         </div>

										@endforeach
								
										 @foreach($result_top_dons1 as $val)
										     
                                            <div class="choix" data-id="{{ $val['ambassadrice']}}" style="width:550px;height:30px;border-bottom:1px solid #eee;color:black;cursor:pointer">{{ $val['ambassadrice']  }} </div>
											<div id="product{{ $val['ambassadrice'] }}">
												<div> {{ $val['product1']  }}      {{ $val['total'] }} ventes </div>
                                                <div> {{ $val['product2'] }}       {{ $val['total2']  }} ventes </div>

                                               </div>

										@endforeach
                                         
										@foreach($result_top_dons2 as $val)
										     
											 <div class="choix" data-id="{{ $val['ambassadrice']}}" style="width:550px;height:30px;border-bottom:1px solid #eee;color:black;cursor:pointer">{{ $val['ambassadrice']  }} </div>
											 <div id="product{{ $val['ambassadrice'] }}">
												 <div> {{ $val['product1']  }}   {{ $val['total1'] }} vente(s)</div>
			
										     </div>
 
										 @endforeach




										</div>

									  </div>
									</div>
							</div>
						</div>
					</div>

                </div>




		</div>
		@endsection
		
	@section("script")
	
	


	<script src="{{ asset('admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/highcharts/js/highcharts.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/highcharts/js/exporting.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/highcharts/js/variable-pie.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/highcharts/js/export-data.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/highcharts/js/accessibility.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>



	<script>

 $('.choix').click(function(){
   // choix....
    var s = $(this).data('id');
    $('#product'+s).slideToggle();

 });

 $('.choix').hover(function(){
  
	$('choix').css('background-color','#eee');
	$('choix').css('color','white');

 });

 $('#txt').click(function(){
	$('#checkdate').slideToggle();

 });

    $("#date_years").on("change", function(){
           
       $.ajax({
		url: "{{ route('superadmin.getchiffre') }}",
		method: 'GET',
		data: { date_years: $("#date_years").val()},
		}).done(function(data) {
              
			var res =  JSON.parse(data).chiffre
			var years = JSON.parse(data).annee
			$('#annee').text(years);
			$('#checkdate').css('display','none');
			$('#result').text(res);
			
		});
 });


    $(function(){
		var winners_list = $('.winners li');

		if(winners_list.length >= 4){
			var ul_height = $('.winners').outerHeight();
			$('.winners').append(winners_list.clone());

			var i = 0;
			(function displayWinners(i){
				setTimeout(function(){

				if( $('.winners').css('top') < (-1 * ul_height) + 'px'){
					$('.winners').css('top', '0');
				}
				var li_height = $(winners_list[i]).outerHeight();
				$('.winners').animate({
					top: '-=' + li_height + 'px'}, 500);
				if( i == winners_list.length - 1){
					i = 0;
				}else{
					i++;
				}
				displayWinners(i);
				
				}, 4000);
			})(i);
		}
	
  
	});

	</script>

@endsection