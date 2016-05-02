$(document).ready(function(){

    // ############################################
    // ################# AJAXFORM #################
    // ############################################

    // Configuration de AjaxForm
    var optionsAJAXFORM = {
        // Avant de récupérer le contenu des champs du formulaire
        beforeSerialize: function(arr, form, options){
            for(instance in CKEDITOR.instances){
                // On met à jour les champs de type CKEDITOR
                CKEDITOR.instances[instance].updateElement();
            }
        },
        // Quand la réponse Ajax sera reçu, on appelle ce callback
        'success' : treatResponse,
        // La réponse Ajax est de type JSON
        'dataType' : 'json'
    };

    // Tous les formulaires sans la classe noAjax seront en Ajax
    $('form:not(.noAjax)').ajaxForm(optionsAJAXFORM);


    // ############################################
    // ################# TECHNOTES ################
    // ############################################

    $('#modifierTechnote').on('click', function(){
        // On redirige sur la bonne page
        $(location).attr('href', '/technotes/edit/' + $(this).attr('data-id_technote'));
    });
    $('#supprimerTechnote').on('click', function(){
        // On redirige sur la bonne page
        $(location).attr('href', '/technotes/drop/' + $(this).attr('data-id_technote'));
    });

    function treatAddTechnote(data, form){
        if(data.success){
            for(instance in CKEDITOR.instances){
                CKEDITOR.instances[instance].updateElement();
                CKEDITOR.instances[instance].setData('');
            }
        }
    }
    function treatDropTechnote(data, form){
        $('#dropTechnoteConfirmModal').modal('hide');
        var messages = $('#divResultatAJAX').detach().show();
        $('h1').after(messages);
    }


    // ############################################
    // ############### COMMENTAIRES ###############
    // ############################################

    $('.repondreCommentaire').on('click', addCommentaireForm);
    $('.modifierCommentaire').on('click', editCommentaireForm);
    $('.supprimerCommentaire').on('click', dropCommentaireForm);

    function addCommentaireForm(){
        if($(this).closest('.commentaire').children('.margeTop').length == 0){
            // On récupère l'id du commentaire parent
            var id_commentaire_parent = $(this).closest('.commentaire').find('.id_commentaire').html();

            // On copie le formulaire déjà présent et on le modifie
            var clone = $('form[name=addCommentaire]').parent().clone();

            // On modifie la copie du formulaire
            $(clone).find('form').attr('name', 'addCommentaireImbrique');
            $(clone).find('label').attr('for', 'commentaire' + id_commentaire_parent);
            $(clone).find('#commentaire').attr('id', 'commentaire' + id_commentaire_parent);
            $(clone).find('form').append('<input type="hidden" name="id_commentaire_parent" value="' + id_commentaire_parent + '">');

            // On affiche le formulaire
            $(this).closest('.commentaire').append(clone).find('form[name=addCommentaireImbrique]').parent().hide().slideToggle(400);

            // On ajoute l'auditeur d'événement AjaxForm sur ce nouveau formulaire
            $(clone).find('form').ajaxForm(optionsAJAXFORM);
        }
        else{
            $(this).closest('.commentaire').children('.margeTop').toggle(400);
        }
    }
    function editCommentaireForm(){
        if($(this).closest('.container-fluid').find('form[name=editCommentaire]').length == 0){
            // On récupère l'id du commentaire
            var id_commentaire = $(this).closest('.commentaire').find('.id_commentaire').html();

            // On clone le formulaire déjà présent
            var clone = $('form[name=addCommentaire]').parent().clone();

            // On modifie la copie du formulaire
            $(clone).find('form').attr('action', '/commentaires/edit/' + id_commentaire);
            $(clone).find('form').attr('name', 'editCommentaire');
            $(clone).find('form input[type=submit]').attr('value', 'Modifier');

            // On affiche le formulaire
            $(this).closest('.container-fluid').append(clone).find('form[name=editCommentaire]').parent().hide().slideToggle(400);

            // On ajoute l'auditeur d'événement AjaxForm sur ce nouveau formulaire
            $(clone).find('form').ajaxForm(optionsAJAXFORM);
        }
        else{
            $(this).closest('.container-fluid').find('form[name=editCommentaire]').parent().toggle(400);
        }
        // On récupère le texte actuel du commentaire
        var commentaire = $(this).closest('.commentaire').find('.texteCommentaire:first').html();
        var texte = $('<div>').html(commentaire).text();
        $(this).closest('.container-fluid').find('form #commentaire').text(texte);
    }
    function dropCommentaireForm(){
        $(this).next().ajaxSubmit(optionsAJAXFORM);
    }

    function treatAddCommentaire(data, form){
        if(data.success){
            if($(form[0]).attr('name') == 'addCommentaireImbrique')
                $(form[0]).parent().slideToggle(400);
            $(form[0]).parent().before(data.add.commentaire);
            $(form[0]).parent().prev().find('.repondreCommentaire').on('click', addCommentaireForm);
            $(form[0]).parent().prev().find('.modifierCommentaire').on('click', editCommentaireForm);
            $(form[0]).parent().prev().find('.supprimerCommentaire').on('click', dropCommentaireForm);
        }
    }
    function treatEditCommentaire(data, form){
        if(data.success){
            $(form[0]).closest('.commentaire').find('.texteCommentaire:first').html(data.edit.commentaire.commentaire);
            // On récupère le texte actuel du commentaire
            var texte = $(form[0]).closest('.commentaire').find('.texteCommentaire:first').html().replace(/<br>/, '');
            $(form[0]).find('#commentaire').html(texte);
            $(form[0]).parent().slideToggle(400);
            if($(form[0]).parent().prev().find('.infosModificaton').length > 0)
                $(form[0]).parent().prev().find('.infosModificaton').remove();
            $(form[0]).parent().prev().find('.dateCommentaire').append('<span class="glyphicon glyphicon-pencil infosModificaton" aria-hidden="true" title="modifié par ' + data.edit.commentaire.modificateur + ' le ' + data.edit.commentaire.date_modification + '"></span>');
            //$(form[0]).parent().prev().find('.modifierCommentaire').show();
        }
    }
    function treatDropCommentaire(data, form){
        if(data.success){
            $(form[0]).closest('.commentaire').find('.texteCommentaire').html('<span class="commentaireSupprimer">// Commentaire supprimé</span>');
            $(form[0]).closest('.container-fluid').prev().nextAll().remove();
        }
    }


    // ############################################
    // ################ QUESTIONS #################
    // ############################################

    $('#modifierQuestion').on('click', function(){
        // On redirige sur la bonne page
        $(location).attr('href', '/questions/edit/' + $(this).attr('data-id_question'));
    });
    $('#supprimerQuestion').on('click', function(){
        // On redirige sur la bonne page
        $(location).attr('href', '/questions/drop/' + $(this).attr('data-id_question'));
    });

    function treatAddQuestion(data, form){
        if(data.success){
            for(instance in CKEDITOR.instances){
                CKEDITOR.instances[instance].updateElement();
                CKEDITOR.instances[instance].setData('');
            }
        }
    }
    function treatDropQuestion(data, form){
        $('#dropQuestionConfirmModal').modal('hide');
        var messages = $('#divResultatAJAX').detach().show();
        $('h1').after(messages);
    }


    // ############################################
    // ################# REPONSES #################
    // ############################################

    $('.repondreReponse').on('click', addReponseForm);
    $('.modifierReponse').on('click', editReponseForm);
    $('.supprimerReponse').on('click', dropReponseForm);

    function addReponseForm(){
        if($(this).closest('.panel-footer').prev().children('.divReponseAdd').length == 0){
            // On récupère l'id de la réponse parent
            var id_reponse_parent = $(this).closest('.panel-footer').prev().find('.id_reponse').html();

            // On copie le formulaire déjà présent et on le modifie
            var clone = $('form[name=addReponse]').parent().clone();

            // On modifie la copie du formulaire
            $(clone).attr('class', 'divReponseAdd');
            $(clone).find('form').attr('name', 'addReponseImbrique');
            $(clone).find('label').attr('for', 'reponse' + id_reponse_parent);
            $(clone).find('#reponse').attr('id', 'reponse' + id_reponse_parent);
            $(clone).find('form').append('<input type="hidden" name="id_reponse_parent" value="' + id_reponse_parent + '">');
            $(clone).find('#cke_reponse').remove();

            // On affiche le formulaire
            $(this).closest('.panel-footer').prev().append(clone).find('.divReponseAdd').hide().slideToggle(400);

            // On ajoute l'auditeur d'événement AjaxForm sur ce nouveau formulaire
            $(clone).find('form').ajaxForm(optionsAJAXFORM);
            CKEDITOR.replace('reponse' + id_reponse_parent);
        }
        else{
            $(this).closest('.panel-footer').prev().children('.divReponseAdd').toggle(400);
        }
    }
    function editReponseForm(){
        // On récupère l'id de la réponse
        var id_reponse = $(this).closest('.panel-heading').next().find('.id_reponse').html();
        if($(this).closest('.panel-heading').next().children('.divReponseEdit').length == 0){
            // On clone le formulaire déjà présent
            var clone = $('form[name=addReponse]').parent().clone();

            // On modifie la copie du formulaire
            $(clone).attr('class', 'divReponseEdit');
            $(clone).find('form').attr('action', '/reponses/edit/' + id_reponse);
            $(clone).find('form').attr('name', 'editReponse');
            $(clone).find('form input[type=submit]').attr('value', 'Modifier');
            $(clone).find('#reponse').attr('id', 'editReponse' + id_reponse);
            $(clone).find('#cke_reponse').remove();

            // On affiche le formulaire
            $(this).closest('.panel-heading').next().children('.texteReponse').after(clone).find('.divReponseEdit').hide().slideToggle(400);

            // On ajoute l'auditeur d'événement AjaxForm sur ce nouveau formulaire
            $(clone).find('form').ajaxForm(optionsAJAXFORM);
            CKEDITOR.replace('editReponse' + id_reponse);
        }
        else{
            $(this).closest('.panel-heading').next().children('.divReponseEdit').toggle(400);
        }

        // On récupère le texte actuel de la réponse
        var texte = $(this).closest('.panel-heading').next().find('.texteReponse:first').html();
        CKEDITOR.instances['editReponse' + id_reponse].setData(texte);
        $(this).closest('.panel-heading').next().find('form #reponse').text(texte);
    }
    function dropReponseForm(){
        $(this).next().ajaxSubmit(optionsAJAXFORM);
    }

    function treatAddReponse(data, form){
        if(data.success){
            if($(form[0]).attr('name') == 'addReponseImbrique')
                $(form[0]).parent().slideToggle(400);
            $(form[0]).parent().before(data.add.reponse);
            for(instance in CKEDITOR.instances){
                CKEDITOR.instances[instance].setData('');
            }
            $(form[0]).parent().prev().find('.repondreReponse').on('click', addReponseForm);
            $(form[0]).parent().prev().find('.modifierReponse').on('click', editReponseForm);
            $(form[0]).parent().prev().find('.supprimerReponse').on('click', dropReponseForm);
        }
    }
    function treatEditReponse(data, form){
        if(data.success){
            $(form[0]).closest('.panel-body').children('.texteReponse').html(data.edit.reponse.reponse);
            // On récupère le texte actuel de la réponse
            var texte = $(form[0]).closest('.panel-body').find('.texteReponse').html().replace(/<br>/, '');
            $(form[0]).find('#reponse').html(texte);
            $(form[0]).parent().slideToggle(400);
            if($(form[0]).parent().prev().find('.infosModificaton').length > 0)
                $(form[0]).parent().prev().find('.infosModificaton').remove();
            $(form[0]).parent().prev().find('.dateReponse').append('<span class="glyphicon glyphicon-pencil infosModificaton" aria-hidden="true" title="modifié par ' + data.edit.reponse.modificateur + ' le ' + data.edit.reponse.date_modification + '"></span>');
            //$(form[0]).parent().prev().find('.modifierCommentaire').show();
        }
    }
    function treatDropReponse(data, form){
        if(data.success){
            $(form[0]).closest('.panel-heading').next().html('<span class="reponseSupprimer">// Réponse supprimé</span>');
            $(form[0]).closest('.panel-heading').next().next().find('.container-fluid').remove();
        }
    }


    // ############################################
    // ################ RECHERCHES ################
    // ############################################

    $("#toggleRecherche").click(function(){
        $("#divRecherche").toggle(400);
    });

    // Supprime les virgules espace ', '
    function split(val){
        return val.split(/,\s*/);
    }


    // ############################################
    // ############### AUTOCOMPLETE ###############
    // ############################################

    $( "#search-titreTechnote" ).autocomplete({
        minLength: 3,
        source : function(request, response){
            $.getJSON('/autocomplete?type=titreTechnote&term=' + request.term, function(data){
                response($.map(data, function(item){
                    return item.titre;
                }));
            });
        }
    });
    $( "#search-titreQuestion" ).autocomplete({
        minLength: 3,
        source : function(request, response){
            $.getJSON('/autocomplete?type=titreQuestion&term=' + request.term, function(data){
                response($.map(data, function(item){
                    return item.titre;
                }));
            });
        }
    });
    $( "#search-membre" ).autocomplete({
        minLength: 1,
        source : function(request, response){
            $.getJSON('/autocomplete?type=membre&term=' + request.term, function(data){
                response($.map(data, function(item){
                    return item.pseudo;
                }));
            });
        }
    });
    $( "#search-motsCles" ).autocomplete({
        minLength: 1, // Il faut au moins 1 caractère pour lancer la recherche d'autocomplétion
        source: function(request, response){
            var search = split(request.term).pop().replace(/^\++/, ''); // Enlève le + pour rendre obligatoire le mot clé s'il y en a un
            if(search != ''){
                $.getJSON('/autocomplete?type=motcle&term=' + encodeURIComponent(search), function(data){
                    response(data);
                });
            }
        },
        focus: function(){
            return false;
        },
        select: function(event,ui){
            var terms = split(this.value);
            var last = terms.pop(); // Recupère le dernier mot clé tapé
            if(last.charAt(0) == '+') // Si le client voulait que le mot clé soit obligatoire
                terms.push('+' + ui.item.value); // On remet le +
            else
                terms.push(ui.item.value);
            terms.push("");
            this.value = terms.join(", ");
            return false;
        }
    });


    // ############################################
    // ################ MOTS CLES #################
    // ############################################

    function treatAddMotCle(data, form){
        $('#addMotCleModal').modal('hide');
    }


    // ############################################
    // ################## DIVERS ##################
    // ############################################

    $("[data-hide]").on("click", function(){
        // On le cache
        $("." + $(this).attr("data-hide")).hide();
    });

    /**
     * Traite le résultat d'un formulaire
     */
    function treatResponse(data, status, xhr, form){

        // S'il y a un ordre de redirection, redirection après 3 secondes
        if(data.redirect){
            form[0].reset();
            data.msg.push('Vous allez être redirigé dans 3 secondes');
            setTimeout(function(){
                $(location).attr('href', data.redirect);
            }, 3000);
        }

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
        else if(form[0].name == "dropTechnote")
            treatDropTechnote(data, form);
        else if(form[0].name == "addCommentaire" || form[0].name == "addCommentaireImbrique")
            treatAddCommentaire(data, form);
        else if(form[0].name == "editCommentaire")
            treatEditCommentaire(data, form);
        else if(form[0].name == "dropCommentaire")
            treatDropCommentaire(data, form);
        else if(form[0].name == "dropToken")
            treatDropToken(data, form);
        else if(form[0].name == "addQuestion")
            treatAddQuestion(data, form);
        else if(form[0].name == "dropQuestion")
            treatDropQuestion(data, form);
        else if(form[0].name == "addReponse" || form[0].name == "addReponseImbrique")
            treatAddReponse(data, form);
        else if(form[0].name == "editReponse")
            treatEditReponse(data, form);
        else if(form[0].name == "dropReponse")
            treatDropReponse(data, form);
        else if(form[0].name == "addMotCle")
            treatAddMotCle(data, form);


        $('#divResultatAJAX').hide();
        // Affiche les messages s'il y en a
        if(data.msg.length > 0) {
            $('#messagesResultatAJAX').empty().append(constructMessagesHTML(data, form));
            $('#divResultatAJAX').show();
        }
    }
    function constructMessagesHTML(data, form){
        // Détermine le type de message
        var alert = '';
        if(data.success){
            form[0].reset();
            alert = 'success';
        }
        else
            alert = 'danger';
        $('#divResultatAJAX').removeClass('alert-success alert-danger').addClass('alert-' + alert);

        // Créer la liste des messages
        var messagesHTML = '';
        $.each(data.msg, function(key, value){
            messagesHTML += '<li>' + value + '</li>'
        });

        return messagesHTML;
    }

    function treatConnexion(data, form){
        if(!data.success){
            $('#badLogin').empty().append(data.msg).show();
            form.find('input[type=password]').val('');
        }
        $(location).attr('href', data.redirect);
    }
    function treatUpdateEmail(data, form){
        if(data.success) {
            $('#email').attr('placeholder', data.update.email);
        }
    }
    function treatDropToken(data, form){
        $(form).remove();
        $('#nbNavCoAuto').html(($('#nbNavCoAuto').html()) - 1);
    }

});