<div class="row heading-bg icantSelectIt">
    <div class="col-sm-12">
      <h5 class="txt-dark">Création d'un pack</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
                echo $this->Form->create(null,['url'=>'/manager/packs/add','id'=>'frm_periode','class'=> 'form-horizontal']);
                ?>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Titre : <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-3 col-sm-10">
                        <?php echo $this->Form->input('titre',['id'=>'titre','label'=>false,'class'=>'form-control']);  ?>                       
                    </div>
                </div>
                        
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Prix : <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-3 col-sm-10">
                        <?php echo $this->Form->input('cout',['id'=>'cout','label'=>false,'class'=>'form-control']);  ?>                       
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-2 pr-0 text-left font-16 txt-black">Actif (O/N) <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="vert: actif, rouge: non"></i> <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-3 col-sm-10">
                        <input name="actif_yn" type="checkbox" class="js-switch js-switch-1"  data-color="#4dad44" data-secondary-color="#eb0000" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-2 pr-0 text-left font-16 txt-black">Commentaire<sup class='text-danger'>*</sup></label>
                    <div class="col-lg-10 col-sm-12">
                        <textarea style="max-width: 100%" name="comment" class="textarea_editor form-control" rows="15"></textarea>
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
                            <a href="<?php echo $this->Url->build('/',true);?>manager/packs/" class="btn btn-default">Retour </a>
                        </div>
                        <div class="col-sm-offset-2 col-sm-2">
                            <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Enregistrer</span></button>
                        </div>
                    </div>
                </div>
            <?php
            
				 echo $this->Form->end();
                ?>
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
<?php $this->Html->script("/js/msdropdown/jquery.dd.min.js", array('block' => 'scriptBottom')); ?>

<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Switch JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Switches CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css", array('block' => 'cssTop')); ?>

<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    
    $('.js-switch-1').each(function() {
            new Switchery($(this)[0], $(this).data());
    });
    
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
                                    ['link',['linkDialogShow', 'unlink']],
                                    ['fullscreen',['fullscreen']],
                                    ['codeview',['codeview']],
                                    ['undo',['undo']],
                                    ['redo',['redo']],
                                            ]
                        });
    
    jQuery.validator.addMethod(
        "regex",
         function(value, element, regexp) {
             if (regexp.constructor != RegExp)
                regexp = new RegExp(regexp);
             else if (regexp.global)
                regexp.lastIndex = 0;
                return this.optional(element) || regexp.test(value);
         },"erreur expression reguliere"
    );

    $("#frm_periode").validate({
	rules: {
		titre: {
                    required: true,
		},
                cout:{
                    required: true,
                    "regex": /^[0-9]{1,}(\.|)[0-9]{0,2}$/g
                },
	},
        lang: 'fr',
        messages: {
            titre: "Choisir un Titre",
            cout:{ required:"Choisir un Prix",
                   "regex":"Format invalide" },
        }
    });
    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Le pack a bien été sauvegardé',
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
                            heading: 'Le pack n\'a pas été sauvegardé',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 7000
                        });
    <?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>
    
<?php $this->start('cssTop'); ?>
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
    </style>
<?php $this->end(); ?>