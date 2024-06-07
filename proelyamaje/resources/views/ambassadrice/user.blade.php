@extends("layouts.apps_ambassadrice")





		@section("wrapper")

		<div class="page-wrapper">

			<div class="page-content">
			
			<div class="activity_live">
			<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
				<div style="font-size: 25px" class="mb-3 breadcrumb-title pe-3">Tableau de bord </div>
			</div>
				<!-- <h1 class="mb-5"> Tableau d'activité   </h1> -->
			<div>
				<span class="" style="margin-bottom:5px; color: #e77e95;font-weight:bold;font-size:18px;"> Période : {{ $mois  }} {{ $annee }} </span>
				<div style="margin-bottom:5px; color:black;font-size:18px;" id="author{{ Auth()->user()->is_admin }}">Code parrainage  :<strong>{{ $code_live_user   }}</strong>
					@if( $date_limit )		
						<span style="font-size: 15px !important">(
							<i class="bx bx-error" style="color:red"></i>
							<span class="p-1" style="font-weight:bold">Valide jusqu'au {{ $date_limit }}</span>
						)</span>		
					@endif
				</div>
				
				
				<div class="row mt-3" id="">
            		<!-- <div class="nx{{$csss}}{{ $is_admin }}"> -->
					<!-- </div>  -->
					@if($csss == "activecode")
						<div class="mb-3">
							<div style="white-space: normal !important;" class="nv{{ $csss  }}{{ $is_admin }} badge rounded-pill text-info bg-light-info p-2 px-3">
								<i class="bx bxs-circle align-middle me-1"></i><span style="font-size:14px;">{{ $ss }}</span>
							</div>
							<a href="{{ route('ambassadrice.gestionlive') }}" class="d-flex gap-3 p-3" style="font-weight:500; font-size:16px;"><i class="bx bx-right-arrow-alt"></i>Modifier ou annuler le live</a>
						</div>	
					@elseif($csss == "livereel")
						
						<div class="mb-3">
							<div style="position:relative; white-space: normal !important;"  class="nv{{ $csss  }}{{ $is_admin }} badge rounded-pill text-success bg-light-success p-2 px-3">
								<div class="bubble">
									<span class="bubble-outer-dot">
									<span class="bubble-inner-dot"></span>
									</span>
								</div>
							
								<span class="livereel">{{ $ss }}</span>
							</div>
						</div>
					
					@elseif($csss == "demandecode")
						<div class="mb-3">
							<div style="white-space: normal !important;" class="nv{{ $csss  }}{{ $is_admin }} badge rounded-pill text-warning bg-light-warning p-2 px-3">
								<i class="bx bxs-circle align-middle me-1"></i><span style="font-size:14px;">{{ $ss }}</span>
							</div>
							<a href="{{ route('ambassadrice.gestionlive') }}" class="d-flex gap-3 p-3" style="font-weight:500; font-size:16px;"><i class="bx bx-right-arrow-alt"></i>Modifier ou annuler le live</a>
						</div>
					@elseif($csss == "paliervide")
						<div class="mb-3">
							<div style="white-space: normal !important;" class="nv{{ $csss  }}{{ $is_admin }} badge rounded-pill text-danger bg-light-danger p-2 px-3">
								<i class="bx bxs-circle align-middle me-1"></i><span style="font-size:14px;">{{ $ss }}</span>
							</div>
						</div>
					@elseif($csss == "green")
							<div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-3">
								<div style="white-space: normal !important;" class="live_declencher">
									<span style="color: white;" class="bg-gradient-cosmic-btn justify-content-around mb-0 nv{{ $csss  }}{{ $is_admin }}" data-id="{{ $ids  }}">
										<svg fill="#fff" width="20" height="20" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><path d="M62.9 19.2C62.8 16 62.2 13.7 61.5 11.6C60.8 9.5 59.7 7.8 58 6.1C56.3 4.4 54.6 3.4 52.6 2.6C50.6 1.8 48.4 1.3 45 1.2C41.5 1 40.5 1 32 1C23.5 1 22.6 1 19.2 1.1C15.8 1.2 13.7 1.8 11.6 2.5C9.5 3.2 7.8 4.4 6.1 6.1C4.4 7.8 3.3 9.5 2.6 11.6C1.8 13.6 1.3 15.8 1.2 19.2C1.1 22.6 1 23.5 1 32C1 40.5 1 41.4 1.1 44.8C1.2 48.2 1.8 50.3 2.5 52.4C3.2 54.5 4.3 56.2 6 57.9C7.7 59.6 9.5 60.7 11.5 61.4C13.5 62.1 15.7 62.7 19.1 62.8C22.5 63 23.4 63 31.9 63C40.4 63 41.3 63 44.7 62.9C48.1 62.8 50.2 62.2 52.3 61.5C54.4 60.8 56.1 59.7 57.8 58C59.5 56.3 60.6 54.5 61.3 52.5C62 50.5 62.6 48.3 62.7 44.9C62.8 41.7 62.8 40.7 62.8 32.2C62.8 23.7 63 22.6 62.9 19.2ZM57.3 44.5C57.2 47.5 56.6 49.1 56.2 50.3C55.6 51.7 54.9 52.8 53.8 53.8C52.7 54.9 51.7 55.5 50.3 56.2C49.2 56.6 47.6 57.2 44.5 57.3C41.3 57.3 40.3 57.3 32.1 57.3C23.9 57.3 22.8 57.3 19.6 57.2C16.6 57.1 15 56.5 13.8 56.1C12.4 55.5 11.3 54.8 10.3 53.7C9.2 52.6 8.6 51.6 7.9 50.2C7.5 49.1 6.9 47.5 6.8 44.4C6.8 41.3 6.8 40.3 6.8 32C6.8 23.7 6.8 22.7 6.9 19.5C7 16.5 7.6 14.9 8 13.7C8.6 12.3 9.3 11.2 10.3 10.2C11.4 9.1 12.4 8.5 13.8 7.9C14.9 7.5 16.5 6.9 19.6 6.8C22.8 6.7 23.8 6.7 32.1 6.7C40.4 6.7 41.4 6.7 44.6 6.8C47.6 6.9 49.2 7.5 50.4 7.9C51.8 8.5 52.9 9.2 53.9 10.2C55 11.3 55.6 12.3 56.3 13.7C56.7 14.8 57.3 16.4 57.4 19.5C57.5 22.7 57.5 23.7 57.5 32C57.5 40.3 57.4 41.3 57.3 44.5Z"/><path d="M32.0016 16.0996C23.1016 16.0996 16.1016 23.2996 16.1016 31.9996C16.1016 40.8996 23.3016 47.8996 32.0016 47.8996C40.7016 47.8996 48.0016 40.8996 48.0016 31.9996C48.0016 23.0996 40.9016 16.0996 32.0016 16.0996ZM32.0016 42.3996C26.2016 42.3996 21.6016 37.6996 21.6016 31.9996C21.6016 26.2996 26.3016 21.5996 32.0016 21.5996C37.8016 21.5996 42.4016 26.1996 42.4016 31.9996C42.4016 37.7996 37.8016 42.3996 32.0016 42.3996Z"/><path d="M48.7 19.1002C50.7435 19.1002 52.4 17.4436 52.4 15.4002C52.4 13.3567 50.7435 11.7002 48.7 11.7002C46.6565 11.7002 45 13.3567 45 15.4002C45 17.4436 46.6565 19.1002 48.7 19.1002Z"/></svg>
										<span style="font-size:17px;font-weight: 500;">{{ $ss }}</span>
									</span>
								</div>
							
                       
						</div>

						

					@endif
				</div>
			</div>

             <form method="post" id="form_activelive" action="{{ route('ambassadrice.activate') }}">

				@csrf

				<input type="hidden" id="id_codes" name="id_codes" value="{{ $ids  }}">

				<input type="hidden" id="names_email" name="names_email" value="{{ $email  }}">

			</form>

         </div>

			

		   <div class="m-0 mb-2 d-flex flex-column align-items-start ambassadrice_cards_gift cards_gift text-center" style="margin-bottom:18px">
				<span class="p-0  {{ $css_action }}"> 
					<!--<i class="bx bx-cart-alt"></i> Cagnotte(Bon d'achat) - Solde actuel:  <strong>{{ $somme_api }} €</strong><br/>
				</span>-->
				
				<span class="{{ $css_action }}">
					<button type="button" style="width:210px;height:40px;background-color:black;color:white;border-radius:20px" class="data-gift p-2"  data-id3="{{ $code_number }}"> 
						Voir mon bon d'achat<i class="bx bx-chevron-down-circle"></i>
					</button>
				</span>
				<!--<span class="p-0  {{ $css_action }}">Votre N° de Bon est: <strong>{{ $code_number }}</strong></span>-->
			</div>

			<div id="result_gift" style="font-size:14px;color:black; max-width:370px;"></div><!--afficher le retour reponse-->
			
			<div class="row row-cols-1 row-cols-lg-2" style="margin-top:20px">
					<div class="col">
					<div class="card radius-10">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="flex-grow-1">
									<p class="mb-0">Commission générée</p>
									<h4 class="font-weight-bold">{{ $gain   }} €</h4>
									<!-- <p class="text-success mb-0 font-13">Analytics for last week</p> -->
								</div>
								<div class="widgets-icons bg-gradient-cosmic text-white"><i class="fadeIn animated bx bx-euro font-30"></i>
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
									<p class="mb-0">Ventes totales générés</p>
									<h4 class="d-flex align-items-center font-weight-bold">
										{{ $nombre }}
										<span class="{{ $img }}" style="margin-left:35px">
											<a href="{{ route('ambassadrice.orderslists')  }}">
												<i style="color:black" class="fadeIn animated bx bx-show-alt font-25"></i>
											</a>
										</span>
									</h4>
									<!-- <p class="text-success mb-0 font-13">Analytics for last week</p> -->
								</div>
								<div class="widgets-icons bg-gradient-cosmic text-white"><i class="bx bx-line-chart font-30"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
				<div class="row row-cols-1 row-cols-lg-2">
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Ventes élèves/codes élèves</p>
										<h4 class="font-weight-bold">{{ $nombres }} / {{  $num  }}</h4>
										<!-- <p class="text-success mb-0 font-13">Analytics for last week</p> -->
									</div>
									<div class="widgets-icons bg-gradient-cosmic text-white"><i class="fadeIn animated bx bx-user font-30"></i>
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
										<p class="mb-0">Ventes par code parrainage (live)</p>
										<h4 class="font-weight-bold">{{ $nbrs }}</h4>
										<!-- <p class="text-success mb-0 font-13">Analytics for last .week</p> -->
									</div>
									<div class="widgets-icons bg-gradient-cosmic text-white"><i class="fadeIn animated bx bx-camera font-30"></i>
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

	<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

	<script>

    

	$(document).ready(function() {

		$('.data-gift').click(function() {
			var id = $(this).data('id3');
			$.ajax({
			url: "{{ route('ambassadrice.bongift') }}",
			method: 'GET',
			data: {id:id},
			}).done(function(data) {
				
				var res =  JSON.parse(data).message_retour;
				$('#result_gift').html(res);
				
			});

		});
    
	} );

	$(document).ready(function() {
    // Utiliser la délégation d'événements pour attacher un gestionnaire de clic
    // à l'élément #code_id_text, même s'il est ajouté dynamiquement au DOM
    $(document).on('click', '#code_id_text', function() {
		event.preventDefault(); // Empêche l'action par défaut
        // Créer un élément textarea temporaire
		var $temp = $("<textarea>");
$temp.css({
    position: "absolute",
    left: "-9999px", // Position hors de l'écran
    top: "0"
}).appendTo('body').val($(this).text()).select();
document.execCommand('copy');
$temp.remove();
		// Récupérer le parent .copyable et ajouter la classe .copied
        $(this).closest('.copyable').addClass('copied');

                const currentSvg = this.nextElementSibling;
                
                // Définir le nouveau SVG
                const newSvgMarkup = `
               <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="18" height="18" viewBox="0 0 16 16">
                    <path d="M 7.679688 0.957031 C 4.097656 0.855469 1.105469 3.691406 1.003906 7.273438 C 0.902344 10.855469 3.738281 13.851563 7.320313 13.953125 C 10.902344 14.050781 13.898438 11.21875 14 7.632813 C 14.019531 6.882813 13.90625 6.160156 13.6875 5.484375 L 12.863281 6.261719 C 12.960938 6.695313 13.011719 7.144531 13 7.609375 C 12.914063 10.640625 10.378906 13.035156 7.347656 12.953125 C 4.316406 12.867188 1.917969 10.332031 2 7.300781 C 2.085938 4.269531 4.621094 1.871094 7.652344 1.953125 C 8.644531 1.984375 9.566406 2.277344 10.359375 2.765625 L 11.109375 2.054688 C 10.125 1.398438 8.953125 0.992188 7.679688 0.957031 Z M 12.5 2.792969 L 6.5 8.792969 L 4.851563 7.148438 L 4.5 6.792969 L 3.792969 7.5 L 4.148438 7.851563 L 6.5 10.207031 L 13.207031 3.5 Z"></path>
                </svg>`;
                // Remplacer le SVG actuel par le nouveau
                if (currentSvg && currentSvg.tagName.toLowerCase() === 'svg') {
                    currentSvg.outerHTML = newSvgMarkup;
                }
        
        // Afficher une notification de succès ici si nécessaire
        // alert("Contenu copié : " + $(this).text());
    });
});


	</script>


@endsection