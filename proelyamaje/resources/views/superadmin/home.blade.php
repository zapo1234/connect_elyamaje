@extends("layouts.apps")

	@section("style")
	<link href="{{ asset('admin/assets/assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
	<style>
   #montants{margin-left:1%;font-size:20px;font-weight:bold;color:#000}
	</style>

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
										<p class="mb-2 text-white">({{ $mois  }})</p>
										<h5 class="mb-0 text-white">{{ $nombre_code  }} code(s)</h5>
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
										<p class="mb-2 text-white">({{ $mois  }})</p>
										<h5 class="mb-0 text-white">{{ number_format($commission1, 2, ',', '') }} € </h5>
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
										<p class="mb-2 text-white">(Année {{ $annee  }})</p>
										<h5 class="mb-0 text-white">{{ number_format($commission, 2, ',', '') }} € / {{ $nombre_codes   }} ventes</h5>
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
										<p class="mb-2 text-white">(Année {{ $annee  }})</p>
										<h5 class="mb-0 text-white">{{   number_format($commission*100/20, 2, ',', '') }}  €</h5>
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
			  
			  
			  <div class="row">
			    <div class="col-12 col-xl-12 d-flex">
				  <div class="card radius-10 w-100" id="cardp">
						<div class="card-body">
						<h6 class="mb-0 font-weight-bold">Performances Ambassadrices</h6>
						<p class="m-0">Statiques périodiques et mensuelle</p>

							<div class="mb-3 d-flex w-100 justify-content-around align-items-baseline flex-wrap">
									<form class="d-flex align-items-center" method="post" id="form_charjs" action="{{ route('superadmin.home') }}">
										@csrf
									<select id="date_from" name="date_from" class="form-select" aria-label="Default select example" style="height:38px; width:auto;float:left;" required>
								<option value="" selected>De</option>
								<option value="1">Janvier</option>
								<option value="2">Février</option>
								<option value="3">Mars</option>
								<option value="4">Avril</option>
								<option value="5">Mai</option>
								<option value="6">Juin</option>
								<option value="7">Juillet</option>
								<option value="8">Aout</option>
								<option value="9">Septembre</option>
								<option value="10">Octobre</option>
								<option value="11">Novembre</option>
								<option value="12">Décembre</option>
								</select>
									
									
									<select id="date_after" name="date_after" class="form-select" aria-label="Default select example" style="width:auto;float:left;margin-left:2%" required>
								<option value="" selected>A</option>
								<option value="1">Janvier</option>
								<option value="2">Février</option>
								<option value="3">Mars</option>
								<option value="4">Avril</option>
								<option value="5">Mai</option>
								<option value="6">Juin</option>
								<option value="7">Juillet</option>
								<option value="8">Aout</option>
								<option value="9">Septembre</option>
								<option value="10">Octobre</option>
								<option value="11">Novembre</option>
								<option value="12">Décembre</option>
								</select>
								
								
									<select id="date_years" name="date_years" class="form-select" aria-label="Default select example" style="width:auto;float:left;margin-left:2%" required>
								<option value="" selected>Année</option>
								<option value="2022">2022</option>
								<option value="2023">2023</option>
								<option value="2024">2024</option>
								<option value="2025">2025</option>
								<option value="2026">2026</option>
								
								</select>
								
								<button type="button" id="validercharts_1" value="Appliquer" style="margin-left:1%;width:120px;height:38px;border-radius:5px;color:white;border:2px solid black;border-color:black;background-color:black">Rechercher</button><br/>
								
								</form>
						
								<div class="s" style="margin-top:10px;">
								<form  class="d-flex align-items-center" id="form_charj" action="{{ route('superadmin.home') }}" style="display:block;margin-top:3px;">
									@csrf
									<select id="mois_cours" name="mois_cours" class="form-select" aria-label="Default select example" style="width:auto;float:left;" required>
									<option value="" selected>Mois</option>
									<option value="1">Janvier</option>
									<option value="2">Février</option>
									<option value="3">Mars</option>
									<option value="4">Avril</option>
									<option value="5">Mai</option>
									<option value="6">Juin</option>
									<option value="7">Juillet</option>
									<option value="8">Aout</option>
									<option value="9">Septembre</option>
									<option value="10">Octobre</option>
									<option value="11">Novembre</option>
									<option value="12">Décembre</option>
									</select>
									
									<select id="date_yearss" name="date_yearss"  class="form-select" aria-label="Default select example" style="width:auto;float:left;margin-left:2%" required>
									<option value="" selected>Année</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
									<option value="2026">2026</option>
									
									</select>
								
									<button type="button" id="validercharts_2" value="Appliquer" style="margin-left:1%;width:120px;height:38px;border-radius:5px;color:white;border:2px solid black;border-color:black;background-color:black">Rechercher</button>
								</form>
							</div>
                       </div>
							<div id="chart13"></div>
							<div id="montants"></div>
						</div>
					</div>
				</div>
	
			  </div><!--end row-->


			  

			   <div class="row mb-3" style="margin-bottom:25px !important">
					<div class="col-12 col-lg-6">
						<div class="card radius-10 w-100 h-100">
							<div class="card-body h-100">
								<div class="d-flex align-items-center">
									<div>
										<h5 class="mb-1">Nombre de ventes mensuelle en cours</h5>
									</div>
									<div class="font-22 ms-auto">
										<!-- <i class="bx bx-dots-horizontal-rounded"></i> -->
									</div>
								</div>

								<div class="product-list p-3 mb-3" style="height:450px;overflow-y:scroll">
								@foreach($array_list as $resultat)
									<div class="d-flex align-items-center py-3 border-bottom cursor-pointer">
										<div class="product-img me-2">

											@if(file_exists('admin/uploads/'.$resultat['name'].'.jpg'))
												<img class="img-profile" style="border-radius:10px;" src="{{ asset('admin/uploads/'.$resultat['name'].'.jpg' )}}" style="width:45px;height:45px;">
											@else
												<img class="img-profile" style="border-radius:10px;" src="{{ asset('admin/uploads/default_avatar.png') }}" style="width:45px;height:45px;">
											@endif
																				</div>
										<div class="">
											<h6 class="mb-0 font-14">{{ $resultat['name'] }}</h6>
											<p class="mb-0">Ventes</p>
										</div>
										<div class="ms-auto">
											<h6 class="mb-0" style="font-size:18px;color:#0E5AAF;font-weight:800;">{{  $resultat['vente'] }}</h6>
										</div>
									</div>
									
									@endforeach
								</div>
							</div>

						</div>
				 	</div>
					<div class="col-12 col-lg-6 commission_mensuelle_progress">
						<div class="card radius-10 w-100 h-100">
								<div class="card-body h-100">
									<div class="d-flex align-items-center">
											<div>
												<h5 class="mb-1">Commission  mensuel en cours</h5>
											</div>
											<div class="font-22 ms-auto">
												<!-- <i class="bx bx-dots-horizontal-rounded"></i> -->
											</div>
										</div>
									<div class="mt-4" id="chart6"></div>
									<div class="d-flex align-items-center" style="overflow-y:auto;margin-top:-30px">
											<div class="w-100"><br/>
												<table style="width:100%">
												@foreach($montant_cours as $values)
													<tr style="border-bottom:1px solid #eee;">
														<td class="p-1">
															<span  style="font-size:15px;color:black;font-weight:700;text-transform:uppercase">{{ $values['name'] }}  </span> 
														</td>      
														<td class="p-1"> 
															@if(number_format($values['total_montant'], 2, ',', '') > 0)
																<span class="text-success" style="font-size:15px"> {{ number_format($values['total_montant'], 2, ',', '') }}   €</span> 
															@else
																<span class="text-danger" style="font-size:15px"> {{ number_format($values['total_montant'], 2, ',', '') }}   €</span> 
															@endif	
														</td> 
													</tr>
												@endforeach
												
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
			var montants = JSON.parse(data).montant_mois
			var s ='Total: '+montants+ '€';
			chart(montant, res)

			$('#montants').text(s);
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