@extends("layouts.apps")


	@section("style")
	<link href="{{ asset('admin/assets/assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
	<style>
	.live-infos{
  /* width: 305px; */
  height:128px;
  overflow: hidden;
  position: relative;
  background-color:white;
  transition: 0.3s;
  
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
	</style>
	
	@endsection

		@section("wrapper")
		<div class="page-wrapper">
			<div class="page-content dashboard_activity">

			<div class="page-breadcrumb d-sm-flex align-items-center mb-2" style="margin-top:10px;">
                <div class="breadcrumb-title pe-3">Dashboard</div>
				 <div>ZAPO.......</div>
            </div>


			<div class="row row-cols-1 row-cols-lg-3 dashboard_global">
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="revenue-by-channel">
									<h6 class="mb-4 font-weight-bold">Nouveaux clients Elyamaje</h6>
									<div class="progress-wrapper">
										<div class="d-flex align-items-center">
											<div class="text-secondary">Marseille</div>
											<div class="ms-auto pe-4 font-18" style="font-weight: bold">{{  $nombre_marseille  }}</div>
											<div style="min-width:90px" class="{{  $nombre_marseille < $nombre_last_marseille ? 'text-danger' : 'text-success'  }}">{{  $nombre_marseille < $nombre_last_marseille ? "-" : "+"  }} 
											{{  $percent_marseille }}%</div>
										</div>
										<div class="progress mt-2" style="height:3px;">
											<div class="progress-bar" role="progressbar" style="width: {{$nombre_marseille == $max_new_customer ? 100 : (100/ $max_new_customer) * ($nombre_marseille) }}%"></div>
										</div>
									</div>
									<div class="progress-wrapper mt-2">
										<div class="d-flex align-items-center">
											<div class="text-secondary">Nice</div>
											<div class="ms-auto pe-4 font-18" style="font-weight: bold">{{  $nombre_nice  }}</div>
											<div style="min-width:90px" class="{{  $nombre_nice < $nombre_last_nice ? 'text-danger' : 'text-success'  }}">{{  $nombre_nice < $nombre_last_nice ? "-" : "+"  }} 
											{{  $percent_nice  }}%</div>
										</div>
										<div class="progress mt-2" style="height:3px;">
											<div class="progress-bar" role="progressbar"style="width: {{$nombre_nice == $max_new_customer ? 100 : (100/ $max_new_customer) * ($nombre_nice) }}%"></div>
										</div>
									</div>
									<div class="progress-wrapper mt-2">
										<div class="d-flex align-items-center">
											<div class="text-secondary">Internet</div>
											<div class="ms-auto pe-4 font-18" style="font-weight: bold">{{  $nombre_internet  }}</div>
											<div style="min-width:90px" class="{{  $nombre_internet < $nombre_last_internet ? 'text-danger' : 'text-success'  }}">{{  $nombre_internet < $nombre_last_internet ? "-" : "+"  }}
											{{  $percent_internet }}%</div>
										</div>
										<div class="progress mt-2" style="height:3px;">
											<div class="progress-bar" role="progressbar" style="width: {{$nombre_internet == $max_new_customer ? 100 : (100/ $max_new_customer) * ($nombre_internet) }}%"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
									  
										<p class="mb-0">Commandes status en cours</p>
										<h4 class="font-weight-bold">{{ $nombre_count_orders }} <small class="text-success font-13"></small></h4>
										<p class="text-secondary mb-0 font-13">{{ $date_cours }}</p>
									</div>
									<div class="widgets-icons bg-gradient-burning text-white"><i class="bx bx-refresh"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Nombre total de clients recupérés</p>
										<h4 class="font-weight-bold">{{ $nombre_customs  }}<small class="text-danger font-13"></small></h4>
										<p class="text-secondary mb-0 font-13">{{ $date_cours }}</p>
									</div>
									<div style="min-width:50px" class="widgets-icons bg-gradient-kyoto  text-white"><i class="bx bx-file"></i>
									<a style="color: #525f7f;position:absolute; bottom:15px; left:45%;font-size:14px" class="100 show_more_dashboard" href="{{ route('gestion.usercustomer') }}">
											<span>Statistique +</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

				     <div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
	
										<p class="mb-0">Recette Internet journalière (TOTAL HT)</p>
										<h4 class="font-weight-bold">{{ $somme_recette_internet}} €</h4>
										<a style="color: #525f7f;position:absolute; bottom:15px; left:45%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.internetrecette')}}">
											<span>Voir +  </span>
										</a>

										<a style="color: #525f7f;position:absolute; bottom:15px; left:55%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.recettesinternets')}}">
											<span></span>
										</a>

										<p class="text-secondary mb-0 font-13">{{ $date_cours }}</p>
									</div>
									<div class="widgets-icons bg-gradient-burning text-white"><i class="lni lni-display"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
								
										<p class="mb-0">Recette Marseille journalière (TOTAL HT)</p>
										<h4 class="font-weight-bold">{{ $somme_recette_marseille }} €<small class="text-danger font-13"></small></h4>
										<a style="color: #525f7f;position:absolute; bottom:15px; left:45%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.marseillerecette')}}">
											<span>Voir +  </span>
										</a>

										<a style="color: #525f7f;position:absolute; bottom:15px; left:55%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.recettesmarseilles')}}">
											<span></span>
										</a>

										<p class="text-secondary mb-0 font-13">{{ $date_cours }}</p>
									</div>
									<div class="widgets-icons bg-gradient-moonlit text-white">M
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Recette Nice journalière (TOTAL HT)</p>
										<h4 class="font-weight-bold">{{ $somme_recette }} € <small class="text-success font-13"></small></h4>
										<a style="color: #525f7f;position:absolute; bottom:15px; left:45%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.nicerecette')}}">
											<span>Voir +  </span>
										</a>

										<a style="color: #525f7f;position:absolute; bottom:15px; left:55%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.nicerecette')}}">
											<span> </span>
										</a>

										<p class="text-secondary mb-0 font-13">{{ $date_cours }}</p>
									</div>
									<div class="widgets-icons bg-gradient-lush text-white">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Recette Nice mensuelle (TOTAL HT)</p>
										<a style="color: #525f7f;position:absolute; bottom:15px; left:45%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.recettesnice')}}">
											<span>Voir +  </span>
										</a>
										<h4 class="font-weight-bold">{{ $somme_recettes }} € <small class="text-success font-13"></small></h4>
										<p class="text-secondary mb-0 font-13">{{ $date_courss }}</p>
									</div>
									<div class="widgets-icons bg-gradient-lush text-white">
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Recette Marseille Mensuelle (TOTAL HT)</p>
										<h4 class="font-weight-bold">{{ $somme_recette_marseilles  }}<small class="text-success font-13"></small></h4>
										<a style="color: #525f7f;position:absolute; bottom:15px; left:45%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.recettesmarseilles')  }}">
											<span>Voir +</span>
										</a>

										<a style="color: #525f7f;position:absolute; bottom:15px; left:55%;font-weight:bold" class="100 show_more_dashboard" href="">
											<span> </span>
										</a>

										<p class="text-secondary mb-0 font-13">{{ $date_cours }}</p>
									</div>
									<div class="widgets-icons bg-gradient-lush text-white">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Recette Inernet Mensuelle (TOTAL HT)</p>
										<a style="color: #525f7f;position:absolute; bottom:15px; left:45%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.recettesinternets') }}">
											<span>Voir +</span>
										</a>
										<h4 class="font-weight-bold">{{  $somme_recette_internets  }}<small class="text-success font-13"></small></h4>
										<p class="text-secondary mb-0 font-13">{{ $date_courss }}</p>
									</div>
									<div class="widgets-icons bg-gradient-lush text-white">
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Activité Ambassadrice & Partenaire <br/> Recette Mensuelle généré (TOTAL HT)</p>
										<a style="color: #525f7f;position:absolute; bottom:15px; left:45%;font-weight:bold" class="100 show_more_dashboard" href="{{ route('gestion.recettesinternets') }}">
											<span>Voir +</span>
										</a>
										<h4 class="font-weight-bold">{{  $montant_activite }}  €<small class="text-success font-13"></small></h4>
										<p class="text-secondary mb-0 font-13">{{ $date_courss }}</p>
									</div>
									<div class="widgets-icons bg-gradient-lush text-white">
									</div>
								</div>
							</div>
						</div>
					</div>

           
			  <div class=" w-100">
			    <div class="col-12 col-xl-12 d-flex">
				  <div class="card radius-10 w-100" id="cardp">
						<div class="card-body">

						<div class="d-flex align-items-center">
								<div>
									<h6 class="title_chart6 mb-0">Fréquences de nouveaux clients {{ $mois }}/{{ $annee }}</h6>
								</div>
								<div class="dropdown ms-auto">
									<select id="select_date_newcustomer"> 
										<option value="month_{{ $mois }}">Ce mois</option>
										<option value="year_{{ $annee }}">Cette année</option>
									</select>
								</div>
							</div>

						<!-- <h2 style="font-size:32px;border-bottom:2px solid #eee;">Fréquences de nouveaux clients {{ $mois }}/{{ $annee }}</h2> -->
						<!-- <p class="m-0" style="">Statistique périodiques et mensuelle</p> -->
						<!-- <form method="post" id="form_charjs" action="#" style="width:95%">
						     @csrf
						<select id="date_from" name="date_from" class="form-select" aria-label="Default select example" style="width:200px;float:left;" required>
                       <option selected>Date From</option>
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
						
						
					  	<select id="date_after" name="date_after" class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                       <option selected>Date From</option>
                       <option value="01">Janvier</option>
                       <option value="02">Février</option>
                       <option value="03">Mars</option>
                       <option value="04">Avril</option>
                       <option value="05">Mai</option>
                       <option value="06">Juin</option>
                       <option value="07">Juillet</option>
                       <option value="08">Aout</option>
                       <option value="09">Septembre</option>
                       <option value="10">Octobre</option>
                       <option value="11">Novembre</option>
                       <option value="12">Décembre</option>
                       </select>
                       
                       
                       	<select id="date_years" name="date_years" class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                       <option selected>Choisir l'année</option>
                       <option value="2022">2022</option>
                       <option value="2023">2023</option>
                       <option value="2024">2024</option>
                       <option value="2025">2025</option>
                       <option value="2026">2026</option>
                       
                       </select>
                       
                       <button type="button" id="validerchart" value="Appliquer" style="margin-left:1%;width:120px;height:40px;border-radius:5px;color:white;border:2px solid #0E5AAF;border-color:#0E5AAF;background-color:#0E5AAF">Rechercher</button><br/>
                       
                       </form><br/>
                       
                       <div class="s" style="margin-top:10px;">
                       <form  id="form_charj" action="{{ route('gestion.home') }}" style="display:block;margin-top:3px;">
                        @csrf
                       <select id="mois_cours" name="mois_cours" class="form-select" aria-label="Default select example" style="width:200px;float:left;" required>
                       <option selected>Date From</option>
                       <option value="01">Janvier</option>
                       <option value="02">Février</option>
                       <option value="03">Mars</option>
                       <option value="04">Avril</option>
                       <option value="05">Mai</option>
                       <option value="°6">Juin</option>
                       <option value="07">Juillet</option>
                       <option value="08">Aout</option>
                       <option value="09">Septembre</option>
                       <option value="10">Octobre</option>
                       <option value="11">Novembre</option>
                       <option value="12">Décembre</option>
                       </select>
                       
                       <select id="date_yearss" name="date_yearss"  class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                       <option selected>Choisir l'année</option>
                       <option value="2022">2022</option>
                       <option value="2023">2023</option>
                       <option value="2024">2024</option>
                       <option value="2025">2025</option>
                       <option value="2026">2026</option>
                       
                       </select>
                       
                       <button type="button" id="validercharts" value="Appliquer" style="margin-left:1%;width:120px;height:40px;border-radius:5px;color:white;border:2px solid #0E5AAF;border-color:#0E5AAF;background-color:#0E5AAF">Rechercher</button>
                       
                       </form> -->
                       </div>
					   		<div id="chart6"></div>
							<!-- <canvas id="canvas_ambassadrice" height="250" width="800"></canvas>
                            <canvas id="select_ambassadrice" height="400" width="800"></canvas> -->
							
						</div>
					</div>
				</div>
				
				     
				
				<div class=" w-100">
			    <div class="col-12 col-xl-12 d-flex">
				  <div class="card radius-10 w-100" id="cardp">
						<div class="card-body">

						<div class="d-flex align-items-center">
								<div>
									<h6 class="title_chart6 mb-0">Chiffre d'affaire réalisée</h6>
								</div>
								<div class="dropdown ms-auto">
									<select id="select_date_newcustomer"> 
										<option value="month_{{ $mois }}">Ce mois</option>
										<option value="year_{{ $annee }}">Cette année</option>
									</select>
								</div>
							</div>

						<!-- <h2 style="font-size:32px;border-bottom:2px solid #eee;">Fréquences de nouveaux clients {{ $mois }}/{{ $annee }}</h2> -->
						<!-- <p class="m-0" style="">Statistique périodiques et mensuelle</p> -->
						<!-- <form method="post" id="form_charjs" action="#" style="width:95%">
						     @csrf
						<select id="date_from" name="date_from" class="form-select" aria-label="Default select example" style="width:200px;float:left;" required>
                       <option selected>Date From</option>
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
						
						
					  	<select id="date_after" name="date_after" class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                       <option selected>Date From</option>
                       <option value="01">Janvier</option>
                       <option value="02">Février</option>
                       <option value="03">Mars</option>
                       <option value="04">Avril</option>
                       <option value="05">Mai</option>
                       <option value="06">Juin</option>
                       <option value="07">Juillet</option>
                       <option value="08">Aout</option>
                       <option value="09">Septembre</option>
                       <option value="10">Octobre</option>
                       <option value="11">Novembre</option>
                       <option value="12">Décembre</option>
                       </select>
                       
                       
                       	<select id="date_years" name="date_years" class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                       <option selected>Choisir l'année</option>
                       <option value="2022">2022</option>
                       <option value="2023">2023</option>
                       <option value="2024">2024</option>
                       <option value="2025">2025</option>
                       <option value="2026">2026</option>
                       
                       </select>
                       
                       <button type="button" id="validerchart" value="Appliquer" style="margin-left:1%;width:120px;height:40px;border-radius:5px;color:white;border:2px solid #0E5AAF;border-color:#0E5AAF;background-color:#0E5AAF">Rechercher</button><br/>
                       
                       </form><br/>
                       
                       <div class="s" style="margin-top:10px;">
                       <form  id="form_charj" action="{{ route('gestion.home') }}" style="display:block;margin-top:3px;">
                        @csrf
                       <select id="mois_cours" name="mois_cours" class="form-select" aria-label="Default select example" style="width:200px;float:left;" required>
                       <option selected>Date From</option>
                       <option value="01">Janvier</option>
                       <option value="02">Février</option>
                       <option value="03">Mars</option>
                       <option value="04">Avril</option>
                       <option value="05">Mai</option>
                       <option value="°6">Juin</option>
                       <option value="07">Juillet</option>
                       <option value="08">Aout</option>
                       <option value="09">Septembre</option>
                       <option value="10">Octobre</option>
                       <option value="11">Novembre</option>
                       <option value="12">Décembre</option>
                       </select>
                       
                       <select id="date_yearss" name="date_yearss"  class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                       <option selected>Choisir l'année</option>
                       <option value="2022">2022</option>
                       <option value="2023">2023</option>
                       <option value="2024">2024</option>
                       <option value="2025">2025</option>
                       <option value="2026">2026</option>
                       
                       </select>
                       
                       <button type="button" id="validercharts" value="Appliquer" style="margin-left:1%;width:120px;height:40px;border-radius:5px;color:white;border:2px solid #0E5AAF;border-color:#0E5AAF;background-color:#0E5AAF">Rechercher</button>
                       
                       </form> -->
                       </div>
					   		<div id="chart6"></div>
							<!-- <canvas id="canvas_ambassadrice" height="250" width="800"></canvas>
                            <canvas id="select_ambassadrice" height="400" width="800"></canvas> -->
							
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


	// chart 6
	var name = <?php echo $jours; ?>;
	var res = name.split(',');
	var nombre = <?php echo $nombre_client; ?>;

	$("#select_date_newcustomer").on("change", function(){

		$.ajax({
		url: '{{ route("gestion.newcustomer") }}',
		method: 'GET',
		data: {annee: $("#select_date_newcustomer").val()},
		success: function(response) {
			var res = JSON.parse(response).jours;
			var nombre = JSON.parse(response).nombre_client;
			var currentTime = new Date()
			var year = currentTime.getFullYear()

			$("#chart6").addClass($("#select_date_newcustomer").val().split('_')[0])

			if($("#select_date_newcustomer").val().split('_')[0] == "month"){
				$(".title_chart6").text("Fréquences de nouveaux clients "+$("#select_date_newcustomer").val().split('_')[1]+"/"+year)
			} else {
				$(".title_chart6").text("Fréquences de nouveaux clients "+$("#select_date_newcustomer").val().split('_')[1])
			}
			

			chart.updateSeries([{ name: "Vue de nouveaux clients",    data: nombre}]);
			chart.updateOptions({
				xaxis: {
					categories: res
				}
			});	
		},
		error: function(error) {
			console.log(error);
		}
		})
	})

	var options = {
    series: [{
        name: "Vue de nouveaux clients",
        data: nombre,
    }],
    chart: {
        type: 'area',
        foreColor: '#9a9797',
        height: 250,
        toolbar: {
            show: false
        },
        zoom: {
            enabled: false
        },
        dropShadow: {
            enabled: false,
            top: 3,
            left: 14,
            blur: 4,
            opacity: 0.12,
            color: '#8833ff',
        },
        sparkline: {
            enabled: false
        }
    },
    markers: {
        size: 0,
        colors: ["#8833ff"],
        strokeColors: "#fff",
        strokeWidth: 2,
        hover: {
            size: 7,
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '45%',
            endingShape: 'rounded'
        },
    }, 
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 3,
        curve: 'smooth'
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.5,
            gradientToColors: ['#fff'],
            inverseColors: false,
            opacityFrom: 0.8,
            opacityTo: 0.5,
            stops: [0, 100]
        }
    },
    colors: ["#8833ff"],
    grid: {
        show: true,
        borderColor: '#ededed',
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                return value;
            }
        },
    },
    xaxis: {
        categories: res,
    },
    
    tooltip: {
        theme: 'dark',
        y: {
            formatter: function (val) {
                return "" + val
            }
        }
    }
};

	var chart = new ApexCharts(document.querySelector("#chart6"), options);
	chart.render();



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