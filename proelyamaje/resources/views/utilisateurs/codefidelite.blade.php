@extends("layouts.apps_utilisateurs")
		
@section("style")
	<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
 <style type="text/css">
 #noaffiche{display:none;}
 #writeaffiche{display:block;}
 #writeaffiches{display:block;}

</style>
	
	@endsection	

		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Gestion des commandes avec un code fidélité</div>
					<div class="ms-auto">
						<div class="btn-group">
							
            <button type="button" class="p-2 px-3 verificode" style="background-color:black;color:white;width:auto;">vérifier un code fidélité</button>
            
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
			  
				
						
						
						<div class="card border-top border-0 border-4 border-primary">

            <div class="alert alert-danger" role="alert" id="{{ $css}}">
                              {{ $message }}
              </div>
          <div class="alert alert-success" role="alert"  id="{{ $csss }}">
                               {{ $messages }}
                   </div>
						    
                                <div class="card-body p-5">
                                    
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                                        </div>
                                       
                                    </div>
                                    <hr>
                                
                                   <!--forms--ici-->
                                   <form method="post" id="forms_codepromo"  action="/utilisateur/prgramme/fidelite">
                    
                          @csrf
                       <div class="form-row">
                           
                    <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Date *</label>
                    <input type="date" name="date_vente" class="form-control form-control-user"  name="account_promo" id="account_promo" required placeholder="">
                   <div><span class id="error_promo"></span></div>
                   </div>

                   <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Type du code *</label>
                    <select class="form-control form-control-user"  name="type_choix" id="type" required placeholder="">
                    <option value="">Choix</option>
                    <option value="1">Carte cadeaux</option>
                    <option value="2">Code promo</option>
                   </select>
                   </div>
                   
                      
                    <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputEmail4">Code fidélité(fem) *</label>
                    <input type="text"  class="form-control form-control-user"  name="account_promo" id="account_promo" required placeholder="">
                   <div><span class id="error_promo"></span></div>
                   </div>
                   
                   <div id="montant_type" class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputPassword4">Montant de la carte cadeaux  à deduire *(NB exemple entrez 5.00 si c'est 5)</label>
                   <input type="text" class="form-control" id="account_montant" name="account_montant"><br/>
                   
                  <div><span class id="error_montant"></span></div>        
                   
                 </div>
                  
                 
                 <div class="form-group col-md-6" style="margin-top:20px;">
                   <label for="inputPassword4">Ref-facture -dolibar *</label>
                   <input type="text" class="form-control" id="ref_facture" name="ref_facture" required>
                  <div><span class id="error_facture"></span></div>        
                   
                 </div>
           
          
          </div>
          
          <div><span class id="error_live"></span></div>
          
          
          </div>
          
          <div class="row d-flex justify-content-center">
            <button class="mb-5 btn btn-dark px-5" style="width:auto" type="button" id="submit_codefidelite" >Enregistrer la commande</button>
          </div>

         
	
	    </form>
                                   
                                   
                                </div>
                            </div>
			
                    

			</div>
		</div>

     <!-- Modal -->
		<div class="modal fade" id="form_verifycodes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content p-3">
			<form method="post" id="form_verifcodes" action="/utilisateur/prgramme/fidelite">
				@csrf

				<h3 style="font-size:17px;text-align:center;text-transform:uppercase">Vérifier le code fidélité <span id="nommer"></span> </h3>

				<div id="error_codelive"></div>

				<div>

				<input type="text" size="45" class="form-control" placeholder="code(NB tapez le code en miniscule)" name="codefemverify" required  required aria-describedby="basic-addon1">

				</div>

				<div class="w-100 mt-2 d-flex justify-content-center">

					<button type="button" data-bs-dismiss="modal" class="annuler" style="background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;">Annuler</button>  
					<button type="submit" class="validateadds" style="background-color:#00FF00;color:black;border:2px solid #00FF00;margin-left:15px;border-radius:15px;font-weight:bold">Vérifier</button> <br/> 

				</div>
			</form>
			</div>
		</div>
		</div>
     


		<!--end page wrapper -->
		@endsection
	  
        @section("script")
	<script src="/admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="/admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script>
		$(document).ready(function() {
			
          $('#submit_codefidelite').click(function()
             {
                var account_promo = $('#account_promo').val();
                var account_montant =$('#account_montant').val();
               var ref_facture = $('#ref_facture').val();
               var regex_name = /^[a-zA-Z0-9-]{2,25}$/;
               var regex_montant  = /^[0-9.,]{1,16}$/;
             var regex_dolibar = /^[TCF][A-Z0-9a-z-]{2,25}$/;
            
            
   
       if(account_promo.length > 50){
        $('#error_promo').html('<div class="alert alert-danger" role="alert">le nombre de caractères du code promo est moins de 16 !</div>');
       }
      else if(account_montant.length > 16){
        $('#error_montant').html('<div class="alert alert-danger" role="alert"> le nombre de caractère du montant est moins de 16 !</div>');
     }
     else if(ref_facture.length > 30){
        $('#error_facture').html('<div class="alert alert-danger" role="alert"> le nombre de caractère de la ref_facture est moins de 30 !</div>');
      }
       else if (!regex_montant.test(account_montant)){
      $('#error_montant').html('<div class="alert alert-danger" role="alert"> la syntaxe du montant est incorrecte !</div>');
     }
     else if (!regex_dolibar.test(ref_facture)){
      $('#error_facture').html('<div class="alert alert-danger" role="alert"> la syntaxe de la ref facture incorrecte !</div>');
     }
	
	  else{
	    // envoi du formulaire
        
          $('#forms_codepromo').submit();
	}
 

          });

            $(".verificode").on('click', function(){
			      $("#form_verifycodes").modal('show')
		       });

           // changer
           $('#type').change(function(){
              var num = $('#type').val();
              if(num==2){
               // cacher le montant
                $('#montant_type').css('display','none');
                 $mmt = 0.50;
                 $('#account_montant').val($mmt);
              }

              if(num==1){
                $('#montant_type').css('display','block');
                    $('#account_montant').val('');
              }

           });

          

		} );
	</script>
	@endsection
	