@extends("layouts.apps_utilisateurs")
@section("style")
<link href="{{ asset('admin/assets/assets/plugins/fullcalendar/css/main.min.css')}}" rel="stylesheet" />



@endsection

		@section("wrapper")
            <div class="page-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">Agenda des lives</div>
                    </div>
                    
                    <div id="inline-picker"></div>
                    <!--end breadcrumb-->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id='calendar' class="calendar_admin"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			<!-- Modal -->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Liste des cadeaux lives</h5>	
					</div>
					<div class="modal-body">
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
					</div>
					</div>
				</div>
			</div>

		@endsection

@section("script")





<script src="{{ asset('admin/assets/assets/plugins/fullcalendar/js/main.min.js')}}"></script>
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
				right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
			},
			buttonText: {
				month: 'Mois',
				week: 'Semaine',
				list: 'Liste',
				day: 'Jour',
				today: 'Aujourd\'hui'
			},
			initialView: 'timeGridWeek',
			eventSources: [{
				url: '{{ route("gestion.getEventCalendar")}}',
				method: 'GET',
				failure: function() {
					alert('there was an error while fetching events!');
				},
				color: 'black',   // an option!
			}], 
			
			windowResize: function(arg) {
				var width = $(window).width()
				if(width < 800){
					calendar.changeView('timeGridDay');
					$(".fc-dayGridMonth-button").hide()
					$(".fc-timeGridWeek-button").hide()
					$(".fc-timeGridDay-button").hide()
					$(".fc-listWeek-button").hide()
					$(".fc-header-toolbar").css({'display': "flex", "flex-direction": "column"})
				} else {
					calendar.changeView('timeGridWeek');
					$(".fc-dayGridMonth-button").show()
					$(".fc-timeGridWeek-button").show()
					$(".fc-timeGridDay-button").show()
					$(".fc-listWeek-button").show()
					$(".fc-header-toolbar").css({'display': "flex", "flex-direction": "row"})
				}
			}, 
			eventClick: function(info) {

				// Show modal with paniers live
				if(info.event.id){
					$.ajax({
						url: "{{ route('gestion.getEventCalendarLive') }}",
						data: {id_live: info.event.id},
						method: 'GET'
					}).done(function(data) {

						$(".list_product").remove()
						var html = ''

						html+= '<div class="list_product">'
						var data = JSON.parse(data)
						for (const [key, value] of Object.entries(data)) {
							html+= '<div class="mb-3 panier_list">'
							html+= '<h4>'+key+'</h4>'
							html+= '<div class="d-flex flex-column">'
							for (const [key2, value2] of Object.entries(value)) {
								html+= '<span>- '+value2.libelle+' <span class="text-success">'+ value2.mont_mini+'€</span></span>'
							}
							html+= '</div>'
							html+= '</div>'
							
						}

						html+= '</div>'

						$("#exampleModalCenter .modal-body").append(html)
						$("#exampleModalCenter").modal("show")
					});
				}
			}
			
		
		});
		

		calendar.setOption('aspectRatio', 2.5);
		calendar.render();

		var width = $(window).width()
		if(width < 800){
			calendar.changeView('timeGridDay');
			$(".fc-dayGridMonth-button").hide()
			$(".fc-timeGridWeek-button").hide()
			$(".fc-timeGridDay-button").hide()
			$(".fc-listWeek-button").hide()
			$(".fc-header-toolbar").css({'display': "flex", "flex-direction": "column"})

		} else {
			calendar.changeView('timeGridWeek');
			$(".fc-dayGridMonth-button").show()
			$(".fc-timeGridWeek-button").show()
			$(".fc-timeGridDay-button").show()
			$(".fc-listWeek-button").show()
			$(".fc-header-toolbar").css({'display': "flex", "flex-direction": "row"})
		}
	});
	

// 	$('#inline-picker').mobiscroll().datepicker({
//     controls: ['calendar'],
//     display: 'inline',
//     touchUi: true
// });
	
	
	
</script>
@endsection
