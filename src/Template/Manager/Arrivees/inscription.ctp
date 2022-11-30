<?php
$mdp_en_clair = "";
$possible = "0123456789bcdfghjkmnpqrstvwxyz";
$i = 0;
while ($i < 8) {
    $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
    if (!strstr($mdp_en_clair, $char)) {
        $mdp_en_clair .= $char;
        $i++;
    }
}
$nouvMdp = $mdp_en_clair;
//echo $nouvMdp;
?>

<div class="row heading-bg icantSelectIt">
    <div class="col-sm-12">
      <h5 class="txt-dark">Inscription</h5>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
                        <form id="example-advanced-form" method="POST">
                            <input type="hidden" name="issubmit" value="1">
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Contact</span></h3>
                                <fieldset>
                                        <div class="row">
                                                        <div class="form-wrap">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Compte mail: <sup class='text-danger'>*</sup></label>
                                                                            <input type="text" placeholder="Email" autocomplete="off" class="form-control"  name="email" id="email"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label" for="firstName">Téléphone:</label>
                                                                            <input type="text"   name="tel" autocomplete="off" id="tel"  class="form-control tel"/>
                                                                            <span id="error-msg" class="hide">Numéro invalide</span>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label" for="firstName">Téléphone 2:</label>
                                                                            <input type="text"   name="mobile2" autocomplete="off" id="mobile2"  class="form-control tel"/>
                                                                            <span id="error-msg2" class="hide">Numéro invalide</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label" for="firstName">Portable: <sup class='text-danger'>*</sup></label>
                                                                            <input type="text"   name="mobile" autocomplete="off" id="mobile"  class="form-control tel"/>
                                                                            <span id="error-msg3" class="hide">Numéro invalide</span>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-12"></div>
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label" for="firstName">Portable 2:</label>
                                                                            <input type="text"   name="tel2" autocomplete="off" id="tel2"  class="form-control tel"/>
                                                                            <span id="error-msg4" class="hide">Numéro invalide</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-12">
                                                                            <label class="control-label">Fax:</label>
                                                                            <input type="text" autocomplete="off" class="form-control"  name="fax" id="fax"/>
                                                                            <label id="msg_fax" class="red"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                            </div>
                                        </div>
                                </fieldset>
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Information</span></h3>
                                <fieldset>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="genre">Genre:</label>
                                                    <select name="genre" id="genre" class="form-control">
                                                        <option value="-1">-select-</option>
                                                        <?php foreach($a_genre as $k=>$v) :?>
                                                        <option value="<?php echo $k?>"><?php echo $v?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="nom">Nom: <sup class='text-danger'>*</sup></label>
                                                    <input type="text" name="nom" autocomplete="off" id="nom"  class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="prenom">Prenom:</label>
                                                    <input type="text"  autocomplete="off" name="prenom" id="prenom"  class="form-control"  />
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="adresse">Adresse principale: <sup class='text-danger'>*</sup></label>
                                                    <input type="text"  name="adresse" autocomplete="off" id="adresse"  class="form-control"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="adresse2">Adresse 2:</label>
                                                    <input type="text"  name="adresse2" autocomplete="off" id="adresse2"  class="form-control"  />
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">  
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="pays">Pays: <sup class='text-danger'>*</sup></label>
                                                    <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control','label'=>false,'options'=>$Pays,'default'=>'0']);?>
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="codepostal">Code postal:</label>
                                                    <input type="text"  name="codepostal" autocomplete="off" id="codepostal"  class="form-control"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row"> 
                                                <div class="col-md-4 col-xs-12" id="region_container">
                                                    <label class="control-label" for="region">Département: <sup class='text-danger'>*</sup></label>
                                                    <?php echo $this->Form->input('region',['type'=>'select','class'=>'form-control','label'=>false,'options'=>'']);?>
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="villeprop">Ville: <sup class='text-danger'>*</sup></label>
                                                    <?php echo $this->Form->input('villeprop',['type'=>'select','class'=>'form-control','label'=>false,'options'=>'']);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 pl-0">
                                            <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                        </div>
                                    </div>
                                </fieldset>
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Compte</span></h3>
                                <fieldset>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="firstName">Mot de passe provisoire (remplacement possible à votre 1ere connexion):</label>
                                                    <input type="password" placeholder="Mot de passe" class="form-control"   name="password" id="password"  />
										<input type="hidden"  class="form-control"   name="a_password" id="a_password"  />
										<input type="hidden"  class="form-control"   name="pwd" id="pwd"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="firstName">Confirmer mot de passe:</label>
                                                    <input type="password" placeholder="Confirmer mot de passe" class="form-control"  name="comfirm" id="cpassword"  />
                                                    <input type="hidden" id="creationCompteGestionnaireHidden" name="creationCompteGestionnaireHidden" />
                                                    <input type="hidden" id="mdpenclair" name="mdpenclair" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Annonce</span></h3>
                                <fieldset>
                                    <div class="row">  

                                        <!-- <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="firstName">Station:</label>
                                                    <select name="lieugeo_id" id="lieugeo_id" class="form-control">
                                                        <option value="0">-select-</option>
                                                        <?php //foreach($lieu_geo as $l) :?>
                                                        <option value="<?php //echo $l->id?>"><?php //echo $l->name?></option>
                                                        <?php //endforeach;?>
                                                    </select>
                                                </div>                                                
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="firstName">Village:</label>
                                                    <select name="village" id="village" class="form-control">
                                                        <option value="0">-select-</option>
                                                        <?php foreach($a_village as $v) :?>
                                                        <option value="<?php echo $v->id?>"><?php echo $v->name?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="firstName">Résidence:</label>
                                                    <select name="residence" id="residance" class="form-control">
                                                        <option value="0">-select-</option>
                                                        <?php foreach($a_residence as $v) :?>
                                                        <option value="<?php echo $v->id?>"><?php echo html_entity_decode($v->name)?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="firstName">N° App:</label>
                                                    <input type="text" class="form-control" autocomplete="off"  name="numapp" id="numapp" />
                                                    <input type="hidden" class="form-control" autocomplete="off"  name="id" id="mailexist" />
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="firstName">Surface:</label>
                                                    <input type="text" class="form-control" name="surafce" id="surafce" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="firstName">Publié sur le site:</label>
                                                    <div class="radio-list">
                                                            <div class="radio-inline pl-0">
                                                                    <span class="radio radio-primary">
                                                                    <input type="radio" value="0" CHECKED id="ReservationTaxe0" name="publication">
                                                            <label for="ReservationTaxe0">Non</label>
                                                            </span>
                                                            </div>
                                                            <div class="radio-inline">
                                                                    <span class="radio radio-primary">
                                                                    <input type="radio" value="1" id="ReservationTaxe1" name="publication">
                                                            <label for="ReservationTaxe1">Oui</label>
                                                            </span>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-xs-12"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <label class="control-label" for="firstName">Annonce gérer par le gestionnaire:</label>
                                                    <div class="radio-list">
                                                            <div class="radio-inline pl-0">
                                                                    <span class="radio radio-primary">
                                                                    <input type="radio" value="0" CHECKED id="ReservationTaxe3" name="gestionnaire">
                                                            <label for="ReservationTaxe3">Non</label>
                                                            </span>
                                                            </div>
                                                            <div class="radio-inline">
                                                                    <span class="radio radio-primary">
                                                                    <input type="radio" value="1"  id="ReservationTaxe4" name="gestionnaire">
                                                            <label for="ReservationTaxe4">Oui</label>
                                                            </span>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="mustache/x-tmpl" id="creationCompteGestionnaire">
 <?php echo $textmail["creationCompteGestionnaire"] ?>
 </script>

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Form Wizard JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery.steps/build/jquery.steps.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/mustache.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<!-- jquery-steps css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery.steps/demo/css/jquery.steps.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$(document).ready(function(){
    
    $("#codepostal").on('input',function(e){
        if($( "#pays" ).val() == 67 && ($( "#codepostal" ).val().length == 4 || $( "#codepostal" ).val().length == 5)){
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
                data: {code: $("#codepostal").val()},
                success:function(xml){                
                    data = xml.listepville;
                    if(data.length > 0){
                        $('#villeprop').empty();
                        for (var i = 0; i < data.length; i++) {
                            console.log(data[i].departement_id);
                            $('#villeprop').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                            $('#region').val(data[i].departement_id);
                        }
                    }
                    
                }
            });
        }
        if($( "#pays" ).val() == 67 && $( "#codepostal" ).val().length > 5){
            $("#codepostal").val($("#codepostal").val().substr(0, 5));
        }
    });

    $("#codepostalann").on('input',function(e){
        if($( "#paysann" ).val() == 67 && ($( "#codepostalann" ).val().length == 4 || $( "#codepostalann" ).val().length == 5)){
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
                data: {code: $("#codepostalann").val()},
                success:function(xml){                
                    data = xml.listepville;
                    $('#villeann').empty();
                    for (var i = 0; i < data.length; i++) {
                        console.log(data[i].departement_id);
                        $('#villeann').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                        $('#regionann').val(data[i].departement_id);
                    }
                }
            });
        }
        if($( "#paysann" ).val() == 67 && $( "#codepostalann" ).val().length > 5){
            $("#codepostalann").val($("#codepostalann").val().substr(0, 5));
        }
    });

    $("#codepostalann").on('input',function(e){
        if($( "#paysann" ).val() == 67 && ($( "#codepostalann" ).val().length == 4 || $( "#codepostalann" ).val().length == 5)){
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
                data: {code: $("#codepostalann").val()},
                success:function(xml){                
                    data = xml.listepville;
                    $('#villeann').empty();
                    for (var i = 0; i < data.length; i++) {
                        console.log(data[i].departement_id);
                        $('#villeann').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                        $('#regionann').val(data[i].departement_id);
                    }
                }
            });
        }
        if($( "#paysann" ).val() == 67 && $( "#codepostalann" ).val().length > 5){
            $("#codepostalann").val($("#codepostalann").val().substr(0, 5));
        }
    });
    
    $('#village').change(function(){
        get_residence($(this).val());
    });
    
    $("#pays").change(function() {
        if($( "#pays" ).val() != 67){
            $('#region_container').hide();
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypaysvilles/",
                data: {paysid: $(this).val()},
                success:function(xml){
                    data = xml.listepville;
                    var valuesvil = [];
                    $('#villeprop').empty();
                    for (var i = 0; i < data.length; i++) {
                      $('#villeprop').append('<option value='+data[i].id+'>'+data[i].name+'</option>');
                    }
                }
            });
        }else{
            $('#region_container').show();
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
                success:function(xml){
                  data = xml.listefrregions;
                  $('#region').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#region').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                  }
                }
            });
            
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
                data: {departementid: $('#region').val()},
                success:function(xml){
                  data = xml.listepville;
                  $('#villeprop').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#villeprop').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                  }
                }
            });
        }
    });

    $("#paysann").change(function() {
        if($( "#paysann" ).val() != 67){
            $('#region_containerann').hide();
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypaysvilles/",
                data: {paysid: $(this).val()},
                success:function(xml){
                    data = xml.listepville;
                    var valuesvil = [];
                    $('#villeann').empty();
                    for (var i = 0; i < data.length; i++) {
                      $('#villeann').append('<option value='+data[i].id+'>'+data[i].name+'</option>');
                    }
                }
            });
        }else{
            $('#region_containerann').show();
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
                success:function(xml){
                  data = xml.listefrregions;
                  $('#regionann').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#regionann').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                  }
                }
            });
            
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
                data: {departementid: $('#regionann').val()},
                success:function(xml){
                  data = xml.listepville;
                  $('#villeann').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#villeann').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                  }
                }
            });
        }
    });
    
    $("#region").change(function() {
        $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
                data: {departementid: $("#region").val()},
                success:function(xml){
                  data = xml.listepville;
                  $('#villeprop').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#villeprop').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                  }
                }
            });
    });

    $("#regionann").change(function() {
        $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
                data: {departementid: $("#regionann").val()},
                success:function(xml){
                  data = xml.listepville;
                  $('#villeann').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#villeann').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                  }
                }
            });
    });
});
              
//additional methods to validation              
jQuery.validator.addMethod("telInputisNumber", function(value, element, param) {
        return telInput.intlTelInput("isValidNumber")||telInput.val()=="";
      }, "Numéro invalide");
jQuery.validator.addMethod("telInput2isNumber", function(value, element, param) {
        return telInput2.intlTelInput("isValidNumber")||telInput2.val()=="";
      }, "Numéro invalide");
jQuery.validator.addMethod("telInput3isNumber", function(value, element, param) {
        return telInput3.intlTelInput("isValidNumber")||telInput3.val()=="";
      }, "Numéro invalide");
jQuery.validator.addMethod("telInput4isNumber", function(value, element, param) {
        return telInput4.intlTelInput("isValidNumber")||telInput4.val()=="";
      }, "Numéro invalide");
      var b=false;
jQuery.validator.addMethod("notvide", function(value, element, param) {
        return value!="";
      }, "Sélectionner un genre");
jQuery.validator.addMethod("notvideForStep4", function(value, element, param) {
    if($('#ReservationTaxe0').is(':checked'))
        return true;
        return value!="";
      }, "Ce champ est Obligatoire");
jQuery.validator.addMethod("notvideSelectForStep4", function(value, element, param) {
    if($('#ReservationTaxe0').is(':checked'))
        return true;
        return value != 0;
      }, "Ce champ est Obligatoire");
jQuery.validator.addMethod("uniqueEmail",
                    function(value, element) {
                    b=false;
                        $.ajax({
                            async : false,
                            type: "get",
                            url: "<?php echo $this->Url->build('/',true)?>/manager/utilisateurs/checkEmailUnique/null/"+value,

                            success:function(xml){
                              if (xml=='true'){b=true; }
                              }
                            });
                        return b;
                    },
                        "Email existe déjà."
                    );
    var c=false;
jQuery.validator.addMethod("uniquePhone",
                    function(value, element) {
                    c=false;
                        $.ajax({
                            async : false,
                            type: "get",
                            url: "<?php echo $this->Url->build('/',true)?>/manager/utilisateurs/checkPhoneUnique/null/"+value,

                            success:function(xml){
                              if (xml=='true'){c=true; }
                              }
                            });
                        return c;
                    },
                        "Ce Numéro de téléphone existe déjà."
                    );
//end additional methods to validation 
if($('#example-advanced-form').length >0){
		var form_2 = $("#example-advanced-form");
		form_2.steps({
			headerTag: "h3",
			bodyTag: "fieldset",
			transitionEffect: "fade",
			titleTemplate: '#title#',
			labels: {
				finish: "Terminer",
				next: "Suivant",
				previous: "Précédent",
			},
			onStepChanging: function (event, currentIndex, newIndex)
			{
				// Allways allow previous action even if the current form is not valid!
				if (currentIndex > newIndex)
				{
					return true;
				}
				// Needed in some cases if the user went back (clean up)
				if (currentIndex < newIndex)
				{
					// To remove error styles
					form_2.find(".body:eq(" + newIndex + ") label.error").remove();
					form_2.find(".body:eq(" + newIndex + ") .error").removeClass("error");
				}
				form_2.validate().settings.ignore = ":disabled,:hidden";
				return form_2.valid();
			},
			onFinishing: function (event, currentIndex)
			{
				form_2.validate().settings.ignore = ":disabled";
				return form_2.valid();
			},
			onFinished: function (event, currentIndex)
			{
                            //envoyer core de message email
                            var motPass;
                            if($('#password').val() == ''){
                              motPass = "<?php echo $nouvMdp ?>";
                            }else{
                              motPass = $('#password').val();
                            }
                            var data = {bureau: "<?php echo $gestInfo['G']['name'] ?>", login: $('#email').val(), password: motPass };
                            var tmpl = document.getElementById("creationCompteGestionnaire").innerHTML;
                            var html = Mustache.to_html(tmpl, data);
                            $("#mdpenclair").val(motPass);
                            $("#creationCompteGestionnaireHidden").val(html);
                            //submit form
                            document.getElementById("example-advanced-form").submit();
			}
		}).validate({
                        onkeyup: false,
			errorPlacement: function errorPlacement(error, element) {
                            if (element.attr("name") == "tel" ) {
                                error.insertAfter("#error-msg");
                              }
                            else if (element.attr("name") == "mobile" ) {
                                error.insertAfter("#error-msg3");
                              }
                            else if (element.attr("name") == "mobile2" ) {
                                error.insertAfter("#error-msg2");
                              }
                            else if (element.attr("name") == "tel2" ) {
                                error.insertAfter("#error-msg4");
                              }
                            else {
                                error.insertAfter(element);
                              }
                            
                        },
			rules: {
				email: {
                                    email: true,
                                    required: true,
                                    uniqueEmail:true
				},
                                tel:{
                                    telInputisNumber:true,
                                },
                                mobile:{
                                    required: true,
                                    telInput3isNumber:true,
                                    uniquePhone:true,
                                },
                                mobile2:{
                                    telInput2isNumber:true
                                },
                                tel2:{
                                    telInput4isNumber:true
                                },
                                genre:{
                                    notvide:true,
                                },
                                nom:{
                                    required: true,
                                },
                                adresse:{
                                    required: true,
                                },
                                pays:{
                                    required: true,
                                    min:1
                                },
                                villeprop:{
                                    required: true,
                                    min:1
                                },
                                comfirm:{
                                    equalTo: "#password",
                                },
                                password:{
                                    minlength: 3,
                                },
                                numapp:{
                                    notvideForStep4: true,
                                },
                                surafce:{
                                    notvideForStep4: true,
                                },
                                // ville:{
                                //     notvideSelectForStep4: true,
                                // },
                                // lieugeo_id:{
                                //     notvideSelectForStep4: true,
                                // },
                                village:{
                                    notvideSelectForStep4: true,
                                },
                                residence:{
                                    notvideSelectForStep4: true,
                                }
                                
			},
                        lang: 'fr',
                        messages: {
                            genre:"Sélectionner un genre",
                            pays:"Choisir un pays",
                            villeprop:"Choisir une ville",
                            comfirm:{
                                equalTo:"Les mots de passe ne correspondent pas.",
                            },
                            password:{
                                minlength:"Mot de passe doit etre plus que 3 caractéres"
                            }
                        }
		});
	}
//intelInput
    var telInput = $("#tel"),
                  errorMsg = $("#error-msg"),
                  validMsg = $("#valid-msg");
                  telInput.intlTelInput({
                                utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                initialCountry: 'fr',
                                autoPlaceholder: true
                              });
                              var reset = function() {
                                telInput.removeClass("errorNumberTel");
                                errorMsg.addClass("hide");
                                validMsg.addClass("hide");
                              };
                              // on blur: validate
                telInput.blur(function() {
                  reset();
                  if ($.trim(telInput.val())) {
                    if (telInput.intlTelInput("isValidNumber")) {
                      validMsg.removeClass("hide");
                      validNum1 = telInput.intlTelInput("getNumber");
                      //alert(telInput.intlTelInput("getNumber"));
                    } else {
                      validNum1 = "non";
                      telInput.addClass("errorNumberTel");
                      errorMsg.removeClass("hide");
                      errorMsg.addClass("errorNumberTel");
                    }
                  }
                });

                // on keyup / change flag: reset
                telInput.on("keyup change", reset);

                var telInput2 = $("#mobile2"),
                    errorMsg2 = $("#error-msg2");
                    //validMsg = $("#valid-msg");
                    telInput2.intlTelInput({
                                  utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                  initialCountry: 'fr',
                                  autoPlaceholder: true
                                });
                                var reset = function() {
                                  telInput2.removeClass("errorNumberTel");
                                  errorMsg2.addClass("hide");
                                  //validMsg2.addClass("hide");
                                };
                                // on blur: validate
                  telInput2.blur(function() {
                    reset();
                    if ($.trim(telInput2.val())) {
                      if (telInput2.intlTelInput("isValidNumber")) {
                        //validMsg2.removeClass("hide");
                        validNum22 = telInput2.intlTelInput("getNumber");
                        //alert(telInput.intlTelInput("getNumber"));
                      } else {
                        validNum22 = "non";
                        telInput2.addClass("errorNumberTel");
                        errorMsg2.removeClass("hide");
                        errorMsg2.addClass("errorNumberTel");
                      }
                    }
                  });

                  // on keyup / change flag: reset
                  telInput2.on("keyup change", reset);

                  var telInput3 = $("#mobile"),
                      errorMsg3 = $("#error-msg3");
                      //validMsg = $("#valid-msg");
                      telInput3.intlTelInput({
                                    utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                    initialCountry: 'fr',
                                    autoPlaceholder: true
                                  });
                                  var reset = function() {
                                    telInput3.removeClass("errorNumberTel");
                                    errorMsg3.addClass("hide");
                                    //validMsg3.addClass("hide");
                                  };
                                  // on blur: validate
                    telInput3.blur(function() {
                      reset();
                      if ($.trim(telInput3.val())) {
                        if (telInput3.intlTelInput("isValidNumber")) {
                          //validMsg3.removeClass("hide");
                          validNum33 = telInput3.intlTelInput("getNumber");
                          //alert(telInput.intlTelInput("getNumber"));
                        } else {
                          validNum33 = "non";
                          telInput3.addClass("errorNumberTel");
                          errorMsg3.removeClass("hide");
                          errorMsg3.addClass("errorNumberTel");
                        }
                      }
                    });

                    // on keyup / change flag: reset
                    telInput3.on("keyup change", reset);

                    var telInput4 = $("#tel2"),
                        errorMsg4 = $("#error-msg4");
                        //validMsg = $("#valid-msg");
                        telInput4.intlTelInput({
                                      utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                      initialCountry: 'fr',
                                      autoPlaceholder: true
                                    });
                                    var reset = function() {
                                      telInput4.removeClass("errorNumberTel");
                                      errorMsg4.addClass("hide");
                                      //validMsg4.addClass("hide");
                                    };
                                    // on blur: validate
                      telInput4.blur(function() {
                        reset();
                        if ($.trim(telInput4.val())) {
                          if (telInput4.intlTelInput("isValidNumber")) {
                            //validMsg4.removeClass("hide");
                            validNum44 = telInput4.intlTelInput("getNumber");
                            //alert(telInput.intlTelInput("getNumber"));
                          } else {
                            validNum44 = "non";
                            telInput4.addClass("errorNumberTel");
                            errorMsg4.removeClass("hide");
                            errorMsg4.addClass("errorNumberTel");
                          }
                        }
                      });
                      // on keyup / change flag: reset
                      telInput4.on("keyup change", reset);
//End intelInput

    function get_residence(id)
				{
				   //alert(id);
				   //$('#City').html('');
				   //$('#City').append('<label for="HotelCity">City</label>')
					if(id!='')
					{
						//loading('loading...');
						$('#ul_residance').html("");
						$('#ul_residance').attr("style","display: none; -moz-user-select: none;");
						i=0;
						$.ajax({
							type: "POST",
							url: "<?php echo $this->Url->build('/',true)?>annonces/getresidence/",
							dataType : 'json',
							data: {id_vil : id},
							success:function(xml){
//								 $('#City').append("<select id='HotelCity' name='data[Hotel][city]' style='display: none;'><option value='0'></option></select>");
//								 $('#dv_residence .selectBox-label').html('&nbsp;');
//								 $('#ul_residance').append('<li><a rel="0"></a></li>');
//								 $('#residance option').remove();
                                                                $('#residance').empty();
                                                                xml['listeresidences'].forEach(element => {
                                                                    $('#residance').append( new Option(element['name'], element['id']) );
                                                                });
							}
						});
					}
				}
  
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Un nouveau propriétaire a été créé',
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
