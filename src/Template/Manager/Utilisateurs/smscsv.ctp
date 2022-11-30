<?php $this->start('cssTop'); ?>
    <style>
        .fileinput.input-group.fileinput-exists {
            overflow: hidden;
        }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-comment-alt"></i> SMS & MAIL</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/smslocataire/">Envoyer un modèle</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/sms">SMS Gestionaires</a></li>
      <li class="active"><a href="#">SMS Propriétaires</a></li>
    </ul>
  </div>
</nav>
    
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                        <h6 class="panel-title txt-dark">Envoi sms ( pour l'import le n° de téléphone est sur la colonne 1)</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
                  echo $this->Form->create(null,['type' => 'file','url'=>'/manager/utilisateurs/smscsv/','id'=>'frm_periode','class'=> 'form-horizontal']);
                  ?>
                <div class="form-group">
                    <label id="txtmessage" class="control-label mb-10 col-sm-5 text-left font-16">Description (max 160 caractère) : <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-6 col-sm-10">
                        <textarea type="" name="description" rows="5" cols="100" id="description" onkeyup="txtreste()"><?=$olddesc?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-5 text-left font-16">SÉLECTIONNEZ LA LISTE DES PROPRIÉTAIRES (.CSV): <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-6 col-sm-10">
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                            <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                <input type="hidden"><input type="file" name="filename" id="filename">
                            </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a> 
                        </div>
                        <div id="errordiv"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-5 text-left font-16">Copie Administrateur <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="vert: Oui, rouge: Non"></i> <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-3 col-sm-10">
                        <input name="Copie_administrateur" type="checkbox" class="js-switch js-switch-1"  data-color="#4dad44" data-secondary-color="#eb0000" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-5 text-left font-16">Type SMS <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="Si Commercial on ajoute la mention 'STOP' "></i> <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-3 col-sm-10">
                        <div class="checkbox">
                            <input id="info" type="checkbox" value="info" name="tabtype[]">
                            <label for="info"> Information </label>
                        </div>
                        <div class="checkbox">
                            <input id="commerce" type="checkbox" value="commerce" name="tabtype[]">
                            <label for="commerce"> Commercial </label>
                        </div>
                        <div id="errordivtype"></div>
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
                            <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-send"></i><span class="btn-text">Envoyer</span></button>
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

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/additional-methods.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Switch JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js", array('block' => 'scriptBottom')); ?>
<!-- Jasny-bootstrap JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js", array('block' => 'scriptBottom')); ?>
                    
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Jasny-bootstrap CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Switches CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});
    txtreste();
    
    $('.js-switch-1').each(function() {
            new Switchery($(this)[0], $(this).data());
    });
    
    function txtreste(){
        //int nb_c=$("#description").val().length;
        txtres=160-$("#description").val().length;
        //else txtres=160;
        $("#txtmessage").html("Description (reste "+txtres+" caractère) :");
    }
    
    $("#frm_periode").validate({
	rules: {
        filename: {
            required: true,
            extension: "csv",
		},
		description: {
            required: true,
            rangelength:[0,160]
        },
        'tabtype[]': {
            required: true, 
        } 
	},
        messages :{
            filename: 'Choisir un fichier csv',
            description: {
                    rangelength: "Veuillez ne pas entrer plus de 160 caractères",
                }
        },
        lang: 'fr',
        errorPlacement: function(error, element) {
            if (element.attr("name") == "filename" )
                error.appendTo('#errordiv');
            else if (element.attr("name") == "tabtype[]")
                error.appendTo('#errordivtype');
            else
                error.insertAfter(element);
        }
    });
    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Sms envoyé',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 6000
                        });
    <?php endif;?>
    <?php if(!empty($error_res)): ?>
        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: '<?=$error_res?>',
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'error',
            hideAfter: 6000
        });
    <?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>