<?php $this->start('cssTop') ?>
<style>
    textarea{width: 100%;}
</style>
<?php $this->end() ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-sm-12">
      <h5 class="txt-dark">Ajouter une période de vacances</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
                echo $this->Form->create($vacance,['url'=>'/manager/gestionnaires/editvacance/'.$vacance->id,'id'=>'frm_periode','class'=> 'form-horizontal']);
                echo $this->Form->input('id');
                ?>
                  <div class="form-group">
                        <label class="control-label mb-10 col-sm-3 text-left font-16 txt-black">Pays <sup class='text-danger'>*</sup></label>
                        <div class="col-lg-4 col-sm-4">
                            <select name="pays_id" class="form-control" id="pays_id">
                                <option value="0"></option>
                                <?php foreach($pays as $k):?>
                                    <option <?php if($vacance->pays_id==$k->id_pays) {$idpayszones = $k->id_pays; echo "SELECTED";}?> value="<?php echo $k->id_pays?>" data-image="<?php echo $this->Url->build('/',true)?>images/msdropdown/icons/blank.gif" data-imagecss="flag <?php echo strtolower($k->code_pays) ?>" data-title="<?php echo $k->fr ?>"><?php echo $k->fr?></option>
                                <?php endforeach;?>
                            </select>
                            <div id="error_pays"></div>
                        </div>
                  </div>
                    <div class="form-group">
                        <label class="control-label mb-10 col-sm-3 text-left font-16 txt-black">subdivision par </label>
                        <div class="col-lg-4 col-sm-4">
                            <select name="zonevac" class="form-control" id="zonevac">
                                <option value="0">------------</option>
                                <option <?php if($tabzonespays[$idpayszones]==10) echo "SELECTED"?> value="10">Canton</option>
                                <option <?php if($tabzonespays[$idpayszones]==70) echo "SELECTED"?> value="70">Comté</option>
                                <option <?php if($tabzonespays[$idpayszones]==90) echo "SELECTED"?> value="90">Conseil régional</option>
                                <option <?php if($tabzonespays[$idpayszones]==20) echo "SELECTED"?> value="20">District</option>
                                <option <?php if($tabzonespays[$idpayszones]==30) echo "SELECTED"?> value="30">Lander</option>
                                <option <?php if($tabzonespays[$idpayszones]==40) echo "SELECTED"?> value="40">Province</option>
                                <option <?php if($tabzonespays[$idpayszones]==50) echo "SELECTED"?> value="50">Région</option>
                                <option <?php if($tabzonespays[$idpayszones]==80) echo "SELECTED"?> value="80">Voblast</option>
                                <option <?php if($tabzonespays[$idpayszones]==60) echo "SELECTED"?> value="60">Zone</option>
                            </select>
                        </div>
                  </div>
                
                <div class="form-group"> 
                    <label class="control-label mb-10 col-sm-3 text-left font-16 txt-black">Zone</label>
                    <div class="col-lg-3 col-sm-9">
                        <input type="text" name="zonechampvac" id="zonechampvac" class="form-control" value="<?php echo $vacance->zone_champ_vac ?>">
                    </div>
                </div>
                
                <div class="form-group">
                        <label class="control-label mb-10 col-sm-3 text-left font-16 txt-black">Titre <sup class='text-danger'>*</sup></label>
                        <div class="col-lg-4 col-sm-4">
                            <select name="titre" class="form-control" id="titre">
                                <option value="0"></option>
                                <option <?php if($vacance->titre=="Vacances d'automne") echo "SELECTED"?> value="Vacances d'automne">Vacances d'automne</option>
                                <option <?php if($vacance->titre=="Vacances de carnaval") echo "SELECTED"?> value="Vacances de carnaval">Vacances de carnaval</option>
                                <option <?php if($vacance->titre=="Vacances d'hiver") echo "SELECTED"?> value="Vacances d'hiver">Vacances d'hiver</option>
                                <option <?php if($vacance->titre=="Vacances de printemps") echo "SELECTED"?> value="Vacances de printemps">Vacances de printemps</option>
                                <option <?php if($vacance->titre=="Vacances d'été") echo "SELECTED"?> value="Vacances d'été">Vacances d'été</option>
                                <option <?php if($vacance->titre=="Vacances de Noël") echo "SELECTED"?> value="Vacances de Noël">Vacances de Noël</option>
                                <option <?php if($vacance->titre=="Vacances de Pâques") echo "SELECTED"?> value="Vacances de Pâques">Vacances de Pâques</option>
                            </select>
                        </div>
                  </div>
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 text-left font-16 txt-black">Date début période <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-3 col-sm-9">
                        <?php echo $this->Form->input('dbt_vac',['type'=>'text','value'=>"$vacance->dbt_vac", 'id'=>'dbt_vac','label'=>false,'class'=>'form-control date']);  ?>                       
                    </div>
                </div>
                        
                <div class="form-group">
                    <label class="control-label mb-10 col-sm-3 text-left font-16 txt-black">Date début période <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-3 col-sm-9">
                        <?php echo $this->Form->input('fin_vac',['type'=>'text','value'=>"$vacance->fin_vac", 'id'=>'fin_vac','label'=>false,'class'=>'form-control date']);  ?>                       
                    </div>
                </div>
                        
                <div class="form-group">
                        <label class="control-label mb-10 col-sm-3 text-left font-16 txt-black">Type <sup class='text-danger'>*</sup></label>
                        <div class="col-lg-4 col-sm-4">
                            <select name="type" class="form-control" id="type">
                                <option value="0"></option>
                                <option <?php if($vacance->type==10) echo "SELECTED"?> value=10>Afrique</option>
                                <option <?php if($vacance->type==20) echo "SELECTED"?> value=20>Amérique</option>
                                <option <?php if($vacance->type==30) echo "SELECTED"?> value=30>Asie</option>
                                <option <?php if($vacance->type==40) echo "SELECTED"?> value=40>Europe</option>
                                <option <?php if($vacance->type==50) echo "SELECTED"?> value=50>France</option>
                                <option <?php if($vacance->type==60) echo "SELECTED"?> value=60>France zone A</option>
                                <option <?php if($vacance->type==70) echo "SELECTED"?> value=70>France zone B</option>
                                <option <?php if($vacance->type==80) echo "SELECTED"?> value=80>France zone C</option>
                                <option <?php if($vacance->type==90) echo "SELECTED"?> value=90>Océanie</option>
                            </select>
                        </div>
                  </div>
                  
                  <div class="form-group">
                      <label class="control-label mb-10 col-sm-3 text-left font-16 txt-black">Commentaire</label>
                      <div class="col-lg-4 col-sm-9">
                          <textarea type="" name="commentairevac" rows="5" id="commentairevac"><?php echo $vacance->commentaire_vac?></textarea>
                      </div>
                  </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-sm-2">
                                <a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/vacances/" class="btn btn-default">Retour </a>
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
<?php $this->Html->script("/js/msdropdown/jquery.dd.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$("#pays_id").msDropdown({roundedBorder:false,mainCSS: 'dd',});

$('#dbt_vac').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
<?php $date = date_create_from_format('j/m/Y', $vacance->dbt_vac); ?>                    
$('#fin_vac').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        minDate: '<?=date_format($date, 'Y/m/d');?>',
                        viewDate: '<?=date_format($date, 'Y/m/d');?>',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
                    
$("#dbt_vac").on('dp.change', function(e){
    if($("#dbt_vac").val()!=""){
        $('#fin_vac').data("DateTimePicker").destroy();

        $('#fin_vac').datetimepicker({
            useCurrent: false,
            format: 'DD-MM-YYYY',
            minDate: e.date.format("YYYY/MM/DD"),
            viewDate: e.date.format("YYYY/MM/DD"),
            icons: {
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
            },
        });
    }
});
    
    
    jQuery.validator.addMethod("notEqual", function(value, element, param) {
        return this.optional(element) || value != param;
      }, "Choisir un Titre");
    $("#frm_periode").validate({
	rules: {
		pays_id: {
                    required: true,
                    min:1
		},
                titre:{
                    required: true,
                    notEqual: "0"
                },
                dbt_vac:{
                    required: true,
                    date: false,
                },
                fin_vac :{
                    required: true,
                    date: false,
                },
                type:{
                    required: true,
                    min:1
                },
                // zonevac:{
                //     notEqual: "0"
                // }
	},
        lang: 'fr',
        messages: {
            zonevac: "Choisir une Subdivision",
            titre: "Choisir un Titre",
            type: "Choisir un Type",
            pays_id: "Choisir un pays",
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "pays_id" )
                error.insertAfter("#error_pays");
            else
                error.insertAfter(element);
        }
    });
    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'La période de vacances est modifiée',
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
        
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/css/flags.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/msdropdown/dd.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/msdropdown/flags.css", array('block' => 'cssTop')); ?>