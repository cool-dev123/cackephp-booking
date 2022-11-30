<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>
<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>

<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-settings  mr-10"></i> Configuration</span>
    </div>
    <ul class="nav navbar-nav">
    <?php if($InfoGes['G']['role']!='gestionnaire'):?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/pub">Publicités</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/packs/index">Packs De Services</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/parametrage/gps">Points GPS</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/index">Liste Des Gestionaires</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/8">Gestion Des Pages</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/cautions/index">Résidences de tourisme</a></li>
    <?php endif; ?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/stations/">Stations</a></li>
    <?php if($InfoGes['G']['role']!='gestionnaire'):?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/vacances/">Vacances</a></li>
    <?php endif; ?>
      <li class="active"><a href="#">Gestion de modèles</a></li>
    </ul>
  </div>
</nav>

<div class="row icantSelectIt">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view mt-0 pt-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="text-center button-list">
                            <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelmail">Modèle mail</a>
                            <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelsms">Modèle sms</a>
                            <?php if($InfoGes['G']['role']!="admin"): ?><button class="btn btn-success mt-5">Informations des emails transactionnels</button><?php endif; ?>
                            <?php if($InfoGes['G']['role']=="admin"): ?>
                                <a class="btn btn-success mt-5" href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelmailsysteme">Modèle Mail Systéme</a>
                                <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelsmsysteme">Modèle Sms Systéme</a>
                                <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/modelcontrat">Modèle Contrat</a>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($InfoGes['G']['role']=="admin"): ?>
<div class="row icantSelectIt">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view mt-0 pt-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="text-center button-list">
                    <button class="btn btn-success mt-5">Blocs Mails Système</button>
                            <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/blocservicemailgestionnaire">Blocs Services Mails Système</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <h5 class="txt-dark mb-30">Informations des emails transactionnels</h5>
                    <div class="form-wrap col-sm-12 col-xs-12 mt-2">
                <?php
                echo $this->Form->create(null,['url'=>'/manager/gestionnaires/blocmailgestionnaire','id'=>'frm_periode','class'=> 'form-horizontal']);
                echo $this->Form->input('gestionnaire_id',['value'=>$InfoGes['G']['id'],'type'=>'hidden']); ?>
             
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15">Bloc Informations Arrivée <sup class='text-danger'>*</sup> <span class="text-lowercase font-12">{{{bloc_info_arrivee}}}</span></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Français : </label>
                        <textarea class="textarea_editor" name="bloc_info_arrivee" rows="5" id="bloc_info_arrivee"><?php echo $blocMailGestionnaire->bloc_info_arrivee?$blocMailGestionnaire->bloc_info_arrivee:$blocMailGestionnaireDefault->bloc_info_arrivee; ?></textarea>
                    </div>                    
                </div> 
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15"></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Anglais : </label>
                        <textarea class="textarea_editor" name="bloc_info_arrivee_en" rows="5" id="bloc_info_arrivee_en"><?php echo $blocMailGestionnaire->bloc_info_arrivee_en?$blocMailGestionnaire->bloc_info_arrivee_en:$blocMailGestionnaireDefault->bloc_info_arrivee_en; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15">Bloc Informations Départ <sup class='text-danger'>*</sup> <span class="text-lowercase font-12">{{{bloc_info_depart}}}</span></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Français : </label>
                        <textarea class="textarea_editor" name="bloc_info_depart" rows="5" id="bloc_info_depart"><?php echo $blocMailGestionnaire->bloc_info_depart?$blocMailGestionnaire->bloc_info_depart:$blocMailGestionnaireDefault->bloc_info_depart; ?></textarea>
                    </div>                    
                </div> 
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15"></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Anglais : </label>
                        <textarea class="textarea_editor" name="bloc_info_depart_en" rows="5" id="bloc_info_depart_en"><?php echo $blocMailGestionnaire->bloc_info_depart_en?$blocMailGestionnaire->bloc_info_depart_en:$blocMailGestionnaireDefault->bloc_info_depart_en; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15">Bloc Informations Horaire <sup class='text-danger'>*</sup> <span class="text-lowercase font-12">{{{bloc_info_horaires}}}</span></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Français : </label>
                        <textarea class="textarea_editor" name="bloc_info_horaires" rows="5" id="bloc_info_horaires"><?php echo $blocMailGestionnaire->bloc_info_horaires?$blocMailGestionnaire->bloc_info_horaires:$blocMailGestionnaireDefault->bloc_info_horaires; ?></textarea>
                    </div>                    
                </div> 
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15"></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Anglais : </label>
                        <textarea class="textarea_editor" name="bloc_info_horaires_en" rows="5" id="bloc_info_horaires_en"><?php echo $blocMailGestionnaire->bloc_info_horaires_en?$blocMailGestionnaire->bloc_info_horaires_en:$blocMailGestionnaireDefault->bloc_info_horaires_en; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15">Bloc Services Propriétaire <sup class='text-danger'>*</sup> <span class="text-lowercase font-12">{{{bloc_service_proprietaire}}}</span></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Français : </label>
                        <textarea class="textarea_editor" name="bloc_service_proprietaire" rows="5" id="bloc_service_proprietaire"><?php echo $blocMailGestionnaire->bloc_service_proprietaire?$blocMailGestionnaire->bloc_service_proprietaire:$blocMailGestionnaireDefault->bloc_service_proprietaire; ?></textarea>
                    </div>                    
                </div> 
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15"></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Anglais : </label>
                        <textarea class="textarea_editor" name="bloc_service_proprietaire_en" rows="5" id="bloc_service_proprietaire_en"><?php echo $blocMailGestionnaire->bloc_service_proprietaire_en?$blocMailGestionnaire->bloc_service_proprietaire_en:$blocMailGestionnaireDefault->bloc_service_proprietaire_en; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15">Bloc Ménage Départ <sup class='text-danger'>*</sup> <span class="text-lowercase font-12">{{{bloc_menage_depart}}}</span></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Français : </label>
                        <textarea class="textarea_editor" name="bloc_menage_depart" rows="5" id="bloc_menage_depart"><?php echo $blocMailGestionnaire->bloc_menage_depart?$blocMailGestionnaire->bloc_menage_depart:$blocMailGestionnaireDefault->bloc_menage_depart; ?></textarea>
                    </div>                    
                </div> 
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 col-lg-3 text-left txt-black font-15"></label>
                    <div class="col-lg-9 col-sm-9">
                        <label>Anglais : </label>
                        <textarea class="textarea_editor" name="bloc_menage_depart_en" rows="5" id="bloc_menage_depart_en"><?php echo $blocMailGestionnaire->bloc_menage_depart_en?$blocMailGestionnaire->bloc_menage_depart_en:$blocMailGestionnaireDefault->bloc_menage_depart_en; ?></textarea>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-sm-12 ml-10">
                            <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-right">
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
    
    $("#frm_periode").validate({
	rules: {
        bloc_info_arrivee:{
            required: true,
        },
        bloc_info_depart:{
            required: true,
        },
        bloc_info_horaires :{
            required: true,
        },
        bloc_service_proprietaire :{
            required: true,
        },
        bloc_menage_depart :{
            required: true,
        },
        bloc_info_arrivee_en:{
            required: true,
        },
        bloc_info_depart_en:{
            required: true,
        },
        bloc_info_horaires_en :{
            required: true,
        },
        bloc_service_proprietaire_en :{
            required: true,
        },
        bloc_menage_depart_en :{
            required: true,
        },
	},
        lang: 'fr',
        ignore: ":hidden:not(#bloc_info_arrivee, #bloc_info_arrivee_en, #bloc_info_depart, #bloc_info_depart_en, #bloc_info_horaires, #bloc_info_horaires_en, #bloc_service_proprietaire, #bloc_service_proprietaire_en, #bloc_menage_depart, #bloc_menage_depart_en),.note-editable.panel-body"
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
    $('#bloc_info_arrivee').summernote({
        height: 130,
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
                $('#bloc_info_arrivee').val($('#bloc_info_arrivee').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_info_arrivee'));
            }
        }
    });  
    $('#bloc_info_arrivee_en').summernote({
        height: 130,
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
                $('#bloc_info_arrivee_en').val($('#bloc_info_arrivee_en').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_info_arrivee_en'));
            }
        }
    }); 
    $('#bloc_info_depart').summernote({
        height: 130,
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
                $('#bloc_info_depart').val($('#bloc_info_depart').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_info_depart'));
            }
        }
    });  
    $('#bloc_info_depart_en').summernote({
        height: 130,
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
                $('#bloc_info_depart_en').val($('#bloc_info_depart_en').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_info_depart_en'));
            }
        }
    }); 
    $('#bloc_info_horaires').summernote({
        height: 130,
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
                $('#bloc_info_horaires').val($('#bloc_info_horaires').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_info_horaires'));
            }
        }
    }); 
    $('#bloc_info_horaires_en').summernote({
        height: 130,
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
                $('#bloc_info_horaires_en').val($('#bloc_info_horaires_en').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_info_horaires_en'));
            }
        }
    }); 
    $('#bloc_service_proprietaire').summernote({
        height: 130,
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
                $('#bloc_service_proprietaire').val($('#bloc_service_proprietaire').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_service_proprietaire'));
            }
        }
    });  
    $('#bloc_service_proprietaire_en').summernote({
        height: 130,
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
                $('#bloc_service_proprietaire_en').val($('#bloc_service_proprietaire_en').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_service_proprietaire_en'));
            }
        }
    });
    $('#bloc_menage_depart').summernote({
        height: 130,
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
                $('#bloc_menage_depart').val($('#bloc_menage_depart').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_menage_depart'));
            }
        }
    }); 
    $('#bloc_menage_depart_en').summernote({
        height: 130,
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
                $('#bloc_menage_depart_en').val($('#bloc_menage_depart_en').summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                summernoteValidator.element($('#bloc_menage_depart_en'));
            }
        }
    });  
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/css/flags.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/msdropdown/dd.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/msdropdown/flags.css", array('block' => 'cssTop')); ?>