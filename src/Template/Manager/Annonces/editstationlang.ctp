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
<?php // print_r("<pre>");print_r($Lieugeo);print_r("</pre>") ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                <div class="form-wrap col-sm-12 col-xs-12">
                        <?=$this->Form->create($Lieugeo,['type' => 'file','id'=>'station','class'=> 'form-horizontal']);?>
                        <?php echo $this->Form->input('niveau',['type'=>'hidden','id'=>'niveau','value'=>3,'label'=>false]);  ?>
                        <?php if( !empty($Lieugeo->invalid()) ): ?>
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
                                <label class="control-label text-left font-16 txt-black"><u>Préposition:</u> </label>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->input('preposition_a',['type'=>'text','id'=>'preposition_a','label'=>false,'class'=>'form-control','placeholder'=>'à, au, aux ...', 'required']);  ?>
                                  </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->input('preposition_a_en',['type'=>'text','id'=>'preposition_a','label'=>false,'class'=>'form-control', 'value'=>$Lieugeo->_translations[$language->code]->preposition_a, 'required']);  ?>
                                  </div>
                              </div>
                            </div>                            
                        </div>
                        <div class="row mt-30">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Article:</u> </label>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->input('article_de',['type'=>'text','id'=>'article_de','label'=>false,'class'=>'form-control','placeholder'=>'du, de l\', des ...', 'required']);  ?>
                                  </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->input('article_de_en',['type'=>'text','id'=>'article_de','label'=>false,'class'=>'form-control','value'=>$Lieugeo->_translations[$language->code]->article_de, 'required']);  ?>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="row mt-30">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Description:</u> </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("descreption",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->descreption.'</textarea >'],
                                            'type'=>'textarea','rows'=>'5',]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("descreption_en",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->_translations[$language->code]->descreption.'</textarea >'],
                                            'type'=>'textarea','rows'=>'5',]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-30">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Sous Description:</u> </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("sous_description",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->sous_description.'</textarea >'],
                                            'type'=>'textarea','rows'=>'5',]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("sous_description_en",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->_translations[$language->code]->sous_description.'</textarea >'],
                                            'type'=>'textarea','rows'=>'5',]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-30">
                            <div class="col-sm-12">
                                <label class="control-label text-left font-16 txt-black"><u>Accessibilité:</u> </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("description_acc",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->description_acc.'</textarea >'],
                                            'type'=>'textarea','rows'=>'5',]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("description_acc_en",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->_translations[$language->code]->description_acc.'</textarea >'],
                                            'type'=>'textarea','rows'=>'5',]);
                                    ?>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group row mt-30">
                            <div class="col-sm-12">
                            <label class="control-label text-left font-16 txt-black"><u>Description API:</u> </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Français:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("description_api",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->description_api.'</textarea >'],
                                            'type'=>'textarea','rows'=>'5',]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black"><?php echo $language->name; ?>:</label>
                                <div class="col-sm-12">
                                    <?= $this->Form->input("description_api_en",[
                                            'label'=>false,
                                            'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->_translations[$language->code]->description_api.'</textarea >'],
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
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/annonces/stationlanguage" class="btn btn-default">Retour </a>
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

$('#sous-description').summernote({
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
            $('#sous-description').val($('#sous-description').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#sous-description'));
        }
    }
}); 

$('#sous-description-en').summernote({
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
            $('#sous-description-en').val($('#sous-description-en').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#sous-description-en'));
        }
    }
});

$('#description-acc').summernote({
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
            $('#description-acc').val($('#description-acc').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#description-acc'));
        }
    }
}); 

$('#description-acc-en').summernote({
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
            $('#description-acc-en').val($('#description-acc-en').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#description-acc-en'));
        }
    }
});

$('#description-api').summernote({
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
            $('#description-api').val($('#description-api').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#description-api'));
        }
    }
});
// $('#description-api').summernote('disable');  

$('#description-api-en').summernote({
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
            $('#description-api-en').val($('#description-api-en').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#description-api-en'));
        }
    }
});
<?php // if($Lieugeo->description_acc != ''){ ?>
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