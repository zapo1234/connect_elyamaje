 @extends("layouts.apps")


	@section("style")

	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

   <link href="{{asset('admin/assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<!-- <link href="{{asset('admin/assets/assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" /> -->


	<style type="text/css">

	h1{display:none;}

	#multiple_fact {background-color:black;color:white;border-radius:5px;height:40px;}

	</style>

	@endsection	

		@section("wrapper")

		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center justify-content-between flex-wrap">
               <div class="d-flex align-items-center"> 
                  <div class="breadcrumb-title pe-3">Factures</div>
                  <div class="ps-3">
                     <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 pe-3">
                           <li class="breadcrumb-item active" aria-current="page">Gestion des factures</li>
                        </ol>
                     </nav>

					   </div>
               </div>

               
               <div>
						<h2 class="text-center" style="font-size:16px;">Télécharger les factures dans des dossiers zip !</h2>
                  <form  class="select2_style d-flex justify-content-center" method="post" id="form_zip_facture" action="/download-zip/facture" style="display:block;margin-top:3px; margin-bottom:35px;">
                     @csrf

                     <select id="mois_cours" name="mois_cours" class="form-select" aria-label="Default select example" style="width:200px;float:left;" required>
                        <option  value="selected">Choisir Mois</option>
                        <option value="1">Janvier</option>
                        <option value="2">Fevrier</option>
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
                     <div style="width:10px;"></div>
                     <select id="date_year" name="date_year"  class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:4px !important" required>
                        <option value="selected">Choisir Année</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                     </select>

                     <button type="submit" id="validercharts" value="Appliquer" style="margin-left:1%;width:120px;height:38px;border-radius:5px;color:white;border:2px solid #0E5AAF;border-color:#0E5AAF;background-color:#0E5AAF">Télécharger</button>
                  </form>
					</div>

               <div class="col-md-2">
               </div>

				</div>
            
				<!--end breadcrumb-->

				<div class="card card_table_mobile_responsive">
					<div class="card-body">

                  <div class="d-flex justify-content-center w-100 loading"> 
                    
                  </div>

                  <div class="table-responsive">
                     <div class="d-flex flex-wrap">
                        <!-- Form recherche par type utilisateur -->
                        <div class="d-none mb-3 filter_research_invoice d-flex fact{{ Auth()->user()->is_admin }}" style="color:black">
                                                
                           <div class="filter_column">
                              <i style="width:38px" class="d-flex justify-content-center  fadeIn animated bx bx-filter-alt"></i>
                           </div>

                           <div class="hide_column d-none">
                              <a class="toggle-vis" data-column="1">Période</a>
                              <a class="toggle-vis" data-column="2">Montant (TTC)</a>
                              <a class="toggle-vis" data-column="3">User</a>
                              <a class="toggle-vis column_hide" data-column="4">Nbr de vente/code live</a>
                              <a class="toggle-vis column_hide" data-column="5">Nbr de vente/code élève </a>
                              <a class="toggle-vis" data-column="6">Nbr de lives</a>
                              <a class="toggle-vis" data-column="7">Type</a>
                              <a class="toggle-vis" data-column="8">Status</a>
                              <a class="toggle-vis" data-column="9">Choix du paiement</a>
                              <a class="toggle-vis" data-column="10">RIB</a>
                              <a class="toggle-vis" data-column="11">Facture</a>
                              <a class="toggle-vis" data-column="12">Virement</a>
                              <a class="toggle-vis" data-column="13">Carte Cadeau</a>
                           </div>

                           <select class="type_dropdown input_form_type" name="type_user">
                              <option value="">{{  $option_default }}</option>
                              <option value="Ambassadrice">Ambassadrice</option>
                              <option value="Partenaire">Partenaire</option>
                           </select>

                           <div class="add_option d-none"></div>
                           <select class="users_dropdown input_form_type">
                              <option value="">Utilisateur</option>
                                 @foreach($list as $k => $val)
                                    @foreach($val as $m =>$vals)
                                       <option class="amba" value="{{ $vals }}">{{ $vals }}</option>
                                    @endforeach
                                 @endforeach
                                 @foreach($lists as $ks => $vals)
                                    @foreach($vals as $ms =>$valss)
                                       <option class="parte" value="{{ $valss }}">{{ $valss }}</option>
                                    @endforeach
                                 @endforeach
                           </select>

                           <select class="input_form_type month_dropdown">
                              <option value="">Choisir Mois</option>
                              <option value="Janvier">Janvier</option>
                              <option value="Février">Fevrier</option>
                              <option value="Mars">Mars</option>
                              <option value="Avril">Avril</option>
                              <option value="Mai">Mai</option>
                              <option value="Juin">Juin</option>
                              <option value="Juillet">Juillet</option>
                              <option value="Août">Août</option>
                              <option value="Septembre">Septembre</option>
                              <option value="Octobre">Octobre</option>
                              <option value="Novembre">Novembre</option>
                              <option value="Décembre">Décembre</option>
                           </select>

                           <select class="input_form_type year_dropdown">
                              <option value="">Choisir Année</option>
                              <option value="2022">2022</option>
                              <option value="2023">2023</option>
                              <option value="2024">2024</option>
                              <option value="2025">2025</option>
                              <option value="2026">2026</option>
                              <option value="2027">2027</option>
                              <option value="2028">2028</option>
                              <option value="2029">2029</option>
                              <option value="2030">2030</option>
                              <option value="2031">2031</option>
                              <option value="2032">2032</option>
                              <option value="2033">2033</option>
                              <option value="2034">2034</option>
                           </select>

                           <select class="invoice_dropdown input_form_type"  name="fact_pay" id="">
                              <option value="">Facture payable</option>
                              <option value="yes">Oui</option>
                              <option value="no">Non</option>
                              <option value="soldée">Soldée</option>
                           </select> 

                        </div>
                     </div>

                     <form style="width:99%" method="post" action="{{ route('factures.validateds') }}">
                        @csrf
                        <input type="submit" id="multiple_fact" class="d-none" value="valider mutiple facture">

                        <!-- Table liste factures .-->
                        <table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;">
                           <thead>
                              <tr>
                                 <th><input class="check_all" type="checkbox"></th>
                                 <th scope="col" style="color:black;font-size:16px;font-weight:300"><i class="fa fa-calendar" aria-hidden="true"></i>  Période </th>
                                 <th scope="col">Montant(TTC)</th>
                                 <th scope="col">User</th>
                                 <th scope="col" class="cx{{ Auth()->user()->is_admin }}">Nbr de vente/code live</th>
                                 <th scope="col" class="cx{{ Auth()->user()->is_admin }}">Nbr de vente/code élève </th>
                                 <th scope="col" class="cx{{ Auth()->user()->is_admin }}">Nbr de lives</th>
                                 <th scope="col" class="cx{{ Auth()->user()->is_admin }}">Type</th>
                                 <th class="col-md-1" scope="col">Status</th>
                                 <th class="col-md-1" scope="col">Choix du paiement</th>
                                 <th scope="col">RIB</th>
                                 <th scope="col">Facture</th>
                                 <th scope="col">Virement</th>
                                 <th scope="col">Carte Cadeau</th>
                                 <th class="d-none" scope="col">Payable</th>


                              </tr>
                           </thead>
                           <tbody>
                              @foreach($users as $resultat)
                                 <tr class="{{ number_format($resultat['somme'], 2, '.', '') }}">
                                    <td>
                                       <input class="check" type="checkbox"  name="check[]" value="{{ $resultat['email'] }} , {{ $resultat['id'] }}, {{ $resultat['mois'] }}, {{ $resultat['id_ambassadrice'] }},  {{ $resultat['id_mois'] }}, {{ number_format($resultat['somme']+$resultat['somme']*$resultat['tva']/100, 2, ',', '') }}">
                                    </td>
                                    <th scope="row" style="color:#000;font-weight:bold">{{ $resultat['mois'] }} {{ $resultat['annee']   }}</th>
                                    <td style="position:relative" data-label="Montant(TTC)">
                                       <span class="ligne_note_span d-flex justify-content-between">{{ number_format($resultat['somme']+$resultat['somme']*$resultat['tva']/100, 2, ',', '') }} € <br/>
                                          
                                          @if ($resultat['ligne_note'] != "")
                                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="{{ $resultat['id'] }}" class="show_ligne_note bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                             </svg>
                                             <div id="ligne_note_{{ $resultat['id'] }}" class="ligne_note">
                                                @foreach(explode('%', $resultat['ligne_note']) as $key => $info) 
                                                   @if(count(explode('%', $resultat['ligne_note'])) - 1  == $key)
                                                      <option>{{$info}} <br/></option>
                                                   @else 
                                                      <option>{{ substr($info, 10, 7)}} : {{substr($info, 17)}}<br/></option>
                                                   @endif
                                                @endforeach
                                             </div>

                                          @endif

                                       </span>
                                       @if ($resultat['ligne_note'] != "")
                                          <span class="total_invoice">{{ explode('%', $resultat['ligne_note'])[count(explode('%', $resultat['ligne_note'])) - 1] }}</span>
                                       @endif
                                    </td>
                                    <td data-label="User" class="dersuser">{{ $resultat['name'] }}</td>
                                    <td data-label="Nbr de vente/code live" class="cx{{ Auth()->user()->is_admin   }}">{{ $resultat['nbrslive']  }} </td>
                                    <td data-label="Nbr de vente/code élève" class="cx{{ Auth()->user()->is_admin   }}">{{ $resultat['nbrseleve'] }}</td>
                                    <td data-label="Nbr de (live/mensuel)" class="cx{{ Auth()->user()->is_admin   }}">{{ $resultat['nbrsfois'] }}</td>
                                    <td data-label="Type"> {{ $resultat['type_compte'] }}</td>
                                    <td style="position:relative" data-label="Status">

                                    @if($resultat['status'] == "non payée" OR str_contains($resultat['status'], "facture provisoire"))
                                       <span class="badge badge_border-danger">{{ $resultat['status']}}</span>
                                    @else
                                       <span class="badge badge_border-success">payé</span>
                                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="{{ $resultat['id'] }}" class="show_detail_paid bi bi-info-circle-fill" viewBox="0 0 16 16">
                                          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                       </svg>
                                       <div id="detail_paid_{{ $resultat['id'] }}" class="detail_paid">
                                             {{ $resultat['status']}}
                                       </div>   
                                    @endif
                                       <!-- <span class="{{ $resultat['css'] }}"> -->
                                          <!-- <span class="img{{ $resultat['css']}}">
                                             <img src="https://prodev.elyamaje.com/admin/img/check-circle-solid.png" width="23px" height="23px">
                                          </span>  -->
                                          <!-- {{ $resultat['status']}} -->
                                       <!-- </span> -->
                                    </td>
                                    <td style="position:relative" data-label="Choix du paiement">
                                       @if($resultat['status_paiement'])
                                          <span>{{ $resultat['status_paiement'] }}</span>
                                       @endif
                                    </td>
                                    <td data-label="RIB"> 
                                       @if($resultat['rib'])
                                       <span data-src="{{ $resultat['rib'] }}" class="badge bg-dark show_rib button_show_rib">Voir</span>
                                       @else
                                          <span>Aucun</span>
                                       @endif
                                    </td>
                                    <td data-label="Facture"><a class="aa{{ $resultat['nbrslive'] }}{{ $resultat['nbrseleve']}}" href="invoice/pdf/{{ $resultat['id_ambassadrice']}}/{{ $resultat['id_mois'] }}/{{ $resultat['annee'] }}"><i class="bx bx-file" style="color:red"></i> pdf </a> </td>
                                    <td style="vertical-align:middle" data-label="Virement" class="cx{{ Auth()->user()->is_admin }}{{ $resultat['is_admin'] }}">
                                    @if($resultat['csss'] == "actifpay")   
                                       <span class="aa{{ $resultat['nbrslive'] }}{{ $resultat['nbrseleve'] }}">
                                             <button type="button"  id="facture{{ $resultat['id'] }}" class="btn btn-dark px-1 p-1 {{ $resultat['button'] }}{{ $resultat['css'] }}" data-id2="{{ $resultat['id'] }},{{ $resultat['name'] }},{{ $resultat['is_admin']}},{{ $resultat['somme']}}, {{ $resultat['id_ambassadrice'] }},{{ $resultat['email'] }},{{ $resultat['mois'] }},{{ $resultat['annee'] }}"> {{ $resultat['content'] == "payer la facture par virement" ? "Payer par virement" : "" }}</button>
                                          </span>
                                          <br/> 
                                        
                                      @endif
                                    </td>
                                    <td style="vertical-align:middle" data-label="Carte Cadeau" class="cx{{ Auth()->user()->is_admin }} {{ $resultat['is_admin'] }}">
                                       @if($resultat['csss'] == "giftpay" || $resultat['csss'] == "actifpay")   
                                          <span class="{{ $resultat['nbrseleve'] }}">
                                             <button type="button"  id="facture{{ $resultat['id'] }}" class="btn btn-dark px-1 p-1 validerbon{{ $resultat['css'] }}" data-id3="{{ $resultat['id'] }},{{ $resultat['name'] }},{{ $resultat['is_admin']}},{{ $resultat['somme']}}, {{ $resultat['id_ambassadrice'] }},{{ $resultat['email'] }}" style="background-color:grey;border:2px solid grey">Payer par carte cadeaux</button>
                                          </span>
                                          <br/> 
                                          <span class="add_button"></span> 
                                       @endif
                                    </td> 
                                    <td class="">
                                       @if($resultat['csss'] == "actifpay") 
                                          {{ $resultat['status'] == "non payée" ? "yes" : "soldée"}}
                                       @else
                                          {{ $resultat['status'] == "non payée" ? "no" : "soldée"}}
                                       @endif
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </form>
						</div>
               </div>
            </div>

						
		
				

               <div id="resultat"></div><!--resultat ajax- access-->
               <div="pak" style="display:none"></div>
				</div>
			


         <!-- Modal -->
         <div class="modal fade" id="modalPaiementIm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content">
                  <div class="modal-body">
                     <form method="post" action="{{ route('ambassadrice.factures') }}">
                     @csrf
                     <h3 style="font-size:17px;text-align:center">Confirmer  vous la validation de la facture <span id="nommer"></span> ? </h3>
                  
                        <input type="hidden" id="id_facture" name="id_facture" readonly>
                        <input type="hidden" id="is_admin" name="is_admin" readonly>
                        <input type="hidden" id="montant" name="montant" readonly>
                        <input type="hidden" id="id_ambassadrice" name="id_ambassadrice" readonly>
                        <input type="hidden" id="email_user" name="email_user" readonly>
                        <input type="hidden" id="name_user" name="name_user" readonly>
                        <input type="hidden" id="mois" name="mois" readonly>
                        <input type="hidden" id="annee" name="annee" readonly>
                        <div class="d-flex w-100 justify-content-center"> 
                           <button type="button"  data-bs-dismiss="modal" class="annuler" style="background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;">Annuler</button>  
                           <button type="submit" class="validate" style="margin-left:10px;background-color:black;color:white;border:2px solid black;border-radius:15px;font-weight:bold">valider</button> <br/> 
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>

            <!-- Modal -->
            <div class="modal fade" id="modalValiderbonim" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-body">
                     <form class="w-100" method="post" action="{{ route('ambassadrice.factures2') }}">
                           @csrf
                           <h3 style="font-size:17px;text-align:center">Attribuer un bon achat cartes cadeau à <span id="nommers"></span> ? </h3>
                           <input type="hidden" id="id_facturees" name="id_facturees" readonly>
                           <input type="hidden" id="is_admins" name="is_admins" readonly>
                           <input type="hidden" id="montants" name="montants">
                           <input type="hidden" id="id_ambassadrices" name="id_ambassadrices" readonly>
                           <input type="hidden" id="email_users" name="email_users" readonly>
                           <input type="hidden" id="name_users" name="name_users" readonly>
                           <input type="hidden" id="mois" name="mois" readonly>
                           <input type="hidden" id="annee" name="annee" readonly>

                           <div class="d-flex w-100 justify-content-center"> 
                              <button type="button" data-bs-dismiss="modal" class="annuler" style="background-color:#eee;color:black;border:2px solid #eee;border-radius:15px">Annuler</button>  
                              <button type="submit" class="validate" style="background-color:black;color:white;border:2px solid black;margin-left:10px;border-radius:15px;font-weight:bold">valider</button> <br/> 
                           </div>

                        </form>
                     </div>
                  </div>
               </div>
            </div>

            <!-- Modal RIB -->
            <div class="modal fade" id="show_rib_modal" tabindex="-1" role="dialog" aria-labelledby="show_rib_modalCenterTitle" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                     <!-- <h5 class="modal-title" id="show_rib_modalLongTitle">Modal title</h5> -->
                     </div>
                     <div class="modal-body display_rib">
                     
                     </div>
                     <div class="modal-footer">
                     <button type="button" class="close_modal_rib" data-bs-dismiss="modal">Annuler</button>
                     </div>
                  </div>
               </div>
            </div>
      </div>


		<!--end page wrapper -->

		@endsection

		

  <!-- <div id="paks" style="display:none;width:100%;height:4000px;background-color:black;opacity:0.8;position:absolute;z-index:3;"></div>   -->

		@section("script")

		<script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> -->
      <script src="{{asset('admin/assets/assets/plugins/select2/js/select2.min.js')}}"></script>

   

	<script>

      $(".paimentim").on('click', function(){
         $("#modalPaiementIm").modal('show')
      })

      $(".validerbonim").on('click', function(){
         $("#modalValiderbonim").modal('show')
      })

      $(document).mouseup(function(e) 
      {
         var container = $(".hide_column ");
         var container2 = $(".filter_column");

         // if the target of the click isn't the container nor a descendant of the container
         if (!container.is(e.target) && container.has(e.target).length === 0 
         && $('.hide_column').hasClass('filter_open')
         && !container2.is(e.target)
         && container2.has(e.target).length === 0) 
         {
            container.removeClass('filter_open')
            container.addClass('d-none')
         }
      });

		$(document).ready(function() {

         $('#fact_pay').click(function()
        {
            var fact_pay = $('#fact_pay').val();
            if(fact_pay!="")
            {
               $('#fact_pays').submit();
            }
           
        });

         $(".check_all").on('change', function(){
            if($(this).prop('checked')){
               $('.check').prop('checked', true)
            } else {
               $('.check').prop('checked', false)
            }
         })

         $(".filter_column").on('click', function(){
            if($('.hide_column').hasClass('filter_open')){
               $('.hide_column').removeClass('filter_open')
               $('.hide_column').addClass('d-none')

            } else {
               $('.hide_column').addClass('filter_open')
               $('.hide_column').removeClass('d-none')

            }
         })

        
			$('#example').DataTable({
            "pageLength": 25,
            "columnDefs": [
               { "orderable": false, "targets": 0 },
               { "sorting": false, "targets": 0 }

            ],

            "initComplete": function(settings, json) {


               $(".filter_research_invoice").removeClass('d-none')
               $("#multiple_fact").removeClass('d-none')

               $(".loading").remove()
               $("#example").removeClass('d-none')
               // $('.form-select form-select-sm')
               $("#example_length select").css('margin-left', '10px')
               $("#example_length select").addClass('filter_length')
               $("#example_length select").appendTo('.filter_research_invoice')
               $(".dataTables_length").hide()
               $("select").select2({
                  width: '150px'
               });

               $(".filter_length").select2({
                  width: '80px'
               });

               

               $('#example').DataTable().columns(14).visible(false);
               $('#example').DataTable().columns(4).visible(false);
               $('#example').DataTable().columns(5).visible(false);
               // $('#example').DataTable().columns(6).visible(false);
            }
           
         });

         $("#example_filter").remove()
         $('a.toggle-vis').on('click', function (e) {
            e.preventDefault();
            // Get the column API object
            var column =  $('#example').DataTable().column($(this).attr('data-column'));
            // Toggle the visibility

            column.visible(!column.visible());

            console.log(column.visible())
            if(column.visible()){
               $(this).removeClass('column_hide')
            } else {
               $(this).addClass('column_hide')
            }
         });

        


         $('.users_dropdown').on('change', function(e){
            var invoice_dropdown = $('.invoice_dropdown').val();
            var type_user = $('.type_dropdown').val();
            var user = $(this).val();
            var month = $('.month_dropdown').val();
            var year = $('.year_dropdown').val();
            $('.users_dropdown').val(user);
            $('#example').DataTable()
            .column(1).search(month+' '+year, true, false)
            .column(3).search(user, true, false)
            .column(7).search(type_user, true, false)
            .column(14).search(invoice_dropdown, true, false)
            .draw();
         })

         $('.type_dropdown').on('change', function(e){


            

            // CACHER LES TYPES DE USER NON CORRESPONDANT
            if($(this).val() == "Ambassadrice"){
               $('.users_dropdown').append($(".add_option option"))
               $('.users_dropdown option').each(function() {
                  if ($(this).hasClass('parte')) {
                     $(".add_option").append($(this))
                  } 
               })
            } else if($(this).val() == "Partenaire"){
               $('.users_dropdown').append($(".add_option option"))
               $('.users_dropdown option').each(function() {
                  if ($(this).hasClass('amba')) {
                     $(".add_option").append($(this))
                  } 
               })
            } else {
               $('.users_dropdown').append($(".add_option option"))
            }
            
            var invoice_dropdown = $('.invoice_dropdown').val();
            var type_user = $(this).val();
            var user = $('.users_dropdown').val();
            var month = $('.month_dropdown').val();
            var year = $('.year_dropdown').val();
            $('.type_dropdown').val(type_user)
            $('#example').DataTable()
            .column(1).search(month+' '+year, true, false)
            .column(3).search(user, true, false)
            .column(7).search(type_user, true, false)
            .column(14).search(invoice_dropdown, true, false)
            .draw();
         })

         $('.month_dropdown').on('change', function(e){
            var invoice_dropdown = $('.invoice_dropdown').val();
            var type_user = $('.type_dropdown').val();
            var user = $('.users_dropdown').val();
            var month = $(this).val();
            var year = $('.year_dropdown').val();
            $('.month_dropdown').val(month);
            $('#example').DataTable()
            .column(1).search(month+' '+year, true, false)
            .column(3).search(user, true, false)
            .column(7).search(type_user, true, false)
            .column(14).search(invoice_dropdown, true, false)
            .draw();
         })

         $('.year_dropdown').on('change', function(e){
            var invoice_dropdown = $('.invoice_dropdown').val();
            var type_user = $('.type_dropdown').val();
            var user = $('.users_dropdown').val();
            var month = $('.month_dropdown').val();
            var year = $(this).val();
            $('.year_dropdown').val(year);
            $('#example').DataTable()
            .column(1).search(month+' '+year, true, false)
            .column(3).search(user, true, false)
            .column(7).search(type_user, true, false)
            .column(14).search(invoice_dropdown, true, false)
            .draw();
         })

         $('.invoice_dropdown').on('change', function(e){
            var invoice_dropdown = $(this).val();
            var type_user = $('.type_dropdown').val();
            var user = $('.users_dropdown').val();
            var month = $('.month_dropdown').val();
            var year = $('.year_dropdown').val();
            $('.invoice_dropdown').val(invoice_dropdown);
            $('#example').DataTable()
            .column(1).search(month+' '+year, true, false)
            .column(3).search(user, true, false)
            .column(7).search(type_user, true, false)
            .column(14).search(invoice_dropdown, true, false)
            .draw();
         })


		  } );


      $(".show_rib").on("click", function(){
         var img = $(this).attr('data-src')
         var type = img.split('.')[1]
         var url = "{{ asset('admin/uploads/rib') }}"
         $(".pdf_embed").remove()
         $(".display_rib").css("background-image", "") 

         if(type == "pdf" || type ==  "PDF"){
            
            $(".display_rib").append("<embed class='pdf_embed' src='"+url+'/'+img+"' frameborder='0' width='100%' height='100%'>")
         } else {
            $(".display_rib").css("background-image", "url("+url+'/'+img+")")  
         }

         $('#show_rib_modal').modal({backdrop: 'static', keyboard: false})  
         $('#show_rib_modal').modal("show")  
      })

	</script>


	@endsection

	