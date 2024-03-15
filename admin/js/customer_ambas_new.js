$(document).ready(function(){

  var cont = 0;
$(document).on('click','#add_customer', function(){
  var html = '';
 cont = cont +1;
 if(cont < 11){
 html += '<tr class="dir" id ="row_id_'+cont+'">';
 html += '<td><input type="text" class="form-control nom"  name="nom[]"  placeholder="Nom" required></td>';
 html +='<td><input type="text" class=" form-control prenom"  name="prenom[]" placeholder="Prénom" required></td>';
 html +='<td><input type="email" class="form-control email"  name="email[]" placeholder="Email-client"/></td>';
 html +='<td class="numero"><input type="text" class="form-control phone"  name="phone[]" placeholder="Numéro de tel" required></td>';
 
 html +='<td class="adresse"><input type="text" class="form-control adresse"  name="adresse[]" placeholder="Adresse"></td>';
 
 html +='<td><button class="remove" name="remove" id="'+cont+'"><i class="bx bxs-box" style="font-size:15px"></i> </button></td>';
 html +='</tr>';
$('#add').append(html);

}

});


  var conts = 0;
$(document).on('click','#add_panier', function(){
  var html = '';
 conts = conts +1;
 if(conts < 11){
 html += '<tr class="dir" id ="row_id_'+conts+'">';
 html += '<td><input type="text" class="form-control nom"  name="panier[]" ></td>';
 html +='<td><input type="text" class=" form-control prenom"  name="montant_mini[]"></td>';
 html +='<td><input type="email" class="form-control email"  name="montant_max[]"></td>';
 html +='<td class="numero"><input type="text" class="form-control phone"  name="proctus[]"></td>';
 
 html +='<td><button class="remove" name="remove" id="'+cont+'"><i class="bx bxs-box" style="font-size:15px"></i> </button></td>';
 html +='</tr>';
$('#adds').append(html);

}

});


 $(document).on('click','.remove', function(){
   $(this).closest('tr').remove();
  
  });
  
  $('#nom1').keyup(function()
  {
      var nom =$('#nom1').val();
      $('#der1').text(nom);
      $('#der0').text(nom);
      
  });
  
  
   $('#nom2').keyup(function()
  {
      var nom =$('#nom2').val();
      $('#der2').text(nom);
      $('#der3').text(nom);
      
  });
  
   $('#nom3').keyup(function()
  {
      var nom =$('#nom3').val();
      $('#der4').text(nom);
      $('#der5').text(nom);
      
  });
  
   $('#nom4').keyup(function()
  {
      var nom =$('#nom4').val();
      $('#der6').text(nom);
      $('#der7').text(nom);
      
  });
  
  
   $('#nom5').keyup(function()
  {
      var nom =$('#nom5').val();
      $('#der8').text(nom);
      $('#der9').text(nom);
      
  });
  
  
  $(document).on('click', '#create_customer_amba', function()
  {
     
     var regex = /^[a-zA-Z0-9éèàç]{2,100}(\s[a-zA-Z0-9éèàçà]{2,100}){0,4}$/;	
	var rege =  /^[a-zA-Z0-9-]{0,15}$/;
	var reg =   /^[+0-9]{0,15}$/;
	var email = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
	
	$('.nom').each(function() {
	 
	 if($(this).val().length >150){
		$('#erros').html(' le champ du nom à moins de 150 caractères');
	 }
	 
	 else if($(this).val().length==0){
		$('#erros').html('le champs du nom est vide');
	 }
	 
	else if (!regex.test($(this).val())){
      $('#erros').html('Erreur de syntaxe pour le nom');
    }
	
	else{
	     
	      $('#erros').html('');
	
     	}
     	
     });
	
	

     
     $('.prenom').each(function() {
	 
	 if($(this).val().length >150){
		$('#erros_prenom').html(' le champ du prénom à  au moins de 150 caractères');
	 }
	 
	else if (!regex.test($(this).val())){
      $('#erros_prenom').html('Erreur de syntaxe pour le  prénom');
    }
	
	else{
	     
	      $('#erros_prenom').html('');
	
     	}
     	
     });
     
     
     
     
     $('.email').each(function() {
	 
	 if($(this).val().length >70){
		$('#erros_email').html(' le champ du email à moins de 70 caractères');
	 }
	 
	  else if($(this).val().length==0){
		$('#erros_email').html('le champs de email est vide');
	 }
	 
	else if (!email.test($(this).val())){
      $('#erros_email').html('Erreur de syntaxe pour l\'email');
    }
	
	else{
	     
	      $('#erros_email').html('');
	
     	}
     	
     });
     
     
    
     
     var erreur1 =$('#erros').text();
     var erreur2 =$('#erros_prenom').text();
     var erreur3 = $('#erros_email').text();
     var erreur4 =$('#erros_adresse').text();
     var erreur5 = $('#errors_phone').text();
     
     
     if(erreur1=="" && erreur2=="" && erreur3=="")
     {
         // envoi du email
         // affiche des spinner en attente du script
         $('#pakss').css('display','block');
         $('.spiner').css('display','block');
         $('#forms_ambassadrice_customers').css('display','none');
         $('#forms_ambassadrice_customers').submit();
     }
     
     
     
  });
  
  
  $('#envoyer1').click(function(){
      
      var search = $('#search_name').val();
      
      if(search.length > 0)
      {
          $('#pakss').css('display','block');
         $('.spiners').css('display','block');
         
         // envoi du formulaire
         $('#form_search_learn').submit();
          
        }
      
       
      
  });
  
  
  $('#envoyer2').click(function(){
      
      var search = $('#search_name').val();
      
      if(search.length > 0)
      {
          $('#pakss').css('display','block');
         $('.spiner').css('display','block');
         
         // envoi du formulaire
         $('#form_search_learn1').submit();
          
        }
      
       
      
  });
  
  
  
  // envoi forms create customer mobile amabassadrice
  
   $(document).on('click', '#creates_customer_amba', function()
  {
     
     var regex = /^[a-zA-Z0-9éèàç]{2,100}(\s[a-zA-Z0-9éèàçà]{2,100}){0,4}$/;	
	var rege =  /^[a-zA-Z0-9-]{0,15}$/;
	var reg =   /^[+0-9]{0,15}$/;
	var email = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
	var nom =$('#nom1').val();
	var emails = $('#email1').val();
	var prenom = $('#prenom1').val();
	var phone =$('#phone1').val();
	
	if(nom.length==0)
	{
	    $('#required_champ').html('au moins un  nom client est obligatoire');
	}
	
	else{
	    $('#required_champ').html('');
	}
	
	if(emails.length==0)
	{
	    $('#required_champ1').html('au moins un email client est obligatoire');
	}
	
	else{
	     $('#required_champ1').html('');
	}
	
	
	
	
	$('.nom').each(function() {
	 
	 if($(this).val().length >150){
		$('#erross').html(' le champ du nom à moins de 150 caractères');
	 }
	 
	 
	else if (!regex.test($(this).val()) && $(this).val().length!=0){
      $('#erross').html('Erreur de syntaxe pour le nom');
    }
	
	else{
	     
	      $('#erross').html('');
	
     	}
     	
     });
	
	
     
     $('.prenom').each(function() {
	 
	 if($(this).val().length >150){
		$('#erros_prenoms').html(' le champ du prénom à  au moins de 150 caractères');
	 }
	 
	else if (!regex.test($(this).val()) && $(this).val().length!=0){
      $('#erros_prenoms').html('Erreur de syntaxe pour le  prénom');
    }
	
	else{
	     
	      $('#erros_prenoms').html('');
	
     	}
     	
     });
     
     
     
     
     $('.email').each(function() {
	 
	 if($(this).val().length >70){
		$('#erros_emails').html(' le champ du email à moins de 70 caractères');
	 }
	 
	 
	else if (!email.test($(this).val()) && $(this).val().length!=0 ){
      $('#erros_emails').html('Erreur de syntaxe pour l\'email');
    }
	
	else{
	     
	      $('#erros_emails').html('');
	
     	}
     	
     });
     
     
     
     
     var erreur1 =$('#erross').text();
     var erreur2 =$('#erros_prenoms').text();
     var erreur3 = $('#erros_emails').text();
     var erreur4 =$('#erros_adresses').text();
     var erreur5 = $('#errors_phones').text();
     var erreur_r = $('#required_champ').text();
     var erreur_r1 = $('#required_champ1').text();
     var erreur_r2 = $('#required_champ2').text();
     
     if(erreur1=="" && erreur2=="" && erreur3==""  && erreur_r=="" && erreur_r1=="" && erreur_r2=="")
     {
         // envoi du email
          // envoi du email
         // affiche des spinner en attente du script
         $('#pakss').css('display','block');
         $('.spiner').css('display','block');
         $('#forms_ambassadrice_customer').css('display','none');
         $('#forms_ambassadrice_customer').submit();
     }
     
     
     
  });
  
  
  $('#submit_customer_edit').click(function() {
 
 var regex_name = /^[a-zA-Z0-9éèç]{2,50}(\s[a-zA-Z0-9]{2,25}){0,50}$/;
 var regex_username = /^[a-zA-Z0-9-éèç]{2,25}(\s[a-zA-Z0-9-]{2,25}){0,3}$/;
 var regex_accountcodep = /^[0-9]{5}$/;
 var regex_phone  = /^[+0-9]{8,14}$/;
 var email = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
 
// on recupére les variables
var account_name =$('#account_name').val();
var account_username =$('#account_username').val();
var account_address = $('#account_address').val();
var account_phone = $('#account_phone').val();
var account_codep =$('#account_codep').val();
var account_email =$('#account_email').val();


 if(account_name.length > 150) {
	$('#error_name').html('<div class="alert alert-danger" role="alert"> le nombre de caractères du nom est limité à 70 !</div>');
	$('#account_name').css('border-color', 'red');
	}
	
	else if(account_name.length==0) {
	$('#error_name').html('<div class="alert alert-danger" role="alert"> le nom du client est vide !</div>');
	}
	
	
	else if(account_username.length > 150){
	$('#error_username').html('<div class="alert alert-danger" role="alert"> le nombre de caractères du prénoms est limité à 70 !</div>');

	 }
	
	else if(account_username.length == 0){
	$('#error_username').html('<div class="alert alert-danger" role="alert"> le nombre de caractères du prénoms est vide</div>');
	$('#account_name').css('border-color', 'red');
	    
	}
	
	else if(account_email.length > 80){
	$('#error_email').html('<div class="alert alert-danger" role="alert"> le nombre de caractères de l\'email est trop long</div>');
	$('#account_email').css('border-color', 'red');
	    
	}
	
	
		else if (!email.test(account_email)){
      $('#error_email').html('<div class="alert alert-danger" role="alert"> la syntaxe de l\'adresse email est incorrecte</div>');
      $('#account_email').css('border-color','red');
	}
	
	
	else if (!regex_accountcodep.test(account_codep) && account_codep!=""){
      $('#error_codep').html('<div class="alert alert-danger" role="alert"> le code postal est de 5 chiffres !</div>');
      $('#account_codep').css('border-color','red');
	}
	
	else if (!regex_phone.test(account_phone) && account_phone !=""){
      $('#error_phone').html('<div class="alert alert-danger" role="alert"> le numéro de télephone est entre 10 et 14 caractères !</div>');
      $('#account_phone').css('border-color','red');
	}
	
	else if (account_address.length > 100 && account_adress!=""){
      $('#error_address').html('<div class="alert alert-danger" role="alert"> le nombre de caractères de l\'adresse postal est limité à 100 !</div>');
      $('#account_address').css('border-color','red');
	}
	
	else{
	    
	    // envoi submit forms_account
	    $('#forms_ambassadrice_edit').submit();
	}

 
});

// mobile

$('#submits_customer_accounts').click(function() {
 
 var regex_name = /^[a-zA-Z0-9]{2,25}(\s[a-zA-Z0-9]{2,25}){0,4}$/;
 var regex_username = /^[a-zA-Z0-9-]{2,25}(\s[a-zA-Z0-9-]{2,25}){0,3}$/;
 var regex_accountcodep = /^[0-9]{5}$/;
 var regex_phone  = /^[+0-9]{8,14}$/;
 var regex_email = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
 
// on recupére les variables
var account_name =$('#account_na').val();
var account_username =$('#account_userna').val();
var account_ville = $('#account_vill').val();
var account_address = $('#account_addres').val();
var account_phone = $('#account_phon').val();
var account_codep =$('#account_cod').val();
var account_email = $('#account_emai').val();


 if(account_name.length > 150) {
	$('#error_na').html('<div class="alert alert-danger" role="alert"> le nombre de caractères du nom est limité à 70 !</div>');
	$('#account_na').css('border-color', 'red');
	
	}
	
	
	else if(account_username.length > 150){
	$('#error_userna').html('<div class="alert alert-danger" role="alert"> le nombre de caractères du prénoms est limité à 70 !</div>');
	$('#account_na').css('border-color', 'red');
		
	    
	}
	
	else if(account_email.length > 80){
	$('#error_userna').html('<div class="alert alert-danger" role="alert"> le nombre de caractères de l\'email est limité à 80 !</div>');
	$('#account_emai').css('border-color', 'red');
		
	 }
	 
	 else if (!regex_email.test(account_email)){
      $('#error_cod').html('<div class="alert alert-danger" role="alert"> la syntaxe de l\'email est incorrecte !</div>');
      $('#account_emai').css('border-color','red');
      	
	}
	 
	 
	
	else if (!regex_accountcodep.test(account_codep) && account_codep!=""){
      $('#error_cod').html('<div class="alert alert-danger" role="alert"> le code postal est de 5 chiffres !</div>');
      $('#account_cod').css('border-color','red');
      	
	}
	
	else if (!regex_phone.test(account_phone) && account_phone!=""){
      $('#error_phon').html('<div class="alert alert-danger" role="alert"> le numéro de télephone est entre 10 et 14 caractères !</div>');
      $('#account_phon').css('border-color','red');
      	
	}
	
	else if (account_address.length > 100 && account_address!=""){
      $('#error_addres').html('<div class="alert alert-danger" role="alert"> le nombre de caractères de l\'adresse postal est limité à 150 !</div>');
      $('#account_addres').css('border-color','red');
      	
	}
	
	else{
	    
	    // envoi submit forms_account
	    $('#forms_ambassadrice_edits').submit();
	}

 

});

  // click menu
  
  $('.btns').click(function()
  {
     $('#menu_mobile').show(300);
     $('.btns').css('display','none');
     // afficher le delete div
     $('.btnc').css('display','block');
     
    
  
 });
 
 
  $('.btnc').click(function()
  {
     $('#menu_mobile').hide(300);
     $('.btns').css('display','block');
     // afficher le delete div
     $('.btnc').css('display','none');
    
  
 });
 
 
 $(document).on('change','#account_type',function(){
	
	
	var type = $('#account_type').val(); 
	var result="Ambassadrice";

	
	if(type =="Ambassadrice")
	{
	   $('#live').html('<label for="inputPassword4">Code-live </label><input type="text" name="code_live" class="form-control" id="code_live">');
	}
	
	else{
	    
	    $('#live').html('<input type="hidden" name="code_live" class="form-control" id="code_live" value="">');
	}
	 
	 
 });
 
 
 
 
 $(document).on('change','#account_ty',function(){
	
	
	var type = $('#account_type').val(); 
	var result="Ambassadrice";

	
	if(type =="Ambassadrice")
	{
	   $('#live1').html('<label for="inputPassword4">Code-live </label><input type="text" name="code_live" class="form-control" id="code_live1">');
	}
	
	else{
	    
	    $('#live1').html('<input type="hidden" name="code_live" class="form-control" id="code_live1" value="">');
	}
	 
	 
 });
 
 
  $(document).on('change','#search_date',function(){
	
	
	var id_date = $('#search_date').val(); 
	
	var date="";
	
	var array_date = ['janvier','février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'];
	
	if(id_date ==1){
	    var date ="Janvier";
	}
	
	else if(id_date ==2)
	{
	   var date="Février";
	}
	
	else if(id_date ==3)
	{
	    var date ="Mars";
	}
	
	else if(id_date == 4)
	{
	    var date ="Avril";
	}
	
	else if(id_date == 5)
	{
	    var date ="Mai";
	}

    else if(id_date ==6)
	{
	    var date ="Juin";
	}
	
	else if(id_date == 7)
	{
	    var date ="Juillet";
	}
	
	else if(id_date == 8)
	{
	   var date ="Aout";
	}
	
	
	else if(id_date ==9)
	{
	   var date ="Septembre";
	}
	
	else if(id_date == 10)
	{
	    var date ="Octobre";
	}
	
	else if(id_date == 11)
	{
	   var date ="Novembre";
	}
	
	else if(id_date == 12)
	{
	    var date ="Décembre";
	}
	else{
	    var date ="Aucune";
	}

    // recupérer dans id ajout_date le contenu
	$('#adjoutdate').html('Mois ' +date);
	 
	 
 });
 
 
$('#submit_codepromo').click(function()
{
    
   var account_promo = $('#account_promo').val();
   var account_montant =$('#account_montant').val();
   var ref_facture = $('#ref_facture').val();
   
   var regex_name = /^[a-zA-Z0-9-]{2,25}$/;
   var regex_montant  = /^[0-9.,]{2,16}$/;
   var regex_dolibar = /^[TCF][A-Z0-9a-z-]{2,25}$/;
   
   if(account_promo.length > 50)
   {
        $('#error_promo').html('<div class="alert alert-danger" role="alert">le nombre de caractères du code promo est moins de 16 !</div>');
      
   }
   
   else if(account_montant.length > 16)
   {
        $('#error_montant').html('<div class="alert alert-danger" role="alert"> le nombre de caractère du montant est moins de 16 !</div>');
      
   }
   
   else if(ref_facture.length > 30)
   {
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


// click bouton reset password
$('#update_password').click(function()
{
     var regex = /^[a-zA-Z0-9éèàç]{2,100}(\s[a-zA-Z0-9éèàçà]{2,100}){0,4}$/;	
	var rege =  /^[a-zA-Z0-9-]{0,15}$/;
	var reg_password =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,12}$/;
	var regex_email = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    
    var pass =$('#password').val();
    var pass1 = $('#password_confirmation').val();
    var email = $('#emails').val();
    
    if(pass != pass1)
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> la confirmation du mot de pass n\'est pas égal !</div>');
    }
    
    else if((!reg_password.test(pass)))
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> la confirmation du mot de pass n\'est pas égal !</div>');
    }
    
    else if((!reg_password.test(pass1)))
    {
        $('#error_password').html('<div class="alert alert-danger" role="alert"> la confirmation du mot de pass n\'est pas égal !</div>');
    }
    
     else if((!regex_email.test(email)))
    {
        $('#email_erros').html('<div class="alert alert-danger" role="alert"> la syntaxe du mail n\'est pas correcte !</div>');
    }
    
    
    else{
        
        // envoyer ce formualire ....!
        $('#form_reset').submit();
    }
    
});




 $('.add_contact').click(function()
  {
    $('.pask').css('display','block');
    $('.form_add').css('display','block');
 });
 
 
 $('.add_mobile').click(function()
  {
    $('.pask').css('display','block');
    $('.form_add').css('display','block');
 });
 
 
  $('.pask').click(function()
  {
    $('.pask').css('display','none');
    $('.form_add').css('display','none');
 });
 
   
 

 $('.view_vente').click(function()
  {
     $('#pak').css('display','block');
     $('#table_vente').css('display','block');
 });
 
 
 // notification 
 $('.alert-count').click(function()
 {
     var id = $(this).data('id2');
      // lacner la requete Ajax
      var token = $("meta[name='csrf-token']").attr("content");
     
      $.ajax(
    {
        url: "/notifications/"+id,
        type: 'DELETE',
        data: {
            "id": id,
            "_token": token,
        },
        success: function (data){
            
            $('#dd').html(data);
            $('.alert-count').css('display','none');
            
        }
    });
    
 });
 
 
 // lancer une fonction ajax qui suprime 
 
 $(document).on('click','.paimentim', function(){
     
     $('#paks').css('display','block');
     $('.form_validate').css('display','block');
     var id2 = $(this).data('id2');
      var name = id2.split(',');
      $('#nommer').text('N°'+name[0]+' appartenant à '+name[1]);
      
      $('#id_facture').val(name[0]);
      $('#is_admin').val(name[2]);
      $('#montant').val(name[3]);
      $('#id_ambassadrice').val(name[4]);
      $('#email_user').val(name[5]);
      $('#mois').val(name[6]);
      $('#annee').val(name[7]);
      $('#name_user').val(name[1]); 
      
       $(document).on('click','.validate', function(){
           
           var id = $('#id_facture').val();
           
            var token = $("meta[name='csrf-token']").attr("content");
           
           // lancer la requete Ajax ...
           
        $.ajax(
      {
        url: "/invoices/pay/",
        type: "POST",
        data: {
            id: id,
            _token: _token,
        },
        success: function (data){
            
            alert('zapo');
            $('#message').html(data);
            $('#paks').css('display','none');
        }
    });
    
     setInterval(function(){
		 $('#message').html('');
		 location.reload(true);
	 },4000);


    });
    
 });
 
 
 
 
 $(document).on('click','.validerbonim', function(){
     
     $('#paks').css('display','block');
     $('.form_bonachat').css('display','block');
     var id3 = $(this).data('id3');
      var name = id3.split(',');
      $('#nommers').text('N°'+' appartenant à '+name[1]);
      
      $('#id_facturees').val(name[0]);
      $('#is_admins').val(name[2]);
      $('#montants').val(name[3]);
      $('#id_ambassadrices').val(name[4]);
      $('#email_users').val(name[5]);
      $('#name_users').val(name[1]); 
      
       $(document).on('click','.validate', function(){
           
           var id = $('#id_facturees').val();
           
            var token = $("meta[name='csrf-token']").attr("content");
           
           // lancer la requete Ajax ...
           
        $.ajax(
      {
        url: "/invoicescars/pay/",
        type: "POST",
        data: {
            id: id,
            _token: _token,
        },
        success: function (data){
            
            alert('zapo');
            $('#message').html(data);
            $('#paks').css('display','none');
        }
    });
    
     setInterval(function(){
		 $('#message').html('');
		 location.reload(true);
	 },4000);


    });
    
 });
 
 
 
 $(document).on('click','.annulerf', function(){
     
     $('#paks').css('display','block');
     $('.form_validates').css('display','block');
     var id2 = $(this).data('id2');
      var name = id2.split(',');
      $('#nommers').text('N°'+name[0]+' appartenant à '+name[1]);
      
      $('#id_factures').val(name[0]);
      $('#id_ambassadricess').val(name[4]);
      $('#montantss').val(name[3]);
      
       $(document).on('click','.validates', function(){
           
           var id = $('#id_factures').val();
           var id_ambassadrice = $('#id_ambassadricess').val();
           var montantss = $('#montantss').val();
           
            var token = $("meta[name='csrf-token']").attr("content");
           
           // lancer la requete Ajax ...
           
        $.ajax(
      {
        url: "/invoices/pays/",
        type: "POST",
        data: {
            id: id,
            _token: _token,
        },
        success: function (data){
            
            $('#message').html(data);
            $('#paks').css('display','none');
        }
    });
    
     setInterval(function(){
		 $('#message').html('');
		 location.reload(true);
	 },4000);


    });
    
 });
 
 
 $('.annuler').click(function(){
 
  $('#paks').css('display','none');
     $('.form_validate').css('display','none');
     $('.form_validates').css('display','none');
     $('.form_validateactive').css('display','none');
      $('.form_bonachat').css('display','none');
 });
 
 
 $('#paks').click(function(){
 
  $('#paks').css('display','none');
     $('.form_validate').css('display','none');
      $('.form_validates').css('display','none');
      $('.form_bonachat').css('display','none');
 
 });
 
 
 $('.nvgreen2').click(function()
 {
    if(!$(".nvgreen2").hasClass('loading')){
        $('#form_activelive').submit();
        var loader = `<div style="width:1.4rem; height:1.4rem" class="spinner-border text-light" role="status"> <span class="visually-hidden">Loading...</span></div>`
        $(".nvgreen2 span").remove()
        $(".lni-instagram-original").remove()
        $(".nvgreen2").addClass('loading')
        $(".nvgreen2").append(loader)
    }
 });

 
 $('#search-addon').click(function()
 {
     
     $('#search_amba').submit();
     
 });
 
 $('#search_name').on('keyup', function(){
    search();
});
search();
function search(){
     var search = $('#search_name').val();

     if(search){
        $.post('{{ route("ambassadrice.search") }}',
        {
           _token: $('meta[name="csrf-token"]').attr('content'),
           search:search
         },
         function(data){
          table_post_row(data);
            console.log(data);
         });
     }
   
}
// table row with ajax
function table_post_row(res){
let htmlView = '';
if(res.employees.length <= 0){
    htmlView+= `
       <tr>
          <td colspan="4">No data.</td>
      </tr>`;
}
for(let i = 0; i < res.employees.length; i++){
    htmlView += `
        <tr>
           <td>`+ (i+1) +`</td>
              <td>`+res.employees[i].nom+`</td>
               <td>`+res.employees[i].prenom+`</td>
        </tr>`;
}
     $('tbody').html(htmlView);
}
 
 // Wrap every letter in a span
var textWrapper = document.querySelector('.nvlivereel12');
if(textWrapper){
    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
}

anime.timeline({loop: true})
  .add({
    targets: '.nvlivereel12 .letter',
    scale: [4,1],
    opacity: [0,1],
    translateZ: 0,
    easing: "easeOutExpo",
    duration: 200,
    delay: (el, i) => 70*i
  }).add({
    targets: '.code1',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 4000
  });
  
  
//   window.addEventListener('beforeunload', function (e) { 
//         e.preventDefault(); 
//         e.returnValue = ''; 
        
//         //on se deconnecte
//         $('#logout_form').submit();
//     }); 
 
 
});
  