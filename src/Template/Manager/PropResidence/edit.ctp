<style>
    .is-invalid.invalid-feedback {
        color: red;
    }
</style>
<div class="row heading-bg icantSelectIt">
    <div class="col-sm-12">
      <h5 class="txt-dark">Gestion Règle-Propriétaire</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <div class="form-wrap col-sm-12 col-xs-12">
                        <?php
                        echo $this->Form->create($utilisateur,['url'=>'/manager/propresidence/edit/'.$utilisateur->id,'id'=>'frm_periode','class'=> 'form-horizontal form-validate-summernote']);
                        ?>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Caution : </label>
                            <div class="col-lg-3 col-sm-10">
                                <select id='listecautions' name="listecautions" class="select2 form-control">
                                    <option value="">Choisir une règle caution</option>
                                    <?php foreach($listecautions as $variable):?>
                                    <option <?=in_array($variable->id, $util_cautions)?'selected':''?> value="<?php echo $variable->id?>"><?php echo $variable->name?></option> 
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Cautions : </label>
                            <div class="col-lg-3 col-sm-10">
                                <select id='pre-selected-options' name="listecautions[]" multiple='multiple'>
                                    <?php //foreach($listecautions as $variable):?>
                                    <option <?=in_array($variable->id, $util_cautions)?'selected':''?> value="<?php // echo $variable->id?>"><?php // echo $variable->name?></option> 
                                    <?php //endforeach;?>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group mt-50">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Paiement : </label>
                            <div class="col-lg-3 col-sm-10">
                                <select id='listepaiements' name="listepaiements" class="select2 form-control">
                                    <option value="">Choisir une règle paiement</option>
                                    <?php foreach($listepaiements as $variable):?>
                                    <option <?=in_array($variable->id, $util_paiements)?'selected':''?> value="<?php echo $variable->id?>"><?php echo $variable->name?></option> 
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mt-50">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Annulation : </label>
                            <div class="col-lg-3 col-sm-10">
                                <select id='listeannulations' name="listeannulations" class="select2 form-control">
                                    <option value="">Choisir une règle annulation</option>
                                    <?php foreach($listeannulations as $variable):?>
                                    <option <?=in_array($variable->id, $util_annulations)?'selected':''?> value="<?php echo $variable->id?>"><?php echo $variable->name?></option> 
                                    <?php endforeach;?>
                                </select>
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
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/propresidence/index" class="btn btn-default">Retour </a>
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
<!-- Multiselect JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/multiselect/js/jquery.multi-select.js", array('block' => 'scriptBottom')); ?>
<!-- multiselect CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/multiselect/css/multi-select.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>

$('#pre-selected-options').multiSelect();

$(function () {


});

    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Les règles ont bien été sauvegardées',
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
                            heading: 'Les règles n\'ont pas été sauvegardées',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 7000
                        });
    <?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>
 