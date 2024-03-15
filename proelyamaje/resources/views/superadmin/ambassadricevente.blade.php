@extends("layouts.apps")

		
<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
<style>
th{text-align:center}
.buttooncss{ border-radius:50%;background-color: red;width: 25px;height:25px;margin-left:2%;border:2px solid red}
.buttonone{display:none}
.result{padding-left:3%;}
</style>
		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center mb-2">

					<div class="breadcrumb-title pe-3">Rapport de vente Ambassadrice</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 pe-3">
                                <li class="breadcrumb-item active" aria-current="page">Lives effectués</li>
                            </ol>
                        </nav>
                    </div>


				</div>

				 <div class="card card_table_mobile_responsive">
                   <div style="font-size:15px;margin-top:30px;margin-left:3%"> Export csv Historique live <br/>A recupérer à partir de Avril 2023 incluant un id_live(unique)<br/>si vous ne choississez pas le mois ou l'année<br/>Vous avez tous l'historique</div>
				   <div>
                     <form method="post" id="stat_vente" action="{{ route('superadmin.postcventeslive') }}">
					 @csrf
				     <select  name="ambassadrice"  id="ambassadrice" class="form-select" aria-label="Default select example" style="width:250px;float:left;margin-left:2%" required>
				     <option value="">Chosir l'ambassadrice </option>
				     @foreach($result_name as $key => $name)  
				     <option value="{{ $key }}"> {{ $name  }} </option>
				     @endforeach
                    </select>

					<select  name="mois"  id="mois" class="form-select" aria-label="Default select example" style="width:250px;float:left;margin-left:2%" required>
				       <option value="">Choisir mois </option>
					   <option value="" selected>Mois</option>
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

                     <select  name="annee"  id="annee" class="form-select" aria-label="Default select example" style="width:250px;float:left;margin-left:2%" required>
				     <option value="">Choisir Année </option>
					 <option selected>Choisir l'année</option>
                      <option value="2022">2022</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                      <option value="2025">2025</option>
                      <option value="2026">2026</option>
				     </select>


				       <button id="class" type="submit" style="margin-left:2%;background-color:black;width:250px;height:40px;color:white;border-radius:5px;border:2px solid black"> Export csv </button>
				    </form>

				     </div>
					<div class="card-body">

						<div class="d-flex justify-content-center w-100 loading"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

						<div class="table-responsive">

							<table id="example" class="d-none table_mobile_responsive table table-striped table-bordered">

								<thead>
                                    <tr>
                                     <th scope="col">Date de live </th>
                                      <th scope="col">Réf-live</th>
                                       <th scope="col">Ambassadrice </th>
                                       <th scope="col">Indice </th>
                                       <th scope="col">Chiffre</th>
                                    </tr>

								</thead>

								<tbody>
                                @foreach($result_data as $resultat)
								  <tr>
                                  <td data-label="Chiffre" style="font-size:25px;">{{ $resultat['date_live'] }}</td>
                                 <td data-label="Période" style="font-size:25px">{{ $resultat['ref_live']}} </td>
                                 <td data-label="Chiffre" style="font-size:25px;">{{ $resultat['ambassadrice'] }}</td>
                                 <td> {{ $resultat['ref_jour'] }}  <button class=" {{ $resultat['css']}}"> </button></td>
                                 <td> <button class="tap_view" data-id1="{{ $resultat['ref_live'] }}" style="width:120px;height:25px;text-align:center;color:white;background-color:black;text-align:center;border-radius:5px;border:2px solid black"> Voir </button> <span id="{{ $resultat['ref_live'] }}"></span></td>
                                
                                </tr>

                               @endforeach
                               

							</tbody>

							</table>

					      <div class="affiche" style="margin-left:70%;margin-top:20px">   </div>           

                             <div id="resultat"></div><!--resultat ajax- access-->

                             <div="pak" style="display:none"></div>

						</div>

					</div>

				</div>





			</div>

		</div>

		<!--end page wrapper -->

		@endsection

		

@section("script")

	<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

	<script>

    

	$(document).ready(function() {

	
	  $('.tap_view').click(function() {
       
       var id = $(this).data('id1');

        $.ajax({
		url: "{{ route('superadmin.getsomlive') }}",
		method: 'GET',
		data: {id:id},
		}).done(function(data) {
            
		    var res =  JSON.parse(data).result
			$('#'+id).text(res);
			
		});

    });
    
    
    
        $('#example').DataTable({
			"initComplete": function(settings, json) {
				$(".loading").remove()
				$("#example").removeClass('d-none')
			}
		});

	} );

	</script>



	@endsection

	