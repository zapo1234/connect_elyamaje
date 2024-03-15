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
                <div class="breadcrumb-title pe-3">Statistique répresentative des clients</div>
				
            </div>


			<div class="row row-cols-1 row-cols-lg-3 dashboard_global">
					<div class="col">
						<div class="card radius-10">
							<div class="card-body" style="height:500px;overflow-y:scroll">
								<div class="revenue-by-channel">
									<h6 class="mb-4 font-weight-bold">DEPARTEMENTS </h6>
									<div class="progress-wrapper">
										<div class="d-flex align-items-center">
											<div class="text-secondary"></div>
											<table  class="">
											<th scope="col" style="font-size:12px;padding:1%;width:200px;text-transform:uppercase;">Département</th>
									        <th scope="col" style="font-size:12px;padding:1%;width:200px;text-transform:uppercase">Nombre client</th>
										   <th scope="col" style="font-size:12px;padding:1%;width:200px;text-transform:uppercase">Taux(%)</th>
                                           
										   @foreach($data as $resultat)
										   <tr>
		                                  <td data-label="Nombre">{{ $resultat['departement']  }}</td>
		                                 <td style="vertical-align:middle" data-label="">{{ $resultat['nombre_user'] }}</td>
		                                 <td style="vertical-align:middle" data-label="Forcer le live">{{  $resultat['pourcentage'] }}</td>
	
                                         </tr>
                                        @endforeach
                                       </tbody>



                                        </table>

											<div style="min-width:90px" class="">
											</div>
										</div>
										
									</div>
									<div class="progress-wrapper mt-2">
										<div class="d-flex align-items-center">
											<div class="text-secondary"></div>
										
											<div style="min-width:90px" class="">
											</div>
										</div>
										
									</div>
									<div class="progress-wrapper mt-2">
										<div class="d-flex align-items-center">
											<div class="text-secondary"></div>
											<div style="min-width:90px" class="">
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card radius-10">
							<div class="card-body" style="height:500px;overflow-y:scroll">
								<div class="revenue-by-channel">
									<h6 class="mb-4 font-weight-bold">Régions</h6>
									<div class="progress-wrapper">
										<div class="d-flex align-items-center">
											<div class="text-secondary"></div>
											<table  class="">
											<th scope="col" style="font-size:12px;padding:1%;width:200px;text-transform:uppercase;">Département</th>
									        <th scope="col" style="font-size:12px;padding:1%;width:200px;text-transform:uppercase">Nombre client</th>
										   <th scope="col" style="font-size:12px;padding:1%;width:200px;text-transform:uppercase">Taux(%)</th>
                                           
										   @foreach($regions as $resul)
										   <tr>
		                                  <td data-label="Nombre">{{ $resul['name_region']  }}</td>
		                                 <td style="vertical-align:middle" data-label="">{{ $resul['nombre_customer'] }}</td>
		                                 <td style="vertical-align:middle" data-label="Forcer le live">{{  $resul['pourcentage'] }}</td>
	
                                         </tr>
                                        @endforeach
                                       </tbody>



                                        </table>

											<div style="min-width:90px" class="">
											</div>
										</div>
										
									</div>
									<div class="progress-wrapper mt-2">
										<div class="d-flex align-items-center">
											<div class="text-secondary"></div>
										
											<div style="min-width:90px" class="">
											</div>
										</div>
										
									</div>
									<div class="progress-wrapper mt-2">
										<div class="d-flex align-items-center">
											<div class="text-secondary"></div>
											<div style="min-width:90px" class="">
											</div>
										</div>
										
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
									<h6 class="title_chart6 mb-0">Graphique répresentative </h6>
								</div>
								<div class="dropdown ms-auto">
									
								</div>
							</div>

						
                       </div>
					   		<div id="chart6"></div>
							<!-- <canvas id="canvas_ambassadrice" height="250" width="800"></canvas>
                            <canvas id="select_ambassadrice" height="400" width="800"></canvas> -->
							
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


	

	</script>
	@endsection