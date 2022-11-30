<?php $this->start('cssTop'); ?>
    <style>
        .fileinput.input-group.fileinput-exists {
            overflow: hidden;
        }
        div.error-message{
            color: red;
        }
        div.hide{
            visibility: hidden;
        }
        div.valid-message{
            color: green;
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12">
      <h5 class="txt-dark">Ajouter Partenaire</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
                        <?=$this->Form->create($partenaire,['type' => 'file','id'=>'partenaire','class'=> 'form-horizontal','onsubmit'=>"return validateMyForm();"]);?>
                        <?php if(!empty($partenaire->invalid())): ?>
                          <div class="row">
                            <div class="col-sm-8">
                              <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="zmdi zmdi-block pr-15 pull-left"></i><p class="pull-left">Vérifier les données saisies.</p>
                                <div class="clearfix"></div>
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Massif: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->select('massif_id',$massifs,['id'=>'massif_id','label'=>false,'class'=>'form-control select2']);  ?>
                                <?= $this->Form->isFieldError('massif_id') ? $this->Form->error('massif_id') : '';?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Station: <sup class='text-danger'>*</sup></label>
                                <?= $this->Form->select('lieugeo_id[]',$lieugeos,['multiple','id'=>'lieugeo_id','label'=>false,'class'=>'select2 select2-multiple', 'required']);  ?>
                                <?php //echo $this->Form->select('lieugeo_id',$lieugeos,['id'=>'lieugeo_id','label'=>false,'class'=>'select2 form-control', 'required']);  ?>
                                <?= $this->Form->isFieldError('lieugeo_id') ? $this->Form->error('lieugeo_id') : '';?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Code Partenaire:</label>
                                <?php echo $this->Form->input('part_code',['type'=>'text','id'=>'part_code','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <!-- <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">ID Partenaire: <sup class='text-danger'>*</sup></label>
                                <?php// echo $this->Form->input('part_id',['type'=>'text','id'=>'part_id','label'=>false,'class'=>'form-control']);  ?>
                            </div> -->
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Type: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->select('type',$types,['id'=>'type','label'=>false,'class'=>'form-control select2']);  ?>
                                <?= $this->Form->isFieldError('type') ? $this->Form->error('type') : '';?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Type2:</label>
                                <?php echo $this->Form->select('type2',$types,['id'=>'type2','label'=>false,'class'=>'form-control select2']);  ?>
                                <?= $this->Form->isFieldError('type2') ? $this->Form->error('type2') : '';?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Type3:</label>
                                <?php echo $this->Form->select('type3',$types,['id'=>'type3','label'=>false,'class'=>'form-control select2']);  ?>
                                <?= $this->Form->isFieldError('type3') ? $this->Form->error('type3') : '';?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Type4:</label>
                                <?php echo $this->Form->select('type4',$types,['id'=>'type4','label'=>false,'class'=>'form-control select2']);  ?>
                                <?= $this->Form->isFieldError('type4') ? $this->Form->error('type4') : '';?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Type5:</label>
                                <?php echo $this->Form->select('type5',$types,['id'=>'type5','label'=>false,'class'=>'form-control select2']);  ?>
                                <?= $this->Form->isFieldError('type5') ? $this->Form->error('type5') : '';?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Date de création:</label>
                                <?php echo $this->Form->input('date_creation',['type'=>'text','id'=>'date_creation','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">À contacter: </label>
                                <input id="Acontacter_switch" type="checkbox" data-off-text="NON" data-off-color="danger" data-on-text="OUI" data-on-color="success" class="bs-switch">
                                <input id="radioOui" name="aContacter" class="hidden" type="radio" value="OUI" <?=($partenaire->aContacter=='OUI'||$partenaire->aContacter==null)?'checked':''?>>
                                <input id="radioNon" name="aContacter" class="hidden" type="radio" value="NON" <?=$partenaire->aContacter=='NON'?'checked':''?>>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Langue:</label>
                                <?php echo $this->Form->input('langue',['type'=>'text','id'=>'langue','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group ml-5">
                            <div class="row">
                                <label class="control-label mb-10 col-sm-2 col-lg-2 text-left font-16 txt-black">Position :</label>
                            </div>
                            <div class="row mt-10">
                                <div class="col-sm-3 mt-60">
                                    <div class="row mb-20">
                                        <label class="control-label col-sm-4 col-md-4 text-left font-16 txt-black">Latitude</label>
                                        <div class="col-sm-8 col-md-8">
                                            <?php echo $this->Form->input('lat',['type'=>'text','id'=>'lat','label'=>false,'class'=>'form-control','placeholder'=>"saisir latitude"]);  ?>
                                        </div>
                                    </div>
                                    <div class="row mb-20">
                                        <label class="control-label col-sm-4 col-md-4 text-left font-16 txt-black">Longitude</label>
                                        <div class="col-sm-8 col-md-8">
                                            <?php echo $this->Form->input('lng',['type'=>'text','id'=>'lng','label'=>false,'class'=>'form-control','placeholder'=>"saisir longitude"]);  ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button type="button" id="search_button" class="btn btn-warning btn-anim"><i class="fa fa-search"></i><span class="btn-text">Chercher</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <input id="searchmap" class="form-control" type="text" placeholder="Chercher une adresse"  style="width: 50%; margin: 10px 0px 0px 10px; height: 38px !important;">

                                    <div id="map-canvas" style="width: 100%; height: 400px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Adresse: </label>
                                <?php echo $this->Form->input('adresse',['type'=>'text','id'=>'adresse','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Pays: </label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->select('pays_id',$pays,['value'=>67, 'id'=>'pays_id','label'=>false,'class'=>'select2 form-control']);  ?>
                                    </div>
                                </div>
                          </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Code Postal: </label>
                                <div class="col-sm-12">
                                    <?php echo $this->Form->input('code_postal',['type'=>'text','id'=>'code_postal','label'=>false,'class'=>'form-control']);  ?>
                                </div>
                            </div>
                          </div>
                          <div id="regiondiv" class="col-sm-6">
                            <div class="form-group">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Departement:</label>
                            <div class="col-sm-12">
                                <?php echo $this->Form->select('departement_id',$departements,['id'=>'departement_id','label'=>false,'class'=>'select2 form-control']);  ?>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">ville: </label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->select('ville_id',$villes,['id'=>'ville_id','label'=>false,'class'=>'select2 form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Forme Juridique:</label>
                                <?php echo $this->Form->input('forme_juridique',['type'=>'text','id'=>'forme_juridique','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Raison Sociale: </label>
                                <?php echo $this->Form->input('raison_sociale',['type'=>'text','id'=>'raison_sociale','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Genre:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->select('Genre',[null=>'choisir un genre','Melle'=>'Mademoiselle','Mme'=>'Madame','M.'=>'Monsieur'],['id'=>'genre','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Fonction:</label>
                                <?php echo $this->Form->input('fonction',['type'=>'text','id'=>'fonction','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Code APE:</label>
                                <?php echo $this->Form->input('code_ape',['type'=>'text','id'=>'code_ape','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Capital Social:</label>
                                <?php echo $this->Form->input('capital',['type'=>'number','id'=>'capital','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Effectif:</label>
                                <?php echo $this->Form->input('effectif',['type'=>'number','id'=>'effectif','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Siret:</label>
                                <?php echo $this->Form->input('siriet',['type'=>'text','id'=>'siriet','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Nom:</label>
                                <?php echo $this->Form->input('nom',['type'=>'text','id'=>'nom','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Prenom:</label>
                                <?php echo $this->Form->input('prenom',['type'=>'text','id'=>'prenom','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">E-mail:</label>
                                <?php echo $this->Form->input('email',['type'=>'text','id'=>'email','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Skype:</label>
                                <?php echo $this->Form->input('skype',['type'=>'text','id'=>'skype','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Ftp:</label>
                                <?php echo $this->Form->input('ftp',['type'=>'text','id'=>'ftp','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Adresse du site:</label>
                                <?php echo $this->Form->input('url_adress',['type'=>'text','id'=>'url_adress','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Téléphone:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('tel',['type'=>'text','id'=>'tel','label'=>false,'class'=>'form-control']);  ?>
                                        <div id="error-msgTel" class="error-message hide">Numéro invalide</div>
                                        <div id="valid-msgTel" class="valid-message hide">Numéro valide</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Portable: </label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('portable',['type'=>'text','id'=>'portable','label'=>false,'class'=>'form-control']);  ?>
                                        <div id="error-msg" class="error-message hide">Numéro invalide</div>
                                        <div id="valid-msg" class="valid-message hide">Numéro valide</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Fax:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('fax',['type'=>'text','id'=>'telecopie','label'=>false,'class'=>'form-control']); ?>
                                        <div id="error-telecopie" class="error-message hide">Numéro invalide</div>
                                        <div id="valid-telecopie" class="valid-message hide">Numéro valide</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Description:</label>
                            <div class="col-sm-8">
                                <?= $this->Form->input("description",[
                                        'label'=>false,
                                        'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$partenaire->description.'</textarea >'],
                                        'type'=>'textarea','rows'=>'5',]);
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Image (png) : <sup class='text-danger'>*</sup></label>
                            <div class="mb-10 col-sm-12 text-left font-12"><span>L'image sera enregistrée avec la taille (350 x 150)</span></div>
                            <div class="col-sm-6">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                    <input type="hidden"><?php echo $this->Form->file('image',['accept'=>'image/png', 'required']);?>
                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                </div>
                                <?= $this->Form->isFieldError('image') ? $this->Form->error('image') : '';?>
                            </div>
                        </div> 
                        <div class="form-group row">
                          <div class="col-sm-6">
                            <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">À afficher sur landing: </label>
                            <input id="Aafficher_switch" type="checkbox" data-off-text="NON" data-off-color="danger" data-on-text="OUI" data-on-color="success" class="bs-switch">
                            <input id="radioOui" name="aContacter" class="hidden" type="radio" value="OUI" <?=($partenaire->aAfficher=='OUI'||$partenaire->aAfficher==null)?'checked':''?>>
                            <input id="radioNon" name="aContacter" class="hidden" type="radio" value="NON" <?=$partenaire->aAfficher=='NON'?'checked':''?>>
                          </div>
                        </div> 
                        <div class="form-group mb-0">
                            <div class="row mb-10">
                                <div class="col-sm-12 ml-30">
                                    <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/partenaire/index" class="btn btn-default">Retour </a>
                                </div>
                                <div class="col-sm-offset-2 col-sm-3">
                                    <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Enregistrer</span></button>
                                </div>
                            </div>
                        </div>
                        <?=$this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Switch JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<!-- Google map -->
<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&libraries=places", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Jasny-bootstrap CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>

<!-- Bootstrap Switches CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css", array('block' => 'cssTop')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var ville_id = null;
var validtel =true;
var validtelCopie = true;
var validportable = true;
function validateMyForm(){
    $('#tel').val(telInputrestel.intlTelInput("getNumber"))
    $('#portable').val(mobileInputport.intlTelInput("getNumber"))
    $('#telecopie').val(telInputrestelecopie.intlTelInput("getNumber"))
    if (validportable==false || validtel==false || validtelCopie==false) {
        if(validportable==false)
        {
            validMsgportable.addClass("hide");
            errorMsgportable.removeClass("hide");
        }
        if(validtel==false)
        {
            validMsgtel.addClass("hide");
            errorMsgtel.removeClass("hide");
        }
        if(validtelCopie==false)
        {
            validtelCopie.addClass("hide");
            errortelCopie.removeClass("hide");
        }
        return false
    }
    return true
}
errorMsgportable = $("#error-msg"),
validMsgportable = $("#valid-msg");
var mobileInputport = $("#portable");
mobileInputport.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset1 = function() {
                errorMsgportable.addClass("hide");
                validMsgportable.addClass("hide");
            };
            mobileInputport.blur(function() {
            reset1();
            if ($.trim(mobileInputport.val())) {
            if (mobileInputport.intlTelInput("isValidNumber")) {
                validMsgportable.removeClass("hide");
                validportable = true;
            } else {
                errorMsgportable.removeClass("hide");
                validportable = false;
            }
            }
        });
errorMsgtel = $("#error-msgTel"),
validMsgtel = $("#valid-msgTel");
var telInputrestel = $("#tel");
telInputrestel.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset2 = function() {
                errorMsgtel.addClass("hide");
                validMsgtel.addClass("hide");
            };
            telInputrestel.blur(function() {
            reset2();
            if ($.trim(telInputrestel.val())) {
            if (telInputrestel.intlTelInput("isValidNumber")) {
                validMsgtel.removeClass("hide");
                validtel = true;
            } else {
                validtel = false;
                errorMsgtel.removeClass("hide");
            }
            }
        });
        validtelCopie = $("#valid-telecopie"),
errortelCopie = $("#error-telecopie");
var telInputrestelecopie = $("#telecopie");
telInputrestelecopie.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset4 = function() {
                errortelCopie.addClass("hide");
                validtelCopie.addClass("hide");
            };
            telInputrestelecopie.blur(function() {
            reset4();
            if ($.trim(telInputrestelecopie.val())) {
            if (telInputrestelecopie.intlTelInput("isValidNumber")) {
                validtelCopie.removeClass("hide");
                validtelCopie = true;
            } else {
                validtelCopie = false;
                errortelCopie.removeClass("hide");
            }
            }
        });
$('#Acontacter_switch').bootstrapSwitch('state', <?=($partenaire->aContacter=='OUI'||$partenaire->aContacter==null)?'true':'false'?>);
$('#Acontacter_switch').on('switchChange.bootstrapSwitch', function (e, state) {
    if(state)
        $('#radioOui').prop("checked", true);
    else
        $('#radioNon').prop("checked", true);
});
$('#date_creation').datetimepicker({
        useCurrent: false,
        format: 'DD-MM-YYYY',
        icons: {
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down",
        },
    });
$(".select2").select2();

<?php if(!empty($confirm_res)): ?>
    $.toast().reset('all');
    $("body").removeAttr('class');
    $.toast({
        heading: 'Vous avez crée Un Partenaire',
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
        heading: "Anomalie au moment de l'enregistrement du Partenaire",
        text: '',
        position: 'bottom-right',
        loaderBg:'#fec107',
        icon: 'error',
        hideAfter: 7000
    });
<?php endif;?>

$("#massif_id").change(function() {
    if($(this).val()!=null)
    $.ajax({
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>manager/massif/getStations/"+$(this).val(),
        success:function(data){
        $('#lieugeo_id').empty();
        for (var stationId in data) {
            $('#lieugeo_id').append('<option value=' + stationId + '>' + data[stationId].toLowerCase() + '</option>');
        }
        }
    });
});
$("#code_postal").on('input',function(e){
    if($(this).val().length == 4 || $(this).val().length == 5){
    $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
        data: {code: $("#code_postal").val()},
        success:function(xml){
            data = xml.listepville;
            if(data.length>0)
            {
                ville_id=data[0].id
                $('#departement_id').val(data[0].departement_id).trigger('change');
            }
        }
    });
    }
    if($( "#code_postal" ).val().length > 5){
    $("#code_postal").val($("#code_postal").val().substr(0, 5));
    }
});

$( "#pays_id" ).change(function() {  
  if($(this).val() == 67){
    $('#regiondiv').css('display','block');
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
        success:function(xml){
          data = xml.listefrregions;
          $('#departement_id').empty();
          for (var i = 0; i < data.length; i++) {
              $('#departement_id').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
    
   $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: 182},
        success:function(xml){
          data = xml.listepville;
          $('#ville_id').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville_id').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
  }else{
    $('#regiondiv').css('display','none');
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypaysvilles/",
        data: {paysid: $(this).val()},
        success:function(xml){
          data = xml.listepville;
          $('#ville_id').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville_id').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
          }
        }
    });
  }
});

$("#departement_id").change(function() {
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
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: $(this).val()},
        success:function(xml){
          data = xml.listepville;
          $('#ville_id').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville_id').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
          if(ville_id!=null){
            $('#ville_id').val(ville_id);
            ville_id=null;
          }
          $('#ville_id').trigger('change')
          $('body').loadingModal('destroy');
        },error: function(){
          $('body').loadingModal('destroy');
        }
    });
  });

//google map
var map = new google.maps.Map(document.getElementById('map-canvas'),{
        disableDoubleClickZoom: true,
        styles:[
    {
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#f5f5f5"
        }
      ]
    },
    {
      "elementType": "labels.icon",
      "stylers": [
        {
          "visibility": "off"
        }
      ]
    },
    {
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#616161"
        }
      ]
    },
    {
      "elementType": "labels.text.stroke",
      "stylers": [
        {
          "color": "#f5f5f5"
        }
      ]
    },
    {
      "featureType": "administrative.land_parcel",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#bdbdbd"
        }
      ]
    },
    {
      "featureType": "poi",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#eeeeee"
        }
      ]
    },
    {
      "featureType": "poi",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#757575"
        }
      ]
    },
    {
      "featureType": "poi.park",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#e5e5e5"
        }
      ]
    },
    {
      "featureType": "poi.park",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#9e9e9e"
        }
      ]
    },
    {
      "featureType": "road",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#ffffff"
        }
      ]
    },
    {
      "featureType": "road.arterial",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#757575"
        }
      ]
    },
    {
      "featureType": "road.highway",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#dadada"
        }
      ]
    },
    {
      "featureType": "road.highway",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#616161"
        }
      ]
    },
    {
      "featureType": "road.local",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#9e9e9e"
        }
      ]
    },
    {
      "featureType": "transit.line",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#e5e5e5"
        }
      ]
    },
    {
      "featureType": "transit.station",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#eeeeee"
        }
      ]
    },
    {
      "featureType": "water",
      "stylers": [
        {
          "color": "#3cacff"
        },
        {
          "visibility": "on"
        }
      ]
    },
    {
      "featureType": "water",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#c9c9c9"
        }
      ]
    },
    {
      "featureType": "water",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#9e9e9e"
        }
      ]
    }
  ],
            center :{
                lat: 46.734255,
                lng: 2.418815
            },
            zoom:6,
        });

        var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));

        var input = document.getElementById('searchmap');
        
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);



        var marker = new google.maps.Marker({
            position: {
                lat: 46.734255,
                lng: 2.418815
            },
            map :map,
            draggable: true
        });

        google.maps.event.addListener(searchBox,'places_changed',function () {
            var places = searchBox.getPlaces();
            var bounds = new google.maps.LatLngBounds();
            var i,place;

            for(i=0;place=places[i];i++){
                bounds.extend(place.geometry.location);
                marker.setPosition(place.geometry.location);
            }

            map.fitBounds(bounds);
            map.setZoom(15);
        });
        function findcords() {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
            //var country,region;
            //$.get("http://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&sensor=false",function (data) {
            //    var resultat=data['results'][0];
             //   resultat['address_components'].forEach(function(comp) {
             //       if (comp['types']['0']=='country') country = comp['long_name'];
             //       if (typeof comp['types']['0'] != "undefined" && comp['types']['0']=='locality') region = comp['long_name'];
             //   });
             //   $('#lat').val(lat);     $('#lng').val(lng);
            //    $('#country').val(country);
            //    $('#adress').val(resultat['formatted_address']);
            //    $('#region').val(region);
                //console.log(resultat['formatted_address'],"country = "+country,"region = "+region);
            //});
            $('#lat').val(lat);     $('#lng').val(lng);
        };
        google.maps.event.addListener(map,'idle',function () {
            findcords();
        });
        
        google.maps.event.addListener(map, 'dblclick', function(e) {
        var positionDoubleclick = e.latLng;
        marker.setPosition(positionDoubleclick);
        findcords();
        });

        google.maps.event.addListener(marker,'dragend',function () {
            findcords();
        });
        
        $('#search_button').click(function(){
            var latlng = new google.maps.LatLng($('#lat').val(), $('#lng').val());
            marker.setPosition(latlng);
            map.setCenter(latlng);
        }); 
    //end google map
<?php $this->Html->scriptEnd(); ?>