  $(document).ready(function(){
    $('#create_pass').click(function() {
     

    var regex_pass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    var email =$('#email').val();
    var token =$('#token').val();
    
    var password =$('#password').val();
    var passwords = $('#password-confirm').val();
    
    if(password.length < 8 )
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> le mot de pass est entre 8 et 12 caractères !</div>');
	    $('#password').css('border-color', 'red');
    }
    
     else if(password.length > 12)
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> le mot de pass est entre 8 et 12 caractères !</div>');
	    $('#password').css('border-color', 'red');
    }
    
    
    else if(passwords.length < 8 )
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> le mot de pass est entre 8 et 12 caractères !</div>');
	    $('#password-confirm').css('border-color', 'red');
    }
    
     else if(passwords.length > 12)
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> la confirmation du mot de pass est compris entre  8 et 12 caractères !</div>');
	    $('#password-confirm').css('border-color', 'red');
    }
    
    
    else if (!regex_pass.test(password)){
      $('#error_password').html('<div class="alert alert-danger" role="alert"> votre mot de pass doit etre composé(1chiffre,une lettre miniscule et majuscule !</div>');
      $('#error_password').css('border-color','red');
	}
	
	
	
	else if (password != passwords){
      $('#error_password').html('<div class="alert alert-danger" role="alert"> les mots de pass ne sont pas égales</div>');
      $('#error_password').css('border-color','red');
	}
	
	else{
	    
	    // envoi forms_password
	    $('#forms_create_password').submit();
	}
    
    
    });
    
    
 
    
    
    // click bouton reset password
$('#update_passw').click(function()
{
     
     var regex = /^[a-zA-Z0-9éèàç]{2,100}(\s[a-zA-Z0-9éèàçà]{2,100}){0,4}$/;	
	var rege =  /^[a-zA-Z0-9-]{0,15}$/;
	var reg_password =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,12}$/;
	var regex_email = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    
    var pass =$('#password').val();
    var pass1 = $('#password-confirm').val();
    var email = $('#emails').val();
    
    if(pass!=pass1)
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> les mots de pass ne sont pas égaux !</div>');
    }
    
    else if(pass.length > 12)
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> le mots de pass doit contenir au plus 12 caractères !</div>');
    }
    
    else if(!reg_password.test(pass))
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> le mot de pass contient au moins 1 chiffre ,lettre majuscule et miniscule !</div>');
    }
    
    else if(!reg_password.test(pass))
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> le mot de pass contient au moins 1 chiffre ,lettre majuscule et miniscule !</div>');
    }
    
    
     else if(!reg_password.test(pass1))
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> le mot de pass contient au moins 1 chiffre ,lettre majuscule et miniscule !</div>');
    }
    
    
     else{
        
        // envoyer ce formualire
        $('#rest_password').submit();
    }
    
});
    
    
    });