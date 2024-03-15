@extends("layouts.apps")

	@section("style")
	<link href="{{ asset('admin/assets/assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />

	@endsection

		@section("wrapper")
		<div class="page-wrapper">
			<div class="page-content">
			<div class="page-breadcrumb d-sm-flex align-items-center mb-2" style="margin-top:10px;">
				<div class="breadcrumb-title pe-3">Ambassadrices</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Suivi Activité</li>
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
										<h5 class="mb-0 text-white"></h5>
									</div>
									<div class="ms-auto text-white"><i class="fadeIn animated bx bx-user font-30"></i>
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
										<p class="mb-0 text-white">Commission mensuelle cours</p>
										<p class="mb-2 text-white"></p>
										<h5 class="mb-0 text-white"></h5>
									</div>
									<div class="ms-auto text-white"><i class="fadeIn animated bx bx-euro font-30"></i>
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
										<p class="mb-0 text-white">Commission annuelle total versée</p>
										<p class="mb-2 text-white"></p>
										<h5 class="mb-0 text-white"></h5>
									</div>
									<div class="ms-auto text-white"><i class="fadeIn animated bx bx-euro font-30"></i>
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
										<p class="mb-0 text-white">Total chiffre d'affaire Généré</p>
										<p class="mb-2 text-white"></p>
										<h5 class="mb-0 text-white"></h5>
									</div>
									<div class="ms-auto text-white"><i class="fadeIn animated bx bx-euro font-30"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>



			<!-- <h1>Gestion des Ambassadrice</h1> -->
			  <!-- <div class="card_gestion_ambassadrice row row-cols-1 row-cols-lg-2 row-cols-xl-4">
			    <div class="col">
						<div class="card radius-10 overflow-hidden">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="w-100">
										<p class="mb-0 text-left" style="font-size:16px">Nombre code élève crées Ambassadrice 
										<div class="mt-3 d-flex align-items-center">
											<span class="w-100 tt text-center" style="font-size:20px;color:#0E5AAF;font-weight:800;"> {{ $mois  }}</span><br/><br/></p>
											<div class="ms-auto"><i class='bx bx-group font-30'></i></div>
									</div>
									<h5 class="mb-0 text-center" style="margin-top:10px;font-size:24px;color:#000;font-weight:600;margin-top:20px;">{{ $nombre_code  }} code(s)</h5>
									</div>
								</div>
							</div>
							<div class="" id="chart"></div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 overflow-hidden">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="w-100">
										<p class="mb-0 text-left" style="font-size:16px">Commission mensuelle cours Ambassadrice
										<div class="mt-3 d-flex align-items-center">
											<span class="w-100 tt text-center" style="font-size:20px;color:#0E5AAF;font-weight:800;"> {{ $mois  }}</span><br/><br/></p>
											<div class="ms-auto"><i class='bx bx-wallet font-30'></i></div>
									</div>
									<h5 class="mb-0 text-center" style="margin-top:10px;font-size:24px;color:#000;font-weight:600;margin-top:20px;">{{ number_format($commission1, 2, ',', '') }} € </h5>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 overflow-hidden">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="w-100">
										<p class="mb-0 text-left" style="font-size:16px">Commission annuelle total versée
										<div class="mt-3 d-flex align-items-center">
											<span class="w-100 tt text-center" style="font-size:20px;color:#0E5AAF;font-weight:800;">Année {{ $annee  }}</span><br/><br/></p>
											<div class="ms-auto"><i class='bx bx-wallet font-30'></i></div>
									</div>
									<h5 class="mb-0 text-center" style="margin-top:10px;font-size:24px;color:#000;font-weight:600;margin-top:20px;">{{ number_format($commission, 2, ',', '') }} € / {{ $nombre_codes   }} ventes </h5>
									</div>
								</div>
							</div>
							<div class="" id="chart"></div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 overflow-hidden">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="w-100">
										<p class="mb-0 text-left" style="font-size:16px">Total chiffre d'affaire Généré
										<div class="mt-3 d-flex align-items-center">
											<span class="w-100 tt text-center" style="font-size:20px;color:#0E5AAF;font-weight:800;">Année {{ $annee  }}</span><br/><br/></p>
											<div class="ms-auto"><i class='bx bx-wallet font-30'></i></div>
										</div>
										<h5 class="mb-0 text-center" style="margin-top:10px;font-size:24px;color:#000;font-weight:600;margin-top:20px;">{{   number_format($commission*100/20, 2, ',', '') }}  € </h5>
									</div>
								</div>
							</div>
							<div class="" id="chart"></div>
						</div>
					</div>
			  </div> -->
			  <!--end row-->
			
                 <div class="row mb-3" style="margin-bottom:25px !important">
					<div class="col-12 col-lg-6">
						<div class="card radius-10 w-100 h-100">
							<div class="card-body h-100">
								<div class="d-flex align-items-center">
									<div>
										<h5 class="mb-1">TOP 3 des produits les plus vendus</h5>
									</div>
									<div class="font-22 ms-auto">
										<!-- <i class="bx bx-dots-horizontal-rounded"></i> -->
									</div>
								</div>

								<div class="product-list p-3 mb-3" style="height:450px;overflow-y:scroll">
							
									<div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
										<div class="product-img me-2">
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
									
										
										<div class="">
											<h6 class="mb-0 font-14"></h6>
											<p class="mb-0">Ventes</p>
										</div>
										<div class="ms-auto">
											<h6 class="mb-0" style="font-size:18px;color:#0E5AAF;font-weight:800;"></h6>
										</div>
									</div>
									
								
								</div>
							</div>

						</div>
				 	</div>
					<div class="col-12 col-lg-6 commission_mensuelle_progress">
						<div class="card radius-10 w-100 h-100">
								<div class="card-body h-100">
									<div class="d-flex align-items-center">
											<div>
												<h5 class="mb-1">Live programmé Ambassadrice</h5>
											</div>
											<div class="font-22 ms-auto">
												<!-- <i class="bx bx-dots-horizontal-rounded"></i> -->
											</div>
										</div>
									<div class="mt-4" id="chart6"></div>
									<div class="d-flex align-items-center" style="overflow-y:auto;margin-top:-30px">
											<div class="w-100"><br/>
												<table style="width:100%">
												
													<tr style="border-bottom:1px solid #eee;">
														<td class="p-1">
															<span  style="font-size:15px;color:black;font-weight:700;text-transform:uppercase">  </span> 
														</td>      
														<td class="p-1"> 
														
																<span class="text-success" style="font-size:15px"> </span> 
														
																<span class="text-danger" style="font-size:15px"></span> 
															
														</td> 
													</tr>
												
												
												</table>
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



	// var name = <?php echo $array_name; ?>;

	// 	var res = name.split(',');

	// var montant = <?php echo $array_montant; ?>;

	// new Chart(document.getElementById("canvas_ambassadrice"), {
	// type: 'horizontalBar',
	
	// data: {
	// labels: res,
	// scales: {
	// 	xAxes: [{
	// 		barThickness : 100,
	// 	}]
	// },
	// datasets: [
	// 	{
	// 	label: "Commission de ventes généré(en euro)",
	// 	backgroundColor: ["#000","#000","#000","#000","#000","#000","#000","#000","#000","#000"],
	// 	data: montant,
	// 	}
	// ]
	// },
	// options: {
	// legend: { display: false },
	// title: {
	// 	display: true,
	// 	text: 'Performance des Ambassadrices '
	// },
	// responsive: true,
	// }
	// });


	$("#validercharts_1").on("click", function(){
		$.ajax({
		url: "{{ route('superadmin.getChartAmba') }}",
		method: 'GET',
		data: {chart: 'chart_1', date_from: $("#date_from").val(), date_after: $("#date_after").val(), date_years: $("#date_years").val()},
		}).done(function(data) {

			var res =  JSON.parse(data).array_name
			var montant =  JSON.parse(data).array_montant

			chart(montant, res)
		});
	})

	$("#validercharts_2").on("click", function(){
		$.ajax({
		url: "{{ route('superadmin.getChartAmba') }}",
		method: 'GET',
		data: {chart: 'chart_2', date_yearss: $("#date_yearss").val(), mois_cours: $("#mois_cours").val()},
		}).done(function(data) {

			var res =  JSON.parse(data).array_name
			var montant =  JSON.parse(data).array_montant
			chart(montant, res)
		});
	})




	var name = <?php echo $array_name; ?>;
	var res = name.split(',');
	var montant = <?php echo $array_montant; ?>;

	chart(montant, res)

	function chart(montant, res){
		Highcharts.chart('chart13', {
			chart: {
				height: 360,
				type: 'column',
				styledMode: false,
			},
			credits: {
				enabled: false
			},
			title: {
				text: ''
			},
			accessibility: {
				announceNewData: {
					enabled: true
				}
			},
			xAxis: {
				categories: res,
			},
			yAxis: {
				title: {
					text: 'Commission de ventes généré(en euro)'
				}
			},
			legend: {
				enabled: false,
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y:.1f}Є'
					}
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}"><b>{point.y:.2f}Є</b>'
			},
			series: [{
				name: "Commissions",
				colorByPoint: false,
				data: montant
			}],
			
		});
	}
	

	</script>

	@endsection