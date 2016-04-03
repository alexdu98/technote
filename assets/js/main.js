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

});

/**
 * Traite le résultat d'un formulaire
 */
function treatResponse(data, status, xhr, form){
    var alert = '';
    if(data.success){
        if(form[0].name == "connexion"){
            $(location).attr('href', data.message);
        }
        form[0].reset();
        alert = 'success';
    }
    else{
        if(form[0].name == "connexion"){
            $('#badLogin').append(data.message).show();
            form.find('input[type=password]').val('');
        }
        alert = 'danger';
    }
    var messagesHTML = '';
    $.each(data.msg, function(key, value){
        messagesHTML += '<li>' + value + '</li>'
    });
    $('#messagesResultatAJAX').empty().append(messagesHTML);
    $('#divResultatAJAX').removeClass('alert-success alert-danger').addClass('alert-' + alert).show();
}