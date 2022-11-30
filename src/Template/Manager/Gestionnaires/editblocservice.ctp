<!-- Multiselect JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/multiselect/js/jquery.multi-select.js", array('block' => 'scriptBottom')); ?>
<!-- multiselect CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/multiselect/css/multi-select.css", array('block' => 'cssTop')); ?>
<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>
<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <h5 class="txt-dark mb-30">Bloc Services Mail Système <span class="text-lowercase font-12">{{{bloc_services_mail}}}</span></h5>
                    <div class="form-wrap col-sm-12 col-xs-12 mt-2">
                <?php
                echo $this->Form->create($blocServiceMail,['id'=>'frm_periode','class'=> 'form-horizontal']);
                ?>
             
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-2 col-lg-2 text-left txt-black font-15">Bloc Services Mail <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-10 col-sm-10">
                        <label>Français : </label>
                        <textarea class="textarea_editor" name="bloc_services_mail" rows="5" id="bloc_services_mail"><?php echo $blocservice->bloc_services_mail; ?></textarea>
                    </div>                    
                </div> 
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-2 col-lg-2 text-left txt-black font-15"></label>
                    <div class="col-lg-10 col-sm-10">
                        <label>Anglais : </label>
                        <textarea class="textarea_editor" name="bloc_services_mail_en" rows="5" id="bloc_services_mail_en"><?php echo $blocservice->bloc_services_mail_en; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-2 col-lg-2 text-left txt-black font-15">Gestionnaires <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-10 col-sm-10">
                        <select id='pre-selected-options' name="listegestionnaires[]" multiple='multiple'>
                            <?php foreach($listegestionnaires as $variable):?>
                            <option value="<?php echo $variable->id?>"><?php echo $variable->name?></option> 
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>                 
                
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-sm-12 ml-10">
                            <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/blocservicemailgestionnaire" class="btn btn-default">Retour </a>
                        </div>
                        <div class="col-sm-6 text-right">
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
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/msdropdown/jquery.dd.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
$('#pre-selected-options').multiSelect();
var listegest = <?php echo json_encode($listegest); ?>;
$.each( listegest, function( key, value ) {   
    if(value != '') $('#pre-selected-options').multiSelect('select', value);                                     
});
    
    $("#frm_periode").validate({
	rules: {
        bloc_services_mail:{
            required: true,
        },
        bloc_services_mail_en:{
            required: true,
        },
        listegestionnaires:{
            required: true,
        },
	},
        lang: 'fr',
        ignore: ":hidden:not(#bloc_services_mail, #bloc_services_mail_en),.note-editable.panel-body"
    });
    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Un nouveau code a été crée',
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
    $('#bloc_services_mail').summernote({
        height: 150,
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
                $('#bloc_services_mail').val($('#bloc_services_mail').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_services_mail'));
            }
        }
    }); 
    $('#bloc_services_mail_en').summernote({
        height: 150,
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
                $('#bloc_services_mail_en').val($('#bloc_services_mail_en').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_services_mail_en'));
            }
        }
    });       
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/css/flags.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/msdropdown/dd.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/msdropdown/flags.css", array('block' => 'cssTop')); ?>