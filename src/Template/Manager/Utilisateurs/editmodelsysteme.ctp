<?php $this->start('cssTop') ?>
    <style>
        .note-group-select-from-files {
            display: none;
        }
        .modal-body{
            margin-left:10px !important;
            margin-right:10px !important;
        }
        .note-btn{
            padding:10px !important;
        }
        .note-editable b, .note-editable strong { font-weight: bold; }
        .note-editable i { font-style: italic; }
        .note-editable ul { list-style: circle !important; }
        
        span.bootstrap-switch-handle-on.bootstrap-switch-primary {
            background-color: blue !important;
        }
        span.bootstrap-switch-handle-off.bootstrap-switch-default {
            background-color: red !important;
            color: white !important;
        }
        div#myTabContent {
            border: 1px solid darkgrey;
        }
    </style>
<?php $this->end() ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h5 class="txt-dark">Modifier modele mail système</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
                    
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="panel panel-info card-view">
                                <div class="panel-heading icantSelectIt">
                                        <div class="pull-left">
                                                <h6 class="panel-title txt-light">Attention</h6>
                                        </div>
                                        <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                        <div class="panel-body">
                                        <?php
                                            if($modelmessage->titre == "contactProprietaire"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}}, {{demande}}, {{prenom}}, {{nom}}, {{email}}, {{tel}}, {{message}}, {{imageannonce}}, {{annonceURL}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif($modelmessage->titre == "infoLocataire"){
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{annonce}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "contactProprietaireAdmin") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{emailprop}}, {{telephoneprop}}, {{annonce}}, {{demande}}, {{prenom}}, {{nom}}, {{email}}, {{tel}}, {{message}}, {{imageannonce}}, {{annonceURL}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "contactProprietaireAdminNotContrat") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{emailprop}}, {{telephoneprop}}, {{annonce}}, {{demande}}, {{prenom}}, {{nom}}, {{email}}, {{tel}}, {{message}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "annoncesNotContrat" ) {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br><br><span class='red'>INDICATION : </span>".$modelmessage->destinataire."<br><hr>";
                                              }elseif ($modelmessage->titre == "creationReservationNoContrat") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationAnnonce") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "confirmationInscription") {
                                                echo "Les variables dynamiques sont : {{login}}, {{password}}, {{url}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "nouveauMdp") {
                                                echo "La variable dynamique est : {{password}}, {{prenom}}, {{nom}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservation" ) {
                                                echo "Les variables dynamiques sont :{{prenomprop}}, {{nomprop}}, {{annonce}}, {{station}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationRappel8h" ) {
                                                echo "Les variables dynamiques sont :{{prenomprop}}, {{nomprop}}, {{annonce}}, {{station}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationRappel3j" ) {
                                                echo "Les variables dynamiques sont :{{prenomprop}}, {{nomprop}}, {{annonce}}, {{station}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationRappel4hExpiration" ) {
                                                echo "Les variables dynamiques sont :{{prenomprop}}, {{nomprop}}, {{annonce}}, {{station}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationExpiration" ) {
                                                echo "Les variables dynamiques sont :{{prenomprop}}, {{nomprop}}, {{annonce}}, {{station}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationpaiementdirect" ) {
                                                echo "Les variables dynamiques sont :{{prenomprop}}, {{nomprop}}, {{annonce}}, {{station}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationManuelle") {
                                                echo "Les variables dynamiques sont :{{prenomprop}}, {{nomprop}}, {{annonce}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationManuelleAdm") {
                                                echo "Les variables dynamiques sont :{{prenomprop}}, {{nomprop}}, {{annonce}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationLoc" ) {
                                                echo "Les variables dynamiques sont :{{prenom}}, {{nom}}, {{prenomprop}}, {{nomprop}}, {{debut}}, {{fin}}, {{annonce}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationLocpaiementdirect" ) {
                                                echo "Les variables dynamiques sont :{{prenom}}, {{nom}}, {{prenomprop}}, {{nomprop}}, {{debut}}, {{fin}}, {{annonce}}, {{{blockreduction}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationLocManuelle") {
                                                echo "Les variables dynamiques sont :{{prenom}}, {{nom}}, {{prenomprop}}, {{nomprop}}, {{debut}}, {{fin}}, {{annonce}}, {{{bloc_services_mail}}}, {{{bloc_services_mail_en}}}, {{{bloc_info_arrivee}}}, {{{bloc_info_arrivee_en}}}, {{{bloc_info_depart}}}, {{{bloc_info_depart_en}}}, {{{bloc_info_horaires}}}, {{{bloc_info_horaires_en}}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationAdm") {
                                                echo "Les variables dynamiques sont :{{annonce}}, {{station}}, {{prenomprop}}, {{nomprop}}, {{telprop}}, {{emailprop}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationReservationAdmpaiementdirect") {
                                                echo "Les variables dynamiques sont :{{annonce}}, {{station}}, {{prenomprop}}, {{nomprop}}, {{telprop}}, {{emailprop}}, {{debut}}, {{fin}}, {{nbrEnfant}}, {{nbrAdulte}}, {{prenom}}, {{nom}}, {{tel}}, {{email}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "editReservationProp") {
                                                echo "Les variables dynamiques sont :{{prenom}}, {{nom}}, {{date}}, {{{bloc_services_mail}}}, {{{bloc_services_mail_en}}}.
                                                 <br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "editDateArrivee") {
                                                echo "Les variables dynamiques sont :{{prenomprop}}, {{nomprop}}, {{prenom}}, {{nom}}, {{date}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "refusReservationClt") {
                                                echo "Les variables dynamiques sont :{{prenom}}, {{nom}}, {{prenomprop}}, {{nomprop}}, {{debut}}, {{fin}}, {{annonce}}, {{note_refus}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationCompteManuelle") {
                                                echo "Les variables dynamiques sont :{{prenom}}, {{nom}}, {{prenomprop}}, {{nomprop}}, {{debut}}, {{fin}}, {{login}}, {{password}}, {{url}}, {{imageannonce}}, {{description}}, {{annonce}}, {{annonceURL}}, {{{bloc_services_mail}}}, {{{bloc_services_mail_en}}}.<br><span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "acceptationReservationClt") {
                                                echo "Les variables dynamiques sont :{{prenom}}, {{nom}}, {{prenomprop}}, {{nomprop}}, {{debut}}, {{fin}}, {{annonce}}, {{imageannonce}}, {{description}}, {{annonceURL}}, {{{bloc_services_mail}}}, {{{bloc_services_mail_en}}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "acceptationReservationProp") {
                                                echo "Les variables dynamiques sont :{{prenom}}, {{nom}}, {{prenomprop}}, {{nomprop}}, {{debut}}, {{fin}}, {{annonce}}, {{annonceURL}}, {{nbrEnfant}}, {{nbrAdulte}}, {{montantreservation}}, {{datedevirement}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "acceptationReservationAdm") {
                                                echo "Les variables dynamiques sont : {{annonce}}, {{prenomprop}}, {{nomprop}}, {{debut}}, {{fin}}, {{prenom}}, {{nom}}, {{tel}}, {{email}}, {{imageannonce}}, {{annonceURL}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationCompteGestionnaire") {
                                                echo "Les variables dynamiques sont : {{bureau}}, {{login}}, {{password}}, {{url}}, {{{bloc_service_proprietaire}}}, {{{bloc_service_proprietaire_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "creationContrat") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{contrat}}, {{gestionnaire}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "editDateArriveeLocataire") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{date}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "editDateArriveeProprietaire") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{prenom}}, {{nom}}, {{date}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "annonceAccepter") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}}, {{station}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "annonceAccepterAdmin") {
                                                echo "Les variables dynamiques sont : {{gestionnaire}}, {{annonce}}, {{prenomprop}}, {{nomprop}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "annonceRejetee") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}}, {{station}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "annonceRejeteeAdmin") {
                                                echo "Les variables dynamiques sont : {{gestionnaire}}, {{annonce}}, {{prenomprop}}, {{nomprop}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "acceptationAnnonceAdmin") {
                                                echo "Les variables dynamiques sont : {{annonce}}, {{appartement}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "facturecontrat") {
                                                echo "Les variables dynamiques sont : {{gestionnaire}}, {{date}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "validationArriveeProp") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{prenom}}, {{nom}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "validationArriveeLoc") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{prenomprop}}, {{nomprop}}, {{taxe}}, {{{blockreduction}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "validationMenage") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{appartement}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "contactProprietaireContact") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}}, {{demande}}, {{prenom}}, {{nom}}, {{email}}, {{tel}}, {{commentaire}}, {{imageannonce}}, {{annonceURL}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "supressionReservationLoc") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{debut}}, {{fin}}, {{annonce}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }elseif ($modelmessage->titre == "supressionReservationProp") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}}, {{prenom}}, {{nom}}, {{debut}}, {{fin}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span>";
                                              }
                                              elseif ($modelmessage->titre == "arriveeDemainProp") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}}, {{prenom}}, {{nom}}, {{date}}, {{gestionnaire}}, {{{bloc_info_arrivee}}}, {{{bloc_info_depart}}}, {{{bloc_info_arrivee_en}}}, {{{bloc_info_depart_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "arriveeDemainPropSansContart") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}}, {{prenom}}, {{nom}}, {{date}}, {{gestionnaire}}, {{{bloc_info_arrivee}}}, {{{bloc_info_depart}}}, {{{bloc_info_arrivee_en}}}, {{{bloc_info_depart_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }
                                              elseif ($modelmessage->titre == "arriveeDemainLoc") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{annonce}}, {{residence}}, {{station}}, {{code_postal}}, {{ville}}, {{gestionnaire}}, {{adresse_gestionnaire}}, {{ville_gestionnaire}}, {{code_postal_gestionnaire}}, {{{bloc_info_arrivee}}}, {{{bloc_info_depart}}}, {{{bloc_info_horaires}}}, {{{bloc_info_arrivee_en}}}, {{{bloc_info_depart_en}}}, {{{bloc_info_horaires_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "arriveeDemainLocSansContrat") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{annonce}}, {{residence}}, {{station}}, {{code_postal}}, {{ville}}, {{{bloc_info_arrivee}}}, {{{bloc_info_depart}}}, {{{bloc_info_arrivee_en}}}, {{{bloc_info_depart_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "arriveeDemainLocResidence") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{annonce}}, {{residence}}, {{station}}, {{code_postal}}, {{ville}}, {{{bloc_info_arrivee}}}, {{{bloc_info_depart}}}, {{{bloc_info_arrivee_en}}}, {{{bloc_info_depart_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "arriveePrevueLoc") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{num_annonce}}, {{residence}}, {{station}}, {{code_postal}}, {{ville}}, {{gestionnaire}}, {{adresse_gestionnaire}}, {{ville_gestionnaire}}, {{code_postal_gestionnaire}}, {{{bloc_info_arrivee}}}, {{{bloc_info_depart}}}, {{{bloc_info_horaires}}}, {{{bloc_info_arrivee_en}}}, {{{bloc_info_depart_en}}}, {{{bloc_info_horaires_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "arriveePrevueLocResidence") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{num_annonce}}, {{residence}}, {{station}}, {{code_postal}}, {{ville}}, {{{bloc_info_arrivee}}}, {{{bloc_info_depart}}}, {{{bloc_info_arrivee_en}}}, {{{bloc_info_depart_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "aarriveePrevueLocSansContrat") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{num_annonce}}, {{residence}}, {{station}}, {{code_postal}}, {{ville}}, {{{bloc_info_arrivee}}}, {{{bloc_info_depart}}}, {{{bloc_info_arrivee_en}}}, {{{bloc_info_depart_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "infoDepart") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{annonceURL}}, {{{bloc_info_depart}}}, {{{bloc_info_depart_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "demandeNoteAppartement") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{annonceURL}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "demandeMenageDepart") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{{bloc_menage_depart}}}, {{{bloc_menage_depart_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "telechargerApplication") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "expirationContrat") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "anniversaireLocation") {
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{annonce}}, {{prenom}}, {{nom}}, {{annonceURL}}, {{imageannonce}}, {{description}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "valideCommentaire") {
                                                  echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{prenom}}, {{nom}}, {{noteGlobale}}, {{annonce}}, {{commentaire}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "validerCompte") {
                                                  echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{email}}, {{url}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "validerCompteModifMail") {
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{email}}, {{url}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "premiermailrappelannonceperiode") {
                                                  echo "Les variables dynamiques sont : {{prenom}}, {{nom}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "deuxiememailrappelannonceperiode") {
                                                  echo "Les variables dynamiques sont : {{prenom}}, {{nom}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "troisiememailrappelannonceperiode") {
                                                  echo "Les variables dynamiques sont : {{prenom}}, {{nom}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "infoCleLocataire"){
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "commentairereservation"){
                                                echo "Les variables dynamiques sont : {{role}}, {{commentaire}}, {{debut}}, {{fin}}, {{annonce}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "paiementTaxeDeSejour"){
                                                echo "Les variables dynamiques sont : {{montant_taxe}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "paiementTaxeDeSejourGestionnaire"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{taxe}}, {{datearrivee}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "annulationreservationprop"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{nomprop}}, {{prenomprop}}, {{datedebut}}, {{datefin}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "acceptationjustificatif"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{annonce}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "refusjustificatif"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{montant}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "ArriveeLocataireSansContratInventaire"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{url_inventaire}}, {{url_inventaire_locataire}}, {{{bloc_services_mail}}}, {{{bloc_services_mail_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "recevoirInventaireLocataire"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{url_inventaire_locataire}}, {{commentaire_inventaire}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "ArriveeLocataireSansContratSansInventaire"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{{bloc_services_mail}}}, {{{bloc_services_mail_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "ArriveeLocataireContratInventaire"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{{bloc_services_mail}}}, {{{bloc_services_mail_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "ArriveeLocataireContratSansInventaire"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{{bloc_services_mail}}}, {{{bloc_services_mail_en}}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }                                             
                                              elseif ($modelmessage->titre == "annulationreservationautomatique"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{annonce}}, {{station}}, {{datedebut}}, {{datefin}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "annulationreservationlocMois"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{montant}}, {{datedebut}}, {{datefin}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "annulationreservationlocSemaineMois"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{montant}}, {{datedebut}}, {{datefin}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }elseif ($modelmessage->titre == "annulationreservationlocSemaine"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{montant}}, {{datedebut}}, {{datefin}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              } elseif ($modelmessage->titre == "AnnulationJustifProp"){
                                                echo "Les variables dynamiques sont : {{nom}}, {{prenom}}, {{prenomprop}}, {{nomprop}}, {{datedebut}}, {{datefin}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              } elseif ($modelmessage->titre == "verificationIban"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{iban}}, {{bic}}, {{titulaire}}, {{rue}}, {{codepostal}}, {{ville}}, {{pays}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              } elseif ($modelmessage->titre == "findReservationOption2hours"){
                                                echo "Les variables dynamiques sont : {{titre_annonce}}, {{imageannonce}}, {{description}}, {{lien_boutique}}, {{lien_annonce}}, {{nb_adulte}}, {{nb_enfant}}, {{date_debut}}, {{date_fin}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              } elseif ($modelmessage->titre == "recapQuotidienGestionnaire"){
                                                echo "Les variables dynamiques sont : {{nombre_arrivees}}, {{arrivees_demain}}, {{taxe_retard}}, {{montant_taxe}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              } elseif ($modelmessage->titre == "infojustificatifdomicile24hours"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{numero_d_annonce}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              } elseif ( $modelmessage->titre == "passerellesAlerteDoubleReservation"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{calendriernom}}, {{annonce_id}}, {{debut}}, {{fin}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              } elseif ( $modelmessage->titre == "passerellesNouvelleReservation"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              } elseif ( $modelmessage->titre == "passerellesNouvellesPeriodes"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre mail. </span><br>";
                                              }                                    
                                              
                                              ?>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
                  echo $this->Form->create($modelmessage,['url'=>'/manager/utilisateurs/editmodelsysteme/'.$modelmessage->id,'id'=>'frm_periode','class'=> 'form-horizontal']);
                  echo $this->Form->input('id');
                  echo $this->Form->hidden('destinataire',['value'=>$modelmessage->destinataire]);
                  ?>
                <div class="form-group">
                    <label id="txtmessage" class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Indication: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-10 col-sm-10">
                        <textarea type="" name="indication" rows="3" cols="120" id="indication"><?php echo $modelmessage->indication ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Titre: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-4 col-sm-10">
                        <?php echo $this->Form->input('titre',['type'=>'text','id'=>'titre','label'=>false,'class'=>'form-control','readonly']);  ?>
                    </div>
                </div>
                <div  class="pills-struct mt-40">
                    <ul role="tablist" class="nav nav-pills" id="myTabs_6">
                        <li class="active" role="presentation"><a aria-expanded="true"  data-toggle="tab" role="tab" id="home_tab_6" href="#FR">Français</a></li>
                        <li role="presentation" class=""><a  data-toggle="tab" id="profile_tab_6" role="tab" href="#EN" aria-expanded="false">Anglais</a></li>
                    </ul>
                    <div class="tab-content pa-10" id="myTabContent">
                        <div  id="FR" class="tab-pane fade active in" role="tabpanel">
                            <div class="form-group row">
                               <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Sujet en français: <sup class='text-danger'>*</sup></label>
                               <div class="col-lg-4 col-sm-10">
                                   <?php echo $this->Form->input('sujet',['type'=>'text','id'=>'sujet','label'=>false,'class'=>'form-control']);  ?>
                               </div>
                           </div>
                           <div class="form-group">
                               <label id="txtmessage" class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Texte en français: <sup class='text-danger'>*</sup></label>
                               <div class="col-lg-10 col-sm-12">
                                   <textarea class="textarea_editor form-control" type="" name="txtmail" rows="20" id="txtmail"><?php echo $modelmessage->txtmail ?></textarea>
                               </div>
                           </div>
                        <?php
                            if($modelmessage->titre == "creationReservationLocpaiementdirect"){
                        ?>
                            <div class="form-group pl-15 pr-15">
                                <br><br>
                                <h6>Block réduction ( {{{blockreduction}}} ): </h6>
                                <br>
                                <blockquote>Les variables utilisées sont {{codereduction}}, {{valeurreduction}}, {{debutreduction}} et {{finreduction}}</blockquote>
                            </div>
                            <div class="form-group">
                                <label id="txtmessage" class="control-label mb-10 col-sm-2 text-left">Block réduction en français: <sup class='text-danger'>*</sup></label>
                                <div class="col-lg-10 col-sm-10">
                                    <textarea class="form-control textarea_editor" type="" name="blockreduction" rows="20" cols="30" id="blockreduction"><?php echo $modelmessage->blockreduction ?></textarea>
                                </div>
                            </div>
                        <?php
                          }
                        ?>
                        </div>
                        <div  id="EN" class="tab-pane fade" role="tabpanel">
                            <div class="form-group row">
                               <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Sujet en anglais: <sup class='text-danger'>*</sup></label>
                               <div class="col-lg-4 col-sm-10">
                                   <?php echo $this->Form->input('sujetEn',['type'=>'text','id'=>'sujetEn','label'=>false,'class'=>'form-control']);  ?>
                               </div>
                           </div>
                           <div class="form-group">
                               <label id="txtmessage" class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Texte en anglais: <sup class='text-danger'>*</sup></label>
                               <div class="col-lg-10 col-sm-12">
                                   <textarea class="textarea_editor form-control" type="" name="txtmailEn" rows="20" id="txtmailEn"><?php echo $modelmessage->txtmailEn ?></textarea>
                               </div>
                           </div>
                        <?php
                            if($modelmessage->titre == "creationReservationLocpaiementdirect"){
                        ?>
                            <div class="form-group pl-15 pr-15">
                                <br><br>
                                <h6>Block réduction ( {{{blockreduction}}} ): </h6>
                                <br>
                                <blockquote>Les variables utilisées sont {{codereduction}}, {{valeurreduction}}, {{debutreduction}} et {{finreduction}}</blockquote>
                            </div>
                            <div class="form-group">
                                <label id="txtmessage" class="control-label mb-10 col-sm-2 text-left">Block réduction en anglais: <sup class='text-danger'>*</sup></label>
                                <div class="col-lg-10 col-sm-10">
                                    <textarea class="form-control textarea_editor" type="" name="blockreductionEn" rows="20" cols="30" id="blockreductionEn"><?php echo $modelmessage->blockreductionEn ?></textarea>
                                </div>
                            </div>
                        <?php
                          }
                        ?>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="row mb-10">
                        <div class="col-sm-12 ml-10">
                            <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="<?php echo $this->Url->build('/',true);?>manager/utilisateurs/modelmailsysteme" class="btn btn-default">Retour </a>
                        </div>
                        <div class="col-sm-offset-2 col-sm-2">
                            <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Enregistrer</span></button>
                        </div>
                        <?php   echo $this->Form->end();    ?>    
                        <div class="col-sm-6">
                            <form class="form-inline" action="/action_page.php">
                              <!-- <label for="email">Email :</label> -->
                              <input type="email" class="form-control" id="email" placeholder="Email">
                              <button type="button" class="btn btn-primary" id="maildetest">Envoyer un mail de test</button>
                            </form>
                        </div>
                    </div>
                </div>                              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    $('.textarea_editor').summernote({
                                height: 300,
                                lang:"fr-FR",
                                fontNames: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
                                fontNamesIgnoreCheck: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                    ['font', ['strikethrough', 'superscript', 'subscript']],
                                    ['fontname',['fontname']],
                                    ['fontsize', ['fontsize']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['picture',['picture']],
                                    ['fullscreen',['fullscreen']],
                                    ['codeview',['codeview']],
                                    ['undo',['undo']],
                                    ['redo',['redo']],
                                            ]
                        });
                        
    $("#frm_periode").validate({
	rules: {
                indication :{
                    required: true,
                },
                sujet: {
                    required: true,
                },
                sujetEn: {
                    required: true,
                },
	},
        lang: 'fr',
    });
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Votre Modèle a été modifié',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 7000
                        });
    <?php endif;?>
     $("#maildetest").click(function(){
      if($("#email").val() != ''){
        if($("#FR").hasClass("active")){
          langue = "FR";
        }else{
          langue = "EN";
        }
        $.ajax({
          type: "POST",
          dataType : 'json',
          async: false,
          url: "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/envoyermaildetest/",
          data: {email: $("#email").val(), titre: $("#titre").val(), langue: langue},
          success:function(xml){
            $("#email").val("");
            $.toast({
                heading: 'Votre Modèle a été envoyé',
                text: '',
                position: 'bottom-right',
                loaderBg:'#fec107',
                icon: 'success',
                hideAfter: 7000
            });
          }
        });
      }
      
     }); 
<?php $this->Html->scriptEnd(); ?>