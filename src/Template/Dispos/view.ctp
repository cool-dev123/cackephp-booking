<?php $this->Html->css("/css/fullcalendar_5.11/main.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/fullcalendar_5.11/main.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/fullcalendar_5.11/locales-all.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->append('cssTopBlock', '<style>
.fc .fc-toolbar {
    padding: 15px 15% 0px 15%;
    margin-bottom: 11px !important;
}
button.fc-prev-button, button.fc-next-button {
    background-color: white !important;
    color: #666 !important;
    padding-top: 0px !important;
    padding-bottom: 0px !important;
}
.fc-col-header-cell-cushion {
    font-weight: normal;
    text-transform: capitalize;
}
.fc-toolbar-title{
    text-transform: capitalize;
}
.fc .fc-button:focus {
    box-shadow: 0 0 0 0.2rem rgb(44 62 80 / 15%) !important;
}
.fc .fc-daygrid-day-top {
    flex-direction: row;
    font-size: 22px;
}
.fc-daygrid-day-events {
    min-height: 1em !important;
}
.fc-event-title.fc-sticky {
    display: none;
}
.priceday{
    text-align: center;
}
.fc-day-today {
    background: transparent !important;
}
.fc-event-start {
    margin-left: 58px !important;
}
.fc-event-end {
    margin-right: 58px !important;
}
.fc-daygrid-event {
    height: 3px;
}
.fc-daygrid-event-harness {
    top: 0px !important;
}

.fc-daygrid-event.fc-event-start::before{
    content: "";
    height: 0.7em;
    width: 0.7em;
    border-radius: 50%;
    position: absolute;
    top: -5px;
    left: -10px;
    background: rgb(252 66 123);
}
.fc-daygrid-event.fc-event-end::after{
    content: "";
    height: 0.7em;
    width: 0.7em;
    border-radius: 50%;
    position: absolute;
    top: -5px;
    right: -10px;
    background: rgb(252 66 123);
}

.promotionprice{
    height: 15px;
    width: 15px;
    background-color: rgb(0 153 255);
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
}
#fc-day-span-today {
    font-size: 9px;
    font-weight: bold;
    border: 1px solid #0099ff;
    color: #0099ff;
    border-radius: 3px;
    padding: 2px 3px 1px 3px;
    position: absolute;
    /* right: -80px; */
    margin-left: 5px;
    top: 10px;
}

.titrediv {
    border: 1px solid #dee2e6;
    padding: 5% 15% 5% 15%;
}
.blocdispo {
    background: #f4f4f4;
}
.rowdispos {
    background: white;
    border-radius: 5px;
    cursor:pointer;
}
.rowdispos:hover {
    transform: scale(1.1);
}
.fontstyle {
    font-size: 14px;
}
.cadrepromo {
    height: 20px;
    width: 20px;
    margin-top: 1px;
}
.cadredispo {
    height: 25px;
    width: 50px;
    background: white;
    display: inline-block;
    border-radius: 5px;
}
.cadreindispo {
    height: 25px;
    width: 50px;
    display: inline-block;
    border-radius: 5px;
    background-color: white;
    background-image: url('.$this->Url->build('/',true).'images/svg/logo-alpissime-filigrane.svg#Calque_2);
    background-repeat: round;
    background-size: 13px;
}
.smallheight {
    height: 66px;
}
.bigheight {
    height: 562px;
}
.fc-day-other .fc-daygrid-day-bg {
    opacity: .3;
}
td.fc-daygrid-day {
    height: 88px;
}

span.tooltipsvc {
    font-size: 17px;
}
.tooltip .arrow::before{
    border-bottom-color: #9e9e9e;
}
.tooltip-inner {
    box-shadow: 0 0 5px #9e9e9e;
    border-radius: 5px;
    font-size: 14px;
    min-width: 350px !important;
}

.divtoremove, .divdisponibilitestoshow, .divpromotionstoshow, .divfraisfixestoshow, .divearlybookingtoshow, .divlastminutetoshow, .divlongsejourstoshow, divparametrestitletoshow{
    width: 100%;
}

.btn-previous:focus {
    box-shadow: none;
}
.card-header {
    background-color: #f8f9fa;
}
.card-header button {
    color: rgb(0 0 0 / 90%);
}
.btn-link:hover {
    color: rgb(0 0 0 / 90%);
}
.btn-link:focus {
    text-decoration: none;
}
.nondispoclass {
    background-image: url('.$this->Url->build('/',true).'images/svg/logo-alpissime-filigrane.svg#Calque_2);
    background-repeat: round;
    background-size: 17px;
    opacity: 0.8;
}
.tooltipselector .arrow {
    display: none;
}
.tooltipselector.show{
    opacity: 1;
}
.tooltipselector{
    font-family: DM Sans,sans-serif!important
}
.tooltipselector .tooltip-inner p{
    font-size: 15px;
}
.libreclass {
    visibility: hidden;
}
button:disabled, .not-allowed {
    cursor: not-allowed !important;
}
/*.fc .fc-highlight {
    background: rgb(188 232 241 / 48%);
    background: var(--fc-highlight-color,rgba(188 232 241 / 48%));
}*/
i.fa.fa-angle-left.fa-2x {
    top: -7px;
    position: relative;
}
.link-reservation::before{
    content: "";
    display: inline-block;
    width: 5px;
    height: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    background-color: #000;
    margin-left: 5px;
    margin-right: 10px;
    margin-bottom: 2px;
}
a.link-reservation {
    color: #0099ff;
}
.fc-event-main-frame {
    display: none !important;
}
.titleurlreservation {
    font-size: 12px;
    font-style: italic;
}
@media (max-width: 991px){
    .promotionprice {
        height: 13px;
        width: 13px;
    }    
    .fc .fc-daygrid-day-number {
        font-size: 17px;
    }
    #fc-day-span-today{
        display: none;
    }
    .fc-day-today {
        background: #0099ff14 !important;
    }

    .fc-daygrid-day-bg {
        font-size: 12px !important;
    }
    .fc-event-end {
        margin-right: 60px !important;
    }
    .fc-event-start {
        margin-left: 60px !important;
    }
    .priceday {
        font-size: 15px;
        margin-top: 15%;
    }
    
}
@media (max-width: 767px){
    .fc .fc-daygrid-day-number {
        font-size: 15px;
    }
    .promotionprice {
        height: 8px;
        width: 8px;
    }  
    .fc-daygrid-day-bg {
        font-size: 10px !important;
    }
    .fc-event-end {
        margin-right: 48px !important;
    }
    .fc-event-start {
        margin-left: 48px !important;
    }
    td.fc-daygrid-day {
        height: 68px !important;
    }
    .priceday {
        font-size: 13px;
        margin-top: 0px;
    }
}
@media (max-width: 450px){
    
    .fc-daygrid-day-bg {
        font-size: 9px !important;
    }
    .fc-event-end {
        margin-right: 38px !important;
    }
    .fc-event-start {
        margin-left: 38px !important;
    }
    
    .priceday {
        font-size: 11px;
        margin-top: 0px;
    }
    
}

.automation-promotion-form .montant-block .row.error {
    color: #ff0000;
}

.automation-promotion-form .montant-block .row.error input{
    border-color: #ff0000;
}

.automation-promotion-form .montant-block .range-info {
    text-align: center;
    margin: 0;
    font-size: 12px;
}

.automation-promotion-form .montant-block .range-info.percent-range {
    width: 80%;
}
</style>'); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="tarif_disp" class="container py-2 px-3">
    <?php echo $this->Flash->render(); ?>
    <div class="row bg-light no-gutters mb-4 mt-n3" >
        <div class="col-sm-6 col-lg-3 list-steps">
            <a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/edit/<?php echo $annonce_id ?>"><span class="d-block text-center ann-step">1. <?= __("Informations") ?></span></a>
        </div>
        <div class="col-sm-6 col-lg-3 list-steps">
            <a href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/photo/<?php echo $annonce_id ?>'><span class="d-block text-center ann-step">2. <?= __("Images") ?></span></a>
        </div>
        <div class="col-sm-6 col-lg-3 list-steps">
            <span class="d-block text-center ann-step active-steps">3. <?= __("Tarification") ?></span>
        </div>
        <div class="col-sm-6 col-lg-3 list-steps">
            <a  href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/".$urlvaluemulti['previsualiser']; ?>/<?php echo $annonce->id ?>'><span class="d-block text-center text-lg-right text-xl-center ann-step after-active-steps">4. <?= __("Prévisualisation") ?></span></a>
        </div>
    </div><!-- end row -->
    <div class="alert alert-danger mb-3" role="alert" id="synchromsg" style="display:none;"></div>

    <div class="row">
        <div class="col-md-12 col-lg-7 p-0 border">
            <div id='calendar' style="overflow:auto;"></div>
        </div>
        <div class="col-md-12 col-lg-5 p-0">
            <div class="smallheight border">
                <div class="divtitletoremove">
                    <h2 class="text-center mb-0 py-3">
                        <?= __("Planning et disponibilité") ?><span class="tooltipsvc ml-2" data-toggle="tooltip" data-placement="bottom" title="<h4><?= __('Paramétrez simplement vos tarifs et disponibilités') ?></h4><p><?= __('Sélectionnez une plage de dates en cliquant : <br> - sur la date de début et en glissant votre souris jusqu’à la date de fin désirée.<br> - sur la date de début désirée puis en modifiant la date de fin via l’écran de paramétrage de la période') ?></p><p><?= __('Sélectionnez une plage de date déjà paramétrée pour écraser les anciens paramètres et en définir de nouveaux.') ?></p><p><?= __('Définissez votre stratégie de promotion grâce aux promotions Early Booking, Last Minute et Séjours Longs. Plus d’informations : ') ?><a href='https://help.alpissime.com' target='_blank'><?= __('Centre d\'aide') ?></a></p>"><i class="fa fa-question-circle-o"></i></span>
                    </h2>
                </div>
                <div class="divdisponibilitestitletoshow" style="display:none;">
                    <h2 class="text-center mb-0 py-3">
                        <button type="button" class="btn btn-previous float-left" onclick="retourDisponibilite()"><i class="fa fa-angle-left fa-2x" aria-hidden="true"></i></button>
                        <?= __("Disponibilité") ?>
                    </h2>
                </div>
                <div class="divpromotionstitletoshow" style="display:none;">
                    <h2 class="text-center mb-0 py-3">
                        <button type="button" class="btn btn-previous float-left" onclick="retourPromotions()"><i class="fa fa-angle-left fa-2x" aria-hidden="true"></i></button>
                        <?= __("Règles de promotion") ?>
                    </h2>
                </div>
                <div class="divfraisfixestitletoshow" style="display:none;">
                    <h2 class="text-center mb-0 py-3">
                        <button type="button" class="btn btn-previous float-left" onclick="retourFraisfixes()"><i class="fa fa-angle-left fa-2x" aria-hidden="true"></i></button>
                        <?= __("Frais fixes") ?>
                    </h2>
                </div>
                <div class="divparametrestitletoshow" style="display:none;">
                    <h2 class="text-center mb-0 py-3">
                        <button type="button" class="btn btn-previous float-left" onclick="retourParametres()"><i class="fa fa-angle-left fa-2x" aria-hidden="true"></i></button>
                        <?= __("Paramètres") ?>
                    </h2>
                </div>
                <div class="divearlybookingtitletoshow" style="display:none;">
                    <h2 class="text-center mb-0 py-3">
                        <button type="button" class="btn btn-previous float-left" onclick="retourEarlybooking()"><i class="fa fa-angle-left fa-2x" aria-hidden="true"></i></button>
                        <?= __("Règles de promotion") ?>
                    </h2>
                </div>
                <div class="divlastminutetitletoshow" style="display:none;">
                    <h2 class="text-center mb-0 py-3">
                        <button type="button" class="btn btn-previous float-left" onclick="retourLastminute()"><i class="fa fa-angle-left fa-2x" aria-hidden="true"></i></button>
                        <?= __("Règles de promotion") ?>
                    </h2>
                </div>
                <div class="divlongsejourstitletoshow" style="display:none;">
                    <h2 class="text-center mb-0 py-3">
                        <button type="button" class="btn btn-previous float-left" onclick="retourLongsejours()"><i class="fa fa-angle-left fa-2x" aria-hidden="true"></i></button>
                        <?= __("Règles de promotion") ?>
                    </h2>
                </div>
            </div>
            <div class="bigheight border blocdispo d-flex align-items-center"> 
                <div class="divtoremove">
                    <div class="px-4">
                        <div class="d-flex mb-2 align-items-center h-100 shadow-sm pl-3 pr-2 py-2 rowdispos disponibilites">
                            <div class="mr-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                                <svg aria-hidden="true" width="50" height="50" viewBox="0 0 97.76 100.21">
                                    <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/Disponibilites.svg#Calque_2"></use>
                                </svg>
                            </div>
                            <div class="fontstyle"><?= __("La disponibilité de votre hébergement est de {0} nuitées.", [$nbrnuiteetotal]) ?></div>
                        </div>
                        <div class="d-flex mb-2 align-items-center h-100 shadow-sm pl-3 pr-2 py-2 rowdispos promotions">
                            <div class="mr-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                                <svg aria-hidden="true" width="65" height="65" viewBox="0 0 97.17 95.5">
                                    <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/Promotions.svg#Calque_2"></use>
                                </svg>
                            </div>
                            <div class="fontstyle"><?= __("Early booking, Last Minute, Séjour Long. Configurez des règles de promotion.") ?></div>
                        </div>
                        <div class="d-flex mb-2 align-items-center h-100 shadow-sm pl-3 pr-2 py-2 rowdispos fraisfixes">
                            <div class="mr-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                                <svg aria-hidden="true" width="65" height="65" viewBox="0 0 100 93.73">
                                    <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/Frais-Fixes.svg#Calque_2"></use>
                                </svg>
                            </div>
                            <div class="fontstyle"><?= __("Frais fixe : appliquez des frais pour les animaux ou des frais de ménage.") ?></div>
                        </div>
                        <div class="d-flex mb-2 align-items-center h-100 shadow-sm pl-3 pr-2 py-2 rowdispos mb-5 parametres">
                            <div class="mr-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                                <svg aria-hidden="true" width="50" height="50" viewBox="0 0 95.83 97.98">
                                    <use xlink:href="<?php echo $this->Url->build('/')?>images/pagesavoie/Fichier 12.svg#Calque_2"></use>
                                </svg>
                            </div>
                            <div class="fontstyle"><?= __("Paramètres") ?></div>
                        </div>
                        <h3 class="pt-5 pt-sm-0 pt-lg-5"><?= __("Indications") ?></h3>
                        <div class="d-flex">
                            <div class="col-3 p-0"><span class="cadredispo shadow-sm"></span></div> <?= __('Disponible') ?>
                        </div>
                        <div class="d-flex">
                            <div class="col-3 p-0"><span class="cadreindispo shadow-sm"></span></div> <?= __('Indisponible') ?>
                        </div>
                        <div class="d-flex">
                            <div class="col-3"><span class="promotionprice cadrepromo"></span></div> <?= __('Promotion') ?>
                        </div>
                    </div> 
                </div>
                <?php
                    echo $this->element('dispos_bloc_disponibilite', []);
                    echo $this->element('dispos_bloc_regles_promotion', ['annonce' => $annonce]);
                    echo $this->element('dispos_bloc_frais_fixes', []);
                    echo $this->element('dispos_bloc_early_booking', []);
                    echo $this->element('dispos_bloc_last_minute', []);
                    echo $this->element('dispos_bloc_long_sejour', []);
                    echo $this->element('dispos_bloc_parametres', []);
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 shadow-sm border p-3 mt-3 text-center">
            <h4><?= __("Synchronisation du calendrier") ?></h4>
            <p class="mb-0 mt-2"><span style="font-size: 15px">
            <i class="fa fa-download mr-2"></i> <u><a href="#" class="importexport text-dark" onclick="importerCalendar()"><?= __("Importer le calendrier") ?></a></u>                                
            <br>
            <i class="fa fa-upload mr-2"></i> <u><a href="#" class="importexport text-dark" onclick="expoterCalendar()"><?= __("Exporter le calendrier") ?></a></u>   
            <br>
            <i class="fa fa-calendar-o mr-3"></i> <u><a href="#" class="importexport text-dark" onclick="myCalendar()"><?= __("Voir mes calendriers") ?></a></u>   
            </p>
        </div>
    </div>

    <h3><?= __("Outils d'aide au pricing") ?></h3>
    <div class="accordion" id="accordionExample">
        <div class="card border-0">
            <div class="card-header py-1" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <?= __("Prix moyens par nuitée dans ma station") ?>
                        <i class="fa fa-angle-down fa-2x float-right" aria-hidden="true"></i>
                    </button>                    
                </h2>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body py-0">
                    <?php                     
                    $i = 0;
                    while ($i <= 12){
                        $dataArrPrix[] = $listePrixSurface[$i];
                        $dataArrPrixTotal[] = $listePrixSurfaceTotalNnReser[$i];
                        $colorArrPrix[] = '#46a3fe';
                        $colorArrPrixTotal[] = '#ff530d';
                        $i++;
                    }
                    
                    echo $this->element('dispos_bloc_prix_moyens_station', array(
                        "dataArrPrix" => $dataArrPrix,
                        "colorArrPrix" => $colorArrPrix,
                        "dataArrPrixTotal" => $dataArrPrixTotal,
                        "colorArrPrixTotal" => $colorArrPrixTotal,
                        "listeTotal" => $listeTotal,
                        "anneechoix" => $anneechoix,
                        "villageannonce" => $villageannonce) 
                    ); ?> 
                </div>
            </div>
        </div>
        <div class="card border-0 mt-3">
            <div class="card-header py-1" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <?= __("Carte européenne des vacances scolaires") ?>
                        <i class="fa fa-angle-down fa-2x float-right" aria-hidden="true"></i>
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                <?php                    
                    echo $this->element('dispos_bloc_carte_vacance_scolaire', array() ); ?> 
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 justify-content-end">
        <div class="col-auto">
            <?php if(!$possible){ ?>
                <!-- <a  href = '<?php echo $this->Url->build('/',true); ?>annonces/photo/<?php echo $annonce_id ?>' class="btn btn-retour left"><?= __("Retour") ?></a> -->
                <?php if($this->Session->read('Auth.User.id')!="" || $this->Session->read('Gestionnaire.info.G.id') != ""):?>
                <button class="btn btn-blue text-white rounded-0 px-6" onclick="location.href = '<?php echo $this->Url->build('/',true); ?>annonces/previsualiser/<?php echo $annonce_id ?>';"><?= __("Prévisualiser") ?></button>      
            <?php else:?>
                <?php //echo $this->element("menu_gestionnaire")?>
            <?php endif;?>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Modal ImportCalendar -->
<div class="modal fade" id="ModalImportCalendar" tabindex="-1" role="dialog" aria-labelledby="ModalImportCalendarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title" id="myModalLabel"><?= __("Importer un calendrier") ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
            </div>
            <div class="modal-body">
            <label for="basic-url" class="mb-4"><?= __("Coller l'URL du calendrier à importer : <br><small>Veuillez importer le calendrier au format iCal</small>") ?></label>
            <div class="input-group mb-3">
                <span class="input-group-addon col-3" id="basic-addon3"><?= __("Nom du calendrier") ?></span> 
                <input type="text" class="form-control col-9" id="nomImport" value="">
            </div>
            <div class="input-group">
                <span class="input-group-addon col-3" id="basic-addon3">URL</span> 
                <input type="text" class="form-control col-9" id="urlImport" value="">
            </div>
            </div>
            <div class="row justify-content-end m-3">
            <button type="button" class="btn btn-default rounded-0 mr-3" data-dismiss="modal"><?= __("Fermer") ?></button>
            <button type="button" name="importer" value="importer" id="importer" class="btn btn-blue text-white rounded-0"><i class="fa fa-refresh fa-spin mr-2" id="loader" style="display:none;"></i><?= __("Importer") ?></button>
            </div>
            <?php //echo $this->Form->end();?>
        </div>
    </div>
</div>
<!-- END Modal ImportCalendar -->
<!-- Modal ExportCalendar -->
<div class="modal fade" id="ModalExportCalendar" tabindex="-1" role="dialog" aria-labelledby="ModalExportCalendarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title" id="myModalLabel"><?= __("Exporter le calendrier") ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
            </div>
            <div class="modal-body">
            <label for="basic-url"><?= __("Copier l'URL suivant") ?> :</label>
            <div class="input-group">
                <span class="input-group-addon col-1 mt-2" id="basic-addon3">URL</span> 
                <input type="text" class="form-control" id="urlExport" value="<?php echo $this->Url->build('/',true)?>dispos/exportical/<?php echo base64_encode($annonce_id) ?>" readonly>
            </div>
            </div>
            <div class="row justify-content-end m-3">
            <button type="button" class="btn btn-default rounded-0" data-dismiss="modal"><?= __("Fermer") ?></button>
            </div>
        </div>
    </div>
</div>
<!-- END Modal ExportCalendar -->
<!-- Modal MyCalendars -->
<div class="modal fade" id="ModalMyCalendars" tabindex="-1" role="dialog" aria-labelledby="ModalMyCalendarsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title" id="myModalLabel"><?= __("Mes calendriers") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>            
            </div>
            <div class="modal-body px-4" id="listcalendars">
                
            </div>
            <div class="row justify-content-end m-3">
            <button type="button" class="btn btn-default rounded-0" data-dismiss="modal"><?= __("Fermer") ?></button>
            </div>
        </div>
    </div>
</div>
<!-- END Modal MyCalendars -->

<div class="modal fade" id="promo_save_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= __("Promotions automatiques") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <p><?= __("Les promotions automatiques ne sont pas cumulables : la promotion la plus favorable au client sera automatiquement appliquée à sa demande de réservation.") ?></p>
                <p><?= __("Une promotion automatique peut être cumulée avec une promotion classique, paramétrée lors de la création d'une disponibilité.") ?></p>
                <div class="text-right">
                    <button type="button" class="btn btn-retour rounded-0 border" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
                    <button type="button" class="btn btn-blue rounded-0 text-white confirm-btn"><?= __("C'est compris !") ?></button>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
// <script>
    var proposerearlybooking = "<?= $annonce_detail->proposerearlybooking; ?>";
    var proposerlastminute = "<?= $annonce_detail->proposerlastminute; ?>";
    var proposerlongsejours = "<?php echo $annonce_detail->proposerlongsejours; ?>";
// IMPORT EXPORT iCal
function importerCalendar(){
    $('#ModalImportCalendar').modal('show');
}
/** Click Importer */
var events = [];
$('#importer').click(function () {   
    $("#loader").css("display", "initial");   
    if($('#nomImport').val() != "" && $("#urlImport").val() != ""){
    $.ajax({
        type: "POST",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>dispos/iCalDecoder",
        data: {iCalNom: $('#nomImport').val(), iCalUrl: $("#urlImport").val(), annonce_id: <?php echo $annonce_id ?>},
        success:function(xml){
            if(xml.periodeajouter == "DOUBLE"){
                $("#synchromsg").html("<?php echo __('Vous avez une réservation dans la même période !'); ?>");
                $("#synchromsg").fadeTo(5000, 500).slideUp(500, function() {
                    $("#synchromsg").slideUp(500);
                });
            }else{
                $("#synchromsg").removeClass("alert-danger");
                $("#synchromsg").addClass("alert-success");
                $("#synchromsg").html("<?php echo __('Calendrier synchronisé'); ?>");
                $("#synchromsg").fadeTo(5000, 500).slideUp(500, function() {
                    $("#synchromsg").slideUp(500);
                });
            }    
        }
    }); 
    }                  

    $('#ModalImportCalendar').modal('hide'); 
    $("#urlImport").val("");
    $("#nomImport").val("");
    window.setTimeout(function () { 
        $("#loader").css("display", "none"); 
    }, 3000);
    location.reload(true);
});
/** END Click Importer */
/** Click exporter */
function expoterCalendar(){
    $('#ModalExportCalendar').modal('show');
}
/** END Click exporter */

/** myCalendar */
function myCalendar(){
    $.ajax({
        type: "POST",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>dispos/listMyCalendar",
        data: {annonce_id: <?php echo $annonce_id ?>},
        success:function(xml){
            $("#listcalendars").html("");
            if(xml.mycalendarscount == 0){
                $("#listcalendars").html("<p><?php echo __("Pas de calendrier synchronisée pour cette annonce"); ?></p>");
            }else{
                $.each(xml.mycalendars,function(i,val){
                    $('#listcalendars').append('<div class="row px-2"><div class="col-md-8 my-auto">' + val.nom + '</div><div class="col-md-4"><button type="button" class="btn btn-danger float-right" onclick="deleteCalendar('+ val.id +')"><?php echo __("Supprimer"); ?></button></div></div>');
                    $('#listcalendars').append('');
                    $('#listcalendars').append('<hr>');
                });
            }            
            $('#ModalMyCalendars').modal('show');        
        }
    });  
}
/** deleteCalendar */
function deleteCalendar(id_calendar){
    $.ajax({
        type: "POST",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>dispos/deleteCalendar",
        data: {idcalendar: id_calendar},
        success:function(xml){
            myCalendar();   
        }
    });
}


$('#collapseOne').on('show.bs.collapse', function () {
  $("#headingOne h2 button i").removeClass('fa-angle-down');
  $("#headingOne h2 button i").addClass('fa-angle-up');
});
$('#collapseOne').on('hide.bs.collapse', function () {
  $("#headingOne h2 button i").removeClass('fa-angle-up');
  $("#headingOne h2 button i").addClass('fa-angle-down');
});
$('#collapseTwo').on('show.bs.collapse', function () {
  $("#headingTwo h2 button i").removeClass('fa-angle-down');
  $("#headingTwo h2 button i").addClass('fa-angle-up');
});
$('#collapseTwo').on('hide.bs.collapse', function () {
  $("#headingTwo h2 button i").removeClass('fa-angle-up');
  $("#headingTwo h2 button i").addClass('fa-angle-down');
});

function retourDisponibilite(){
    $(".divdisponibilitestitletoshow").slideToggle(500, "swing", function(){
        $(".divtitletoremove").slideToggle(500, "swing");    
    }); 
    $(".divdisponibilitestoshow").slideToggle(500, "swing", function(){
        $(".divtoremove").slideToggle(500, "swing");    
    }); 
}

function retourPromotions(){
    $(".divpromotionstitletoshow").slideToggle(500, "swing", function(){
        $(".divtitletoremove").slideToggle(500, "swing");    
    }); 
    $(".divpromotionstoshow").slideToggle(500, "swing", function(){
        $(".divtoremove").slideToggle(500, "swing");    
    });
}

function retourFraisfixes(){
    $(".divfraisfixestitletoshow").slideToggle(500, "swing", function(){
        $(".divtitletoremove").slideToggle(500, "swing");    
    }); 
    $(".divfraisfixestoshow").slideToggle(500, "swing", function(){
        $(".divtoremove").slideToggle(500, "swing");    
    }); 
}
function retourParametres(){
    $(".divparametrestitletoshow").slideToggle(500, "swing", function(){
        $(".divtitletoremove").slideToggle(500, "swing");    
    }); 
    $(".divparametrestoshow").slideToggle(500, "swing", function(){
        $(".divtoremove").slideToggle(500, "swing");    
    }); 
}

    
$(".disponibilites").click(function(){   
    $(".divtitletoremove").slideToggle(500, "swing", function(){
        $(".divdisponibilitestitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divtoremove").slideToggle(500, "swing", function(){
        $(".divdisponibilitestoshow").slideToggle(500, "swing");    
    });  
}); 

$(".promotions").click(function(){
    $(".divtitletoremove").slideToggle(500, "swing", function(){
        $(".divpromotionstitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divtoremove").slideToggle(500, "swing", function(){
        $(".divpromotionstoshow").slideToggle(500, "swing");    
    });
});

$(".fraisfixes").click(function(){   
    $(".divtitletoremove").slideToggle(500, "swing", function(){
        $(".divfraisfixestitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divtoremove").slideToggle(500, "swing", function(){
        $(".divfraisfixestoshow").slideToggle(500, "swing");    
    });  
});

$(".parametres").click(function(){   
    $(".divtitletoremove").slideToggle(500, "swing", function(){
        $(".divparametrestitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divtoremove").slideToggle(500, "swing", function(){
        $(".divparametrestoshow").slideToggle(500, "swing");    
    });  
});


$(".tooltipsvc").tooltip({
    html: true,
    trigger : "manual"
}); 
// $(".tooltipsvc").tooltip('show');


function calculerPrixtotal(prixtaxeapayer = null, fraisService = null){
    var start = moment($("#dbt_at").val(), ["DD-MM-YYYY"]);
    var end = moment($("#fin_at").val(), ["DD-MM-YYYY"]);
    var nbrdays = end.diff(start, 'days');
    var prixTotal = ($("#prix_nuitee").val() * nbrdays).toFixed(2);
    var prixTotalPromo = ($("#prix_promotion").val() * nbrdays).toFixed(2);
   
    var tauxcommession = parseInt("<?php echo $tauxcommession; ?>");
    var prixrecu = (prixTotal-(prixTotal*tauxcommession/100)).toFixed(2);
    var prixrecupromo = (prixTotalPromo-(prixTotalPromo*tauxcommession/100)).toFixed(2);

    if(prixtaxeapayer != null && fraisService != null){
        var prixtotalvacancier = (parseFloat(prixTotal) + parseFloat(prixtaxeapayer) + parseFloat(fraisService)).toFixed(2);
        var prixtotalvacancierpromo = (parseFloat(prixTotalPromo) + parseFloat(prixtaxeapayer) + parseFloat(fraisService)).toFixed(2);
    }

    $("#labelnbrnuitee").html(nbrdays);
    if($("#prix_promotion").val() == ""){
        $(".divprixtotal").html('<span class="float-right font-weight-bold">'+prixTotal+' €</span>');
        $(".divprixtotalrecu").html('<span class="float-right font-weight-bold">'+prixrecu+' €</span>');
        if(prixtaxeapayer != null && fraisService != null){
            $(".divpaiementcavancier").css('display', 'flex');
            $(".divprixtotalcavancier").html('<span class="float-right font-weight-bold">'+prixtotalvacancier+' €</span>');
        } else {
            $(".divpaiementcavancier").css('display', 'none');
        }
    }else{
        $(".divprixtotal").html('<span class="float-right font-weight-bold"><span class="totalSpromo mr-2">'+prixTotal+' €</span><span class="totalWpromo">'+prixTotalPromo+' €</span></span>');
        $(".divprixtotalrecu").html('<span class="float-right font-weight-bold">'+prixrecupromo+' €</span>');
        if(prixtaxeapayer != null && fraisService != null){
            $(".divpaiementcavancier").css('display', 'flex');
            $(".divprixtotalcavancier").html('<span class="float-right font-weight-bold">'+prixtotalvacancierpromo+' €</span>');
        } else {
            $(".divpaiementcavancier").css('display', 'none');
        }
    }
}


document.addEventListener('DOMContentLoaded', function() {
    var datelien = "<?php echo $datedajout; ?>";
    var initialDateValue = moment().format('YYYY-MM-DD');
    if(datelien != ""){
        datelien = moment(datelien, 'DD-MM-YYYY').format('YYYY-MM-DD');
        initialDateValue = datelien;
    }

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        height: 628,
        locale: '<?php echo $language_header_name; ?>',
        dragScroll: true,
        selectable: true,
        longPressDelay: 0,
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        dayHeaderFormat:{
            weekday: 'long',
        },
        initialDate: initialDateValue,
        // selectOverlap: function(event) {
        //     if(event.title == "Libre" || event.title == "PeriodIndispo") return true; 
        //     else return false;
        // },
        selectAllow: function(selectInfo) {
            return moment().diff(selectInfo.start) <= 0
        },
        select: function(arg) {
            if(moment(arg.start).isBefore(moment())) {
                if($(".divtitletoremove").css("display") == "none"){
                    $(".divdisponibilitestitletoshow").slideToggle(500, "swing", function(){
                        $(".divtitletoremove").slideToggle(500, "swing");    
                    }); 
                    $(".divdisponibilitestoshow").slideToggle(500, "swing", function(){
                        $(".divtoremove").slideToggle(500, "swing");    
                    }); 
                }              
                return false;
            }

            if($(".divtitletoremove").css("display") == "block"){
                $(".divtitletoremove").slideToggle(500, "swing", function(){
                    $(".divdisponibilitestitletoshow").slideToggle(500, "swing");    
                }); 
                $(".divtoremove").slideToggle(500, "swing", function(){
                    $(".divdisponibilitestoshow").slideToggle(500, "swing");    
                });
            }
            $('.btn-valider-tarif').prop("disabled", "");            
            $('#statutdispo').prop("disabled", ""); 
            $("#statutdispo + .slider").removeClass('not-allowed');  

            $('#statutdispo').attr('checked', 'checked');
            $("#disponiblelabel").html('<?= __("Disponible") ?>');
            $(".nocheckeddispo").slideDown(500, "swing"); 
            $(".nuiteminlabel").slideDown(500, "swing"); 
            $(".nuitemininput").slideDown(500, "swing");
            
            var start = moment(arg.start);
            var end = moment(arg.end);
            $("#dbt_at").val(start.format('DD-MM-YYYY'));
            $("#fin_at").val(end.format('DD-MM-YYYY'));
            
            calculerPrixtotal();
            
            // chercher nbr evenement durant la période sélectionnée
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>dispos/cherchernbrdispoperiode/<?php echo $annonce_id ?>",
                data: {debut:start.format('DD-MM-YYYY'), fin:end.format('DD-MM-YYYY')},
                success:function(xml){
                    // console.log(xml.totalperiodecount);
                    if(xml.totalperiodecount > 1) $(".spaninfoplustatut").html("<?= __('La période sélectionnée contient plusieurs statuts de disponibilité.') ?>");
                    else $(".spaninfoplustatut").html("");
                }
            });
            // chercher prix
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>dispos/chercherprixperiodeselect/<?php echo $annonce_id ?>",
                data: {debut:start.format('DD-MM-YYYY'), fin:end.format('DD-MM-YYYY')},
                success:function(xml){
                    if(xml.totalperiodecount != ""){
                        if(xml.totalperiodecount.nbr_jour != 0) $('#nbr_nuitee_min').val(xml.totalperiodecount.nbr_jour);
                        if(xml.totalperiodecount.prix_jour != 0) $('#prix_nuitee').val(xml.totalperiodecount.prix_jour);
                        if(xml.totalperiodecount.promo_jour != 0) $('#prix_promotion').val(xml.totalperiodecount.promo_jour);

                        calculerPrixtotal(xml.totalperiodecount.prixtaxeapayer, xml.totalperiodecount.fraisService);
                    }
                }
            });
        },
        // dateClick: function( dateClickInfo ) {
        //     console.log(dateClickInfo.dayEl);
        // },
        eventClick: function(arg) {
            // console.log(arg.event);
            // $(".tooltip").tooltip('hide');
            $(arg.el).tooltip('show');
            
            if($(".divtitletoremove").css("display") == "block"){
                $(".divtitletoremove").slideToggle(500, "swing", function(){
                    $(".divdisponibilitestitletoshow").slideToggle(500, "swing");    
                }); 
                $(".divtoremove").slideToggle(500, "swing", function(){
                    $(".divdisponibilitestoshow").slideToggle(500, "swing");    
                });
            }
            $('#statutdispo').attr('checked', 'checked');
            $("#disponiblelabel").html('<?= __("Disponible") ?>');
            $(".nocheckeddispo").slideDown(500, "swing"); 
            $(".nuiteminlabel").slideDown(500, "swing"); 
            $(".nuitemininput").slideDown(500, "swing");
            
            $('#dbt_at').datepicker("setDate", moment(arg.event.start).format('DD-MM-YYYY') );
            $('#fin_at').datepicker("setDate", moment(arg.event.end).format('DD-MM-YYYY') );
            $('#nbr_nuitee_min').val(arg.event.extendedProps.nbr_jour);
            $('#prix_nuitee').val(arg.event.extendedProps.prix_jour);
            if(arg.event.extendedProps.promo_jour != 0) $('#prix_promotion').val(arg.event.extendedProps.promo_jour);

            calculerPrixtotal(arg.event.extendedProps.prixtaxeapayer, arg.event.extendedProps.fraisService);

            $(".spaninfoplustatut").html("");
            $('.btn-valider-tarif').prop("disabled", "disabled");            
            $('#statutdispo').prop("disabled", "disabled"); 
            $("#statutdispo + .slider").addClass('not-allowed');
        },
        dayMaxEvents: false, // allow "more" link when too many events
        events: {
            url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispo/<?php echo $annonce_id ?>',
            type: 'POST', // Send post data
            error: function() {
                alert('There was an error while fetching events.');
            }
        },
        eventClassNames: function(arg) {
            if (arg.event.title == 'Libre') return [ 'libreclass' ]
        },
        eventContent: function(arg) {
            console.log("eventContent");
            var start = moment(arg.event.start);
            var end = moment(arg.event.end);
            console.log("arg.event.start = ",arg.event.start)
            console.log("arg.event.end = ",arg.event.end)

            if (arg.event.title == 'PeriodIndispo') {
                console.log("PeriodIndispo")
                var count = 1;
                var last = start.format('YYYY-MM-DD');
                while(  start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ) {
                    var dataToFind = start.format('YYYY-MM-DD');
                    var unavailablePeriodTxt = count == 1 ? "<?= __('Période indisponible'); ?>" : '';
                    var cell = $("td[data-date='"+dataToFind+"']");

                    cell.addClass('nondispoclass');
                    cell.find(".fc-daygrid-day-frame .fc-daygrid-day-events").css({'display': 'none'});
                    cell.find(".fc-daygrid-day-frame .fc-daygrid-day-bg").css({'font-size': '12px', 'margin-left': '5px'}).html(unavailablePeriodTxt);

                    start.add(1, 'd');
                    count = count + 1;
                    last = start.format('YYYY-MM-DD');
                }
                if(last == end.format('YYYY-MM-DD')){
                    $("td[data-date='"+end.format('YYYY-MM-DD')+"'] .fc-daygrid-day-frame .fc-daygrid-day-events").css({'visibility': 'hidden'}); 
                }
            } else {
                console.log("start = ",start.format('YYYY-MM-DD'))
                console.log("end = ",end.format('YYYY-MM-DD'))
                console.log("arg.event = ",arg.event)
                console.log("dispo_id = ",arg.event.extendedProps.dispo_id)
                console.log("reservation_id = ",arg.event.extendedProps.reservation_id)
                console.log("prixnuitee = ",arg.event.extendedProps.prixnuitee)
                console.log("arg.event.title = ",arg.event.title)
                while (start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD')){
                    var dataToFind = start.format('YYYY-MM-DD');
                    var cell = $("td[data-date='" + dataToFind + "']");
                    console.log("dataToFind = ",dataToFind)
                    console.log("cell = ",cell)
                    cell.find(".fc-daygrid-day-frame .fc-daygrid-day-events").css("visibility", (arg.event.title == 'Libre' ? "hidden" : "visible"));

                    if (arg.event.extendedProps.stautreserve != 90) {
                        var promoElem = arg.event.extendedProps.promotion == 1 ? "<span class='promotionprice'></span>" : '';
                        var priceHtml = "<div class='priceday font-italic'>" + promoElem + arg.event.extendedProps.prixnuitee + "€</div>";

                        cell.find(".fc-daygrid-day-frame .fc-daygrid-day-bg").html(priceHtml);
                    }

                    start.add(1, 'd');
                }
            }
        },
        dayCellContent: function(info, create) {
            let listelements = [];
            let today = moment().format('YYYY-MM-DD');
            let elementoday = "";
            if(today == moment(info.date).format("YYYY-MM-DD")) elementoday = create('span', { id: "fc-day-span-today" }, "Aujourd'hui");
            const element = create('span', { id: "fc-day-span-"+moment(info.date).format("YYYY-MM-DD") }, info.dayNumberText);
            listelements.push(element,elementoday);
            return listelements;
        },
        eventDidMount: function(info) {
            if(info.event.extendedProps.url_liste_reservation != ''){
                $(info.el).tooltip({ 
                    html: true,
                    title: '<h4 class="font-weight-bold text-blue mb-0">'+info.event.title+'</h4><span>'+info.event.extendedProps.periode+'</span><p class="my-2">'+info.event.extendedProps.locataire+' <span class="titleurlreservation">'+info.event.extendedProps.titre_url_liste_reservation+'</span> <a class="link-reservation text-center" href="<?php echo $this->Url->build('/',true).$urlLang;?>'+info.event.extendedProps.url_liste_reservation+'"><?= __("Voir la réservation") ?></a></p>',
                    placement: "top",
                    trigger: "manual",
                    container: "body",
                    template: '<div class="tooltip tooltipselector" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                });
            }else{
                $(info.el).tooltip({ 
                    html: true,
                    title: '<h4 class="font-weight-bold text-blue mb-0">'+info.event.title+'</h4><span>'+info.event.extendedProps.periode+'</span><p class="my-2">'+info.event.extendedProps.locataire+' </p>',
                    placement: "top",
                    trigger: "manual",
                    container: "body",
                    template: '<div class="tooltip tooltipselector" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                });
            }
           
        },
        eventMouseEnter: function( mouseEnterInfo ) {
            $(".tooltip").tooltip('hide');
            $(mouseEnterInfo.el).tooltip('show');
        },
        eventMouseLeave: function( mouseLeaveInfo ) {
            $(mouseLeaveInfo.el).tooltip('show');
        }
    });

    calendar.render();

    if (window.matchMedia("(max-width: 767px)").matches) {
        calendar.setOption('height', 500);
    }
});

// var datelien = "<?php echo $datedajout; ?>";
// if(datelien != ""){
//     datelien = moment(datelien, 'DD-MM-YYYY');
//     calendar.gotoDate( datelien );
//     //$('#calendar').fullCalendar('gotoDate', datelien);
// }

$( "#calendar" ).mouseleave(function() {
    $(".tooltip").tooltip('hide');
});

$(document).ready(function () {

    $('body').on('mouseleave', '.tooltip', function () {
        $(this).tooltip('hide');
    });

    $( '[data-toggle="tooltip"]' ).hover(function() {
        $(this).tooltip('show');
    });

    // $('[data-toggle="tooltip"] > i').on('mouseenter', function () {
    //     $(this).tooltip('show');
    // });
    // $('.tooltip > i').on('mouseenter', function () {
    //     $(this).tooltip('show');
    // });

    $('[data-toggle="tooltip"]').on('click', function () {
        $(this).tooltip('show');
    }); 
});

<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->script("/js/dispos/scripts.js", ['block' => 'scriptBottom']); ?>
