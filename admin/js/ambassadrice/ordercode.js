$(document).ready(function(){

$('.add_panier').click(function()
{
    
    alert('zapo');
    var account_code = $('#account_promo').val();
    var montant = $('#account_montant').val();
    var ref_facture = $('#ref_facture').val();
    
    var regex_name = /^[a-zA-Z0-9]{2,25}(\s[a-zA-Z0-9]{2,25}){0,4}$/;
    var regex_code = /^[a-zA-Z0-9-]{2,30}$/;
    var regex_montant = /^[0-18,.]{1,18}$/;
    
    
    if(account_code.length > 70) {
	$('#error_code').html('<div class="alert alert-danger" role="alert"> le nombre de caractÃ¨res du code promo est limitÃ© Ã  70 !</div>');
	$('#account_code').css('border-color', 'red');
	}
	
	
	else if (!regex_montant.test(montant)){
      $('#error_code').html('<div class="alert alert-danger" role="alert"> le montant moins de 16caractères !</div>');
      $('#account_code').css('border-color','red');
	}

 	else{
	     // envoi submit forms_account
	     $('#forms_codeprmo').submit();
	}

 
});

    // traiter 
    
    $('.add_delete_code').click(function()
    {
       var id = $(this).data('id2');
       $('#paks').css('display','block');
       $('.form_validate').css('display','block');
       $('#id_codeeleve').val(id);
       
        
    });
    
});
 
 
 
  