$(document).ready(function(){

    var optionsAJAXFORM = {
        beforeSerialize: function(arr, form, options){
            for(instance in CKEDITOR.instances){
                CKEDITOR.instances[instance].updateElement();
            }
        },
        'success' : treatResponse,
        'dataType' : 'json'
    };

    /**
     * Configuration de ajaxForm (envoie des formulaires en ajax)
     */
    $('form').ajaxForm(optionsAJAXFORM);

    $('.repondreCommentaire').on('click', function(){
        var id_commentaire_parent = $(this).closest('.commentaire').find('.id_commentaire').html();
        var clone = $('form[name=addCommentaire]').parent().clone();
        console.log(clone);
        $(this).closest('.commentaire').append(clone);
        $(clone).find('form').attr('name', 'addCommentaireImbrique');
        $(clone).find('label').attr('for', 'commentaire' + id_commentaire_parent);
        $(clone).find('#commentaire').attr('id', 'commentaire' + id_commentaire_parent);
        $(clone).find('form').append('<input type="hidden" name="id_commentaire_parent" value="' + id_commentaire_parent + '">');
        $(clone).find('form').ajaxForm(optionsAJAXFORM);
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
    else if(form[0].name == "addTechnote")
        treatAddTechnote(data, form);
    else if(form[0].name == "addCommentaire" || form[0].name == "addCommentaireImbrique")
        treatAddCommentaire(data, form);

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
    if(data.success)
        $('#email').attr('placeholder', data.update.email);
}

function treatAddTechnote(data, form){
    if(data.success){
        for(instance in CKEDITOR.instances){
            CKEDITOR.instances[instance].updateElement();
            CKEDITOR.instances[instance].setData('');
        }
    }
}

function treatAddCommentaire(data, form){
    if(data.success){
        $(form[0]).parent().before(data.add.commentaire);
        $(form[0]).parent().prev().find('.repondreCommentaire').remove();
    }
}