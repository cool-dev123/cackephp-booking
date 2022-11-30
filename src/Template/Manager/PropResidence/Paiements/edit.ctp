<style>
    .is-invalid.invalid-feedback {
        color: red;
    }
</style>
<div class="row heading-bg icantSelectIt">
    <div class="col-sm-12">
      <h5 class="txt-dark">Nouvelle paiement</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <div class="form-wrap col-sm-12 col-xs-12">
                        <?php
                        echo $this->Form->create($paiement,['url'=>'/manager/paiements/edit/'.$paiement->id,'id'=>'frm_periode','class'=> 'form-horizontal form-validate-summernote']);
                        ?>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-3 pl-0 text-left font-16 txt-black">Nom : <sup class='text-danger'>*</sup></label>
                            <div class="col-lg-3 col-sm-10">
                                <input class="form-control" name="name" type="text" required="required" value="<?php echo $paiement->name; ?>" data-msg="Veuillez saisir un nom" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-3 pr-0 pl-0 text-left font-16 txt-black">Nbr jours avant date arrivé : <sup class='text-danger'>*</sup></label>
                            <div class="col-lg-3 col-sm-10">
                                <input class="form-control" name="nbr_jour" type="number" required="required" value="<?php echo $paiement->nbr_jour; ?>" data-msg="Veuillez saisir un nombre" />
                            </div>    
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-3 pr-0 pl-0 text-left font-16 txt-black">Taux commission propriétaire ( % ) : <sup class='text-danger'>*</sup></label>
                            <div class="col-lg-3 col-sm-10">
                                <input class="form-control" name="taux_commission" type="number" required="required" value="<?php echo $paiement->taux_commission; ?>" data-msg="Veuillez saisir un nombre" />
                            </div>    
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-3 pr-0 pl-0 text-left font-16 txt-black">Commission locataire : <sup class='text-danger'>*</sup></label>
                            <div class="d-flex">
                                <div class="col-sm-2 mb-20">
                                    <select id='typefrais' name="type_frais" class="select2 form-control" required="required">
                                        <option value="">Choisir type frais service</option>
                                        <option value="pourcentage" <?php if($paiement->type_frais == "pourcentage") echo "selected"; ?>>Pourcentage</option>
                                        <option value="fixe" <?php if($paiement->type_frais == "fixe") echo "selected"; ?>>Prix fixe</option>
                                    </select>
                                </div> 
                                <div class="col-sm-2">
                                    <input class="form-control" name="frais_service" type="number" step="0.01" required="required" value="<?php echo $paiement->frais_service; ?>" data-msg="Veuillez saisir un nombre" />
                                </div> 
                                <div class="col-sm-2 font-20 pt-5 signetype">
                                    <?php if($paiement->type_frais == "pourcentage") echo "%"; 
                                    else if($paiement->type_frais == "fixe") echo "€"; ?>
                                </div> 
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
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/paiements/index" class="btn btn-default">Retour </a>
                                </div>
                                <div class="col-sm-offset-6 col-sm-2">
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

<!-- Bootstrap Switch JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Switches CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css", array('block' => 'cssTop')); ?>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'La règle paiement a bien été sauvegardé',
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
                            heading: 'La règle paiement n\'a pas été sauvegardé',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 7000
                        });
    <?php endif;?>

    $("#typefrais").change(function() { 
        if($(this).val() == "pourcentage") $(".signetype").html("%");
        else if($(this).val() == "fixe") $(".signetype").html("€");
        else $(".signetype").html("");
    });    
<?php $this->Html->scriptEnd(); ?>
 