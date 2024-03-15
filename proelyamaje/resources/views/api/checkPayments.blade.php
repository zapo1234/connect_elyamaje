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
                  <div class="breadcrumb-title pe-3">Payements</div>
                  <div class="ps-3">
                     <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 pe-3">
                           <li class="breadcrumb-item active" aria-current="page">Cheking des payements</li>
                        </ol>
                     </nav>

					   </div>
               </div>

               
               <div>
                  <form  class="select2_style d-flex justify-content-center" method="post" id="form_zip_facture" action="/download-zip/facture" style="display:block;margin-top:3px; margin-bottom:35px;">
                     @csrf

                   </form>
					</div>

               <div class="col-md-2">
               </div>

				</div>
            
				<!--end breadcrumb-->

				<div class="card card_table_mobile_responsive">
					<div class="card-body">

                  <div class="d-flex justify-content-center w-100 loading"> 
                     <div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
                  </div>

                  <div class="table-responsive">

                     {{-- <form style="width:99%" method="post" action="{{ route('factures.validateds') }}">
                        @csrf --}}
                        {{-- <input type="submit" id="multiple_fact" class="d-none" value="valider mutiple facture"> --}}

                        <!-- Table liste factures .-->
                        <table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%">

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



                                 <tr class="">
                                    <td>
                                       <input class="check" type="checkbox"  name="check[]" value="">
                                    </td>

                                    <th scope="row" style="color:#000;font-weight:bold">annnnnne</th>
                                    <td style="position:relative" data-label="Montant(TTC)">
                                       <span class="ligne_note_span d-flex justify-content-between">bbbbbbbbbbbb <br/>
                                    </td>

                                    <td data-label="User">cccccccc</td>
                                    <td data-label="Nbr de vente/code live" class=""> dddddd </td>
                                    <td data-label="Nbr de vente/code élève" class="">eeeeeeeeeee</td>
                                    <td data-label="Nbr de (live/mensuel)" class="">ffffffffff</td>
                                    <td data-label="Type"> ggggggggg</td>
                                    <td style="position:relative" data-label="Status">

                                       <span class="badge badge_border-danger">hhhhhhhhhhh</span>
                                  
                                    </td>
                                    <td style="position:relative" data-label="Choix du paiement">
                                        status_paiement
                                    </td>
                                    <td data-label=""> 
                                        <span>Aucun</span>
                                    </td>

                                    <td data-label="Facture"><a class="" href="#"><i class="bx bx-file" style="color:red"></i> pdf </a> </td>
                                    <td style="vertical-align:middle" data-label="Virement" class="cx{{ Auth()->user()->is_admin }}">
                                       <span class="">
                                             <button type="button"  id="" class="btn btn-dark px-1 p-1" data-id2=""> iiiiiiiiiiiiiiii</button>
                                          </span>
                                          <br/> 
                                        
                                    </td>
                                    <td style="vertical-align:middle" data-label="Carte Cadeau" class="cx{{ Auth()->user()->is_admin }}">
                                         jjjjjjjjjjjjjjj
                                    </td> 
                                    <td class="">
                                      kkkkkkkkkkkkkkkk
                                    </td>
                                 </tr>


                                 <tr class="">
                                    <td>
                                       <input class="check" type="checkbox"  name="check[]" value="">
                                    </td>

                                    <th scope="row" style="color:#000;font-weight:bold">annnnnne</th>
                                    <td style="position:relative" data-label="Montant(TTC)">
                                       <span class="ligne_note_span d-flex justify-content-between">bbbbbbbbbbbb <br/>
                                    </td>

                                    <td data-label="User">cccccccc</td>
                                    <td data-label="Nbr de vente/code live" class=""> dddddd </td>
                                    <td data-label="Nbr de vente/code élève" class="">eeeeeeeeeee</td>
                                    <td data-label="Nbr de (live/mensuel)" class="">ffffffffff</td>
                                    <td data-label="Type"> ggggggggg</td>
                                    <td style="position:relative" data-label="Status">

                                       <span class="badge badge_border-danger">hhhhhhhhhhh</span>
                                  
                                    </td>
                                    <td style="position:relative" data-label="Choix du paiement">
                                        status_paiement
                                    </td>
                                    <td data-label=""> 
                                        <span>Aucun</span>
                                    </td>

                                    <td data-label="Facture"><a class="" href="#"><i class="bx bx-file" style="color:red"></i> pdf </a> </td>
                                    <td style="vertical-align:middle" data-label="Virement" class="cx{{ Auth()->user()->is_admin }}">
                                       <span class="">
                                             <button type="button"  id="" class="btn btn-dark px-1 p-1" data-id2=""> iiiiiiiiiiiiiiii</button>
                                          </span>
                                          <br/> 
                                    </td>
                                    <td style="vertical-align:middle" data-label="Carte Cadeau" class="cx{{ Auth()->user()->is_admin }}">
                                         jjjjjjjjjjjjjjj
                                    </td> 
                                    <td class="">
                                      kkkkkkkkkkkkkkkk
                                    </td>
                                 </tr>





                           </tbody>
                        </table>



                     {{-- </form> --}}
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

    //   $(".paimentim").on('click', function(){
    //      $("#modalPaiementIm").modal('show')
    //   })

    //   $(".validerbonim").on('click', function(){
    //      $("#modalValiderbonim").modal('show')
    //   })

    //   $(document).mouseup(function(e) 
    //   {
    //      var container = $(".hide_column ");
    //      var container2 = $(".filter_column");

    //      // if the target of the click isn't the container nor a descendant of the container
    //      if (!container.is(e.target) && container.has(e.target).length === 0 
    //      && $('.hide_column').hasClass('filter_open')
    //      && !container2.is(e.target)
    //      && container2.has(e.target).length === 0) 
    //      {
    //         container.removeClass('filter_open')
    //         container.addClass('d-none')
    //      }
    //   });

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

	