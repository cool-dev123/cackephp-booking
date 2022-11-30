<?php $this->start('cssTop') ?>
<style>
    textarea{width: 100%;}
</style>
<?php $this->end() ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h5 class="txt-dark">Modification modele sms</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
                  echo $this->Form->create($modelmessage,['url'=>'/manager/utilisateurs/editmodelsms/'.$modelmessage->id,'id'=>'frm_periode','class'=> 'form-horizontal']);
                  echo $this->Form->input('id');
                  echo $this->Form->input('id_gestionnaire',['type'=>'hidden','value'=>$InfoGes['G']['id']]);
                  ?>
                <div class="form-group row">
                    <label class="control-label mb-10 col-sm-4 col-lg-3 text-left txt-black font-16">Titre: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-4 col-sm-8">
                        <?php echo $this->Form->input('titre',['type'=>'text','id'=>'titre','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label mb-10 col-sm-4 col-lg-3 text-left txt-black font-16">Sujet: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-4 col-sm-8">
                        <?php echo $this->Form->input('sujet',['type'=>'text','id'=>'sujet','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="form-group">
                    <label id="txtmessage" class="control-label mb-10 col-sm-4 col-lg-3 text-left txt-black font-16">Message <br>(reste 160 caractère) : <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-4 col-sm-8">
                        <textarea type="" name="txtsms" rows="5" cols="30" id="message" onkeyup="txtreste()"><?php echo $modelmessage->txtsms ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-4 col-lg-3 text-left font-16 txt-black">Type SMS <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="Si Commercial on ajoute la mention 'STOP' "></i> <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-4 col-sm-8">
                        <div class="checkbox">
                            <input id="info" type="checkbox" value="info" name="typesms" <?php if($modelmessage->typesms == "info") echo "checked"; ?>>
                            <label for="info"> Information </label>
                        </div>
                        <div class="checkbox">
                            <input id="commerce" type="checkbox" value="commerce" name="typesms" <?php if($modelmessage->typesms == "commerce") echo "checked"; ?>>
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
                            <a href="<?php echo $this->Url->build('/',true);?>manager/utilisateurs/modelsms" class="btn btn-default">Retour </a>
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
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>


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
    function txtreste(){
        //int nb_c=$("#message").val().length;
        txtres=160-$("#message").val().length;
        //else txtres=160;
        $("#txtmessage").html("Message <br>(reste "+txtres+" caractère) : <sup class='text-danger'>*</sup>");
    }
    
    txtreste();
                    
    $("#frm_periode").validate({
	rules: {
		titre: {
                    required: true,
		},
                sujet: {
                    required: true,
                },
                txtsms: {
                    required: true,
                    rangelength:[0,160]
                },
                typesms: {
                    required: true, 
                }       
	},
        messages :{
            txtsms: {
                    rangelength: "Veuillez ne pas entrer plus de 160 caractères",
                }
        },
        lang: 'fr',
        errorPlacement: function(error, element) {
            if (element.attr("name") == "typesms")
                error.appendTo('#errordivtype');
            else
                error.insertAfter(element);
        }
    });
    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'modele sms a &eacute;t&eacute; modifié',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 7000
                        });
    <?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>