@extends("layouts.apps_ambassadrice")
	
	@section("style")
	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	<style type="text/css">
	h1{display:none;}
	</style>
	@endsection	
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Historique des lives </div>
					<div class="ms-auto">
						<div class="btn-group">
							
							
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				
					<div class="cards_mobile">
				    <h2 style="font-size:15px;text-transform:uppercase">Historique des lives</h2>
				    
				  
				    
				      
				     <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
				    @foreach($data as $key => $valu)
			         <div class="col">
						<div class="card radius-10 overflow-hidden" style="width:350px;margin-left:-2%">
							
							 
							<div class="card-body" style="height:370px">
							   
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0" style="font-size:16px">
										 
										  <p><span class="tt" style="font-size:20px;color:#000;font-weight:bold"> </p>
										 
										 <p style="font-size:13px;color:#000;font-weight:bold;width:340px;height:50px;padding:0.5%;"> Infos live  : {{ $key  }}<span class=""> </span></p>
										 <p style="color:black;text-transform:uppercase">Details cadeaux choisis </p>   
										 
										 <div style="width:300px;overflow-y:scroll;height:200px;">  @foreach($valu as $val)
                                                      
                                                      {{ $val['libelle'] }}<br/><br/>
                                                     
                                                      @endforeach  </div>
										
										 
									
										
										<p style="font-size:15px;color:#000;font-weight:bold"></p>
										 <p style="color:black;"><span class="ds"> </p>
										<p style="color:black"><span class="ds"> </span></p>
                                       
                                        
										
										
	                                       
										
									</div>
									
				
								</div>
							</div>
							
							
					
						</div>
					
						
					</div>
						@endforeach
					
					</div>
					
				
					
					  <div class="affiche" style="margin-left:5%">   </div> 
					</div>
					
					  
					
				   <div class="card" id="account_body">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
								
					
							</div>
							
							</div>
						  
						</div>
						<div class="table-responsive">
							
							<table id="example" class="table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;font-size:14px">
								<thead>
									<tr style="font-weight:300">
									    <th style="font-size:14px;font-weight:300">infos live</th>
									    <th style="font-size:14px;font-weight:300">Details cadeaux choisis </th>
									   
									    <th>Action</th>
										
									
										
									</tr>
								</thead>
								<tbody>
		                    @foreach($data as $key => $valu)
                          <tr class="">
                         <td style="font-size:13px;color:#000;font-weight:bold;width:370px;height:50px;padding:0.5%;">{{ $key }}</td>
                         <td style="height:150px;overflow-y:scroll">  @foreach($valu as $val)
                                                      
                                                      {{ $val['libelle'] }}<br/><br/>
                                                     
                                                      @endforeach
                         </td>
                        <td><span class=""><span class=""></span></span></td>
                 
            
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
		
		
		  
     
             
     
		
		<!--end page wrapper -->
		@endsection
		
  <div id="paks" style="display:none;width:100%;height:4000px;background-color:black;opacity:0.8;position:absolute;z-index:3;"></div>  
		@section("script")
		<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	
	@endsection
	