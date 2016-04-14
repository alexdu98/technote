$(document).ready(function(){

    /**
     * Configuration de AjaxForm
     */
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

    /**
     * Tous les formulaires seront en Ajax
     */
    $('form').ajaxForm(optionsAJAXFORM);

    /**
     * Au clic sur un lien pour répondre à un commentaire
     */
    $('.repondreCommentaire').on('click', function(){
        // On récupère l'id du commentaire parent
        var id_commentaire_parent = $(this).closest('.commentaire').find('.id_commentaire').html();

        // On copie le formulaire déjà présent et on le modifie
        var clone = $('form[name=addCommentaire]').parent().clone();
        $(this).closest('.commentaire').append(clone);
        $(clone).find('form').attr('name', 'addCommentaireImbrique');
        $(clone).find('label').attr('for', 'commentaire' + id_commentaire_parent);
        $(clone).find('#commentaire').attr('id', 'commentaire' + id_commentaire_parent);
        $(clone).find('form').append('<input type="hidden" name="id_commentaire_parent" value="' + id_commentaire_parent + '">');

        // On rajoute l'auditeur d'événement AjaxForm sur ce nouveau formulaire
        $(clone).find('form').ajaxForm(optionsAJAXFORM);

        // On supprime le lien pour répondre au commentaire
        $(this).remove();
    });

    $('.lienSendAjax').on('click', dropCommentaireForm);

    // Au clic sur un lien pour modifier un commentaire, on appelle le callback
    $('.modifierCommentaire').on('click', editCommentaireForm);

    // Au clic sur un lien pour modifier une technote
    $('#modifierTechnote').on('click', function(){
        // On redirige sur la bonne page
        $(location).attr('href', '/technotes/edit/' + $(this).attr('data-id_technote'));
    });

    // Au clic sur un élement avec un attribut data-hide
    $("[data-hide]").on("click", function(){
        // On le cache
        $("." + $(this).attr("data-hide")).hide();
    });

    function split(val){
        return val.split(/,\s*/);
    }
    function extractLast(term){
        return split(term).pop();
    }

    // Autocomplétion pour la recherche de membre
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

    // Autocomplétion pour la recherche par mot clé
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

    function dropCommentaireForm(){
        $(this).next().ajaxSubmit(optionsAJAXFORM);
    }

    /**
     * Traite le résultat d'un formulaire
     */
    function treatResponse(data, status, xhr, form){

        // S'il y a un ordre de redirection, redirection après 3 secondes
        if(data.redirect){
            form[0].reset();
            data.msg.push('Vous allez être redirectionné dans 3 secondes');
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
        else if(form[0].name == "rechercheTechnote")
            treatRechercheTechnote(data, form);
        

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

    function treatRechercheTechnote(data, form){
        if(data.success) {
            $('#technotes').empty().append(data.get.technotes);
        }
    }

    /**
     * Affiche le formulaire de modification d'un commentaire
     */
    function editCommentaireForm(){
        // On récupère l'id du commentaire
        var id_commentaire = $(this).closest('.commentaire').find('.id_commentaire').html();

        // On clone le formulaire déjà présent
        var clone = $('form[name=addCommentaire]').parent().clone();

        // On récupère le texte actuel du commentaire
        var texte = $(this).closest('.commentaire').find('.texteCommentaire').html().replace(/<br>/, '');
        $(this).closest('.container-fluid').after(clone);

        // On modifie la copie du formulaire
        $(clone).find('form #commentaire').text(texte);
        $(clone).find('form').attr('action', '/commentaires/edit/' + id_commentaire);
        $(clone).find('form').attr('name', 'editCommentaire');
        $(clone).find('form input[type=submit]').attr('value', 'Modifier');

        // On ajoute l'auditeur d'événement AjaxForm sur ce nouveau formulaire
        $(clone).find('form').ajaxForm(optionsAJAXFORM);

        // On cache le lien pour éditer le commentaire
        $(this).hide();
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

    function treatDropToken(data, form){
        $(form).remove();
        $('#nbNavCoAuto').html(($('#nbNavCoAuto').html()) - 1);
    }

    function treatAddCommentaire(data, form){
        if(data.success){
            $(form[0]).parent().before(data.add.commentaire);
            $(form[0]).parent().prev().find('.modifierCommentaire').on('click', editCommentaireForm);
            $(form[0]).parent().prev().find('.lienSendAjax').on('click', dropCommentaireForm);
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

    function treatDropCommentaire(data, form){
        if(data.success){
            $(form[0]).closest('.commentaire').find('.texteCommentaire').html('<span class="commentaireSupprimer">// Commentaire supprimé</span>');
            $(form[0]).closest('.container-fluid').prev().nextAll().remove();
        }
    }

});