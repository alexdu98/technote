$(document).ready(function(){

    /**
     * Configuration de ajaxForm (envoie des formulaires en ajax)
     */
    $('form').ajaxForm({
        'success' : treatResponse,
        'dataType' : 'json'
    });

});

/**
 * Traite le résultat d'un formulaire
 */
function treatResponse(data, status, xhr, form){
    if(data.success){
        if(form[0].name == "connexion"){
            $(location).attr('href', data.message);
        }
        form[0].reset();
    }
    else{
        if(form[0].name == "connexion"){
            $('#badLogin').append(data.message).show();
            form.find('input[type=password]').val('');
        }
        else{

        }
    }
}