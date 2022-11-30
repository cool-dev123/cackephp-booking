<style>
    .nonenregistrer {
        border-color: orange;
    }
    .labelnonenregistrer {
        color: #e8af48;
        font-size: small;
    }
</style>
<div class="form-wrap col-sm-12 col-xs-12">
    <form id="test_form" style="form-horizontal">
        <input type="hidden" class="full" id="id_user"  value="<?php echo $user->id  ?>">
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Type : <sup class='text-danger'>*</sup></label>
            <div class="col-sm-8">
                <select name="type" class="form-control" id="type">
                    <option <?php if('CLT'==$user->nature) echo "SELECTED"?> value="CLT">Locataire</option>
                    <option <?php if('CLT'!=$user->nature) echo "SELECTED"?> value="ANNO">Propriétaire</option>
                    <?php if($InfoGes['G']['role']=='admin'):?><option <?php if('PRES'==$user->nature) echo "SELECTED"?> value="PRES">Propriétaire Résidence</option><?php endif;?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16 prenomlabel">Prénom : <sup class='text-danger'>*</sup></label>
            <label class="control-label mb-10 col-sm-4 text-left font-16 libellelabel" style="display:none;">Libellé : <sup class='text-danger'>*</sup></label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('prenom',['value'=>$user->prenom,'type'=>'text','id'=>'prenom','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row nom">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Nom de famille : <sup class='text-danger'>*</sup></label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('nom_famille',['value'=>$user->nom_famille,'type'=>'text','id'=>'nom_famille','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row description">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Description : <sup class='text-danger'>*</sup></label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('description',[
                      'label'=>false,
                      'templates' => ['inputContainer' => "{{content}}"],
                      'type'=>'textarea',
                      'rows'=>'5','cols'=>'75',
                      'value'=>$user->description,'class'=>'form-control mt-3 rounded-0']);?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Téléphone:</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('telephone',['value'=>$user->telephone,'type'=>'text','id'=>'telephone','label'=>false,'class'=>'form-control']);  ?>
                <span id="error-msg-tel" class="hide">Numéro invalide</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Portable: <sup class='text-danger'>*</sup></label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('portable',['value'=>$user->portable,'type'=>'text','id'=>'portable','label'=>false,'class'=>'form-control']);  ?>
                <span id="error-msg" class="hide">Numéro invalide</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Email: <sup class='text-danger'>*</sup></label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('email',['value'=>$user->email,'type'=>'text','id'=>'email','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Mot de passe:</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('password',['type'=>'password','id'=>'password','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Adresse:</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('adresse',['value'=>$user->adresse,'type'=>'text','id'=>'adresse','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>        
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Pays : <sup class='text-danger'>*</sup></label>
            <div class="col-sm-7">
                <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control','label'=>false,'options'=>$Pays, 'value'=>$user['P']['id_pays']]);?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Code postal: </label>
            <div class="col-sm-5">
                <?php echo $this->Form->input('code_postal',['value'=>$user->code_postal,'type'=>'text','id'=>'code_postal','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row" id="regiondiv">
            <label class="control-label mb-10 col-sm-4 text-left font-16">Département : </label>
            <div class="col-sm-7">
               <?php echo $this->Form->input('region',['type'=>'select','class'=>'form-control','label'=>false,'empty'=>'Sélectionnez le département','options'=>'']);?>
            </div>
        </div>
        <div class="form-group row" >
            <label class="control-label mb-10 col-sm-4 text-left font-16">Ville : </label>
            <div class="col-sm-7">
                <?php echo $this->Form->input('ville',['type'=>'select','class'=>'form-control','label'=>false,'empty'=>'Sélectionnez la ville','options'=>'']);?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
            </div>
        </div>
        <div class="text-center">
            <a class="btn btn-success btn-anim mt-10"><i class="fa fa-save" id="recherche_res" onclick="valider()"></i><span class="btn-text">Modifier</span></a>
            <button type="button" class="btn btn-warning mt-10" data-dismiss="modal">Annuler</button>
        </div>    
    </form>
</div>

<script type="text/javascript">
function veriftypeprop()
{
    if($("#type").val() == "PRES"){
        $(".nom").css('display', 'none');
        $(".prenomlabel").css('display', 'none');
        $(".libellelabel").css('display', 'block');
        $(".description").css('display', 'block');
    }else{
        $(".nom").css('display', 'block'); 
        $(".libellelabel").css('display', 'none');
        $(".description").css('display', 'none');
        $(".prenomlabel").css('display', 'block');
    }
}
$(document).ready(function() {

    veriftypeprop();
    
    $( "#type" ).change(function() {  
        veriftypeprop();      
    });

  var telInputport = $("#portable"),
    errorMsgport = $("#error-msg");
    telInputport.intlTelInput({
                  utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                  initialCountry: 'fr',
                  autoPlaceholder: true
                });
                var reset = function() {
                  telInputport.removeClass("errorNumberTel");
                  errorMsgport.addClass("hide");
                };
  // on keyup / change flag: reset
  telInputport.on("keyup change", reset);

  var telInputtel = $("#telephone"),
    errorMsgtel = $("#error-msg-tel");
    telInputtel.intlTelInput({
                  utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                  initialCountry: 'fr',
                  autoPlaceholder: true
                });
                var reset = function() {
                  telInputtel.removeClass("errorNumberTel");
                  errorMsgtel.addClass("hide");
                };
  // on keyup / change flag: reset
  telInputtel.on("keyup change", reset);   
    $("#region").change(function() {  
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
                if(i==0) $('#ville').append('<option value=0>Choisir ville</option>');
                  $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
              }
            }
        });
    });   
    if($('#pays').val() == 67){
      $('#regiondiv').css('display','block');
      $.ajax({
          type: "POST",
          dataType : 'json',
          async: false,
          url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
          success:function(xml){
            data = xml.listefrregions;
            $('#region').empty();
            $('#region').append('<option value=0>Choisir département</option>');
            for (var i = 0; i < data.length; i++) {
                $('#region').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
            }
            $('#region').val(<?php echo $user->region ?>);
            if($('#region').val() == "" || $('#region').val() == null) $('#region').val(0);
          }
      });

     $.ajax({
          type: "POST",
          dataType : 'json',
          async: false,
          url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
          data: {departementid: <?php echo ($user->region == '' ? 0 : $user->region) ?>},
          success:function(xml){
            data = xml.listepville;
            $('#ville').empty();
            $('#ville').append('<option value=0>Choisir ville</option>');
            for (var i = 0; i < data.length; i++) {
                $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
            }
            
            $('#ville').val(<?php if(is_numeric( $user->ville )==true) echo $user->ville; else echo 0 ?>);
          }
      });

      $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
        data: {code: $("#code_postal").val()},
        success:function(xml){                
            data = xml.listepville;
            if(data.length > 0){
                if(($('#region').val() != data[0].departement_id) || $('#region').val() == 0 || $('#region').val() == null){
                    $('#ville').empty();
                    var oldregion = $('#region').val();
                    for (var i = 0; i < data.length; i++) {
                        if(i==0) $('#ville').append('<option value=0>Choisir ville</option>');
                        $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                        $('#region').val(data[i].departement_id);                        
                    }
                    if($('#region').val() == "" || $('#region').val() == null) $('#region').val(0);
                    
                    if($('#region').val() != 0 && $('#region').val() != oldregion){
                        $('#region').addClass('nonenregistrer');
                        $('#region').after('<div class="labelnonenregistrer">Cette information n\'est pas encore enregistrée');
                        // $('#ville').addClass('nonenregistrer');
                        // $('#ville').after('<div class="labelnonenregistrer">Cette information n\'est pas encore enregistrée');
                    }
                }
                
            }
            
        }
      });
    }else{
      $('#regiondiv').css('display','none');
      $.ajax({
          type: "POST",
          dataType : 'json',
          async: false,
          url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypaysvilles/",
          data: {paysid: $('#pays').val()},
          success:function(xml){
            data = xml.listepville;
            $('#ville').empty();
            $('#ville').append('<option value=0>Choisir ville</option>');
            for (var i = 0; i < data.length; i++) {
                $('#ville').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
            }
            $('#ville').val(<?php if(is_numeric( $user->ville )==true) echo $user->ville; else echo 0 ?>);
          }
      });
    }
    
    
    $( "#pays" ).change(function() {
        if($(this).val() == 67){
            $('#regiondiv').css('display','block');
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
                success:function(xml){
                  data = xml.listefrregions;
                  $('#region').empty();
                  $('#region').append('<option value=0>Choisir département</option>');
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
                data: {departementid: 182},
                success:function(xml){
                  data = xml.listepville;
                  $('#ville').empty();
                  for (var i = 0; i < data.length; i++) {
                    if(i==0) $('#ville').append('<option value=0>Choisir ville</option>');
                      $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                  }
                }
            });

            if($("#code_postal").val() != ""){
                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
                    data: {code: $("#code_postal").val()},
                    success:function(xml){                
                        data = xml.listepville;
                        if(data.length > 0){
                            if(($('#region').val() != data[0].departement_id) || $('#region').val() == 0 || $('#region').val() == null){
                                $('#ville').empty();
                                var oldregion = $('#region').val();
                                for (var i = 0; i < data.length; i++) {
                                    if(i==0) $('#ville').append('<option value=0>Choisir ville</option>');
                                    $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                                    $('#region').val(data[i].departement_id);                        
                                }
                                if($('#region').val() == "" || $('#region').val() == null) $('#region').val(0);
                                
                                // if($('#region').val() != 0 && $('#region').val() != oldregion){
                                //     $('#region').addClass('nonenregistrer');
                                //     $('#region').after('<div class="labelnonenregistrer">Cette information n\'est pas encore enregistrée');
                                //     // $('#ville').addClass('nonenregistrer');
                                //     // $('#ville').after('<div class="labelnonenregistrer">Cette information n\'est pas encore enregistrée');
                                // }
                            }
                            
                        }
                        
                    }
                });
            }
            
        }else{
          $('#regiondiv').css('display','none');
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
                    if(i==0) $('#ville').append('<option value=0>Choisir ville</option>');
                    $('#ville').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                }
              }
          });
        }
//        var monTableauJS = <?php //echo json_encode($paysNum) ?>;
//        $("#utiliTelephone").intlTelInput("setCountry", monTableauJS[$(this).val()]);
//        $("#utiliTelephone").val('');
//        validNum = "non";
//        $("#portablenum").intlTelInput("setCountry", monTableauJS[$(this).val()]);
//        $("#portablenum").val('');
//        validNum2 = "non";
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
                    if(data.length > 0){
                        $('#ville').empty();
                        for (var i = 0; i < data.length; i++) {
                            if(i==0) $('#ville').append('<option value=0>Choisir ville</option>');
                            $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                            $('#region').val(data[i].departement_id);
                        }
                        if($('#region').val() == "" || $('#region').val() == null) $('#region').val(0);
                    }
                    
                }
            });
        }
        if($( "#pays" ).val() == 67 && $( "#code_postal" ).val().length > 5){
            $("#code_postal").val($("#code_postal").val().substr(0, 5));
        }
    });

});
</script>
