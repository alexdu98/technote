$(document).ready(function(){

    // ############################################
    // ################# AJAXFORM #################
    // ############################################

    // On supprime le traitement par défaut (non admin)
    $('form').ajaxFormUnbind();

    // Configuration de AjaxForm
    var optionsAJAXFORM = {
        // Avant de récupérer le contenu des champs du formulaire
        beforeSerialize: function (arr, form, options) {
            for (instance in CKEDITOR.instances) {
                // On met à jour les champs de type CKEDITOR
                CKEDITOR.instances[instance].updateElement();
            }
        },
        // Quand la réponse Ajax sera reçu, on appelle ce callback
        'success': treatResponse,
        // La réponse Ajax est de type JSON
        'dataType': 'json'
    };

    // Tous les formulaires sans la classe noAjax seront en Ajax
    $('form:not(.noAjax)').ajaxForm(optionsAJAXFORM);

    // ############################################
    // ################## MODALES #################
    // ############################################

    $('.dropMembreButton').on('click', function(e){
        var pseudo = $(this).closest('tr').find('.pseudo').html();
        var id = $(this).closest('tr').find('.id').html();
        $('.modal-title').html(pseudo + ' (id:<span id="idDrop">' + id + '</span>)');
        $('form[name=dropMembre]').attr('action', '/admin/membres/drop/' + id);
    });

    $('.dropMotCleButton').on('click', function(e){
        var mot = $(this).closest('tr').find('.mot').html();
        var id = $(this).closest('tr').find('.id').html();
        $('.modal-title').html(mot + ' (id:<span id="idDrop">' + id + '</span>)');
        $('form[name=dropMotCle]').attr('action', '/admin/mots_cles/drop/' + id);
    });


    // ############################################
    // ################ DATATABLES ################
    // ############################################

    var tableMembres = $('#tableMembres').DataTable({
        "language": {
            "url": "/assets/librairies/datatables/dataTables.french.lang"
        }
    });
    var tableMotsCles = $('#tableMotsCles').DataTable({
        "language": {
            "url": "/assets/librairies/datatables/dataTables.french.lang"
        }
    });


    // ############################################
    // ################## DIVERS ##################
    // ############################################

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
        if(form[0].name == "connexion")
            treatConnexion(data, form);
        else if(form[0].name == "dropMembre")
            treatDropMembre(data, form);
        else if(form[0].name == "dropMotCle")
            treatDropMotCle(data, form);


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
            form[0].reset();
        }
        $(location).attr('href', data.redirect);
    }

    // ############################################
    // ################## MEMBRES #################
    // ############################################

    function treatDropMembre(data, form){
        $('#dropMembreConfirmModal').modal('hide');
        if(data.success){
            //var id = $(form[0]).find('#idDrop').html();
            //tableMembres.row($('#idMembre' + id)).remove().draw();
            location.reload();
        }
    }

    function treatDropMotCle(data, form){
        $('#dropMotCleConfirmModal').modal('hide');
        if(data.success){
            //var id = $(form[0]).find('#idDrop').html();
            //tableMembres.row($('#idMembre' + id)).remove().draw();
            location.reload();
        }
    }

});