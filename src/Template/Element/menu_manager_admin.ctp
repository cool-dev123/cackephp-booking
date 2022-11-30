<style>
.slimScrollBar{
    background: rgb(173 173 173) !important;
    width: 12px !important;
}
</style>
        <?php if($InfoGes['G']['role']=='admin'):?>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/"><div class="pull-left"><i class="ti-dashboard  mr-20"></i><span class="right-nav-text">Accueil</span></div><div class="clearfix"></div></a>
            </li>
            <li class="navigation-header mt-5">
                <span>Utilisateurs</span> 
                <hr>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/utilisateurs/listuser"><div class="pull-left"><i class="icon-people mr-20"></i><span class="right-nav-text">Utilisateurs</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/adminnonarrive"><div class="pull-left"><i class="icon-user-following mr-20"></i><span class="right-nav-text">Gestion des arrivées</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/utilisateurs/contactprop"><div class="pull-left"><i class="ti-comments mr-20"></i><span class="right-nav-text">Messagerie propriétaires</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/smslocataire"><div class="pull-left"><i class="ti-comment-alt mr-20"></i><span class="right-nav-text">SMS & MAIL</span></div><div class="clearfix"></div></a>
            </li>
            <li class="navigation-header mt-5">
                <span>ANNONCES</span> 
                <hr>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/annonces/periodeannonces"><div class="pull-left"><i class="icon-home mr-20"></i><span class="right-nav-text">Annonces</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/admincontrat"><div class="pull-left"><i class="ti-agenda mr-20"></i><span class="right-nav-text">Contrats</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/annonces/virementsreservations"><div class="pull-left"><i class="fa fa-euro ml-5 mr-20"></i><span class="right-nav-text">Virements Réservations</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/annonces/reservationsannulees"><div class="pull-left"><i class="icon-note mr-20"></i><span class="right-nav-text">Annulation réservation</span></div><div class="clearfix"></div></a>
            </li>
            <li class="navigation-header mt-5">
                <span>PARAMÈTRES</span> 
                <hr>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/taxe"><div class="pull-left"><i class="fa fa-euro ml-5 mr-20"></i><span class="right-nav-text">Taxe de séjour</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/codereduction/"><div class="pull-left"><i class="icon-note mr-20"></i><span class="right-nav-text">Codes de réductions</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/annonces/pub"><div class="pull-left"><i class="ti-settings  mr-20"></i><span class="right-nav-text">Configuration</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/annonces/stationlanguage"><div class="pull-left"><i class="ti-world  mr-20"></i><span class="right-nav-text">Multilingue</span></div><div class="clearfix"></div></a>
            </li>
            <li class="navigation-header mt-5">
                <span>AUTRES</span> 
                <hr>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>full-calendar"><div class="pull-left"><i class="icon-calender mr-20"></i><span class="right-nav-text">Calendrier</span></div><div class="clearfix"></div></a>
            </li>
<!--            <li>
                <a class="main_menue_button" href="<?php// echo $this->Url->build('/',true);?>manager/registres/pages/8"><div class="pull-left"><i class="ti-book  mr-20"></i><span class="right-nav-text">Gestion de pages</span></div><div class="clearfix"></div></a>
            </li>-->
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/statistiquegenerale"><div class="pull-left"><i class="icon-chart mr-20"></i><span class="right-nav-text">Statistiques</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/statistique"><div class="pull-left"><i class="ti-stats-up mr-20"></i><span class="right-nav-text">Informations détaillées</span></div><div class="clearfix"></div></a>
            </li>
        <?php endif;?>

        <?php if($InfoGes['G']['role']=='gestionnaire'):?>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/"><div class="pull-left"><i class="ti-dashboard  mr-20"></i><span class="right-nav-text">Accueil</span></div><div class="clearfix"></div></a>
            </li>
            <li class="navigation-header mt-5">
                <span>Utilisateurs</span> 
                <hr>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/utilisateurgestionnaire"><div class="pull-left"><i class="icon-people mr-20"></i><span class="right-nav-text">Utilisateurs</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/nonarrive"><div class="pull-left"><i class="icon-user-following mr-20"></i><span class="right-nav-text">Gestion des arrivées</span></div><div class="clearfix"></div></a>
            </li>
            <!-- <li>
                <a class="main_menue_button" href="<?php //echo $this->Url->build('/',true);?>manager/arrivees/listecontactprop/"><div class="pull-left"><i class="ti-comments mr-20"></i><span class="right-nav-text">Messagerie propriétaires</span></div><div class="clearfix"></div></a>
            </li> -->
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/smslocataire/"><div class="pull-left"><i class="ti-comment-alt mr-20"></i><span class="right-nav-text">SMS & MAIL</span></div><div class="clearfix"></div></a>
            </li>
            <li class="navigation-header mt-5">
                <span>ANNONCES</span> 
                <hr>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/mesannonces/"><div class="pull-left"><i class="icon-home mr-20"></i><span class="right-nav-text">Annonces</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/mescontrat/"><div class="pull-left"><i class="ti-agenda mr-20"></i><span class="right-nav-text">Contrats</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/location/"><div class="pull-left"><i class="ti-pencil-alt  mr-20"></i><span class="right-nav-text">Créer une réservation</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/gestioncle/"><div class="pull-left"><i class="ti-key  mr-20"></i><span class="right-nav-text">Gestion des clés</span></div><div class="clearfix"></div></a>
            </li>
            <li class="navigation-header mt-5">
                <span>PARAMÈTRES</span> 
                <hr>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/arrivees/taxedesejour/"><div class="pull-left"><i class="fa fa-euro ml-5 mr-20"></i><span class="right-nav-text">Taxe de séjour</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/codereduction/"><div class="pull-left"><i class="ti-receipt  mr-20"></i><span class="right-nav-text">Codes de réductions</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/stations"><div class="pull-left"><i class="ti-settings  mr-20"></i><span class="right-nav-text">Configuration</span></div><div class="clearfix"></div></a>
            </li>
            <li class="navigation-header mt-5">
                <span>AUTRES</span> 
                <hr>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>full-calendar"><div class="pull-left"><i class="icon-calender mr-20"></i><span class="right-nav-text">Calendrier</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/annoncesstatisgest"><div class="pull-left"><i class="icon-chart mr-20"></i><span class="right-nav-text">Statistiques</span></div><div class="clearfix"></div></a>
            </li>
            <li>
                <a class="main_menue_button" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/statistique"><div class="pull-left"><i class="ti-stats-up mr-20"></i><span class="right-nav-text">Informations détaillées</span></div><div class="clearfix"></div></a>
            </li>
            <!--
            <li>
                <a class="main_menue_button" href="<?php// echo $this->Url->build('/',true);?>manager/arrivees/contrat/"><div class="pull-left"><i class="ti-ink-pen mr-20"></i><span class="right-nav-text">Création de contrat</span></div><div class="clearfix"></div></a>
            </li> -->
            <!--
            <li>
                <a class="main_menue_button" href="<?php// echo $this->Url->build('/',true);?>manager/arrivees/inscription/"><div class="pull-left"><i class="ti-stamp mr-20"></i><span class="right-nav-text">Inscription propriétaire</span></div><div class="clearfix"></div></a>
            </li>
            -->
        <?php endif;?>
