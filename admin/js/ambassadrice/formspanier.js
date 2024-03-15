$(document).ready(function(){


  var cont = 0;
$(document).on('click','.add_panier', function(){
  var html = '';
 cont = cont +1;
 if(cont < 11){
 html += '<tr class="dir" id ="row_id_'+cont+'">';
 html += '<td><input type="text" class="form-control nom"  name="nom[]"  ></td>';
 html +='<td><input type="text" class=" form-control prenom"  name="prenom[]"  ></td>';
 html +='<td><input type="email" class="form-control email"  name="email[]" ></td>';
 html +='<td class="numero"><input type="text" class="form-control phone"  name="phone[]"  required></td>';
 
 html +='<td class="adresse"><input type="text" class="form-control adresse"  name="adresse[]" placeholder="Adresse"></td>';
 
 html +='<td><button class="remove" name="remove" id="'+cont+'"><i class="bx bxs-box" style="font-size:15px"></i> </button></td>';
 html +='</tr>';
$('#add').append(html);

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
  
  
 
 
 
});
  