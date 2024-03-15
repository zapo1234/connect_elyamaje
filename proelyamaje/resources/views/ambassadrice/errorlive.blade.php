@extends("layouts.apps_ambassadrice")


   <style type="text/css">
        .response{width:30%;margin:auto;}
         h3{color:black;font-weight:bold;font-size:24px;margin-top:100px;}
         .loading{margin-top:20px;margin-left:10%;}
         
         
         .loader {
         border: 16px solid #f3f3f3; /* Light grey */
       border-top: 16px solid green; /* Blue */
        border-radius: 50%;
         width: 160px;
        height: 160px;
        animation: spin 2s linear infinite;
    }

      @keyframes spin {
       0% { transform: rotate(0deg); }
       100% { transform: rotate(360deg); }
   }
         
         
         
         
         @media (max-width: 760.98px) {
         
        .response{width:30%;margin-top:300px;margin:auto;font-family:45px;}
         h3{color:black;font-weight:bold;font-size:4%;margin-top:100px;width:350px;}
         .loading{margin-top:20px;margin-left:10%;font-size:70px;}
          #imc{margin-top:150px;}
         }
     </style>
     
     
		
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Confirmation de live</div>
				</div>
				<!--end breadcrumb-->
				
				
				
				
			  
				<div class="card" id="">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
								
							
							</div>
						  <div class="ms-auto" style="position:absolute;left:50%;top:20px" id="add_customer"></div>
						</div>
						
						<h1 class="text-danger text-center mb-3" style="font-size:18px;">{{ $error_type }}</h1>


						<!-- <div class="d-flex w-100 justify-content-center text-danger"  style="font-size:100px;">	
                            <i class="lni lni-cross-circle"></i>
						</div> -->
						 
                        <div class="d-flex w-100 justify-content-center text-danger" style="font-size:100px;">
                            <i class="bx bxs-message-square-x"></i>
                        </div>

					</div>
				</div>


			</div>
		</div>
		
		
		

		
		<!--end page wrapper -->
		@endsection
	   
	   @section("script")
	<script src="/admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="/admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script>
	let dateInput = document.getElementById("search_dates");
     dateInput.min = new Date().toISOString().slice(0,new Date().toISOString().lastIndexOf(":"));
	</script>

	@endsection
	
	
	