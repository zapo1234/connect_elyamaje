@extends("layouts.apps_ambassadrice")

@section("style")

	<link href="{{asset('admin/assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/fullcalendar/css/main.min.css')}}" rel="stylesheet" />

    	<style>

	   #livecssaccept{display:none;}

         #nolive{display:block;}

         

           @media (max-width: 575.98px) { 

               

             h1{text-align:center;}

             .data_date{text-align:center;color:black;}

              .mami{display:block}

           }

           

           h2{text-align:center;}

	      
           @media screen and (min-width: 1025px) {
              .mami{display:none}
		   }
		

   </style>

	

	@endsection

		

		@section("wrapper")

		<!--start page wrapper- -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3">Lives</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 pe-3">
								<li class="breadcrumb-item active" aria-current="page">Programmer un live</li>
							</ol>
						</nav>
					</div>

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

				

				

				

					

				<form method="post"  action="{{ route('ambassadrice.addliveforms') }}">
					@csrf


					<div class="row row-cols-1 row-cols-lg-1 row-cols-xl-1">
                        <div class="col">
                            <div class="card radius-15 w-100">
                                <div class="card-body text-center">
											@if(file_exists('admin/uploads/'.Auth()->user()->img_select))
												<img width="110" height="110" class="rounded-circle shadow" alt="" src="{{ asset('admin/uploads/'.Auth()->user()->img_select )}}">
											@else 
												<img width="110" height="110" class="rounded-circle shadow" alt="" src="{{ asset('admin/uploads/default_avatar.png' )}}">
											@endif


						  					@if (session('success'))
												<div class="mt-3 w-100 d-flex justify-content-center">
													<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
														<div class="text-white">{{ session('success') }}</div>
														<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
													</div>
												</div>
                                 			@endif 
											@if (session('alert'))
												<div class="mt-3 w-100 d-flex justify-content-center">
													<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
														<div class="text-white">{{ session('alert') }}</div>
														<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
													</div>
												</div>
                                 			@endif 
                                        <h5 class="mb-0 mt-4">Programmez votre live</h5>
                                        <p class="mb-1">Choisir la date et l'heure</p>
										@if($status)
											<div class="mt-3 d-flex w-100 justify-content-center">
												<div style="position:relative" class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3 mb-3">
													<div class="bubble_warning">
															<span class="bubble-outer-dot">
															<span class="bubble-inner-dot"></span>
															</span>
														</div>
													
													<span style="margin-left:25px" >{{ $status }}</span>

												</div>
												
											</div>
											<div class="mami d-flex justify-content-center align-items-center" style="">
												<a href ="{{ route('ambassadrice.gestionlive') }}" style="color:white;padding:9px 15px;background-color:black;width:200px;height:38px;border-radius: 0.25em;">Modifier le live</a>
											</div>
										@else
											<input type="datetime-local" id="search_dates" name="search_dates" placeholder="Date souhaitée*" min=""  style="margin-top:15px;height:50px;width:250px" required>
										@endif

										 <div id="checkresponse"></div>
										
                                </div>
                            </div>
                        </div>
                    </div>

					<div class="card radius-15" id="" >
					 <div class="card-body">
							<div class="text-center p-2 mb-3" id=""><i class='bx bx-error' style="color:red"></i> Merci de sélectionner au moins <strong>1 cadeau par palier</strong> et jusqu'à <strong>6 cadeaux maximum</strong>.
							<br/>Vous pouvez choisir d'offrir tous les produits d'une catégorie ou bien de sélectionner spécifiquement un produit.</div>

							@foreach($liste_choix as $key => $valu)

							<div class="h" style="font-size:16px;color:black;font-weight:bold;margin-bottom:5px;border-bottom:3px solid black;width:150px;"> {{ $key }}</div>

								<select class="w-100 multiple-select" data-placeholder="Choose anything" multiple="multiple" name="id_token[]" required>

								@foreach($valu as $val)

									<option value="{{$val['data']['token']}}" {{ $val['data']['choix'] }}>{{ $val['data']['libelle'] }}</option>

									@endforeach

								</select><br/>

							@endforeach

							<div class="mt-3 w-100 d-flex justify-content-center">
								<button type="submit" class="validate" id="{{$css}}" style="width:250px;height:40px;background-color:black;color:white;border:2px solid black;border-radius:0.25em;font-weight:bold">Envoyer la demande</button> <br/> 
							</div>
						
						</div>

						

	              	</div> 

				

						

						<!-- <h3 class="text-center mb-0 card-title">Programmer votre live !<br/><span class="tt" style="font-size:20px;color:#0E5AAF;font-weight:800;"></span></h3> -->

		   				
						
						
					

						<!-- <div class="mt-2 w-100 text-center text-danger" style="color:#000;font-size:16px;font-weight:bold">{{ $status }}</div> -->

						

						

						

                        <!-- <div  id="{{$css}}" class="data_date w-100 text-center" style=""><span>Programmation de la date : choisssez la date et l'heure</span><br>
						<span id="nommers"></span> 

           
		   			
                      <input type="datetime-local" id="search_dates" name="search_dates" placeholder="Date souhaitée*" min=""  style="margin-top:15px;height:50px;width:250px" required></div><br/><br/> -->

					 <div class="card-body live-class">
						<h3 class="text-center mb-3 card-title">Calendrier des lives<br/></h3>
							<div id='calendar' class="calendar_ambassadrice"></div>
					</div>
				</div>

				
				
				</div>

				</div>

				</form>





			</div>

		</div>


<!--end page wrapper -->

@endsection

	   

@section("script")

	<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{asset('admin/assets/assets/plugins/select2/js/select2.min.js')}}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/fullcalendar/js/main.min.js')}}"></script>

	<script>

         $('#search_dates').change(function(){

		   var date = $('#search_dates').val();
		   var date_x =  new Date(date);

		   let jourMois = date_x.getDay();// recupérer la numero du jours 2 pour le mardi
		   if(jourMois===2){
              $('#checkresponse').html('<div><input type="hidden" name="choixtype" id="choixtype"><i class="bx bx-error" style="color:red;font-size:18px"></i>  Vous avez choisir un Mardi,  êtes vous l\'ambassadrice séléctionnée pour effectuer un live au sein d\'Elyamaje ? <br/> Si oui Cliquer sur le bouton <button type="button" id="valid" style="border-radius:5px;bacground-color:black;border:2px solid black;color:white;background-color:black">Confirmer</button><span id="response" style="color:green;font-weight:bold;font-size:13px"></span></div>');
            
			}
			else{
				$('#checkresponse').html('');
			}

			});
			
			 $(document).on("click","#valid",function() {
    
			  $('#valid').css('display','none');
			  $('#response').html('<i class="bx bx-chevron-down-circle" style="color:green;font-size:18px;font-weight:bold"></i> Vous avez bien confirmé !');
			  $('#choixtype').val('xx%xxtypey%');
             });
          
			
		let dateInput = document.getElementById("search_dates");

		

		if(dateInput){
			var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
			var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, new Date().toISOString().lastIndexOf(":"));
			dateInput.min = localISOTime
		}
		
	</script>


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
			maximumSelectionLength: 6,
		});

	</script>

	<script>
		document.addEventListener('DOMContentLoaded', function () {

			var calendarEl = document.getElementById('calendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
				slotMinTime: "08:00:00",
				allDaySlot: false,
				locale: 'fr', // the initial locale
				firstDay: 1,
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: ''
				},
				buttonText: {
					month: 'Mois',
					week: 'Semaine',
					list: 'Liste',
					day: 'Jour',
					today: 'Cette semaine'
				},
				initialView: 'listWeek',
				eventSources: [{
					url: '{{ route("gestion.getEventCalendar")}}',
					method: 'GET',
					failure: function() {
						
					},
					color: 'black',   // an option!
				}], 

				eventDidMount: function(event) {
					var img = event.event._def.extendedProps.img
					var element = event.el.querySelector('.fc-list-event-title')
					if(element && img){
						element.style.position = "relative"
						element.innerHTML = event.event.title + `<img onerror="this.src = '{{ asset("admin/uploads/default_avatar.png" )}}'" style="position:absolute; right:5px;top:1px" class="rounded-circle" width="35" height="35" src="{{ asset("admin/uploads/" )}}/`+img+`">`;
					}
				}
				
				
			});

			calendar.setOption('aspectRatio', 2.5);
			calendar.render();
		});
	
	</script>

@endsection

	

	

	