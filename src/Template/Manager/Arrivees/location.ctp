<?php
$mdp_en_clair = "";
$possible = "0123456789bcdfghjkmnpqrstvwxyz";
$i = 0;
while ($i < 8) {
    $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
    if (!strstr($mdp_en_clair, $char)) {
        $mdp_en_clair .= $char;
        $i++;
    }
}
$nouvMdp = $mdp_en_clair;
?>
<?php $this->start('cssTop'); ?>
<style>
    .fc-unthemed .fc-today { background: #3daefe !important; }

    .vertical-center {
        min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
        align-items: center;
        }
    .nopadding {
        padding: 0 !important;
        margin: 0 !important;
    }
    .calendarinit {
    visibility: hidden;
    position: absolute;
    }
    a.fc-day-grid-event::after {
    left: 97% !important;
    top: 0px !important;
    }
    a.fc-day-grid-event::before {
        left: -1px !important;
        top: 0px !important;
    }
    a.fc-day-grid-event {
        height: 17px;
    }
    a.fc-day-grid-event::before {
        border-top: 17px solid rgba(241, 241, 241, 0.72) !important;
    }
    span.fc-title {
        margin-left: 40px;
    }
    .reserverafter::after {
    border-top: 17px solid #f54f4f !important;
    }
    .displayBlock{
        display: block !important;
    }
    .displayNone{
        display: none !important;
    }
    .country-list{
        z-index: 999 !important;
    }
</style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-sm-12">
      <h5 class="txt-dark">Création d'une location</h5>
</div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
                        <form id="example-advanced-form" method="POST">
                            <input type="hidden" name="issubmit" value="1">

                            <input type="hidden" id="creationCompteManuelleHidden" name="creationCompteManuelleHidden" />
                            <input type="hidden" id="creationReservationLocManuelleHidden" name="creationReservationLocManuelleHidden" />
                            <input type="hidden" id="mdpenclair" name="mdpenclair" />
                            <input type="hidden" id="totalapayer" name="totalapayer" />
                            <input type="hidden" name="issubmit" value="1">
                            
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Réservation</span></h3>
                                <fieldset>
                                        <div class="row">
                                                        <div class="form-wrap">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label font-16">Propriétaire : <sup class='text-danger'>*</sup></label>
                                                                            <select type="text" placeholder="choisir un Propriétaire..." autocomplete="off" class="form-control select2"  name="proprietaire_id" id="nom" onchange="setInfo(this.value)">
                                                                                <option value=""></option>
                                                                                <?php foreach($annonce as $ann):?>
                                                                                <option value="<?php echo $ann->id?>-<?php echo $ann->surface?>"><?php echo $ann['U']['prenom']?> <?php echo $ann['U']['nom_famille']?> <?php echo $ann->num_app?> <?php echo strtolower($ann['R']['name'])?> </option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                            <div id="before_proprietaire_id_error"></div>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label font-16" for="firstName">ID Annonce:</label>
                                                                            <input type="text" readonly name="annonce_id" id="annonce_id"  class="form-control tel"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="form-group" style="margin-top:5%;">
                                                                <div class="row vertical-center calendarinit" id="calendarResMan">
                                                                        <div class="col-md-6 col-sm-12">
                                                                            <div id="calendar4"></div>
                                                                        </div>
                                                                        <div class="col-md-2 col-sm-4">
                                                                            <div><div id="carreorange" class="pull-left"></div> <span class="indication">&nbsp; Option</span></div>
                                                                            <br>
                                                                            <div><div id="carrevert" class="pull-left"></div> <span class="indication">&nbsp; Disponible</span></div>
                                                                            <br>
                                                                            <div><div id="carrerouge" class="pull-left"></div> <span class="indication">&nbsp; Réservé</span></div>
                                                                            <br>
                                                                            <div><div id="carrerose" class="pull-left"></div> <span class="indication">&nbsp; Promotion</span></div>
                                                                        </div>
                                                                        <div class="col-md-4 col-sm-12">
                                                                            <label id="msg_debut" class="control-label font-16">Choisir une période :</label><br>
                                                                            <div class="row nopadding">
                                                                                <div class="col-sm-6 nopadding">
                                                                                    <label id="msg_debut" class="control-label font-15">Date d'arrivée : <sup class='text-danger'>*</sup></label><br>
                                                                                    <input autocomplete="off" type="text" name="debut" id="dbt_at"  class="medium date"/>
                                                                                </div>
                                                                                <div class="col-sm-6 nopadding">
                                                                                    <label id="msg_debut" class="control-label font-15">Date de départ : <sup class='text-danger'>*</sup></label><br>
                                                                                    <input autocomplete="off" type="text" name="fin" id="fin_at"  class="medium date"/>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <button type="button" class="submit_reserv btn btn-success hvr-sweep-to-top right " onclick="chercherdisponibilite()">Chercher</button>
                                                                            <br><br>
                                                                            <p style="text-align:center" id="resultatdispo"></p>
                                                                            <p style="text-align:center" id="periodedispo"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-3 col-xs-12">
                                                                        <label class="control-label font-16">Nombre d'enfants : <sup class='text-danger'>*</sup></label>
                                                                        <select type="text" placeholder="choisir un Propriétaire..." autocomplete="off" class="form-control select2" name="enfant" id="nb_enfant">
                                                                            <?php for($i=0;$i<17;$i++):?>
                                                                                <option value="<?php echo $i?>"><?php echo $i?></option>
                                                                            <?php endfor;?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3 col-xs-12"></div>
                                                                    <div class="col-md-4 col-xs-12">
                                                                        <label class="control-label col-sm-12 nopadding font-16">Nombre d'adultes à partir de 18 ans : <sup class='text-danger'>*</sup></label>
                                                                        <div class="col-sm-6 nopadding">
                                                                            <select type="text" placeholder="choisir un Propriétaire..." autocomplete="off" class="form-control select2" name="adult" id="nb_adult">
                                                                                <?php for($i=1;$i<19;$i++):?>
                                                                                    <option value="<?php echo $i?>"><?php echo $i?></option>
                                                                                <?php endfor;?>
                                                                            </select>
                                                                        </div>
                                                                        <div id="listenum" class="displayNone nopadding col-sm-12 pt-20" >
                                                                            <!--<div class="col-sm-4">-->
                                                                              <div class="form-group">
                                                                              <label class="control-label col-sm-12 nopadding font-16">Ajouter des numéros de téléphone : </label>
                                                                              <div class="col-lg-6 col-md-6 col-sm-6 nopadding pt-10" id="numl">

                                                                              </div>
                                                                              </div>
                                                                            <!--</div>-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4 col-xs-12">
                                                                        <label class="control-label mb-10 font-16">Ménage</label>
                                                                        <div class="radio-list">
                                                                                <div class="radio-inline pl-0">
                                                                                        <span class="radio radio-primary">
                                                                                            <input type="radio" checked name="menage" id="ReservationMenage0" value="0">
                                                                                            <label for="ReservationMenage0">Non</label>
                                                                                </span>
                                                                                </div>
                                                                                <div class="radio-inline">
                                                                                        <span class="radio radio-primary">
                                                                                                <input type="radio" name="menage" id="ReservationMenage1" value="1">
                                                                                                <label for="ReservationMenage1">Oui </label>
                                                                                </span>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-xs-12"></div>
                                                                    <div class="col-md-4 col-xs-12">
                                                                        <label class="control-label font-16">Surface :</label>
                                                                        <div class="input-group">
                                                                            <input type="text" readonly class="form-control" id="surface" name="surface">
                                                                                <div class="input-group-addon">m²</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4 col-xs-12">
                                                                        <label class="control-label mb-10 font-16">Taxe de séjour gérée par alpissime</label>
                                                                        <div class="radio-list">
                                                                                <div class="radio-inline pl-0">
                                                                                        <span class="radio radio-primary">
                                                                                            <input type="radio" checked name="taxe" id="ReservationTaxe0" value="0">
                                                                                            <label for="ReservationTaxe0">Non</label>
                                                                                </span>
                                                                                </div>
                                                                                <div class="radio-inline">
                                                                                        <span class="radio radio-primary">
                                                                                                <input type="radio" name="taxe" id="ReservationTaxe1" value="1">
                                                                                                <label for="ReservationTaxe1">Oui </label>
                                                                                </span>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-xs-12"></div>
                                                                    <div class="col-md-4 col-xs-12">
                                                                        <label class="control-label font-16">Commentaires :</label>
                                                                        <textarea id="ReservationComment" class="form-control" maxlength="1000" rows="3" cols="40" name="comment"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                            </div>
                                        </div>
                                </fieldset>
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Locataire</span></h3>
                                <fieldset>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2 col-xs-12">
                                                    <label class="control-label font-16" for="firstName">Civilité: <sup class='text-danger'>*</sup></label>
                                                    <select id="ReservationCivilite"  name="civilite" class="form-control">
                                                        <option value="Mr">Mr</option>
                                                        <option value="Mme">Mme</option>
                                                        <option value="Mlle">Mlle</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label font-16" for="firstName">Nom: <sup class='text-danger'>*</sup></label>
                                                    <input type="text"  autocomplete="off" name="nom" id="ReservationNom"  class="form-control"  />
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label font-16" for="firstName">Prénom: <sup class='text-danger'>*</sup></label>
                                                    <input type="text"  name="prenom" autocomplete="off" id="ReservationPrenom"  class="form-control"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label font-16" for="firstName">E-mail: <sup class='text-danger'>*</sup></label>
                                                    <input type="text"  name="email" autocomplete="off" id="ReservationMail"  class="form-control"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label font-16" for="firstName">Pays: <sup class='text-danger'>*</sup></label>
                                                    <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control','label'=>false,'options'=>$Pays,'default'=>'0']);?>
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-3 col-xs-12">
                                                    <label class="control-label font-16" for="firstName">Code postal: <sup class='text-danger'>*</sup></label>
                                                    <input type="text"  name="code_postal" id="ReservationCodePostal"  class="form-control"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div id="regiondiv">
                                                    <div class="col-md-4 col-xs-12">
                                                        <label class="control-label font-16" for="firstName">Département: <sup class='text-danger'>*</sup></label>
                                                        <?php echo $this->Form->input('region',['type'=>'select','class'=>'form-control','label'=>false,'options'=>'']);?>
                                                    </div>
                                                    <div class="col-md-2 col-xs-12"></div>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label font-16" for="firstName">Ville: <sup class='text-danger'>*</sup></label>
                                                    <?php echo $this->Form->input('villeprop',['type'=>'select','class'=>'form-control','label'=>false,'options'=>'']);?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label font-16" for="firstName">Portable 1: <sup class='text-danger'>*</sup></label>
                                                    <input type="text"   name="portable1" autocomplete="off" id="ReservationPortable1"  class="form-control tel"/>
                                                    <span id="error-msg" class="hide">Numéro invalide</span>
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label font-16" for="firstName">Portable 2:</label>
                                                    <input type="text"   name="portable2" autocomplete="off" id="ReservationPortable2"  class="form-control tel"/>
                                                    <span id="error-msg2" class="hide">Numéro invalide</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                         <div class="col-sm-12 pl-0">
                                             <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                         </div>
                                    </div>
                                </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.modal -->
<div id="ModalEdit2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title">Détails période</h5>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8"><h6 class="panel-title txt-dark">Statut :</h6></div>
                        <div class="col-sm-4"><label id="statut" class="control-label mb-10"></label></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8"><h6 class="panel-title txt-dark">Durée minimum de séjour :</h6></div>
                        <div class="col-sm-4"><label id="nbr_jour" class="control-label mb-10"></label></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8"><h6 class="panel-title txt-dark">Prix /nuitée (€) :</h6></div>
                        <div class="col-sm-4"><label id="prix_jour" class="control-label mb-10"></label></div>
                    </div>
                    <div class="row" id="divpromojour">
                        <div class="col-sm-8"><h6 class="panel-title txt-dark">Prix promotion /nuitée (€) :</h6></div>
                        <div class="col-sm-4"><label id="promo_jour" class="control-label mb-10"></label></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Form Wizard JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery.steps/build/jquery.steps.min.js", array('block' => 'scriptBottom')); ?>

<!-- Select2 JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/fullcalendar.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/fullcalendar/css/fullcalendar.css", array('block' => 'cssTop')); ?>

<link href='<?php echo $this->Url->build('/',true)?>/manager-arr/vendors/bower_components/fullcalendar/css/fullcalendar.print.css' rel='stylesheet' media='print' />

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<!-- jquery-steps css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery.steps/demo/css/jquery.steps.css", array('block' => 'cssTop')); ?>

<!-- select2 CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    $('#regiondiv').hide();
    var prd_dispo=false;
    function check_th_input(){
        $('#radio_container input').click();
        form_2.valid();
    }
    function chercherdisponibilite(){
        prd_dispo=true;
        $("#Modaladd .close").click();
        document.getElementById("periodedispo").style.display = 'block';
        document.getElementById("resultatdispo").style.display = 'block';
        $.ajax({
          type: "POST",
          dataType : 'json',
          url: "<?php echo $this->Url->build('/',true)?>dispos/chercherdisponibilite/"+$('#annonce_id').val(),
          data: {debut:$('#dbt_at').val(), fin:$('#fin_at').val()},
          success:function(xml){
            document.getElementById("resultatdispo").style.display = 'block';
            if(xml.nbrperiode == 1){
              var deb = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
              var debCal = moment($('#dbt_at').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
              var fn = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
              var fnCal = moment($('#fin_at').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

               var elim = '';
               var elimCon = '';
               var dureemin = [];
                 $.each(xml.nbrDiff[1], function(index, value) {
                   if(value.toString().indexOf("_") != -1){
                     var tab = value.split("_");
                     var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                     var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                     var Diff = fnDiff.diff(dbtDiff, 'days');
                     var d = tab[0];
                     dureemin.push(parseInt(d));
                    //  if(Diff < parseInt(d)){
                    //    if(dbtDiff.format('YYYY-MM-DD') == deb){
                    //      deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                    //    }else{
                    //      fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                    //    }
                    //    elim = d;
                    //  }
                    //  if(Diff == 7){
                    //    if(xml.details['condition'][1] == 1 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                    //        elimCon = "ui";
                    //    }else if (xml.details['condition'][1] == 2 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                    //      elimCon = "ui";
                    //    }
                    //  }

                     }else{
                       var dbtDiff = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                       var fnDiff = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                       var Diff = fnDiff.diff(dbtDiff, 'days');
                       var d = value;
                       dureemin.push(parseInt(d));
                      //  if(Diff < parseInt(d)){
                      //    if(dbtDiff.format('YYYY-MM-DD') == deb){
                      //      deb = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                      //    }else{
                      //      fn = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                      //    }
                      //    elim = d;
                      //  }
                      //  if(Diff == 7){
                      //    if(xml.details['condition'][1] == 1 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                      //        elimCon = "ui";
                      //    }else if (xml.details['condition'][1] == 2 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                      //      elimCon = "ui";
                      //    }
                      //  }

                     }
                 });

                var maxMinduree = Math.max(...dureemin);
                var debutdiffmin = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                var findiffmin = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                var DiffDateCal = findiffmin.diff(debutdiffmin, 'days');
                if(DiffDateCal < maxMinduree){
                  if(debutdiffmin.format('YYYY-MM-DD') == deb){
                    deb = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                  }else{
                    fn = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                  }
                  elim = maxMinduree;
                }  

                 if(deb < fn){
                   xml.disponi[1] = 'Période : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
                 }else{
                   xml.disponi[1] = '';
                 }

                 if( elimCon == ''){
                   if((deb == debCal) && (fn == fnCal)){
                     document.getElementById("periodedispo").style.marginBottom = '0';

                     if(deb > fn){
                       $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE</span>");
                       $('#periodedispo').html('');
                       prd_dispo=false;
                     }else{
                       $('#resultatdispo').html("<span style='color: #106710;font-size: 15px;font-weight: 600;'>PERIODE DISPONIBLE</span>");
                       $('#periodedispo').html('');
                       if(xml.disponi[1] != ''){
                       $('#periodedispo').append("<div id='radio_container' style='visibility: hidden;' class=\"radio radio-primary\"><input type=\"radio\" name=\"sel\" id='"+deb+"/"+fn+"' value='"+deb+"/"+fn+"' checked><label> </label></div>");
                     }
                     }

                    }else{
                      if(elim != ''){
                        $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE (Minimum séjour: "+elim+" nuitées)</span><br>");
                        $('#periodedispo').html('');
                        prd_dispo=false;
                      }else{
                        $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span><br>");
                        $('#periodedispo').html('');
                        prd_dispo=false;
                      }

                     $.each(xml.disponi, function(index, value) {
                       if(xml.disponi[index] != ''){
                           "<div class=\"radio radio-primary\"><input type=\"radio\" name=\"sel\" id='"+deb+"/"+fn+"' value='"+deb+"/"+fn+"'><label for=\"radio1\">"+value+" </label></div>"
                       $('#periodedispo').append("<div id='radio_container' class=\"radio radio-primary\"><span class='radio radio-primary'><input type=\"radio\" name=\"sel\" id='"+deb+"/"+fn+"' value='"+deb+"/"+fn+"'><label onclick='check_th_input()' >"+value+" </label></span></div>");
                     }
                     });
                   }
                 }else{
                   $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span>");
                   $('#periodedispo').html('');
                   prd_dispo=false;
                 }

            }else{
              //var i = 1;
              for (i = 1; i <= xml.nbrperiode; i++) {
                var elimCon = '';
                  $.each(xml.nbrDiff[i], function(index, value) {

                    var deb = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                    var debCal = moment($('#dbt_at').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
                    var fn = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                    var fnCal = moment($('#fin_at').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

                     var elim = '';var elimCon = '';var dureemin = [];
                       $.each(xml.nbrDiff[i], function(index, value) {
                         if(value.toString().indexOf("_") != -1){
                           var tab = value.split("_");
                           var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                           var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                           var Diff = fnDiff.diff(dbtDiff, 'days');
                           var d = tab[0];
                           dureemin.push(parseInt(d));
                          //  if(Diff < parseInt(d)){
                          //    if(dbtDiff.format('YYYY-MM-DD') == deb){
                          //      deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                          //    }else{
                          //      fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                          //    }
                          //    elim = "ui";
                          //  }
                          //  if(Diff == 7){
                          //    if(xml.details['condition'][i] == 1 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                          //        elimCon = "ui";
                          //    }else if (xml.details['condition'][i] == 2 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                          //      elimCon = "ui";
                          //    }
                          //  }

                           }else{
                             var dbtDiff = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                             var fnDiff = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                             var Diff = fnDiff.diff(dbtDiff, 'days');
                             var d = value;
                             dureemin.push(parseInt(d));
                            //  if(Diff < parseInt(d)){
                            //    if(dbtDiff.format('YYYY-MM-DD') == deb){
                            //      deb = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                            //    }else{
                            //      fn = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                            //    }
                            //    elim = "ui";
                            //  }
                            //  if(Diff == 7){
                            //    if(xml.details['condition'][i] == 1 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                            //        elimCon = "ui";
                            //    }else if (xml.details['condition'][i] == 2 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                            //      elimCon = "ui";
                            //    }
                            //  }

                           }

                       });
                        var maxMinduree = Math.max(...dureemin);
                        var debutdiffmin = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var findiffmin = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var DiffDateCal = findiffmin.diff(debutdiffmin, 'days');
                        if(DiffDateCal < maxMinduree){
                          if(debutdiffmin.format('YYYY-MM-DD') == deb){
                            deb = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                          }else{
                            fn = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                          }
                          elim = maxMinduree;
                        } 
                       if(deb < fn){
                         xml.disponi[i] = 'Période  : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
                       }else{
                         xml.disponi[i] = '';
                       }

                  });

              }

              if( elimCon == ''){
                $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span><br>");
                $('#periodedispo').html('');
                prd_dispo=false;
                $.each(xml.disponi, function(index, value) {
                  var deb = moment(xml.details['debut'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                  var fn = moment(xml.details['fin'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                  if(xml.disponi[index] != ''){
                    $('#periodedispo').append("<div id='radio_container' class=\"radio radio-primary\"><span class='radio radio-primary'><input type=\"radio\" name=\"sel\" id='"+deb+"/"+fn+"' value='"+deb+"/"+fn+"'><label onclick='check_th_input()' >"+value+" </label></span></div>");
                  }
                });
              }else{
                $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span>");
                prd_dispo=false;
                console.log(elimCon);
                $('#periodedispo').html('');
              }
            }
           }

          });
          form_2.valid();
    }
function setInfo(vId){
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
         a_info=vId.split("-");
         $('#annonce_id').val(a_info[0]);
         $('#surface').val(a_info[1]);
         $('#getreservation').attr('href','<?php echo $this->Url->build('/',true)?>manager/arrivees/getreservation/'+a_info[0]);
         $('#dbt_at').val('');
         $('#fin_at').val('');

            document.getElementById("periodedispo").style.display = 'none';
            document.getElementById("resultatdispo").style.display = 'none';
            if($(document).width()>992)
            document.getElementById("calendarResMan").style.display = 'flex';
            else document.getElementById("calendarResMan").style.display = 'block';
            
            $('#calendarResMan').removeClass('calendarinit');
            $('#calendarResMan').addClass('calendarinitinvers');
       
            var source = {
              url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispoLoc/'+$('#annonce_id').val(),
              type: 'POST', // Send post data
                    };
                    $('#calendar4').fullCalendar('removeEvents');
                    $('#calendar4').fullCalendar('addEventSource', source);
        $('body').loadingModal('destroy');
        form_2.valid();
        }
$(document).ready(function(){

      $("#region").change(function() {  
        $.ajax({
            type: "POST",
            dataType : 'json',
            async: false,
            url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
            data: {departementid: $(this).val()},
            success:function(xml){
              data = xml.listepville;
              $('#villeprop').empty();
              for (var i = 0; i < data.length; i++) {
                  $('#villeprop').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
              }
            }
        });
    }); 
        $( "#pays" ).change(function() {
        if($(this).val() == 67){
            $('#regiondiv').show();
            $('#notregiondiv').hide();
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
                success:function(xml){
                  data = xml.listefrregions;
                  $('#region').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#region').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                  }
                }
            });

           $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
                data: {departementid: $('#region').val()},
                success:function(xml){
                  data = xml.listepville;
                  $('#villeprop').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#villeprop').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                  }
                }
            });
        }else{
          $('#regiondiv').hide();
          $('#notregiondiv').show();
          $.ajax({
              type: "POST",
              dataType : 'json',
              async: false,
              url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypaysvilles/",
              data: {paysid: $(this).val()},
              success:function(xml){
                data = xml.listepville;
                $('#villeprop').empty();
                for (var i = 0; i < data.length; i++) {
                    $('#villeprop').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                }
              }
          });
        }
//        var monTableauJS = <?php //echo json_encode($paysNum) ?>;
//        $("#utiliTelephone").intlTelInput("setCountry", monTableauJS[$(this).val()]);
//        $("#utiliTelephone").val('');
//        validNum = "non";
//        $("#portablenum").intlTelInput("setCountry", monTableauJS[$(this).val()]);
//        $("#portablenum").val('');
//        validNum2 = "non";
    });
    
    $("#ReservationCodePostal").on('input',function(e){
        if($( "#pays" ).val() == 67 && ($( "#ReservationCodePostal" ).val().length == 4 || $( "#ReservationCodePostal" ).val().length == 5)){
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
                data: {code: $("#ReservationCodePostal").val()},
                success:function(xml){                
                    data = xml.listepville;
                    if(data.length > 0){
                      $('#villeprop').empty();
                      for (var i = 0; i < data.length; i++) {
                          $('#villeprop').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                          $('#region').val(data[i].departement_id);
                      }
                    }
                    
                }
            });
        }
        if($( "#pays" ).val() == 67 && $( "#ReservationCodePostal" ).val().length > 5){
            $("#ReservationCodePostal").val($("#ReservationCodePostal").val().substr(0, 5));
        }
    });

    $('#dbt_at').datetimepicker({
                            useCurrent: false,
                            format: 'DD-MM-YYYY',
                            minDate: moment(),
                            viewDate: moment(),
                            icons: {
                            date: "fa fa-calendar",
                            up: "fa fa-arrow-up",
                            down: "fa fa-arrow-down"
                        },
                        });
    $('#fin_at').datetimepicker({
                            useCurrent: false,
                            format: 'DD-MM-YYYY',
                            minDate: moment().add(1, 'days'),
                            viewDate: moment().add(1, 'days'),
                            icons: {
                            date: "fa fa-calendar",
                            up: "fa fa-arrow-up",
                            down: "fa fa-arrow-down"
                        },
                        });

    $("#dbt_at").on('dp.change', function(e){
    $('#fin_at').data("DateTimePicker").destroy();

        $('#fin_at').datetimepicker({
                            useCurrent: false,
                            format: 'DD-MM-YYYY',
                            minDate: e.date.add(1, 'days').format("YYYY/MM/DD"),
                            viewDate: e.date.format("YYYY/MM/DD"),
                            icons: {
                            date: "fa fa-calendar",
                            up: "fa fa-arrow-up",
                            down: "fa fa-arrow-down"
                        },
                        });
        });
        /* Select2 Init*/
        $(".select2").select2();

          $('#calendar4').fullCalendar({
              header: {
                left: 'prev',
                center: 'title',
                right: 'next'
              },
                editable: false,
                eventLimit: false, // allow "more" link when too many events
                firstDay: 1,
           events: {
             url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispoLoc/'+$('#annonce_id').val(),
             type: 'POST', // Send post data
    //         error: function() {
    //           alert('There was an error while fetching events.');
    //         }
           },
           eventRender: function (event, element) {
             if (event.promotion == 1) {
               var start = moment(event.start);
               var end = moment(event.end);
               while( start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ){
                 var dataToFind = start.format('YYYY-MM-DD');
                 $("td[data-date='"+dataToFind+"'].fc-widget-content").addClass('promotion');
                 start.add(1, 'd');
               }
              // element.addClass('promosbefore');
             }
             if(event.statut == 50){
               element.addClass('optionafter');
             }

             if(event.statut == 90 || event.statut == 100){
               element.addClass('reserverafter');
             }
           },

           eventClick:  function(event, jsEvent, view) {
             var cond;
            //  if(event.conditionnbr == 1){
            //    cond = " <i><b> (semaine commence le samedi)</b></i>" ;
            //  }else if (event.conditionnbr == 2){
            //    cond = " <i><b> (semaine commence le dimanche)</b></i>" ;
            //  }else{
               cond = "";
            //  }
             if(event.statut == 50) $('#ModalEdit2 #statut').html("Option");
             else if(event.statut == 0) $('#ModalEdit2 #statut').html("Libre");
             else if(event.statut == 90 || event.statut == 100) $('#ModalEdit2 #statut').html("Réservé");
             $('#ModalEdit2 #nbr_jour').html(event.nbr_jour + cond);
             $('#ModalEdit2 #prix_jour').html(event.prix_jour);
             if(event.promotion == 0 ){
               document.getElementById('promo_jour').style.display = 'none';
               document.getElementById('divpromojour').style.display = 'none';
               document.getElementById("prix_jour").style.textDecoration = "none";
               document.getElementById("prix_jour").style.color = "black";
             }else{
               document.getElementById('promo_jour').style.display = 'block';
               document.getElementById('divpromojour').style.display = 'block';
               $('#ModalEdit2 #promo_jour').html(event.promo_jour);
               document.getElementById("prix_jour").style.textDecoration = "line-through";
               document.getElementById("prix_jour").style.color = "red";
             }

             $('#ModalEdit2').modal('show');
           },
           eventMouseover: function (data, event, view) {
             var cond;
            //  if(data.conditionnbr == 1){
            //    cond = "<strong> (semaine commence le samedi)</strong>" ;
            //  }else if (data.conditionnbr == 2){
            //    cond = "<strong> (semaine commence le dimanche)</strong>" ;
            //  }else{
               cond = "";
            //  }
             if(data.promotion == 0){
               tooltip = '<div class="tooltiptopicevent">' + 'Durée minimum de séjour ' + ': <span class="nouveauprix">' + data.nbr_jour + cond + '</span></br>' + 'Prix/nuitée ' + ': <span class="nouveauprix">' + data.prix_jour + '€</span><br>Date de départ ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
             }else{
               tooltip = '<div class="tooltiptopicevent">' + 'Durée minimum de séjour ' + ': <span class="nouveauprix">' + data.nbr_jour + cond +'</span></br>' + 'Prix/nuitée ' + ': <span class="ancienprix">' + data.prix_jour + '€</span></br>' + 'Prix promotion/nuitée ' + ': <span class="nouveauprix">' + data.promo_jour +'€</span><br>Date de départ ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
             }

              $("body").append(tooltip);
              $(this).mouseover(function (e) {
                  //$(this).css('z-index', 10000);
                  $('.tooltiptopicevent').fadeIn('500');
                  $('.tooltiptopicevent').fadeTo('10', 1.9);
              }).mousemove(function (e) {
                  $('.tooltiptopicevent').css('top', e.pageY + 10);
                  $('.tooltiptopicevent').css('left', e.pageX + 20);
              });


          },
          eventMouseout: function (data, event, view) {
              //$(this).css('z-index', 8);

              $('.tooltiptopicevent').remove();

          },
          viewRender : function ( view, element ){
            if($('#annonce_id').val() != 0){
              $('#calendar4').fullCalendar('removeEventSources');
              var source = {
                url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispoLoc/'+$('#annonce_id').val(),
                type: 'POST', // Send post data
                      };
                $('#calendar4').fullCalendar('addEventSource', source);
            }

          }

      });
    
});
              
//additional methods to validation              
jQuery.validator.addMethod("telInputisNumber", function(value, element, param) {
        return telInput.intlTelInput("isValidNumber")||telInput.val()!="";
      }, "Numéro invalide");
jQuery.validator.addMethod("telInput2isNumber", function(value, element, param) {
        return telInput2.intlTelInput("isValidNumber")||telInput2.val()=="";
      }, "Numéro invalide");
jQuery.validator.addMethod("adultstels", function(value, element, param) {
            var test = '';
               for(i = 1; i < $("#nb_adult").val(); i++){

                 var telInputpp = $("#num_tel"+i),	errorMsgpp = $("#error-msg"+i),	validMsg = $("#valid-msg");
                 console.log()
                 if ($.trim(telInputpp.val())) {
                   if (telInputpp.intlTelInput("isValidNumber")) {
                     validMsg.removeClass("hide");
                     validNumpp = telInputpp.intlTelInput("getNumber");
                     errorMsgpp.addClass("hide");
                     $("#num_tel"+i).val(validNumpp);
                     telInputpp.removeClass("errorNumberTel");
                   } else {
                     test = "non";
                     validNumpp = "non";
                     telInputpp.addClass("error");
                     errorMsgpp.removeClass("hide");
                     errorMsgpp.addClass("errorNumberTel");
                   }
                 }
               }
               if(test != ''){
                 return  false;
               }else{
                   return  true;
               }
}, "");
var b=false;
jQuery.validator.addMethod("notvide", function(value, element, param) {
        return value!="";
      }, "Sélectionner un Propriétaire");
jQuery.validator.addMethod("prd_dispo", function(value, element, param) {
        return prd_dispo || $('#radio_container input').is(':checked')
      }, "Sélectionner une Periode");

//end additional methods to validation 
if($('#example-advanced-form').length >0){
		var form_2 = $("#example-advanced-form");
		form_2.steps({
			headerTag: "h3",
			bodyTag: "fieldset",
			transitionEffect: "fade",
			titleTemplate: '#title#',
			labels: {
				finish: "Terminer",
				next: "Suivant",
				previous: "Précédent",
			},
			onStepChanging: function (event, currentIndex, newIndex)
			{
				// Allways allow previous action even if the current form is not valid!
				if (currentIndex > newIndex)
				{
					return true;
				}
				// Needed in some cases if the user went back (clean up)
				if (currentIndex < newIndex)
				{
					// To remove error styles
					form_2.find(".body:eq(" + newIndex + ") label.error").remove();
					form_2.find(".body:eq(" + newIndex + ") .error").removeClass("error");
				}
				form_2.validate().settings.ignore = ":disabled,:hidden";
				return form_2.valid();
			},
			onFinishing: function (event, currentIndex)
			{
        $.ajax({
          async: false,
          type: "POST",
          dataType : 'json',
          url: "<?php echo $this->Url->build('/',true)?>dispos/calculertotalprixperiode",
          data: {annonce_id:$("#annonce_id").val(), sel:$('#dbt_at').val()+"/"+$('#fin_at').val(), nbradulte:$("#nb_adult").val(), nbrenfant:$("#nb_enfant").val()},
          success:function(xml){
            var prixTotal      = (xml.resultatDetail['total_price']).toFixed(2);
            var taxeDeSejour   = (xml.resultatDetail['prixtaxeapayer']).toFixed(2);
            var fraisAlpissime = ((xml.resultatDetail['total_price'] - xml.resultatDetail.automaticPromo.value)/100 * 10.6);
            var fraisStripe    = ((xml.resultatDetail['total_price'] - xml.resultatDetail.automaticPromo.value)/100 * 1.4);
            var fraisService   = (fraisAlpissime + fraisStripe).toFixed(2);
            var fraisdemenage  = parseFloat(xml.fraisdemenage) != 0 ? parseFloat(xml.fraisdemenage).toFixed(2) : 0;
            var fraisanimaux   = (xml.acceptanimal == 1 && xml.demandefraisanimal == 1) ? parseFloat(xml.fraisanimaux).toFixed(2) : 0;

            var totalPrixPayer = (parseFloat(prixTotal) + parseFloat(taxeDeSejour) + parseFloat(fraisService) + parseFloat(fraisdemenage) + parseFloat(fraisanimaux) - parseFloat(xml.resultatDetail.automaticPromo.value)).toFixed(2);

            $("#totalapayer").val(totalPrixPayer);
          }
        });
				form_2.validate().settings.ignore = ":disabled";
				return form_2.valid();
			},
			onFinished: function (event, currentIndex)
			{
                            var block2;
                            $.ajax({
                             type: "POST",
                             dataType : 'json',
                             async: false,
                             url: "<?php echo $this->Url->build('/',true)?>reservations/blockreduction/",
                             data: {debut: $('#dbt_at').val(), fin: $('#fin_at').val(), ann_id: $('#annonce_id').val(), modelemail: "creationCompteManuelle"},
                             success:function(xml){
                               block2 = xml.blockdetail;                 
                               $("#mdpenclair").val("<?php echo $nouvMdp ?>");
                               $("#creationCompteManuelleHidden").val(block2);
                             }
                            });


                            var block;
                            $.ajax({
                              type: "POST",
                              dataType : 'json',
                              async: false,
                              url: "<?php echo $this->Url->build('/',true)?>reservations/blockreduction/",
                              data: {debut: $('#dbt_at').val(), fin: $('#fin_at').val(), ann_id: $('#annonce_id').val(), modelemail: "creationReservationLocManuelle"},
                              success:function(xml){
                                block = xml.blockdetail;               
                                $("#creationReservationLocManuelleHidden").val(block);
                              }
                            });
                            document.getElementById("example-advanced-form").submit();
			}
		}).validate({
			errorPlacement: function errorPlacement(error, element) {
                            if (element.attr("name") == "surface" ) {
                                element.attr('class','form-control');
                              }
                            if (element.attr("name") == "portable1" ) {
                                error.insertAfter("#error-msg");
                              }
                            else if (element.attr("name") == "portable2" ) {
                                error.insertAfter("#error-msg2");
                              }
                            else if (element.attr("name") == "proprietaire_id" ) {
                                error.insertAfter("#before_proprietaire_id_error");
                              }
                            else if (element.attr("name") == "debut" || element.attr("name") == "fin" ) {
                                error.insertAfter("#resultatdispo");
                              }
                            else {
                                error.insertAfter(element);
                              }
                            
                        },
			rules: {
                                debut:{date:false,prd_dispo:true},
                                fin:{date:false},
				proprietaire_id: {
                                    notvide: true,
				},
                                portable1:{required:true,telInputisNumber:true},
                                portable2:{telInput2isNumber:true},
                                pays:{
                                    required: true,
                                    min:1
                                },
                                surface:{
                                    adultstels:true,
                                },
                                ville:{
                                    required: true,
                                    min:1
                                },
                                nom:{required:true},
                                prenom:{required:true},
                                email:{required:true,email:true},
                                code_postal:{required:true},
			},
                        lang: 'fr',
                        messages: {
                            debut:"Sélectionner une periode",
                            pays:"Choisir un pays",
                            villeprop:"Choisir une ville",
                        }
		});
	}
//intelInput
    var telInput = $("#ReservationPortable1"),
                  errorMsg = $("#error-msg"),
                  validMsg = $("#valid-msg");
                  telInput.intlTelInput({
                                utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                initialCountry: 'fr',
                                autoPlaceholder: true
                              });
                              var reset = function() {
                                telInput.removeClass("errorNumberTel");
                                errorMsg.addClass("hide");
                                validMsg.addClass("hide");
                              };
                              // on blur: validate
                telInput.blur(function() {
                  reset();
                  if ($.trim(telInput.val())) {
                    if (telInput.intlTelInput("isValidNumber")) {
                      validMsg.removeClass("hide");
                      validNum1 = telInput.intlTelInput("getNumber");
                      //alert(telInput.intlTelInput("getNumber"));
                    } else {
                      validNum1 = "non";
                      telInput.addClass("errorNumberTel");
                      errorMsg.removeClass("hide");
                      errorMsg.addClass("errorNumberTel");
                    }
                  }
                });

                // on keyup / change flag: reset
                telInput.on("keyup change", reset);

                var telInput2 = $("#ReservationPortable2"),
                    errorMsg2 = $("#error-msg2");
                    //validMsg = $("#valid-msg");
                    telInput2.intlTelInput({
                                  utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                  initialCountry: 'fr',
                                  autoPlaceholder: true
                                });
                                var reset = function() {
                                  telInput2.removeClass("errorNumberTel");
                                  errorMsg2.addClass("hide");
                                  //validMsg2.addClass("hide");
                                };
                                // on blur: validate
                  telInput2.blur(function() {
                    reset();
                    if ($.trim(telInput2.val())) {
                      if (telInput2.intlTelInput("isValidNumber")) {
                        //validMsg2.removeClass("hide");
                        validNum22 = telInput2.intlTelInput("getNumber");
                        //alert(telInput.intlTelInput("getNumber"));
                      } else {
                        validNum22 = "non";
                        telInput2.addClass("errorNumberTel");
                        errorMsg2.removeClass("hide");
                        errorMsg2.addClass("errorNumberTel");
                      }
                    }
                  });

                  // on keyup / change flag: reset
                  telInput2.on("keyup change", reset);
//End intelInput
    $('#nb_adult').on( "change", function() {
        if($(this).val()>1){
            $("#listenum").attr('class','displayBlock nopadding col-sm-12 pt-20');
        }
        else{
            $("#listenum").attr('class','displayNone nopadding col-sm-12 pt-20');
        }
        $('#numl').html('');
        for (i = 1; i < $(this).val(); i++) {
          $('#numl').append("<input type='text' name='telephoneNum"+ i +"' id='num_tel"+ i +"' class='form-control' size='45' autocomplete='off'><span id='error-msg"+ i +"' class='hide'>Numéro invalide</span><br><br>");

          var telInputdd = $("#num_tel"+i),
            errorMsgdd = $("#error-msg"+i);
            telInputdd.intlTelInput({
                          utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                          initialCountry: 'fr',
                          autoPlaceholder: true
                        });
                        var reset = function() {
                          telInputdd.removeClass("errorNumberTel");
                          errorMsgdd.addClass("hide");
                        };


          // on keyup / change flag: reset
          telInputdd.on("keyup change", reset);

        }
          //alert($(this).val());
    });
    
    
 /*   jQuery.validator.addMethod("notEqual", function(value, element, param) {
        return this.optional(element) || value != param;
      }, "Choisir un Titre");
    $("#frm_periode").validate({
	rules: {
		pays_id: {
                    required: true,
                    min:1
		},
                titre:{
                    required: true,
                    notEqual: "0"
                },
                dbt_vac:{
                    required: true,
                    date: false,
                },
                fin_vac :{
                    required: true,
                    date: false,
                },
                type:{
                    required: true,
                    min:1
                },
	},
        lang: 'fr',
        messages: {
            titre: "Choisir un Titre",
            type: "Choisir un Type",
        }
    });*/
    
    
<?php if(!empty($confirm_res)): ?>
    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: "Création d'une nouvelle réservation",
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'success',
                        hideAfter: 7000
                    });
<?php endif;?>
<?php if(!empty($error_res)): ?>
    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: 'Il faut remplir tous les champs!',
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'error',
                        hideAfter: 7000
                    });
<?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/css/flags.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/msdropdown/dd.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/msdropdown/flags.css", array('block' => 'cssTop')); ?>