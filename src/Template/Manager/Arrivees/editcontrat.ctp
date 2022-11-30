<?php
/*
 *
 */
use Cake\I18n\Time;
?>
<!-- select2 JS -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>
<!-- select2 CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>
<!-- Multiselect JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/multiselect/js/jquery.multi-select.js", array('block' => 'scriptBottom')); ?>
<!-- multiselect CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/multiselect/css/multi-select.css", array('block' => 'cssTop')); ?>

<style>
.input-group .form-control {
    height: 42px;
}
.d-flex{
    display : flex;
}
#variable1, .disableinput{
    background: #f5f5f5 !important;
    cursor: no-drop;
}
</style>
<div class="row heading-bg icantSelectIt">
    <div class="col-sm-12">
      <h5 class="txt-dark">Modification d'un contrat</h5>
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
                            <input type="hidden" name="id" id="id" value="<?=$a_contrat['C']['id']?>">
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Propriétaire</span></h3>
                                <fieldset>
                                        <div class="row">
                                                        <div class="form-wrap">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Mail: <sup class='text-danger'>*</sup></label>
                                                                            <input value="<?php echo $a_contrat['U']['email'] ?>" type="text" name="mail" autocomplete="off" id="proprietaire_id" class="form-control"/>
                                                                            <div id="before_mail_error" class="input-group mb-15">
                                                                            </div>
                                                                            <input type="hidden" name="proprietaire_id" id="hd_prop" value="<?php echo $a_contrat['U']['id'] ?>"/>
                                                                            <input type="hidden" id="hd_gestionnaire"  value="<?php echo $a_contrat['C']['id'] ?>" />
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <!-- <label class="control-label">Fax:</label>
                                                                            <input type="text" name="fax" value="<?php //echo $a_contrat['U']['fax'] ?>" autocomplete="off" id="fax" class="form-control" readonly /> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Prénom:</label>
                                                                            <input type="text" value="<?php echo $a_contrat['U']['prenom'] ?>"  name="prenom" autocomplete="off" id="prenom"  class="form-control"/>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Nom de famille: <sup class='text-danger'>*</sup></label>
                                                                            <input type="text" value="<?php echo $a_contrat['U']['nom_famille'] ?>"  name="nom_famille" autocomplete="off" id="nom_famille"  class="form-control"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Adresse:</label>
                                                                            <textarea id="adresse" class="form-control" maxlength="1000" rows="3" cols="40" name="adresse"><?php echo $a_contrat['U']['adresse'] ?></textarea>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Complément d'adresse:</label>
                                                                            <textarea id="adr2" class="form-control" maxlength="1000" rows="3" cols="40" name="adr2"><?php echo $a_contrat['U']['adr2'] ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label" for="firstName">Portable : <sup class='text-danger'>*</sup></label>
                                                                            <input type="text" value="<?php echo $a_contrat['U']['portable'] ?>"  name="portable1" autocomplete="off" id="portable1"  class="form-control tel"/>
                                                                            <span id="error-msg" class="hide">Numéro invalide</span>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                        <label class="control-label" for="firstName">Téléphone :</label>
                                                                            <input type="text" value="<?php echo $a_contrat['U']['telephone'] ?>"  name="tel1 " autocomplete="off" id="tel1"  class="form-control tel"/>
                                                                            <span id="error-msg3" class="hide">Numéro invalide</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                        <label class="control-label" for="firstName">Portable 2:</label>
                                                                            <input type="text" value="<?php //echo $a_contrat['U']['portable2'] ?>"  name="portable2" autocomplete="off" id="portable2"  class="form-control tel"/>
                                                                            <span id="error-msg2" class="hide">Numéro invalide</span>                                                                            
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label" for="firstName">Téléphone 2:</label>
                                                                            <input type="text" value="<?php //echo $a_contrat['U']['telephone2'] ?>"  name="tel2" autocomplete="off" id="tel2"  class="form-control tel"/>
                                                                            <span id="error-msg4" class="hide">Numéro invalide</span>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <br><hr>
                                                                <h6 class="panel-title txt-dark">Appartement</h6>
                                                                <br>
                                                                <div class="form-group">
                                                                    <div class="row mb-10">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Pays: <sup class='text-danger'>*</sup></label>
                                                                            <input type="text" value="<?= $a_contrat['Pays']['fr'] ?>" readonly name="pays" autocomplete="off" id="pays"  class="form-control"/>
                                                                            <input type="hidden" value="<?php echo $a_contrat->id ?>"  name="annonce_id" id="hd_annonce"  class="medium"  />
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Code postal: <sup class='text-danger'>*</sup></label>
                                                                            <input type="text" value="<?php echo $a_contrat->code_postal ?>" readonly name="code_postal" autocomplete="off" id="code_postal"  class="form-control"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <?php if($region):?>
                                                                        <div class="col-md-4 col-xs-12 mb-10">
                                                                            <label class="control-label">Region: <sup class='text-danger'>*</sup></label>
                                                                            <input type="text" value="<?= $region ?>" readonly name="region" autocomplete="off" id="region"  class="form-control"/>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12 mb-10"></div>
                                                                        <?php endif; ?>
                                                                        <div class="col-md-4 col-xs-12 mb-10">
                                                                            <label class="control-label">Ville: <sup class='text-danger'>*</sup></label>
                                                                            <input type="text" value="<?= $ville ?>" readonly name="ville" autocomplete="off" id="ville"  class="form-control"/>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12 mb-10"></div>
                                                                        <div class="col-md-4 col-xs-12 mb-10">
                                                                            <label class="control-label">Station: <sup class='text-danger'>*</sup></label>
                                                                            <input type="text" value="<?php echo $a_contrat['L']['name'] ?>" readonly name="station" autocomplete="off" id="station"  class="form-control"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Village: <sup class='text-danger'>*</sup></label>
                                                                            <input type="text" value="<?php echo $a_contrat['V']['name'] ?>" readonly name="village" autocomplete="off" id="village"  class="form-control"/>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Résidence: <sup class='text-danger'>*</sup></label>
                                                                            <input value="<?php echo $a_contrat['R']['name'] ?>" type="text" readonly name="residence" autocomplete="off" id="residence"  class="form-control"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">N°Appart: <sup class='text-danger'>*</sup></label>
                                                                            <input value="<?php echo $a_contrat->num_app ?>" type="text" name="num_app" autocomplete="off" id="num_app"  class="form-control"/>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Surface: <sup class='text-danger'>*</sup></label>
                                                                            <input value="<?php echo $a_contrat->surface ?>" type="text" name="surface" autocomplete="off" id="surface"  class="form-control"/>
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
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Contrat</span></h3>
                                <fieldset>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label">Type: <sup class='text-danger'>*</sup></label>
                                                    <select id="contratype"  name="type" class="form-control">
                                                        <option value="0">----</option>
                                                        <?php foreach($a_type as $k=>$type):?>
                                                        <option <?php if($a_contrat['C']['type']==$k) echo "SELECTED"?> value="<?php echo $k?>"><?php echo $type?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label">Date de mise en route: <sup class='text-danger'>*</sup></label>
                                                    <?php
                                                    $d = Time::parse($a_contrat['C']['date_create']);
                                                    ?>
                                                    <?php echo $this->Form->input('date_mise_route',['value'=>$d->i18nFormat('dd-MM-yyyy'), 'autocomplete'=>"off",'id'=>'date_mise_route','label'=>false,'class'=>'form-control date']);?>
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label">Position de clé:</label>
                                                    <input value="<?php if($a_contrat['position_cle'] == 0) echo ''; else echo $a_contrat['position_cle']; ?>" type="text" autocomplete="off" name="position_cle" id="position_cle" class="form-control"  />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <label style="padding: 0 !important;margin: 0 !important;" class="col-sm-12 control-label">Conditions particulières:</label>
                                                    <textarea id="adresse2" maxlength="1000" rows="3" class="form-control" name="comment"></textarea>
                                                </div>
                                            </div>
                                        </div> -->
                                        <hr>
                                        <label class="control-label">Choisissez le produit boutique correspondant à votre contrat : <sup class='text-danger'>*</sup></label>
                                        <select class="form-control required" id="id_produit_contrat_boutique" name="id_produit_contrat_boutique"></select>
                                        <!-- <input type="text" name="id_produit_contrat_boutique" value="<?php //echo $a_contrat['C']['id_produit_contrat_boutique'] ?>" autocomplete="off" id="id_produit_contrat_boutique" class="form-control" /> -->
                                        <br><br><br><br>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 pl-0">
                                            <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                        </div>
                                    </div>
                                </fieldset>
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Création d'un contrat</span></h3>
                                <fieldset>
                                                          <div class="section last" id="gestion_cle" <?php if($a_contrat['C']['type']!=2) echo 'style="display:none"' ?> >
									<?php echo $contratypes['Gestion Clé']; ?>
							  </div>
							  <div class="section last" id="maintenance"  <?php if($a_contrat['C']['type']!=1) echo 'style="display:none"' ?>>
								   <?php 
                                   if($gestInfo['G']['id'] == 9 || $gestInfo['G']['id'] == 10) echo $contratypes['Maintenance - Justride'];
                                   else echo $contratypes['Maintenance'];
                                    ?>
							  </div>
							  <div class="section last" id="mise_relation" <?php if($a_contrat['C']['type']!=3) echo 'style="display:none"' ?> >
									 <?php echo $contratypes['Mise en relation']; ?>
							  </div>
                              <div class="section last" id="contrat_commercialisation" <?php if($a_contrat['C']['type']!=5) echo 'style="display:none"' ?> >
									 <?php echo $contratypes['Contrat de commercialisation']; ?>
							  </div>
                              <hr>
                                <p>Liste des variables à saisir : <p>
                                <div id="vardyncontrat"></div>
                                <hr>
                                <p id="titreoptioncontrat">Choisir l'option à ajouter : <p>
                                <div id="optioncontrat"></div>
                                    <div class="button-list mt-25">
                                        <!-- <button type="button" id="sendmail" class="btn btn-danger btn-anim btn-rounded pull-right"><i class="fa fa-send-o"></i><span class="btn-text">Envoyer par mail</span></button>
                                        <button type="button" id="PopupandLeaveopen" class="btn btn-danger btn-anim btn-rounded pull-right"><i class="fa fa-file-pdf-o"></i><span class="btn-text">Générer  le  PDF</span></button> -->
                                    </div>
							  <div id="print-element" class="print-contrat" ></div>
                                </fieldset>
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Validation</span></h3>
                                <fieldset>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12" id="previewdiv"></div>                                                                                               
                                                <div class="col-md-12"><hr></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label">valider le contrat: <sup class='text-danger'>*</sup></label>
                                                    <div id="beforeradioerror" class="radio-list">
                                                            <div class="radio-inline pl-0">
                                                                    <span class="radio radio-primary">
                                                                    <input type="radio" value="annuler"  id="valider_n" name="valider"/>
                                                                    <label for="valider_n">Non</label>
                                                            </span>
                                                            </div>
                                                            <div class="radio-inline">
                                                                    <span class="radio radio-primary">
                                                                    <input type="radio" value="valider"  id="valider_o" name="valider"/>
                                                                    <label for="valider_o">Oui</label>
                                                            </span>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12 payerdiv">
                                                    <label class="control-label">Paiement : <sup class='text-danger'>*</sup></label>
                                                    <div id="beforeradioerror" class="radio-list">
                                                            <div class="radio-inline pl-0">
                                                                    <span class="radio radio-primary">
                                                                    <input type="radio" value="0"  id="marketplace" name="payerGest"/>
                                                                    <label for="marketplace">Payé via la marketplace</label>
                                                            </span>
                                                            </div>
                                                            <div class="radio-inline">
                                                                    <span class="radio radio-primary">
                                                                    <input type="radio" value="1"  id="payergest" name="payerGest"/>
                                                                    <label for="payergest">Payé chez le gestionnaire</label>
                                                            </span>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12 checkbox mt-20 ml-20 generercommandediv">
                                                    <input name="generercommande" type="checkbox">
                                                    <label for="generercommande">Générer commande boutique</label>
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
<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title">Sélection d'un appartement</h5>
                        </div>
                        <div class="modal-body">
                                <form>
                                    <div id="responsive_modal_content" class="form-group">
                                            
                                    </div>
                                </form>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button id="choisir_appartement" type="button" class="btn btn-danger">Ok</button>
                        </div>
                </div>
        </div>
</div>
<!-- /.end modal -->

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<!-- Form Wizard JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery.steps/build/jquery.steps.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<!-- jquery-steps css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery.steps/demo/css/jquery.steps.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>

//<script>
function afficherdetailoption(id, elem){
    if(elem.checked){
        $.ajax({
            type: "POST",
            dataType : 'json',
            async: true,
            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/detailoption",
            data: {id: id},
            success:function(xml){                
                var textvar = "";
                var k = 1;
                $.each( xml.listevardynoption, function( key, value ) {
                    // if(key == 2) textvar += '<div class="form-group mt-30 mb-30"><label class="control-label mb-10 text-left">'+value+'</label><select class="form-control" id="optionvar2" name="optionvar2"></select></div>';
                    // else 
                    if(key == 2){
                        textvar += '<div class="input-group input-group-sm mb-10"><span class="input-group-addon">Produit boutique correspondant</span><select class="form-control required" id="optionvar'+key+'_'+id+'" name="optionvar'+key+'_'+id+'[]" onchange="afficherprixoption('+id+', this)" multiple></select></div>';
                    } 
                    else if(key == 5){
                        textvar += '<div class="input-group input-group-sm mb-10"><span class="input-group-addon">'+value+'</span><input readonly type="text" class="form-control disableinput required" name="optionvar'+key+'_'+id+'" placeholder="Choisir la valeur"></div>';
                    }
                    else if(key != 3 && key != 4){
                        textvar += '<div class="input-group input-group-sm mb-10"><span class="input-group-addon">'+value+'</span><input type="text" class="form-control required" name="optionvar'+key+'_'+id+'" placeholder="Choisir la valeur"></div>';
                    } 
                    k++;
                });
                $('#optionvar2_'+id).multiSelect();

                $(".div"+id).html("Text de l'option : "+xml.detailoption.text);
                $(".div"+id).append(textvar);

                textperiod = '<div class="checkbox col-sm-4 checkbox'+id+'"><input name="optionvar3_'+id+'" type="checkbox" onclick="afficherperiode('+id+', this);"><label for="optionvar3_'+id+'">Périodicité</label></div>';
                $(".div"+id).append(textperiod);

                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    async: true,
                    url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getlisteidoptionboutique/",
                    data: {},
                    success:function(xml){
                        tab = xml.listeidoptionboutique;
                        $.each(tab, function(index, value){
                            // if(index == 0) $('#optionvar2_'+id).append('<option value="" selected>' + value + '</option>');
                            // else 
                            if(index != 0) $('#optionvar2_'+id).append('<option value=' + index + '>' + value + '</option>');
                            $('#optionvar2_'+id).multiSelect('refresh');
                            $('#optionvar2_'+id).multiSelect('deselect_all');
                        });
                    }
                });

                
            }
        });
    }else{
        $(".div"+id).html(""); 
    }    
    
}

function afficherperiode(id, elem){
    if(elem.checked){
        $('.checkbox'+id).after( '<div class="form-group col-sm-6 d-flex periode'+id+'"><label class="col-sm-6 control-label">Période : </label><select onchange="afficherlistedates('+id+', this)" id="optionvar4_'+id+'" name="optionvar4_'+id+'" class="form-control required"><option value="">Choisir une option</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select></div><div class="listedate'+id+'"></div>' );
    }else{
        $('.periode'+id).remove();
        $('.listedate'+id).remove();
    }
}

function afficherprixoption(id, elem){
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: true,
        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getprixcontratboutique/",
        data: {idboutique: $(elem).val()},
        success:function(xml){
            $("input[name='optionvar5_"+id+"']").val(xml.prixboutique);
        }
    });
}

function afficherlistedates(id, elem){
    var i;
    var listedates = '';
    for (i = 1; i <= $(elem).val(); i++) {
        // listedates += '<div class="form-group col-sm-6 d-flex"><label for="date_'+i+'_'+id+'">Date '+i+' : </label><input type="date" class="required" id="date_'+i+'_'+id+'" name="date_'+i+'_'+id+'"></div>';
        listedates += '<div class="form-group col-sm-6 d-flex"><label>Date '+i+' : </label><div class="input select"><select name="jour_date_'+i+'_'+id+'" class="form-control classwidth required" id="jour_date_'+i+'_'+id+'"><option value="">Jour</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select></div> / <div class="input select"><select name="mois_date_'+i+'_'+id+'" class="form-control classwidth required" id="mois_date_'+i+'_'+id+'"><option value="">Mois</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select></div> </div>';
    }
    $('.listedate'+id).html(listedates);
    // var year = new Date().getFullYear();
    // $('input[type="date"]').attr("min", year + "-01-01");
    // $('input[type="date"]').attr("max", year + "-12-31");
}

$(document).ready(function(){
    $(".payerdiv").css("display","none");
    $(".generercommandediv").css("display","none");    
    //Checked valider
$('#valider_o').click(function(){
    $('#payergest').attr("checked", "checked");
    $(".payerdiv").css("display","block");  
    $(".generercommandediv").css("display","none");  
});
$('#valider_n').click(function(){
    $(".payerdiv").css("display","none");
    // $(".generercommandediv").css("display","block");
});
//end checked valider

    $("#PopupandLeaveopen").click(function() {
	$('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
		$.ajax({
				type: "POST",
				url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/generatepdf/"+$("#hd_prop").val()+"/"+$("#hd_annonce").val(),
				data:{vComment:'',vMail:$('#proprietaire_id').val(),vType:$("#contratype").val(),vDate:$("#date_mise_route").val()},
				success:function(xml){
					$('body').loadingModal('destroy');
					window.open('<?php echo SITE_ALPISSIME ?>/contrat/'+xml, '_blank');
					},
                                error: function(){
                                    $('body').loadingModal('destroy');
                                    $.toast().reset('all');
                                            $("body").removeAttr('class');
                                            $.toast({
                                                heading: 'Erreur',
                                                text: '',
                                                position: 'bottom-right',
                                                loaderBg:'#fec107',
                                                icon: 'error',
                                                hideAfter: 4000
                                            });
                                }
				});
    });
    
     $("#sendmail").click(function() {
		$('body').loadingModal({
                    position: 'auto',
                    text: '',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
		$.ajax({
				type: "POST",
				url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getinfo/"+$("#hd_prop").val()+"/"+$("#hd_annonce").val(),
				data:{vComment:'',vMail:$('#proprietaire_id').val(),vType:$("#contratype").val(),vDate:$("#date_mise_route").val()},
				success:function(xml){
                                    $('body').loadingModal('destroy');
                                    $.toast().reset('all');
                                    $("body").removeAttr('class');
                                    $.toast({
                                        heading: 'Le propriétaire a reçu un contrat par mail',
                                        text: '',
                                        position: 'bottom-right',
                                        loaderBg:'#fec107',
                                        icon: 'success',
                                        hideAfter: 8000
                                    });
                                },
                                error: function(){
                                    $('body').loadingModal('destroy');
                                    $.toast().reset('all');
                                    $("body").removeAttr('class');
                                    $.toast({
                                        heading: 'Erreur',
                                        text: '',
                                        position: 'bottom-right',
                                        loaderBg:'#fec107',
                                        icon: 'error',
                                        hideAfter: 4000
                                    });
                                }
				});

  });
    
    $('#contratype').on("change",function(){
    //alert($(this).val());
      switch($(this).val()){
            case "0":
            $("#gestion_cle").hide();
            $("#maintenance").hide();
            $("#mise_relation").hide();
            $("#contrat_commercialisation").hide();
            break;
            case "2":
            $("#gestion_cle").css("display","block");
            $("#maintenance").css("display","none");
            $("#mise_relation").css("display","none");
            $("#contrat_commercialisation").css("display","none");
            break;
            case "3":
            $("#gestion_cle").css("display","none");
            $("#maintenance").css("display","none");
            $("#mise_relation").css("display","block");
            $("#contrat_commercialisation").css("display","none");
            break;
            case "1":
            $("#gestion_cle").css("display","none");
            $("#maintenance").css("display","block");
            $("#mise_relation").css("display","none");
            $("#contrat_commercialisation").css("display","none");
            break;
            case "5":
            $("#gestion_cle").css("display","none");
            $("#contrat_commercialisation").css("display","block");
            $("#mise_relation").css("display","none");
            $("#maintenance").css("display","none");
            break;
      }
      $.ajax({
            type: "POST",
            dataType : 'json',
            async: true,
            url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getvariablecontrattype",
            data: {id: $(this).val()},
            success:function(xml){
                var textvar = "";
                var i = 1;
                $.each( xml.listevardynoption, function( key, value ) {
                    readonlyvar = "";
                    if(xml.listevardynoptionvaleur[key] == undefined) xml.listevardynoptionvaleur[key]='';
                    if(key == 1) readonlyvar = "readonly";
                    textvar += '<div class="input-group input-group-sm mb-10"><span class="input-group-addon">'+value+'</span><input type="text" class="form-control required" name="variable'+key+'" id="variable'+key+'" placeholder="Choisir la valeur" '+readonlyvar+'></div>';
                    i++;
                });
                $("#vardyncontrat").html(textvar);
            }
        });
        $.ajax({
            type: "POST",
            dataType : 'json',
            async: true,
            url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getoptioncontrattype",
            data: {id: $(this).val()},
            success:function(xml){
                var textvar = "";
                var j = 1;
                $.each( xml.listeoption, function( key, value ) {
                    textvar += '<div class="checkbox col-sm-12"><input name="option'+key+'" type="checkbox" onclick="afficherdetailoption('+key+', this);"><label for="option'+j+'">'+value+'</label></div>';                
                    textvar += '<p class="div'+key+' mb-10 col-sm-12"></p>';
                    textvar += '<div class="col-sm-12"><hr style="width: 95%;border: 0.5px dashed #000;"></div>';
                    j++;
                });
                if(textvar == "") $("#titreoptioncontrat").css('display', 'none');
                $("#optioncontrat").html(textvar);
            }
        });
    });
    
    $('.date').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
                    
    
});          
//additional methods to validation              
jQuery.validator.addMethod("telInputisNumber", function(value, element, param) {
        return telInput.intlTelInput("isValidNumber")||telInput.val()=="";
      }, "Numéro invalide");
jQuery.validator.addMethod("telInput2isNumber", function(value, element, param) {
        return telInput2.intlTelInput("isValidNumber")||telInput2.val()=="";
      }, "Numéro invalide");
jQuery.validator.addMethod("telInput3isNumber", function(value, element, param) {
        return telInput3.intlTelInput("isValidNumber")||telInput3.val()=="";
      }, "Numéro invalide");
jQuery.validator.addMethod("telInput4isNumber", function(value, element, param) {
        return telInput4.intlTelInput("isValidNumber")||telInput4.val()=="";
      }, "Numéro invalide");
      
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
                // console.log("new index:"+newIndex);
                // console.log("current index:"+currentIndex);                
                if(newIndex === 1){
                    var valeuridcontrat = "<?php echo $a_contrat['C']['id_produit_contrat_boutique'] ?>";
                    $.ajax({
                        type: "POST",
                        dataType : 'json',
                        async: true,
                        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getlisteidoptionboutique/",
                        data: {},
                        success:function(xml){
                            $('#id_produit_contrat_boutique').empty();
                            tab = xml.listeidoptionboutique;
                            $.each(tab, function(index, value){
                                if(valeuridcontrat == index) $('#id_produit_contrat_boutique').append('<option value=' + index + ' selected>' + value + '</option>');
                                else{
                                    if(index == 0) $('#id_produit_contrat_boutique').append('<option value="">' + value + '</option>');
                                    else $('#id_produit_contrat_boutique').append('<option value=' + index + '>' + value + '</option>');
                                } 
                            });
                            $('#id_produit_contrat_boutique').select2();
                        }
                    });

                    $.ajax({
                        type: "POST",
                        dataType : 'json',
                        async: true,
                        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getvariablecontrattype/"+$("#id").val(),
                        data: {id: <?php echo $a_contrat['C']['type']; ?>},
                        success:function(xml){
                            var textvar = "";
                            var i = 1;
                            $.each( xml.listevardynoption, function( key, value ) {
                                readonlyvar = "";
                                if(xml.listevardynoptionvaleur[key] == undefined) xml.listevardynoptionvaleur[key] = '';
                                if(key == 1) readonlyvar = "readonly";
                                textvar += '<div class="input-group input-group-sm mb-10"><span class="input-group-addon">'+value+'</span><input type="text" class="form-control required" name="variable'+key+'" id="variable'+key+'" value="'+xml.listevardynoptionvaleur[key]+'" placeholder="Choisir la valeur" '+readonlyvar+'></div>';
                                i++;
                            });
                            $("#vardyncontrat").html(textvar);
                        }
                    });
                    $.ajax({
                        type: "POST",
                        dataType : 'json',
                        async: true,
                        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getoptioncontrattype/"+$("#id").val(),
                        data: {id: <?php echo $a_contrat['C']['type']; ?>},
                        success:function(xml){
                            var textvar = "";
                            var j = 1;
                            $.each( xml.listeoption, function( key, value ) {                                                             
                                if(!$.isEmptyObject(xml.listeoptionchecked[key])){
                                    textvar += '<div class="checkbox col-sm-12"><input name="option'+key+'" type="checkbox" checked onclick="afficherdetailoption('+key+', this);"><label for="option'+j+'">'+value+'</label></div>';   
                                }else{
                                    textvar += '<div class="checkbox col-sm-12"><input name="option'+key+'" type="checkbox" onclick="afficherdetailoption('+key+', this);"><label for="option'+j+'">'+value+'</label></div>';                
                                }
                                textvar += '<p class="div'+key+' mb-10 col-sm-12"></p>';
                                textvar += '<div class="col-sm-12"><hr style="width: 95%;border: 0.5px dashed #000;"></div>';
                                j++;
                            });
                            if(textvar == "") $("#titreoptioncontrat").css('display', 'none');
                            $("#optioncontrat").html(textvar);
                            var valeuroption2 = [];
                            $.each( xml.listeoption, function( key, value ) {
                                if(!$.isEmptyObject(xml.listeoptionchecked[key])){
                                    $.ajax({
                                        type: "POST",
                                        dataType : 'json',
                                        async: true,
                                        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/detailoption",
                                        data: {id: key},
                                        success:function(xmll){                
                                            var textvar = "";
                                            var k = 1;
                                            $.each( xmll.listevardynoption, function( keyy, valuee ) {
                                                if (xml.listvarvaleuroption[key][keyy] === undefined || xml.listvarvaleuroption[key][keyy] === null) {
                                                    xml.listvarvaleuroption[key][keyy] = ''; 
                                                }
                                                // if(keyy == 2) textvar += '<div class="form-group mt-30 mb-30"><label class="control-label mb-10 text-left">'+valuee+'</label><select class="form-control" id="optionvar2" name="optionvar2"></select></div>';
                                                // else 
                                                if(keyy == 2){
                                                    valeuroption2['optionvar2_'+key] = xml.listvarvaleuroption[key][keyy];  
                                                    console.log(valeuroption2['optionvar2_'+key]) ;                                                 
                                                    textvar += '<div class="input-group input-group-sm mb-10"><span class="input-group-addon">Produit boutique correspondant</span><select class="form-control required" id="optionvar'+keyy+'_'+key+'" name="optionvar'+keyy+'_'+key+'[]" onchange="afficherprixoption('+key+', this)" multiple></select></div>';
                                                } 
                                                else if(keyy == 5){
                                                    valeuroption2['optionvar5_'+key] = xml.listvarvaleuroption[key][keyy];                                                    
                                                    textvar += '<div class="input-group input-group-sm mb-10"><span class="input-group-addon">'+valuee+'</span><input readonly type="text" class="form-control disableinput required" name="optionvar'+keyy+'_'+key+'" value="'+xml.listvarvaleuroption[key][keyy]+'" placeholder="Choisir la valeur"></div>';
                                                }
                                                else if(keyy == 3){
                                                    if(xml.listvarvaleuroption[key][keyy] == "on") valeuroption2['optionvar3_'+key] = "checked";
                                                    else valeuroption2['optionvar3_'+key] = "";
                                                }
                                                else if(keyy == 4){
                                                    valeuroption2['optionvar4_'+key] = xml.listvarvaleuroption[key][keyy];
                                                }else
                                                {
                                                    textvar += '<div class="input-group input-group-sm mb-10"><span class="input-group-addon">'+valuee+'</span><input type="text" class="form-control required" name="optionvar'+keyy+'_'+key+'" value="'+xml.listvarvaleuroption[key][keyy]+'" placeholder="Choisir la valeur"></div>';
                                                } 
                                                k++;
                                            });
                                            $('#optionvar2_'+key).multiSelect();

                                            $(".div"+key).html("Text de l'option : "+xmll.detailoption.text);
                                            $(".div"+key).append(textvar);

                                            textperiod = '<div class="checkbox col-sm-4 checkbox'+key+'"><input name="optionvar3_'+key+'" type="checkbox" '+valeuroption2["optionvar3_"+key]+' onclick="afficherperiode('+key+', this);"><label for="optionvar3_'+key+'">Périodicité</label></div>';
                                            $(".div"+key).append(textperiod);

                                            if(valeuroption2['optionvar3_'+key] == "checked"){
                                                $('.checkbox'+key).after( '<div class="form-group col-sm-6 d-flex periode'+key+'"><label class="col-sm-6 control-label">Période : </label><select onchange="afficherlistedates('+key+', this)" id="optionvar4_'+key+'" name="optionvar4_'+key+'" class="form-control required"><option value="">Choisir une option</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select></div><div class="listedate'+key+'"></div>' );
                                                $('#optionvar4_'+key).val(valeuroption2['optionvar4_'+key]);

                                                var i;
                                                var listedates = '';
                                                for (i = 1; i <= valeuroption2['optionvar4_'+key]; i++) {
                                                    // listedates += '<div class="form-group col-sm-6 d-flex"><label for="date_'+i+'_'+key+'">Date '+i+' : </label><input type="date" class="required" id="date_'+i+'_'+key+'" name="date_'+i+'_'+key+'"></div>';
                                                    listedates += '<div class="form-group col-sm-6 d-flex"><label>Date '+i+' : </label><div class="input select"><select name="jour_date_'+i+'_'+key+'" class="form-control classwidth required" id="jour_date_'+i+'_'+key+'"><option value="">Jour</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select></div> / <div class="input select"><select name="mois_date_'+i+'_'+key+'" class="form-control classwidth required" id="mois_date_'+i+'_'+key+'"><option value="">Mois</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select></div> </div>';
                                                }
                                                $('.listedate'+key).html(listedates);
                                                // var year = new Date().getFullYear();
                                                // $('input[type="date"]').attr("min", year + "-01-01");
                                                // $('input[type="date"]').attr("max", year + "-12-31");
                                                $.ajax({
                                                    type: "POST",
                                                    dataType : 'json',
                                                    async: true,
                                                    url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getlistedatesoption/",
                                                    data: {optionID: key, contratID: $("#id").val()},
                                                    success:function(xml){
                                                        tab = xml.datesoption;
                                                        for (i = 1; i <= valeuroption2['optionvar4_'+key]; i++) {
                                                            // console.log('#date_'+i+'_'+key+' : '+tab[i-1]);
                                                            // console.log(moment(tab[i-1]).format('M'));
                                                            $('#jour_date_'+i+'_'+key).val(moment(tab[i-1]).format('DD'));
                                                            $('#mois_date_'+i+'_'+key).val(moment(tab[i-1]).format('MM'));
                                                            // $('#date_'+i+'_'+key).val(tab[i-1]);
                                                        }
                                                    }
                                                });
                                            }

                                            $.ajax({
                                                type: "POST",
                                                dataType : 'json',
                                                async: true,
                                                url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getlisteidoptionboutique/",
                                                data: {},
                                                success:function(xml){
                                                    tab = xml.listeidoptionboutique;
                                                    $.each(tab, function(index, value){  
                                                        if(index != 0) $('#optionvar2_'+key).append('<option value=' + index + '>' + value + '</option>');                                                      
                                                        // if(valeuroption2['optionvar2_'+key] == index) $('#optionvar2_'+key).append('<option value=' + index + ' selected>' + value + '</option>');
                                                        // else{
                                                        //     // if(index == 0) $('#optionvar2_'+key).append('<option value="">' + value + '</option>');
                                                        //     // else 
                                                        //     if(index != 0) $('#optionvar2_'+key).append('<option value=' + index + '>' + value + '</option>');
                                                        // } 
                                                    });
                                                    $('#optionvar2_'+key).multiSelect('deselect_all');
                                                    $('#optionvar2_'+key).multiSelect('refresh');
                                                    if(Array.isArray(valeuroption2['optionvar2_'+key])){
                                                        $.each(valeuroption2['optionvar2_'+key], function(ind, val){
                                                            console.log(val);
                                                            if(value != ""){
                                                                $('#optionvar2_'+key).multiSelect('select', val);
                                                                $('#optionvar2_'+key).multiSelect('refresh');
                                                            }                                                            
                                                        }); 
                                                    }else{
                                                        $('#optionvar2_'+key).multiSelect('select', valeuroption2['optionvar2_'+key]);
                                                        $('#optionvar2_'+key).multiSelect('refresh');
                                                    }
                                                    // $('#optionvar2_'+key).multiSelect('refresh');
                                                }
                                            });

                                            $.ajax({
                                                type: "POST",
                                                dataType : 'json',
                                                async: true,
                                                url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getprixcontratboutique/",
                                                data: {idboutique: valeuroption2['optionvar2_'+key]},
                                                success:function(xml){
                                                    $("input[name='optionvar5_"+key+"']").val(xml.prixboutique);
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                            
                        }
                    });
                }
                if(newIndex === 2){
                    $.ajax({
                        type: "POST",
                        dataType : 'json',
                        async: true,
                        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getprixcontratboutique/",
                        data: {idboutique: $("#id_produit_contrat_boutique").val()},
                        success:function(xml){
                            $("input[name='variable1']").val(xml.prixboutique);
                        }
                    });
                    
                }
                if(newIndex === 3){
                    var data = $("#example-advanced-form").serialize();
                    $.ajax({
                        type: "POST",
                        dataType : 'json',
                        async: false,
                        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/previewcontrat/",
                        data: {listvar: data},
                        success:function(xml){
                            $("#previewdiv").html(xml.previewtext);
                        }
                    });
                    
                }
                                form_2.validate().settings.ignore = ":disabled,:hidden";
				return form_2.valid();
			},
			onFinishing: function (event, currentIndex)
			{
				form_2.validate().settings.ignore = ":disabled";
				return form_2.valid();
			},
			onFinished: function (event, currentIndex)
			{
                            document.getElementById("example-advanced-form").submit();
			}
		}).validate({
			errorPlacement: function errorPlacement(error, element) {
                            if (element.attr("name") == "ville" || element.attr("name") == "mail" ) {
                                error.insertAfter("#before_mail_error");
                                if(element.attr("name") == "ville")element.removeClass('error');
                              }
                            else if (element.attr("name") == "portable1" ) {
                                error.insertAfter("#error-msg");
                              }
                            // else if (element.attr("name") == "portable2" ) {
                            //     error.insertAfter("#error-msg3");
                            //   }
                            else if (element.attr("name") == "tel1" ) {
                                error.insertAfter("#error-msg2");
                              }
                            // else if (element.attr("name") == "tel2" ) {
                            //     error.insertAfter("#error-msg4");
                            //   }
                            else if ( element.is(":radio") ) {
                                error.insertAfter("#beforeradioerror");
                            }
                            else {
                                error.insertAfter(element);
                              }
                            
                        },
			rules: {
                                mail:{
                                    email:true,
                                    required: true,
                                },
                                nom_famille:{
                                    required:true
                                },
                                ville: 
                                {
                                    required: true,
                                },
                                portable1:{
                                    required:true,
                                    telInputisNumber:true,
                                },
                                // portable2:{
                                //     telInput3isNumber:true,
                                // },
                                tel1:{
                                    telInput2isNumber:true
                                },
                                // tel2:{
                                //     telInput4isNumber:true
                                // },
                                type:{
                                    min:1,
                                    required: true,
                                },
                                date_mise_route:{
                                    date:false,
                                    required: true,
                                },
                                valider:{
                                    required: true,
                                },
                                variable1:{
                                    required: true,
                                },
                                id_produit_contrat_boutique:{
                                    required: true,
                                }
			},
                        lang: 'fr',
                        messages: {
                            type:"Choisir un type",
                            mail:"",
                            ville:"S'il vous plaît veuillez choisir un propriétaire et cliquez sur suivant",
                            valider:"Choisir une option",
                        }
		});
	}
//intelInput
    var telInput = $("#portable1");
                  errorMsg = $("#error-msg");
                  telInput.intlTelInput({
                                utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                initialCountry: 'fr',
                                autoPlaceholder: true
                              });
                              var reset = function() {
                                telInput.removeClass("errorNumberTel");
                                errorMsg.addClass("hide");
                                //validMsg.addClass("hide");
                              };
                              // on blur: validate
                telInput.blur(function() {
                  reset();
                  if ($.trim(telInput.val())) {
                    if (telInput.intlTelInput("isValidNumber")) {
                      //validMsg.removeClass("hide");
                      validNum1 = telInput.intlTelInput("getNumber");
                      telInput.val(validNum1);
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

                // var telInput2 = $("#portable2");
                //     errorMsg2 = $("#error-msg2");
                //     telInput2.intlTelInput({
                //                   utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                //                   initialCountry: 'fr',
                //                   autoPlaceholder: true
                //                 });
                //                 var reset = function() {
                //                   telInput2.removeClass("errorNumberTel");
                //                   errorMsg2.addClass("hide");
                //                   //validMsg2.addClass("hide");
                //                 };
                //                 // on blur: validate
                //   telInput2.blur(function() {
                //     reset();
                //     if ($.trim(telInput2.val())) {
                //       if (telInput2.intlTelInput("isValidNumber")) {
                //         //validMsg2.removeClass("hide");
                //         validNum22 = telInput2.intlTelInput("getNumber");
                //         //alert(telInput.intlTelInput("getNumber"));
                //       } else {
                //         validNum22 = "non";
                //         telInput2.addClass("errorNumberTel");
                //         errorMsg2.removeClass("hide");
                //         errorMsg2.addClass("errorNumberTel");
                //       }
                //     }
                //   });

                //   // on keyup / change flag: reset
                //   telInput2.on("keyup change", reset);

                  var telInput3 = $("#tel1");
                      errorMsg3 = $("#error-msg3");
                      telInput3.intlTelInput({
                                    utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                    initialCountry: 'fr',
                                    autoPlaceholder: true
                                  });
                                  var reset = function() {
                                    telInput3.removeClass("errorNumberTel");
                                    errorMsg3.addClass("hide");
                                    //validMsg3.addClass("hide");
                                  };
                                  // on blur: validate
                    telInput3.blur(function() {
                      reset();
                      if ($.trim(telInput3.val())) {
                        if (telInput3.intlTelInput("isValidNumber")) {
                          //validMsg3.removeClass("hide");
                          validNum33 = telInput3.intlTelInput("getNumber");
                          //alert(telInput.intlTelInput("getNumber"));
                        } else {
                          validNum33 = "non";
                          telInput3.addClass("errorNumberTel");
                          errorMsg3.removeClass("hide");
                          errorMsg3.addClass("errorNumberTel");
                        }
                      }
                    });

                    // on keyup / change flag: reset
                    telInput3.on("keyup change", reset);

                    // var telInput4 = $("#tel2");
                    //     errorMsg4 = $("#error-msg4");
                    //     telInput4.intlTelInput({
                    //                   utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                    //                   initialCountry: 'fr',
                    //                   autoPlaceholder: true
                    //                 });
                    //                 var reset = function() {
                    //                   telInput4.removeClass("errorNumberTel");
                    //                   errorMsg4.addClass("hide");
                    //                   //validMsg4.addClass("hide");
                    //                 };
                    //                 // on blur: validate
                    //   telInput4.blur(function() {
                    //     reset();
                    //     if ($.trim(telInput4.val())) {
                    //       if (telInput4.intlTelInput("isValidNumber")) {
                    //         //validMsg4.removeClass("hide");
                    //         validNum44 = telInput4.intlTelInput("getNumber");
                    //         //alert(telInput.intlTelInput("getNumber"));
                    //       } else {
                    //         validNum44 = "non";
                    //         telInput4.addClass("errorNumberTel");
                    //         errorMsg4.removeClass("hide");
                    //         errorMsg4.addClass("errorNumberTel");
                    //       }
                    //     }
                    //   });
                    //   // on keyup / change flag: reset
                    //   telInput4.on("keyup change", reset);
//End intelInput
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Modification d\'un nouveau contrat avec succès',
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
                            heading: 'Le contrat n\'est pas validé par le propriétaire, fournis à titre d\'informations',
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