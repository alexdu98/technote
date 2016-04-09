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
        $(this).closest('.commentaire').append(clone);
        $(clone).find('form').attr('name', 'addCommentaireImbrique');
        $(clone).find('label').attr('for', 'commentaire' + id_commentaire_parent);
        $(clone).find('#commentaire').attr('id', 'commentaire' + id_commentaire_parent);
        $(clone).find('form').append('<input type="hidden" name="id_commentaire_parent" value="' + id_commentaire_parent + '">');
        $(clone).find('form').ajaxForm(optionsAJAXFORM);
        $(this).remove();
    });

    $('.modifierCommentaire').on('click', editCommentaireForm);

    $("[data-hide]").on("click", function(){
        $("." + $(this).attr("data-hide")).hide();
    });

    /**
     * Affiche le formulaire de modification d'un commentaire
     */
    function editCommentaireForm(){
        var id_commentaire = $(this).closest('.commentaire').find('.id_commentaire').html();
        var clone = $('form[name=addCommentaire]').parent().clone();
        var texte = $(this).closest('.commentaire').find('.texteCommentaire').html().replace(/<br>/, '');
        $(this).closest('.container-fluid').after(clone);
        $(clone).find('form #commentaire').text(texte);
        $(clone).find('form').attr('action', '/commentaires/edit/' + id_commentaire);
        $(clone).find('form').attr('name', 'editCommentaire');
        $(clone).find('form input[type=submit]').attr('value', 'Modifier');
        $(clone).find('form').ajaxForm(optionsAJAXFORM);
        $(this).hide();
    }

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
        else if(form[0].name == "editCommentaire")
            treatEditCommentaire(data, form);

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

    function treatEditCommentaire(data, form){
        if(data.success){
            $(form[0]).closest('.commentaire').find('.texteCommentaire:first').replaceWith(data.edit.commentaire.commentaire);
            if($(form[0]).parent().prev().find('.infosModificaton').length > 0)
                $(form[0]).parent().prev().find('.infosModificaton').remove();
            $(form[0]).parent().prev().find('.dateCommentaire').append('<span class="glyphicon glyphicon-pencil infosModificaton" aria-hidden="true" title="modifié par ' + data.edit.commentaire.modificateur + ' le ' + data.edit.commentaire.date_modification + '"></span>');
            $(form[0]).parent().prev().find('.modifierCommentaire').show();
            $(form[0]).remove();
        }
    }

});