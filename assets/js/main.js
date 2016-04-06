$(document).ready(function(){

    var optionsAJAXFORM = {
        'success' : treatResponse,
        'dataType' : 'json'
    };

    /**
     * Configuration de ajaxForm (envoie des formulaires en ajax)
     */
    $('form').ajaxForm(optionsAJAXFORM);

    $('.repondreCommentaire').on('click', function(){
        var id_commentaire_parent = $(this).closest('.commentaire').find('.id_commentaire').html();
        var form = $('form[name=commentaire]').clone().attr('name', 'commentaire' + id_commentaire_parent);
        $(this).closest('.row').append(form);
        $(form).append('<input type="hidden" name="id_commentaire_parent" value="' + id_commentaire_parent + '">');
        $(form).ajaxForm(optionsAJAXFORM);
        $(this).remove();
    });

    $("[data-hide]").on("click", function(){
        $("." + $(this).attr("data-hide")).hide();
    });

});

/**
 * Traite le résultat d'un formulaire
 */
function treatResponse(data, status, xhr, form){

    // S'il y a un ordre de redirection, redirection
    $(location).attr('href', data.redirect);

    // S'il y avait un captcha on le reset
    if($(form[0]).find('.g-recaptcha').length)
        grecaptcha.reset();

    // Traitement du résultat de la requête AJAX
    if(form[0].name == "connexion") {
        treatConnexion(data, form);
        return;
    }
    else if(form[0].name == "updateEmail")
        treatUpdateEmail(data, form);

    // Traiment générique selon si c'est un succès ou un échec
    var alert = '';
    if(data.success){
        form[0].reset();
        alert = 'success';
    }
    else{
        alert = 'danger';
    }

    // Construit la liste des messages
    var messagesHTML = '';
    $.each(data.msg, function(key, value){
        messagesHTML += '<li>' + value + '</li>'
    });

    // Affiche les messages
    $('#messagesResultatAJAX').empty().append(messagesHTML);
    $('#divResultatAJAX').removeClass('alert-success alert-danger').addClass('alert-' + alert).show();
}

function treatConnexion(data, form){
    if(data.success){

    }
    else{
        $('#badLogin').empty().append(data.message).show();
        form.find('input[type=password]').val('');
    }
}

function treatUpdateEmail(data, form){
    $('#email').attr('placeholder', data.update.email);
}