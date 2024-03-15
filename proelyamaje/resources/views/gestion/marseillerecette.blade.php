@extends("layouts.apps")

	@section("style")
	<link href="/admin/assets/assets/plugins/highcharts/css/highcharts.css" rel="stylesheet" />
	<link href="/admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
	<style>
	.live-infos{
  width: 305px;
  height:180px;
  overflow: hidden;
  position: relative;
  background-color:white;
  
}
ul.winners{
  position: absolute;
  top: 0;
  width: 280%;
  list-style-type: none;
  padding: 0;
  margin: 0;
  overflow-y:scroll;
}
ul.winners li{
  /*height: 50px;*/
  border-bottom: 1px #eee solid;
  line-height: 50px;
  font-size: 1rem;
  color: black;
  padding-left: 0.2rem;
}
.mentions{
  display: block;
  margin: 10px 0;
  font-size: 1.2rem;
  
}  
	    
.blue{ color:blue;}
.rouge{color:red;}

.vert{color:green;}
.actuel {colorl:#000;font-weight:bold;}
	</style>
	
	@endsection

		@section("wrapper")
		<div class="page-wrapper">
			<div class="page-content">
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Boutique Marseille Recette journalière(HT)</div>
				</div>
			
			  <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
					
			
					@foreach($list_datas as $val)
						<div class="col">
							<div class="card radius-10 overflow-hidden">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div class="flex-grow-1">
										<p style="font-weight:bold" class="text-capitalize mb-0"> {{ \Carbon\Carbon::parse($val['date'])->isoFormat('DD/MM/YYYY') }}</p>
											<h4 class="text-success font-weight-bold">{{ $val['montant'] }} €</h4>
										</div>
									</div>
								</div>
								<div class="" id="chart"></div>
							</div>
						</div>
					@endforeach()
				
				
				
			 </div><!--end row-->
			  
			  
			  
				
			</div>
		</div>
		@endsection
		
	@section("script")
	
	
	
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	<script src="/admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
	<script src="/admin/assets/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="/admin/assets/assets/plugins/highcharts/js/highcharts.js"></script>
	<script src="/admin/assets/assets/plugins/highcharts/js/exporting.js"></script>
	<script src="/admin/assets/assets/plugins/highcharts/js/variable-pie.js"></script>
	<script src="/admin/assets/assets/plugins/highcharts/js/export-data.js"></script>
	<script src="/admin/assets/assets/plugins/highcharts/js/accessibility.js"></script>
	<script src="/admin/assets/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="/admin/assets/assets/js/index2.js"></script>
	<script>
		new PerfectScrollbar('.customers-list');
		new PerfectScrollbar('.store-metrics');
		new PerfectScrollbar('.product-list');
	</script>
	@endsection