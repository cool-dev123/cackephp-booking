<?php $this->start('cssTop'); ?>
    <style>
        .fileinput.input-group.fileinput-exists {
            overflow: hidden;
        }
        div.background-gris{
          background-color: #f2f2f2;
        }
        .zoom{
            transition: transform .5s;
        }
        .zoom:hover {
            transform: scale(3);
            margin-bottom: 100px;
        }
        hr {
            border-color: #999 !important;
            margin-top: 0px !important;
        }
    </style>
<?php $this->end(); ?>

<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>
<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>

<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12">
      <h5 class="txt-dark">Modifier Média</h5>
    </div>
</div>
<?php // print_r("<pre>");print_r($Media);print_r("</pre>") ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                <div class="form-wrap col-sm-12 col-xs-12">
                        <?=$this->Form->create($Media,['type' => 'file','id'=>'station','class'=> 'form-horizontal']);?>
                        <?php //if( !empty($Media->invalid()) ): ?>
                          <!-- <div class="row">
                            <div class="col-sm-8">
                              <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="zmdi zmdi-block pr-15 pull-left"></i><p class="pull-left">Vérifier les données saisies.</p>
                                <div class="clearfix"></div>
                              </div>
                            </div>
                          </div> -->
                        <?php //endif; ?>
                        <?php if($Media->title_hiver != "--"){ ?>
                            <h3 class="text-center">Été</h3>
                        <?php } ?>                          
                        <div class="row mb-30">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Titre / alt:</u> </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français:</label>
                                <div class="col-sm-12">
                                    <?php echo $this->Form->input('title_ete',['type'=>'text','id'=>'title_ete','label'=>false,'class'=>'form-control','required']);  ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>:</label>
                                <div class="col-sm-12">
                                    <?php echo $this->Form->input('title_ete_en',['type'=>'text','id'=>'title_ete_en','label'=>false,'class'=>'form-control','value'=>$Media->_translations[$language->code]->title_ete, 'required']);  ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Image <?php if($Media->title_hiver != "--"){ ?>été<?php } ?>  :</u> </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français:</label>
                                <div class="col-sm-12">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                        <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                        <input type="hidden"><?php 
                                        if($Media->lien_ete != "") echo $this->Form->file('lien_ete',['accept'=>'image/*']);
                                        else echo $this->Form->file('lien_ete',['accept'=>'image/*', 'required']);
                                        ?>
                                        </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                    </div>
                                    <?= $this->Form->isFieldError('lien_ete') ? $this->Form->error('lien_ete') : '';?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>:</label>
                                <div class="col-sm-12">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                        <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                        <input type="hidden"><?php 
                                        if($Media->_translations[$language->code]->lien_ete != "") echo $this->Form->file('lien_ete_en',['accept'=>'image/*']);
                                        else echo $this->Form->file('lien_ete_en',['accept'=>'image/*', 'required']);
                                        ?>
                                        </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                    </div>
                                    <?= $this->Form->isFieldError('lien_ete_en') ? $this->Form->error('lien_ete_en') : '';?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <?php if($Media->lien_ete != ""){ ?>
                            <h5>Ancienne Image <?php if($Media->title_hiver != "--"){ ?>été<?php } ?>  français</h5>
                            <img width="100%" src="<?= $this->Url->build('/',true).$Media->lien_ete;?>.<?php if($Media->name_key == 'header_bloc_information' || $Media->name_key == 'logo_alpissime' || $Media->name_key == 'paiement_securise_desktop' || $Media->name_key == 'paiement_securise_mobile') echo 'png'; else echo 'jpg'; ?>">
                            <?php } ?>
                          </div>
                          <div class="col-sm-6">
                            <?php if($Media->_translations[$language->code]->lien_ete != ""){ ?>
                            <h5>Ancienne Image <?php if($Media->title_hiver != "--"){ ?>été<?php } ?>  <?php echo $language->name; ?></h5>
                            <img width="100%" src="<?= $this->Url->build('/',true).$Media->_translations[$language->code]->lien_ete;?>.<?php if($Media->name_key == 'header_bloc_information' || $Media->name_key == 'logo_alpissime' || $Media->name_key == 'paiement_securise_desktop' || $Media->name_key == 'paiement_securise_mobile') echo 'png'; else echo 'jpg'; ?>">
                            <?php } ?>
                          </div>
                        </div>
                        <?php if($Media->title_hiver != "--"){ ?>
                        <div class="row text-center">
                            <div class="col-md-12"><hr></div>
                        </div>                        
                        <h3 class="text-center">Hiver</h3> 
                        <div class="row mb-30">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Titre / alt:</u> </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français:</label>
                                <div class="col-sm-12">
                                    <?php echo $this->Form->input('title_hiver',['type'=>'text','id'=>'title_hiver','label'=>false,'class'=>'form-control','required']);  ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>:</label>
                                <div class="col-sm-12">
                                    <?php echo $this->Form->input('title_hiver_en',['type'=>'text','id'=>'title_hiver_en','label'=>false,'class'=>'form-control','value'=>$Media->_translations[$language->code]->title_hiver, 'required']);  ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Image hiver:</u> </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français:</label>
                                <div class="col-sm-12">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                        <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                        <input type="hidden"><?php 
                                        if($Media->lien_hiver != "") echo $this->Form->file('lien_hiver',['accept'=>'image/*']);
                                        else echo $this->Form->file('lien_hiver',['accept'=>'image/*', 'required']);
                                        ?>
                                        </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                    </div>
                                    <?= $this->Form->isFieldError('lien_hiver') ? $this->Form->error('lien_hiver') : '';?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>:</label>
                                <div class="col-sm-12">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                        <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                        <input type="hidden"><?php 
                                        if($Media->_translations[$language->code]->lien_hiver != "") echo $this->Form->file('lien_hiver_en',['accept'=>'image/*']);
                                        else echo $this->Form->file('lien_hiver_en',['accept'=>'image/*', 'required']);
                                        ?>
                                        </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                    </div>
                                    <?= $this->Form->isFieldError('lien_hiver_en') ? $this->Form->error('lien_hiver_en') : '';?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <?php if($Media->lien_hiver != ""){ ?>
                            <h5>Ancienne Image hiver français</h5>
                            <img width="100%" src="<?= $this->Url->build('/',true).$Media->lien_hiver;?>.<?php if($Media->name_key == 'header_bloc_information' || $Media->name_key == 'logo_alpissime' || $Media->name_key == 'paiement_securise_desktop' || $Media->name_key == 'paiement_securise_mobile') echo 'png'; else echo 'jpg'; ?>">
                            <?php } ?>
                          </div>
                          <div class="col-sm-6">
                            <?php if($Media->_translations[$language->code]->lien_hiver != ""){ ?>
                            <h5>Ancienne Image hiver <?php echo $language->name; ?></h5>
                            <img width="100%" src="<?= $this->Url->build('/',true).$Media->_translations[$language->code]->lien_hiver;?>.<?php if($Media->name_key == 'header_bloc_information' || $Media->name_key == 'logo_alpissime' || $Media->name_key == 'paiement_securise_desktop' || $Media->name_key == 'paiement_securise_mobile') echo 'png'; else echo 'jpg'; ?>">
                            <?php } ?>
                          </div>
                        </div>
                        <?php } ?>
                        <div class="form-group mb-0">
                            <div class="row mb-10">
                                <div class="col-sm-12 ml-30">
                                    <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/annonces/medialanguage" class="btn btn-default">Retour </a>
                                </div>
                                <div class="text-right col-sm-5">
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

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Jasny-bootstrap CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>

<!-- Bootstrap Switches CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Switch JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$(".select2").select2();

$('#descreption').summernote({
    height: 200,
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
        ['link',['linkDialogShow', 'unlink']],
        ['fullscreen',['fullscreen']],
        ['codeview',['codeview']],
        ['undo',['undo']],
        ['redo',['redo']],
    ],
    callbacks: {
        onChange: function (contents, $editable) {
            // Note that at this point, the value of the `textarea` is not the same as the one
            // you entered into the summernote editor, so you have to set it yourself to make
            // the validation consistent and in sync with the value.
            $('#descreption').val($('#descreption').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#descreption'));
        }
    }
}); 

$('#descreption-en').summernote({
    height: 200,
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
        ['link',['linkDialogShow', 'unlink']],
        ['fullscreen',['fullscreen']],
        ['codeview',['codeview']],
        ['undo',['undo']],
        ['redo',['redo']],
    ],
    callbacks: {
        onChange: function (contents, $editable) {
            // Note that at this point, the value of the `textarea` is not the same as the one
            // you entered into the summernote editor, so you have to set it yourself to make
            // the validation consistent and in sync with the value.
            $('#descreption-en').val($('#descreption-en').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#descreption-en'));
        }
    }
});

<?php // if($Media->description_acc != ''){ ?>
  // $('#description-acc').summernote('disable');
<?php // } ?>

function arrayToData(array)
{
  json={}
  array.forEach(function(element) {
    json[element.name]=element.value
  })
  return json
}


<?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: 'Vous avez modifier Une Station',
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
            heading: "Anomalie au moment de l'enregistrement du Station",
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'error',
            hideAfter: 7000
        });
    <?php endif;?>

    
<?php $this->Html->scriptEnd(); ?>