<style>
.dropdown-menu {
    z-index: 99999;
}
</style>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Ajouter période station</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
                  echo $this->Form->create(null,['url'=>'/manager/gestionnaires/addperiodestation','id'=>'frm_periode','class'=> 'form-horizontal']);
                  echo $this->Form->input("station",[
                     'label'=>'Station',
                     'templates' => ['inputContainer' => "<div class='form-group'> {{content}}</div>" , 'label' => "<label class='control-label mb-10 col-sm-3 col-lg-3 text-left font-16'>{{text}} <sup class='text-danger'>*</sup></label>", 'select' => '<div class="col-lg-3 col-sm-9"><select type="{{type}}" name="{{name}}" {{attrs}} >{{content}}</select></div>'],
                     'type'=>'select','options'=>$l_lieugeos,'class'=>'form-control validate[required]']);
                  echo $this->Form->input('ouverture',['autocomplete'=>"off",'id'=>'ouverture','label'=>'Date d\'ouverture','templates' => ['inputContainer' => "<div class='form-group'> {{content}}</div>" , 'label' => "<label class='control-label mb-10 col-sm-3 col-lg-3 text-left font-16'>{{text}} <sup class='text-danger'>*</sup></label>", 'input' => '<div class="col-lg-3 col-sm-9"><input type="{{type}}" name="{{name}}" {{attrs}} /></div>'],'class'=>'form-control date validate[required]']);
                  echo $this->Form->input('fermeture',['autocomplete'=>"off",'id'=>'fermeture','label'=>'Date de fermeture','templates' => ['inputContainer' => "<div class='form-group'> {{content}}</div>" , 'label' => "<label class='control-label mb-10 col-sm-3 col-lg-3 text-left font-16'>{{text}} <sup class='text-danger'>*</sup></label>", 'input' => '<div class="col-lg-3 col-sm-9"><input type="{{type}}" name="{{name}}" {{attrs}} /></div>'],'class'=>'form-control date validate[required]']);
				 ?>
                                 <div class="form-group mb-0">
                                     <div class="row">
                                         <div class="col-sm-12 ml-10">
                                             <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                         </div>
                                     </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/stations/" class="btn btn-default">Retour </a>
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
<?php //$this->Html->script("/manager-arr/vendors/bower_components/moment/locale/fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$('.date').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down",
                        //locale: 'fr'
                    },
                    });
                    
$("#ouverture").on('dp.change', function(e){
$('#fermeture').data("DateTimePicker").destroy();

    $('#fermeture').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        minDate: e.date.format("YYYY/MM/DD"),
                        viewDate: e.date.format("YYYY/MM/DD"),
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down",
                        //locale: 'fr'
                    },
                    });
    });
    
    $("#frm_periode").validate({
	rules: {
		station: {
                    required: true,
                    min: 1
		},
                ouverture: {
                    required: true,
                    date: false,
                },
                fermeture: {
                    required: true,
                    date: false,
                }       
	},
        lang: 'fr',
        messages: {
            station: "Choisir une station",
        }
    });
    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Une nouvelle période a été crée',
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