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
    </style>
<?php $this->end(); ?>

<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>
<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>

<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12">
      <h5 class="txt-dark">Modifier Station</h5>
    </div>
</div>
<?php // print_r("<pre>");print_r($Massif);print_r("</pre>") ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                <div class="form-wrap col-sm-12 col-xs-12">
                        <?=$this->Form->create($Massif,['type' => 'file','id'=>'station','class'=> 'form-horizontal']);?>
                        <?php echo $this->Form->input('niveau',['type'=>'hidden','id'=>'niveau','value'=>3,'label'=>false]);  ?>
                        <?php if( !empty($Massif->invalid()) ): ?>
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
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Nom À Utiliser Dans L'url:</u> </label>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->input('nom_url',['type'=>'text','id'=>'nom_url','label'=>false,'class'=>'form-control','required']);  ?>
                                  </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->input('nom_url_en',['type'=>'text','id'=>'nom_url','label'=>false,'class'=>'form-control', 'value'=>$Massif->_translations[$language->code]->nom_url, 'required']);  ?>
                                  </div>
                              </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Description:</u> </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("descreption",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Massif->descreption.'</textarea >'],
                                            'type'=>'textarea','rows'=>'5',]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("descreption_en",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Massif->_translations[$language->code]->descreption.'</textarea >'],
                                            'type'=>'textarea','rows'=>'5',]);
                                    ?>
                                </div>
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
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/annonces/massiflanguage" class="btn btn-default">Retour </a>
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

<?php // if($Massif->description_acc != ''){ ?>
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