<?php $this->start('cssTop'); ?>
<style>
    textarea{width: 100%;}
</style>
<?php $this->end(); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>

<div class="row heading-bg icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Modifier gestionnaire</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
            echo $this->Form->create($gestionnaire,["type"=>"file","url"=>"/manager/gestionnaires/edit/".$gestionnaire->id,'id'=>'frm_periode','class'=> 'form-horizontal']);
        ?>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label mb-10 col-sm-12 text-left txt-black font-16">Rôle : <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <select name="role" class="form-control" id="role">
                            <option <?php if($gestionnaire->role=="gestionnaire") echo "selected"; ?> value="gestionnaire">Gestionnaire</option>
                            <option <?php if($gestionnaire->role=="admin") echo "selected"; ?> value="admin">Admin</option>
                            <option <?php if($gestionnaire->role=="superAdmin") echo "selected"; ?> value="superAdmin">Super admin</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Type: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->select('type',['Personne'=>'Personne','Conciergerie'=>'Conciergerie'],['value'=>$gestionnaire->type,'type'=>'text','id'=>'type','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>
            
            <div class="form-group row toHide">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Raison Sociale: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('raison_sociale',['type'=>'text','id'=>'raison_sociale','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Descriptif Activité: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('descriptif_activité',['type'=>'text','id'=>'descriptif_activité','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>

            <div class="form-group row toHide">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Forme Juridique: </label>
                    <div class="col-lg-6 col-sm-10">
                        <?php echo $this->Form->input('forme_juridique',['type'=>'text','id'=>'forme_juridique','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Capital Social: </label>
                    <div class="input-group col-lg-6 col-sm-10 ml-15">
                        <?php echo $this->Form->input('capital_social',['inputContainer' =>"{{content}}",'type'=>'number','id'=>'capital_social','label'=>false,'class'=>'form-control']);  ?>
                        <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-group row toHide">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Adresse Site web: </label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('adresse_du_site',['type'=>'text','id'=>'adresse_du_site','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Code APE: </label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('code_APE',['type'=>'number','id'=>'code_APE','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>
                        
            <div class="form-group row toHide">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Commission relation TTC tva 20%:</label>
                    <div class="col-lg-8 col-sm-12">
                        <?php echo $this->Form->input('commission_relation',['type'=>'number','id'=>'commission_relation','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Siret: </label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('siret',['type'=>'number','id'=>'siret','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Genre:<sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12 pr-0 mr-0">
                        <?php echo $this->Form->select('genre',['M.'=>'Monsieur','Melle'=>'Mademoiselle','Mme'=>'Madame'],['id'=>'genre','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Nom: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('name',['type'=>'text','id'=>'name','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Prenom: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('prenom',['type'=>'text','id'=>'prenom','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Login: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('login',['type'=>'text','id'=>'login','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Courriel: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('email',['type'=>'text','id'=>'email','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>

            <div class="form-group row toHide">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Pays: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->select('pays_id',$pays,['id'=>'pays','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Code postal: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('code_postal',['type'=>'text','id'=>'code_postal','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>

            <div class="form-group row toHide">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Département: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->select('departements_id',$departements,['id'=>'departement','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">ville: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->select('ville',$ville,['id'=>'ville','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Villages: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <select multiple name="villages[]" id="village" class="select2 select2-multiple" >
                            <?php foreach($villages as $id => $v):?>
                            <option <?=in_array($id, $gest_villages)?'selected':''?> value="<?=$id?>"><?=$v?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php 
                    echo $this->Form->input("adresse",[
                        'label'=>'Adresse:',
                        'templates' => ['inputContainer' => "{{content}}" , 'label' => "<label class='control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black'>{{text}}</label>", 'textarea' => '<div class="col-sm-12"><textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >{{content}}</textarea ></div>'],
                        'type'=>'textarea','rows'=>'3']);
                    ?>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Portable: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-6 col-sm-10">
                        <?php echo $this->Form->input('mobile',['type'=>'text','id'=>'mobile','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6 toHide">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Téléphone:</label>
                    <div class="col-lg-6 col-sm-10">
                        <?php echo $this->Form->input('telephone',['type'=>'text','id'=>'telephone','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label mb-10 col-sm-12 text-left txt-black font-16">Dénomination sociale: <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('denominationsociale',['value'=>$gestionnaire->denominationsociale,'type'=>'text','id'=>'denominationsociale','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <!-- <div class="col-sm-6">
                    <label class="control-label mb-10 col-sm-12 text-left txt-black font-16">ID Google Calendar: <span class="tooltipsvc" data-html="true" data-toggle="tooltip" data-placement="right" title="<p>Suivre les étapes suivantes:<br>1/ Créez compte google avec l'adresse email de votre gestionniare.<br>2/ Connectez-vous sur www.calendar.google.com<br>3/ Créez un calendrier.<br>4/ Allez dans option du nouveau calendrier pour récupérer l'ID.</p>"><i class="fa fa-question-circle-o"></i></span><sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12">
                        <?php //echo $this->Form->input('googlecalendar_id',['value'=>$gestionnaire->googlecalendar_id,'type'=>'text','id'=>'googlecalendar_id','label'=>false,'class'=>'form-control', 'required']);  ?>
                    </div>
                </div> -->
            </div>
                        
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Mot de passe:</label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('password',['value'=>'','type'=>'password','id'=>'password','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Saisissez le à nouveau:</label>
                    <div class="col-sm-12">
                        <?php echo $this->Form->input('pass2',['value'=>'','type'=>'password','id'=>'pass2','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>
                        
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Commission maintenance TTC tva 20%: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-8 col-sm-12">
                        <?php echo $this->Form->input('commission_maint',['type'=>'number','id'=>'commission_maint','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Commission gestion de séjour TTC tva 20%: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-8 col-sm-12">
                        <?php echo $this->Form->input('commission_sejour',['type'=>'number','id'=>'commission_sejour','label'=>false,'class'=>'form-control']);  ?>
                    </div>
                </div>
            </div>
                        
        <?php echo $this->Form->input('commission_relation',['type'=>'hidden']); ?>
                        
            <div class="form-group mb-0">
                <div class="row mb-10">
                        <div class="col-sm-12 ml-10">
                            <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/" class="btn btn-default">Retour </a>
                            </div>
                            <div class="col-sm-offset-2 col-sm-3">
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
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>


<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>

<!-- bootstrap-select CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css", array('block' => 'cssTop')); ?>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    $('.selectpicker').selectpicker();
    $(".select2").select2();
    <?php if($gestionnaire->pays_id!=67): ?>
    $('#departement').empty().prop("disabled", true);
    <?php endif; ?>
changetype()
    function changetype(){
        if($("#type").val()=='Personne'){
            $('.toHide').hide();
        }
        else{
            $('.toHide').show();
        }
    }
    $("#type").change(function() {
        changetype()
    });

    var b=false;
    var a=false;
    var c=false;

        var mobileInputport = $("#mobile");
        mobileInputport.intlTelInput({
                    utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                    initialCountry: 'fr',
                    autoPlaceholder: true
                    });

        var telInputrestel = $("#telephone");
        telInputrestel.intlTelInput({
                    utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                    initialCountry: 'fr',
                    autoPlaceholder: true
                    });
        
        $.validator.addMethod("uniqueEmail",
        function(value, element) {
            b=false;
            $.ajax({
                async : false,
                type: "get",
                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/checkEmailUnique/<?=$gestionnaire->id?>/"+value,

                success:function(xml){
                  if (xml=='true'){b=true;}
                  }
                });
            return b;
        },
            "Email existe déjà."
        );
        
        $.validator.addMethod("uniqueLogin",
        function(value, element) {
            a=false;
            $.ajax({
                async : false,
                type: "get",
                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/checkLoginUnique/<?=$gestionnaire->id?>/"+value,

                success:function(xml){
                  if (xml=='true'){a=true; }
                  }
                });
            return a;
        },
            "Ce login est utilisé choisir un autre login."
        );

        $.validator.addMethod("validPhone",
        function(value, element) {
            if(value=='')
                return true;
            a=false;
            if (telInputrestel.intlTelInput("isValidNumber")) {
                      validNum = telInputrestel.intlTelInput("getNumber");
                      $("#telephone").val(validNum);
                      a=true
                    }
            return a;
        },
            "Invalid Format."
        );

        $.validator.addMethod("validMobile",
        function(value, element) {
            a=false;
            if (mobileInputport.intlTelInput("isValidNumber")) {
                      validNum = mobileInputport.intlTelInput("getNumber");
                      $("#mobile").val(validNum);
                      a=true
                    }
            return a;
        },
            "Invalid Format."
        );

        $.validator.addMethod("uniquePhone",
        function(value, element) {
            c=false;
            $.ajax({
                async : false,
                type: "get",
                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/checkPhoneUnique/<?=$gestionnaire->id?>/"+value,

                success:function(xml){
                  if (xml=='true'){c=true; }
                  }
                });
            return c;
        },
            "Ce Numéro de téléphone existe déjà."
        );

        $.validator.addMethod("uniqueMobile",
        function(value, element) {
            c=false;
            $.ajax({
                async : false,
                type: "get",
                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/checkMobileUnique/<?=$gestionnaire->id?>/"+value,

                success:function(xml){
                  if (xml=='true'){c=true; }
                  }
                });
            return c;
        },
            "Ce Numéro de portable existe déjà."
        );
    
        $("#frm_periode").validate({
        onkeyup: false,
        errorPlacement: function(error, element) {
            if (element.attr("name") == "telephone" || element.attr("name") == "mobile")
                error.insertAfter(element.parent());
            else
                error.insertAfter(element);
        },
        rules: {
                name: {
                    required: true,
                },
                descriptif_activité: {
                    required: true,
                },
                departements:{
                    required: true,
                },
                "villages[]" : "required",
                raison_sociale: {
                    required: true,
                },
                prenom: {
                    required: true,
                },
                login: {
                    required: true,
                    uniqueLogin: true,
                },
                email: {
                    required: true,
                    uniqueEmail: true,
                    email:true,
                },
                pass2:{
                    equalTo: "#password"
                },
                commission_maint:{
                    required: true,
                },
                commission_sejour:{
                    required: true,
                },
                code_postal:{
                    required:true
                },
                ville:{
                    required:true
                },
                telephone:{
                    validPhone:true,
                    uniquePhone:true
                },
                mobile:{
                    validMobile:true,
                    uniqueMobile:true
                },
                pays:{
                    required:true,
                    min: 1
                },
                denominationsociale:{
                    required: true,
                }
        },
        messages:{
            pays:'Ce champ est obligatoire.'
        },
        lang: 'fr',
    });

jQuery(document).ready(function() {
    $(".tooltipsvc").tooltip({
        html: true
    });

$("#code_postal").on('input',function(e){
    if($( "#pays" ).val() == 67 && ($( "#code_postal" ).val().length == 4 || $( "#code_postal" ).val().length == 5)){
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
            data: {code: $("#code_postal").val()},
            success:function(xml){                
                data = xml.listepville;
                $('#ville').empty();
                for (var i = 0; i < data.length; i++) {
                    $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                    $('#departement').val(data[i].departement_id);
                }
            }
        });
    }
    if($( "#pays" ).val() == 67 && $( "#code_postal" ).val().length > 5){
        $("#code_postal").val($("#code_postal").val().substr(0, 5));
    }
    });

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
    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'vous avez bien modifier le gestionnaire',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 7000
                        });
    <?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>