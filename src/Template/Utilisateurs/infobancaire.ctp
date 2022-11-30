<?php $this->Html->css("/css/new/dataTables.bootstrap4.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/jquery.dataTables.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/new/dataTables.bootstrap4.min.js", array('block' => 'scriptBottom')); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="espace_locataire" class="container">
<div class="row justify-content-between mb-5">
      <div class="col espace-menu">
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
        <?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
        <h3 class="border-bottom-menu-espace float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
		<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations") ?></a></h3>
        <?php }else{ ?>
		<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
		<?php } ?>
        <h3 class="float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
      </div>
      <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
      <div class="col-auto align-self-end">
        <h3 class="text-blue"><?= __("Espace") ?> <?php if($this->Session->read('Auth.User.nature')=='CLT') echo "Locataire"; else echo "Propriétaire";?></h3>
      </div>
	  <?php }?>
	  <?php echo $this->Flash->render() ?>
	</div>

<div class="row">
    <div class="col-12">
        <div class="shadow border">
        <?php echo $this->Form->create($infobancaire,['id'=>'informationbancaire', 'class' => 'informationbancaire','novalidate'],['url' => ['controller' => 'Utilisateurs', 'action' => 'infobancaire']]);?>
        <div class="row">    
        <div class="col-md-6 border-md-right">
            <div class="p-4 border-xs-bottom">
                <h4 class="mb-4"><?= __("Mes coordonnées bancaires") ?></h4>
                <div class="form-group">
                    <label><?= __("IBAN") ?></label>
                    <input type="text" name="IBAN" class="form-control rounded-0" required="required" id="IBAN" value="<?php echo $infobancaire->IBAN; ?>">
                    <div class="invalid-feedback iban-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
                </div>
                <div class="form-group">
                    <label><?= __("BIC / SWIFT") ?></label>
                    <input type="text" name="BIC" class="form-control rounded-0" required="required" id="code-securite" value="<?php echo $infobancaire->BIC; ?>">
                    <div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
                </div>
                <div class="form-group">
                    <label><?= __("Titulaire du compte") ?></label>
                    <input type="text" name="titulaire_compte" class="form-control rounded-0" required="required" id="nom-banque" value="<?php echo $infobancaire->titulaire_compte; ?>">
                    <div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4">
                <h4 class="mb-4"><?= __("Adresse") ?></h4>
                <div class="form-group">
                <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control custom-select rounded-0','label'=>false,'options'=>$Pays, 'placeholder'=>__('Pays'), 'required', "value"=>$utilisateur->pays]);?>
                    <div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
                </div>
                <div class="form-group">
                <input type="text" name="adresse" class="form-control rounded-0" required="required" id="adresse" placeholder="<?= __('Adresse') ?>" value="<?php echo $utilisateur->adresse; ?>">
                    <div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="code_postal" class="form-control rounded-0" required="required" id="code_postal" placeholder="<?= __('Code postal') ?>" value="<?php echo $utilisateur->code_postal; ?>">
                    <div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
                </div>
                <div class="form-group" id="regiondiv">
                    <?php echo $this->Form->input('region',['type'=>'select','class'=>'form-control custom-select rounded-0','label'=>false,'options'=>'','placeholder'=>__("Département"), "required", "value"=>$utilisateur->region]);?>
                    <div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>                    
                </div>                
                <div class="form-group">
                    <?php echo $this->Form->input('ville',['type'=>'select','class'=>'form-control custom-select rounded-0','label'=>false,'options'=>'','placeholder'=>__("Ville"), "required", "value"=>$utilisateur->ville]);?>
                    <div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-blue rounded-0 text-white px-6 float-right mb-4"> <?= __('Enregistrer') ?> </button>
            </div>
            </div>
      </div>
    </div>
    </div>
<?php echo $this->Form->end();?>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="shadow border">
            <div class="p-4 border-xs-bottom">
                <h4 class="mb-4"><?= __("Historique virement") ?></h4>
                <div class="table-responsive">           
                    <table id="example" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo __('ID Réservation');?></th> 
                                <th width="20%"><?php echo __('Période');?></th>                                
                                <th><?php echo __('ID Annonce');?></th>                                
                                <th><?php echo __('Locataire');?></th>
                                <th><?php echo __('Montant (€)');?></th>
                                <th><?php echo __('Etat');?></th> 
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-eu-pre": function ( date ) {
        date = date.replace(" ", "");

        if ( ! date ) {
            return 0;
        }

        var year;
        var eu_date = date.split(/[\.\-\/]/);

        /*year (optional)*/
        if ( eu_date[2] ) {
            year = eu_date[2];
        }
        else {
            year = 0;
        }

        /*month*/
        var month = eu_date[1];
        if ( month.length == 1 ) {
            month = 0+month;
        }

        /*day*/
        var day = eu_date[0];
        if ( day.length == 1 ) {
            day = 0+day;
        }

        return (year + month + day) * 1;
    },

    "date-eu-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-eu-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );

$(document).ready(function () {	
    $("#IBAN").blur(function(){
        str = $(this).val();
        soustr1 = str.substr(0, 1);
        soustr2 = str.substr(1, 1);
        if($.isNumeric(soustr1) || $.isNumeric(soustr2)){
            $(".iban-feedback").html('<?php echo __("Code pays manquant"); ?>');
            $(this).addClass("is-invalid");
        }else{
            $(".iban-feedback").html('<?php echo __("Champs obligatoires"); ?>');
            $("#IBAN").removeClass("border-danger"); 
            $(this).removeClass("is-invalid"); 
        }
    });
    
    $('#example').DataTable({
        language: {
            "url": "<?php echo $datatable_file; ?>",
            // search: "_INPUT_",
            // searchPlaceholder: "Recherche"
        },
        'columns': [
            { 'data': 0 },
            { 'data': 1 ,'type': 'date-eu'},
            { 'data': 2 },
            { 'data': 3 },
            { 'data': 4 },
            { 'data': 5 }
        ],
        order: [1, 'desc'],
        "ajax": "<?php echo $this->Url->build('/',true)?>utilisateurs/listevirementprop",
    });
});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('informationbancaire');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          var list = form.querySelectorAll(':invalid');
            for (var item of list) {
                console.log(item);
                //item.setAttribute("style", "background-color: red;")
            }
          console.log("flase");
        }
        var str = $("#IBAN").val();
        var soustr1 = str.substr(0, 1);
        var soustr2 = str.substr(1, 1);
        if($.isNumeric(soustr1) || $.isNumeric(soustr2)){
            event.preventDefault();
            event.stopPropagation();
            $(".iban-feedback").html('<?php echo __("Code pays manquant"); ?>');
            $("#IBAN").addClass("border-danger");
            $("#IBAN").addClass("is-invalid");
            
        }else{
            $(".iban-feedback").html('<?php echo __("Champs obligatoires"); ?>');
            $("#IBAN").removeClass("border-danger"); 
            //$("#IBAN").removeClass("is-invalid"); 
        }
        
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

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
                      $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                      $('#region').val(data[i].departement_id);
                  }
                }
                
            }
        });
    }
    if($( "#pays" ).val() == 67 && $( "#code_postal" ).val().length > 5){
        $("#code_postal").val($("#code_postal").val().substr(0, 5));
    }
});

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
                $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
            }
        }
    });
});   

if($('#pays').val() == 67){
    $('#regiondiv').css('display','block');
    $("#region").attr("required", "");
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
            $('#region').val(<?php echo $utilisateur->region ?>);
        }
    });

    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: <?php echo ($utilisateur->region == '' ? 0 : $utilisateur->region) ?>},
        success:function(xml){
            data = xml.listepville;
            $('#ville').empty();
            for (var i = 0; i < data.length; i++) {
                $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
            }
            $('#ville').val(<?php if(is_numeric( $utilisateur->ville )==true) echo $utilisateur->ville; else echo '' ?>);
        }
    });
}else{
    $('#regiondiv').css('display','none');
    $("#region").removeAttr("required");
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypaysvilles/",
        data: {paysid: $('#pays').val()},
        success:function(xml){
            data = xml.listepville;
            $('#ville').empty();
            for (var i = 0; i < data.length; i++) {
                $('#ville').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
            }
            $('#ville').val(<?php if(is_numeric( $utilisateur->ville )==true) echo $utilisateur->ville; else echo '' ?>);
        }
    });
}

$( "#pays" ).change(function() {			  
    if($(this).val() == 67){
        $('#regiondiv').css('display','block');
        $("#region").attr("required", "");
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
        $('#regiondiv').css('display','none');
        $("#region").removeAttr("required");
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
<?php $this->Html->scriptEnd(); ?>
