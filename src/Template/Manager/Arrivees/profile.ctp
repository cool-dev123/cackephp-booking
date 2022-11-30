<div class="row heading-bg icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Paramètres de profil</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                <div class="form-wrap col-sm-12 col-xs-12">
            <?php
                  echo $this->Form->create($gestionnaire,['id'=>'validation_demo','class'=> 'form-horizontal']);
                  echo $this->Form->input('id',['id'=>'id']);
            ?>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Rôle:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('role',['readonly'=>"readonly",'type'=>'text','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Nom:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('name',['type'=>'text','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Login:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('login',['type'=>'text','id'=>'login','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                            <div class="col-lg-6 col-sm-10"><span class="f_help icantSelectIt"> Nom d'utilisateur login ou registre. <br />Doit être compris entre 3 et pas plus de 20 caractères.</span></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Mot de passe:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('password',['type'=>'password','value'=>'','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Téléphone:</label>
                            <div class="col-lg-2 col-sm-10">
                                <?php echo $this->Form->input('telephone',['type'=>'text','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Courrier:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('email',['type'=>'text','id'=>'email','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Code postal:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('code_postal',['type'=>'text','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="control-label mb-10 mt-10 col-sm-2 text-left font-16 txt-black">Pays: <sup class='text-danger'>*</sup></label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->select('pays_id',$pays,['id'=>'pays','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 mt-10 col-sm-2 text-left font-16 txt-black">Département: <sup class='text-danger'>*</sup></label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->select('departements_id',$departements,['id'=>'departement','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Ville:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->select('ville',$ville,['id'=>'ville','label'=>false,'class'=>'form-control']);  ?>                     
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Adresse:</label>
                            <div class="col-lg-4 col-sm-10">
                                <?php echo $this->Form->input('adresse',['type'=>'text','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">N° Tva:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('num_tva',['type'=>'text','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Forme juridique:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('forme_juridique',['type'=>'text','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Capital social:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('capital_social',['type'=>'text','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Dénomination sociale:</label>
                            <div class="col-lg-3 col-sm-10">
                                <?php echo $this->Form->input('denominationsociale',['type'=>'text','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Enregistrer</span></button><br><br><br>
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
<?php if($InfoGes['G']['role']=='gestionnaire'):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading icantSelectIt">
                        <div class="pull-left">
                                <h6 class="panel-title txt-dark">Absence</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <?php
                                    echo $this->Form->create($gestionnaire,['id'=>'validation_absence','class'=> 'form-horizontal']);
                                    echo $this->Form->input('id',['id'=>'id2']);
                                    echo $this->Form->input('absence',['type'=>"hidden",'value'=>"absent"]);
                              ?>
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-2 text-left txt-black font-16">Absent de:</label>
                                <div class="col-lg-3 col-sm-10">
                                    <?php echo $this->Form->input('debut',['autocomplete'=>"off",'value'=>'','id'=>'date_debut','type'=>'text','label'=>false,'class'=>'form-control date']);  ?>                       
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-2 text-left txt-black font-16">Absent à:</label>
                                <div class="col-lg-3 col-sm-10">
                                    <?php echo $this->Form->input('fin',['autocomplete'=>"off",'value'=>'','id'=>'date_fin','type'=>'text','label'=>false,'class'=>'form-control date']);  ?>                       
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-2 text-left txt-black font-16">Gestionnaire</label>
                                <div class="col-lg-3 col-sm-10">
                                    <select name="gestionnaire_id" class="form-control" id="gestionnaire_id">
                                        <option value="">-select-</option>
                                        <?php foreach($a_gestionnaire as $v) :?>
                                        <option value="<?php echo $v->id?>"><?php echo $v->name?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Valider</span></button><br><br><br>
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
<?php endif;?>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Jasny-bootstrap CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
<?php if($gestionnaire->pays_id!=67): ?>
    $('#departement').empty().prop("disabled", true);
<?php endif; ?>
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
                    
$("#date_debut").on('dp.change', function(e){
$('#date_fin').data("DateTimePicker").destroy();

    $('#date_fin').datetimepicker({
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
    });
    var b=false;
    var c=false;
    $.validator.addMethod("uniqueEmail",
        function(value, element) {
            b=false;
            $.ajax({
                async : false,
                type: "get",
                url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/checkEmailUnique/"+document.getElementById('id').value+"/"+value,

                success:function(xml){
                  if (xml=='true'){b=true; }
                  }
                });
            return b;
        },
            "Email existe déjà."
        );
        $.validator.addMethod("uniqueLogin",
        function(value, element) {
            c=false;
            $.ajax({
                async : false,
                type: "get",
                url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/checkLoginUnique/"+document.getElementById('id').value+"/"+value,

                success:function(xml){
                  if (xml=='true'){c=true; }
                  }
                });
            return c;
        },
            "Login existe déjà."
        );
    $("#validation_demo").validate({
    onkeyup: false,
	rules: {
                name: {
                    required: true,
		},
                code_postal: {
                    required: true,
		},
                ville: {
                    required: true,
		},
                adresse: {
                    required: true,
		},
		login: {
                    required: true,
                    rangelength: [3, 20],
                    uniqueLogin: true,
		},
                password: {
                    required: false,
                    minlength: 3
                },
                'email': {
                    required: true,
                    email: true,
                    uniqueEmail:true,
                },
                denominationsociale:{
                        required: true,
                    } 
	},
        lang: 'fr',
    });
    $.validator.addMethod("notEmpty",
        function(value, element) {
            return value != ''
        },
            "Choisir un gestionnaire"
        );
    $("#validation_absence").validate({
	rules: {
                debut: {
                    required: true,
                    date: false,
		},
		fin: {
                    required: true,
                    date: false,
		},
                gestionnaire_id: {
                    required: false,
                    notEmpty: true
                }, 
	},
        lang: 'fr',
    });
    
    $("#pays").change(function() {  
  if($(this).val() == 67){
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
        success:function(xml){
          data = xml.listefrregions;
          $('#departement').empty().prop("disabled", false);
          for (var i = 0; i < data.length; i++) {
              $('#departement').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
    
   $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: 182},
        success:function(xml){
          data = xml.listepville;
          $('#ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
  }else{
    $('#departement').empty().prop("disabled", true);
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypaysvilles/",
        data: {paysid: $(this).val()},
        success:function(xml){
          data = xml.listepville;
          $('#ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
          }
        }
    });
  }
});

$("#departement").change(function() {  
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: $(this).val()},
        success:function(xml){
          data = xml.listepville;
          $('#ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
});
    
    <?php if(!empty($msg)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: "<?php echo $msg?>",
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 4000
                        });
    <?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>