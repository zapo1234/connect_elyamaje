
$("#single").select2({
    dropdownParent: $('#exampleModal')
    // 
  });

  $("#users_dropdown").select2({
    //dropdownParent: $('#exampleModal')
    // 
  });

  $( document ).ready(function() {

                

    const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric',
    hour12: false,
    timeZone: 'Europe/Paris'
    };


    csrfToken = $('meta[name="csrf-token"]').attr('content');
    $(".task_execution").on('click', function(){

        $(".select2-container").css("width", "100%");
        $(".select2-container").css("display", "none");
       // $("#task_form").attr('action', $(this).attr('data-url'))
        $("#exampleModal").modal('show')
        $(".spinner_content").hide();
        $(".bouton_content").show();
        

        urlFunction = $(this).attr('data-url');
        actionClick = $(this).attr('action');

        // console.log(actionClick);


        if (actionClick == "CalculPointStatusStatusByUser" || actionClick == "calculPointIndividuel" || actionClick == "updateCadeauxStatutByUser") {
            $(".select2-container").show();
        }
        // Ajouter un gestionnaire d'événements pour le bouton "oui"
        $("#exampleModal #btn-yes").on('click', function() {

            $(".spinner_content").show();
            $(".bouton_content").hide();

            //  console.log(urlFunction);

            if (actionClick == "CalculPointStatusStatusByUser" || actionClick == "calculPointIndividuel" || actionClick == "updateCadeauxStatutByUser") {
                socid = $("#single").val();

                // console.log(socid);
                    $.ajax({
                        url: urlFunction,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data : {socid:socid},
            
                        success: function(response) {

                            // console.log(response);
                            // return;

                            response_tab = JSON.parse(response);
                            // console.log(response_tab);
                            const date = new Date(response_tab.date);
                            const dateEnFrancais = date.toLocaleString('fr-FR', options);
                            const origin = response_tab.origin_action;
                            $("#exampleModal").modal('hide');

                            if (response_tab.succes) {
                                $('#last_execution_'+actionClick).text(dateEnFrancais);
                                $('#statu_'+actionClick).html('<span class="badge bg-success">Réussit</span>');
                                $('#origin_'+actionClick).html('<span class="badge bg-success">'+origin+'</span>');

                                $(".alert-succes-calcul").show();
                                setTimeout(() => {
                                    $(".alert-succes-calcul").hide();
                                }, 4000);
                            }else{
                                $('#last_execution_'+actionClick).text(dateEnFrancais);
                                $('#statu_'+actionClick).html('<span class="badge bg-danger">échouée</span>');
                                $('#origin_'+actionClick).html('<span class="badge bg-danger">'+origin+'</span>');

                                $(".alert-danger-calcul").show();
                                setTimeout(() => {
                                    $(".alert-danger-calcul").hide();
                                }, 4000);
                            }
                            
                        },
                        error: function(xhr, status, error) {
                            console.error(status);

                        }
                    });
            }else{
                    $.ajax({
                        url: urlFunction,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },                       
                        success: function(response) {

                            response_tab = JSON.parse(response);
                            // console.log(response_tab);
                            const date = new Date(response_tab.date);
                            const dateEnFrancais = date.toLocaleString('fr-FR', options);
                            const origin = response_tab.origin_action;
                            $("#exampleModal").modal('hide');

                            if (response_tab.succes) {
                                $('#last_execution_'+actionClick).text(dateEnFrancais);
                                $('#statu_'+actionClick).html('<span class="badge bg-success">Réussit</span>');
                                $('#origin_'+actionClick).html('<span class="badge bg-success">'+origin+'</span>');

                                $(".alert-succes-calcul").show();
                                setTimeout(() => {
                                    $(".alert-succes-calcul").hide();
                                }, 4000);
                            }else{
                                $('#last_execution_'+actionClick).text(dateEnFrancais);
                                $('#statu_'+actionClick).html('<span class="badge bg-danger">échouée</span>');
                                $('#origin_'+actionClick).html('<span class="badge bg-danger">'+origin+'</span>');

                                $(".alert-danger-calcul").show();
                                setTimeout(() => {
                                    $(".alert-danger-calcul").hide();
                                }, 4000);
                            }

                        // console.log(response_tab);
                            
                            
                        },
                        error: function(xhr, status, error) {
                            console.error(status);

                        }
                    });
            }


            $(this).off('click');
        });
    });


  
});  

// edite faq
function editeQuestion(id_question){
    $("#question_"+id_question).removeAttr("disabled");
}

function editeResponse(id_response){
    $("#reponse_"+id_response).removeAttr("disabled");
}
// delete

function deleteQuestionReponse(id){

    $("#modalConfirmationDeletQ").attr("data-id", id);
    $("#exampleModal").modal('show')

}
function deleteQR(){

    id = $("#modalConfirmationDeletQ").attr('data-id');
    urlFunctionDelet = $("#routeDeleteQR").val();
    elementPrent = document.getElementById('element_parent_'+id);

    $.ajax({
        url: urlFunctionDelet,
        method: 'POST',
        data:{id:id},
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },                       
        success: function(response) {

            console.log(response);

            if (response) {
                elementPrent.remove();
            }
            $("#exampleModal").modal('hide');

        },
        error: function(xhr, status, error) {
            console.error(status);

        }
    });

}

$(document).ready(function() {

    multip = 1;
    if (/Mobi|Android/i.test(navigator.userAgent)) {
        multip = 3.5;
    } else {
            multip = 1;
    }

    $('.text_area').each(function(index, element) {
    var rows = element.value.split('\n').length*multip;

    $(element).attr('rows', rows);
    console.log(rows);
    });
});


