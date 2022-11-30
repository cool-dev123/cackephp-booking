<?php $this->start('cssTop'); ?>
    <style>
        .fileinput.input-group.fileinput-exists {
            overflow: hidden;
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h5 class="txt-dark">Séléctionnez votre Publicité</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
                  echo $this->Form->create(null,['type' => 'file','url'=>'/manager/annonces/addpub/','id'=>'frm_periode','class'=> 'form-horizontal']);
        ?>
                        <div class="form-group">
                            <label class="col-sm-3 text-left font-16 txt-black">Image : <sup class='text-danger'>*</sup></label>
                            <div class="col-sm-8">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                        <input type="hidden"><input type="file" name="image" id="image" accept="image/*">
                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a> 
                                </div>
                                <div id="errordiv"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 text-left font-16 txt-black">Ajouter lien: <sup class='text-danger'>*</sup></label>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('lien',['type'=>'text','id'=>'lien','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 text-left font-16 txt-black">Titre: <sup class='text-danger'>*</sup></label>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('titre',['type'=>'text','id'=>'titre','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 text-left font-16 txt-black">Situation géographique : <sup class='text-danger'>*</sup></label>
                            <div class="col-sm-5">
                                <select title="Rien sélectionné" id='pre-selected-options' name="lieugeo[]" class="selectpicker" multiple data-style="form-control btn-default btn-outline">
                                        <?php foreach($enrs as $lieu):?>
                                                <option value="<?php echo $lieu->id?>"><?php echo $lieu->name?></option> 
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
                                   <div class="col-lg-2 col-sm-2 col-md-2 mb-10">
                                       <a href="<?php echo $this->Url->build('/',true);?>manager/annonces/pub/" class="btn btn-default">Retour </a>
                                   </div>
                                   <div class="col-lg-offset-2 col-lg-2 col-sm-2 col-md-2">
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
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/additional-methods.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Jasny-bootstrap CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>
<!-- bootstrap-select CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$('.selectpicker').selectpicker();

$('.date').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
                    
$("#ouverture").on('dp.change', function(e){
$('#fermeture').data("DateTimePicker").destroy();

    $('#fermeture').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        minDate: e.date.format("YYYY/MM/DD"),
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
    });

    $("#frm_periode").validate({
	rules: {
                image: {
                    required: true,
                    extension: "png|jpeg|jpg|gif"
		},
		lien: {
                    required: true,
		},
                titre: {
                    required: true,
                },
                'lieugeo[]': {
                    required: true,
                    minlength: 1,
                }  
	},
        messages: {
            'image': 'Choisir un fichier de type image',
            'lieugeo[]': "Choisir une situation géographique"
        },
        lang: 'fr',
        errorPlacement: function(error, element) {
            if (element.attr("name") == "image" )
                error.appendTo('#errordiv');
            else
                error.insertAfter(element);
        }
    });
    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Vous avez crée votre publicité',
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
                            heading: "Anomalie au moment de l'enregistrement de votre publicité",
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 7000
                        });
    <?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>