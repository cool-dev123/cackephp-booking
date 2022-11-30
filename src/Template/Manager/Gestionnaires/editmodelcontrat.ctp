<!-- select2 JS -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>
<!-- select2 CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>
<style>
.afficheroption {
    padding: 2px 6px;
}
.detailvarcontrat {
    cursor: pointer;
}
.prixcontratclass {
    color: gray;
    cursor: not-allowed;
}
.search-input.form-control, .search-btn {
    height: 35px;
}
</style>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Modifier modele contrat</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
                  echo $this->Form->create($modelcontrat,['url'=>'/manager/gestionnaires/editmodelcontrat/'.$modelcontrat->id,'id'=>'frm_periode','class'=> 'form-horizontal']);
                  echo $this->Form->input('id');
                  ?>
                <div class="form-group row">
                    <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Type: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-4 col-sm-10">
                        <?php echo $this->Form->input('type',['type'=>'text','id'=>'type','label'=>false,'class'=>'form-control','readonly']);  ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Variables Dynamiques: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-10 col-sm-10">
                        <p class="mb-10 varyabledyncontrat">
                        <?php 
                        if(!empty($listvariablecontrat)){
                            foreach ($listvariablecontrat as $key => $value) {
                                if($key != 1) echo "<a class='detailvarcontrat varidclass".$key."' onclick='modifvarcontrat(".$key.")' >{{".$value."}} </a>";
                                else echo "<a class='detailvarcontrat varidclass".$key." prixcontratclass'>{{".$value."}} </a>";
                            }
                        }
                            
                        ?>
                        </p>                        
                        <button type="button" class="btn btn-primary btn-anim mt-10" id="ajoutvariable"><i class="fa fa-plus"></i><span class="btn-text">Ajouter variable</span></button>
                    </div>
                </div>
                <div class="form-group">
                    <label id="txtmessage" class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Texte: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-10 col-sm-10">
                        <textarea class="form-control textarea_editor" type="" name="contrat" rows="15" cols="30" id="contrat"><?php echo $modelcontrat->contrat ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Options: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-10 col-sm-10">
                        <p class="mb-10 optioncontrat">
                        <?php 
                        if(!empty($listoptioncontrat)){
                            foreach ($listoptioncontrat as $key=>$name) {
                                if($key) echo '<span class="optionidclass'.$key.'">'.$name.' <button type="button" class="btn btn-warning afficheroption mr-10" onClick="detailoption('.$key.')"><i class="fa fa-eye"></i></button></span>';
                            }
                        }                            
                        ?>
                        </p>                        
                        <button type="button" class="btn btn-primary btn-anim mt-10" id="ajoutoption"><i class="fa fa-plus"></i><span class="btn-text">Ajouter option</span></button>
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
                            <a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/modelcontrat" class="btn btn-default">Retour </a>
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
<!-- popup_ajout_variable -->
<div class="modal fade" id="popup_ajout_variable" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Ajout Nouvelle Variable</h4>
			</div>
			<div class="modal-body">               
                <form>                
                    <div class="form-group row">
                        <label for="nomvariable" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-10">
                        <?php 
                        echo $this->Form->input("nomvariable",[
                                'label'=>false,
                                'templates' => ['inputContainer' => "{{content}}"],
                                'type'=>'text','class'=>'form-control']);

                        echo $this->Form->input("typevariable",[
                            'label'=>false,
                            'templates' => ['inputContainer' => "{{content}}"],
                            'type'=>'hidden','value'=>'gest','class'=>'form-control']);
                            ?> 
                            <span class="text-danger nomerreur">
                                Ce champ est obligatoire
                            </span>
                            <!-- <p>
                                Evitez les espaces et les caractères spéciaux
                            </p> -->
                        </div>                        
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="enregisterVariable">Enregistrer</button>
			</div>
		</div>
	</div>
</div>
<!-- END popup_ajout_variable -->
<!-- popup_modif_variable -->
<div class="modal fade" id="popup_modif_variable" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modifier Variable</h4>
			</div>
			<div class="modal-body">               
                <form>       
                    <div class="form-group row">
                        <label for="nomvariable" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-10">
                        <?php 
                        echo $this->Form->input("nomvariablemodif",[
                                'label'=>false,
                                'templates' => ['inputContainer' => "{{content}}"],
                                'type'=>'text','class'=>'form-control']);

                        echo $this->Form->input("typevariablemodif",[
                            'label'=>false,
                            'templates' => ['inputContainer' => "{{content}}"],
                            'type'=>'hidden','value'=>'gest','class'=>'form-control']);

                        echo $this->Form->input("idvariablemodif",[
                            'label'=>false,
                            'templates' => ['inputContainer' => "{{content}}"],
                            'type'=>'hidden','class'=>'form-control']);
                            ?> 
                            <span class="text-danger nommodiferreur">
                                Ce champ est obligatoire
                            </span>
                            <!-- <p>
                                Evitez les espaces et les caractères spéciaux
                            </p> -->
                        </div>                        
                    </div>
                </form>
			</div>
			<div class="modal-footer">
                <button class="btn btn-danger left" id="supprimerVariable">Supprimer</button>
				<button class="btn btn-success" id="modifierVariable">Enregistrer</button>
			</div>
		</div>
	</div>
</div>
<!-- END popup_modif_variable -->
<!-- popup_ajout_option -->
<div class="modal fade" id="popup_ajout_option" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Ajout Nouvelle Option</h4>
			</div>
			<div class="modal-body">               
                <form>                
                    <div class="form-group row">
                        <label for="titreoption" class="col-sm-2 col-form-label">Titre : </label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input("titreoption",[
                            'label'=>false,
                            'templates' => ['inputContainer' => "{{content}}"],
                            'type'=>'text','class'=>'form-control'])?> 
                            <span class="text-danger titrerreur">
                                Veuillez choisir le titre
                            </span>
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label for="typevariable" class="col-sm-2 col-form-label">Variables : </label>
                        <div class="col-sm-10">
                            <select id='pre-selected-options' name="variablesoptions[]" multiple='multiple'>
                                <?php foreach($listvariablecontrat as $key => $variable):?>
                                <option value="<?php echo $key?>"><?php echo $variable?></option> 
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="titreoption" class="col-sm-2 col-form-label">Text option : </label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input("textoption",[
                            'label'=>false,
                            'templates' => ['inputContainer' => "{{content}}"],
                            'type'=>'textarea','class'=>'form-control textarea_editor'])?> 
                            <span class="text-danger texterreur">
                                Veuillez saisir un contenu
                            </span>
                        </div>                        
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="enregisterOption">Enregistrer</button>
			</div>
		</div>
	</div>
</div>
<!-- END popup_ajout_option -->
<!-- popup_detail_option -->
<div class="modal fade" id="popup_detail_option" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Détail Option</h4>
			</div>
			<div class="modal-body">               
                <form>                
                    <div class="form-group row">
                        <label for="titreoption" class="col-sm-3 col-form-label">Titre : </label>
                        <div class="col-sm-9 titreoption">
                            
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label for="typevariable" class="col-sm-3 col-form-label">Variables : </label>
                        <div class="col-sm-9 listvariable">
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="textoption" class="col-sm-3 col-form-label">Text option : </label>
                        <div class="col-sm-9 textoption">
                            
                        </div>                        
                    </div>
                </form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<!-- END popup_detail_option -->

<!-- popup_modif_option -->
<div class="modal fade" id="popup_modif_option" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modifier Option</h4>
			</div>
			<div class="modal-body">               
                <form>   
                <input type="hidden" id="idmodifoption" value="">                      
                    <div class="form-group row">
                        <label for="titreoption" class="col-sm-2 col-form-label">Titre : </label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input("titreoptionmodif",[
                            'label'=>false,
                            'templates' => ['inputContainer' => "{{content}}"],
                            'type'=>'text','class'=>'form-control'])?> 
                            <span class="text-danger titrerreurmodif">
                                Veuillez choisir le titre
                            </span>
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label for="typevariable" class="col-sm-2 col-form-label">Variables : </label>
                        <div class="col-sm-10">
                            <select id='pre-selected-options-modif' name="variablesoptionsmodif[]" multiple='multiple'>
                                <?php foreach($listvariablecontrat as $key => $variable):?>
                                    <?php if($key != 3 && $key != 4){ ?>
                                    <option value="<?php echo $key?>"><?php echo $variable?></option> 
                                    <?php } ?>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="titreoption" class="col-sm-2 col-form-label">Text option : </label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input("textoptionmodif",[
                            'label'=>false,
                            'templates' => ['inputContainer' => "{{content}}"],
                            'type'=>'textarea','class'=>'form-control textarea_editor'])?> 
                            <span class="text-danger texterreurmodif">
                                Veuillez saisir un contenu
                            </span>
                        </div>                        
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" id="supprimerOption">Supprimer</button>
				<button class="btn btn-success" id="modifierOption">Enregistrer</button>
			</div>
		</div>
	</div>
</div>
<!-- END popup_modif_option -->
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>

<!-- Multiselect JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/multiselect/js/jquery.multi-select.js", array('block' => 'scriptBottom')); ?>

<!-- QuickSearch Javascript -->
<?php $this->Html->script("/manager-arr/js/jquery.quicksearch.js", array('block' => 'scriptBottom')); ?>

<!-- multiselect CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/multiselect/css/multi-select.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
jQuery(document).ready(function() {
    // $('#pre-selected-options').multiSelect();
    $('#pre-selected-options').multiSelect({
        selectableHeader: "<input type='text' id='searchmultiselect' class='search-input form-control mb-10' autocomplete='off' placeholder='Chercher variable'>",
        selectionHeader: "<button type='button' class='btn btn-primary search-btn mb-10' onclick='ajoutervariableoption()'>Ajouter</button>",
        afterInit: function(ms){
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString).on('keydown', function(e){
                if (e.which === 40){                    
                    that.$selectableUl.focus();
                    return false;
                }
            });

        },
        afterSelect: function(){
            this.qs1.cache();
        },
        afterDeselect: function(){
            this.qs1.cache();
        }
    });

    $('#pre-selected-options-modif').multiSelect({
        selectableHeader: "<input type='text' id='searchmultiselectmodif' class='search-input form-control mb-10' autocomplete='off' placeholder='Chercher variable'>",
        selectionHeader: "<button type='button' class='btn btn-primary search-btn mb-10' onclick='ajoutervariableoptionmodif()'>Ajouter</button>",
        afterInit: function(ms){
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString).on('keydown', function(e){
                if (e.which === 40){                    
                    that.$selectableUl.focus();
                    return false;
                }
            });

        },
        afterSelect: function(){
            this.qs1.cache();
        },
        afterDeselect: function(){
            this.qs1.cache();
        }
    });

    /* Fermer popup */
$("#popup_ajout_variable").on("hide.bs.modal", function () {
    $("#nomvariable").val(''); 
    $(".typediv").css("display", "none");
});

});

$("#ajoutvariable").click(function(){

    $(".typediv").css("display", "none");
    $(".nomerreur").css("display", "none");
    $(".typerreur").css("display", "none");
    
    $('#popup_ajout_variable').modal('show');    

});

$("#ajoutoption").click(function(){

    $(".titrerreur").css("display", "none");
    $(".texterreur").css("display", "none");

    $('#pre-selected-options').multiSelect('addOption', { value: "5", text: "prix_option" });
    $('#pre-selected-options').multiSelect('select', "5");            
    $('#pre-selected-options option[value="5"]').attr('disabled','disabled');
    $('#pre-selected-options').multiSelect('refresh');
    $('#popup_ajout_option').modal('show');    

});

function ajoutervariableoption()
{
    $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/ajoutervariabledynamique/",
        data: {nom: $('#searchmultiselect').val()},
        success:function(xml){ 
            $('#pre-selected-options').multiSelect('addOption', { value: xml.nouvelleID, text: xml.nouveauNOM });
            $('#pre-selected-options').multiSelect('select', String(xml.nouvelleID));  
        }
    });
}

function ajoutervariableoptionmodif()
{
    $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/ajoutervariabledynamique/",
        data: {nom: $('#searchmultiselectmodif').val()},
        success:function(xml){ 
            $('#pre-selected-options-modif').multiSelect('addOption', { value: xml.nouvelleID, text: xml.nouveauNOM });
            $('#pre-selected-options-modif').multiSelect('select', String(xml.nouvelleID));  
        }
    });
}

function detailoption($id){
    $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/detailoption/",
        data: {id: $id, contratid: $("#id").val()},
        success:function(xml){ 
            $(".titrerreurmodif").css("display", "none");
            $(".texterreurmodif").css("display", "none");
            $('#pre-selected-options-modif').empty();
            $('#pre-selected-options-modif').multiSelect('refresh');
            // $('#pre-selected-options-modif').multiSelect('deselect_all');
            // $('#pre-selected-options-modif').multiSelect('refresh');
            // $('#pre-selected-options-modif option[value="5"]').prop("disabled", false);            
            // $('#pre-selected-options-modif').multiSelect('refresh');

            $("#titreoptionmodif").val(xml.detailoption.titre);            
            $.each( xml.listabvardyncontrat, function( key, value ) {   
                $('#pre-selected-options-modif').multiSelect('addOption', { value: key, text: value });
            });
            $.each( xml.listevardynoption, function( key, value ) {   
                if(key != 2 && key != 3 && key != 4){
                    $('#pre-selected-options-modif').multiSelect('addOption', { value: key, text: value });
                    $('#pre-selected-options-modif').multiSelect('select', key);                    
                }                 
            });
            $('#pre-selected-options-modif').multiSelect('select', "5"); 
            // $('#pre-selected-options-modif option[value="5"]').attr('selected','selected');
            // $('#pre-selected-options-modif').multiSelect('refresh');
            $('#pre-selected-options-modif option[value="5"]').attr('disabled','disabled');            
            $('#pre-selected-options-modif').multiSelect('refresh');
            $("#textoptionmodif").text(xml.detailoption.text);
            $("#textoptionmodif").summernote('code',xml.detailoption.text);
            $("#idmodifoption").val($id);
            $('#popup_modif_option').modal('show');
            /**** Travail pour view en mode text ****/
            // $(".titreoption").html(xml.detailoption.titre);
            // var textvar = "";
            // $.each( xml.listevardynoption, function( key, value ) {
            //     textvar += "{{"+value+"}} ";
            // });
            // $(".listvariable").html(textvar);
            // $(".textoption").html(xml.detailoption.text);
            // $('#popup_detail_option').modal('show');  
        }
    });
    
}

function sansEspace()
{
    // interdiction d'utiliser le bouton espace
    // if (event.keyCode == 32) return false;
    // return true;
    var keycode = event.keyCode;

    var valid = 
        (keycode > 47 && keycode < 58)   || // number keys
        //keycode == 32 || keycode == 13   || // spacebar & return key(s) (if you want to allow carriage returns)
        (keycode > 64 && keycode < 91)   || // letter keys
        keycode == 8 || //supression key
        (keycode > 95 && keycode < 112); // numpad keys
        //(keycode > 185 && keycode < 193) || // ;=,-./` (in order)
        //(keycode > 218 && keycode < 223);   // [\]' (in order)

    return valid;
}
$("#enregisterVariable").click(function(){
    note = '';
    if($("#nomvariable").val() == ''){
        note = "non";
        $(".nomerreur").css("display", "block");
        $(".typerreur").css("display", "none");
    } 
    if($("#typevariable").val()=='0'){
        note = "non";
        $(".typerreur").css("display", "block");
        $(".nomerreur").css("display", "none");
    }
    if(note == ''){
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/addvariabledynamique/"+$("#id").val(),
            data: {nom: $("#nomvariable").val(), type: $("#typevariable").val()},
            success:function(xml){ 
                $("#nomvariable").val("");
                $(".typediv").css("display", "none");
                var textnouvelle = "<a class='detailvarcontrat varidclass"+xml.nouvelleID+"' onclick='modifvarcontrat("+xml.nouvelleID+")' >{{"+xml.nouvelle+"}} </a>";
                $(".varyabledyncontrat").append(textnouvelle);             
                $('#popup_ajout_variable').modal('hide');  
                $('#pre-selected-options').multiSelect('addOption', { value: xml.nouvelleID, text: xml.nouvelle});
                $('#pre-selected-options-modif').multiSelect('addOption', { value: xml.nouvelleID, text: xml.nouvelle});
            }
        });
    } 
    
});

$("#modifierVariable").click(function(){
    note = '';
    if($("#nomvariablemodif").val() == ''){
        note = "non";
        $(".nommodiferreur").css("display", "block");
    } 
    if(note == ''){
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/modifvariabledynamique/",
            data: {id: $("#idvariablemodif").val(), nom: $("#nomvariablemodif").val()},
            success:function(xml){ 
                $("#nomvariablemodif").val("");
                var textnouvelle = "{{"+xml.nouvelle+"}} ";
                $(".varidclass"+$("#idvariablemodif").val()).html(textnouvelle);             
                $('#popup_modif_variable').modal('hide');  
                //Modifier dans multiselect de l'option IMPORTANT
                $("#pre-selected-options option[value=\""+$("#idvariablemodif").val()+"\"]").text(xml.nouvelle);
                $('#pre-selected-options').multiSelect('refresh');
                $("#pre-selected-options-modif option[value=\""+$("#idvariablemodif").val()+"\"]").text(xml.nouvelle);
                $('#pre-selected-options-modif').multiSelect('refresh');
            }
        });
    } 
    
});

$("#supprimerVariable").click(function(){
    $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/supprimvariabledynamique/",
        data: {idvar: $("#idvariablemodif").val(), id: $("#id").val()},
        success:function(xml){ 
            $(".varidclass"+$("#idvariablemodif").val()).html("");             
            $('#popup_modif_variable').modal('hide');  
            //Modifier dans multiselect de l'option IMPORTANT
            $("#pre-selected-options option[value=\""+$("#idvariablemodif").val()+"\"]").remove();
            $('#pre-selected-options').multiSelect('refresh');
        }
    });
    
});

$("#supprimerOption").click(function(){
    $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/supprimoptioncontrat/",
        data: {idoption: $("#idmodifoption").val(), id: $("#id").val()},
        success:function(xml){ 
            $(".optionidclass"+$("#idmodifoption").val()).html("");             
            $('#popup_modif_option').modal('hide');  
        }
    });
    
});

$("#enregisterOption").click(function(){
    note = '';
    if($("#textoption").val() == ''){
        note = "non";
        $(".texterreur").css("display", "block");
    }else{
        $(".texterreur").css("display", "none");
    }
    if($("#titreoption").val() == ''){
        note = "non";
        $(".titrerreur").css("display", "block");
    }else{
        $(".titrerreur").css("display", "none");
    }
    if(note == ''){
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/addoptiontocontrat/"+$("#id").val(),
            data: {titre: $("#titreoption").val(), variables: $("#pre-selected-options").val(), text: $("#textoption").val()},
            success:function(xml){ 
                $("#titreoption").val('');  
                $('#pre-selected-options').multiSelect('deselect_all');
                $('#pre-selected-options option[value="5"]').attr('disabled',false);
                $('#pre-selected-options').multiSelect('refresh');
                $("#textoption").text('');  
                $("#textoption").summernote('code','');                
                var textnouvelleoption = '<span class="optionidclass'+xml.nouvelleid+'">'+xml.nouvellenom+' <button type="button" class="btn btn-warning afficheroption mr-10" onClick="detailoption('+xml.nouvelleid+')"><i class="fa fa-eye"></i></button></span>';
                $(".optioncontrat").append(textnouvelleoption);
                $('#popup_ajout_option').modal('hide');
                //setTimeout(function () { location.reload(true); }, 1000);    
            }
        }); 
    }
});

$("#modifierOption").click(function(){
    note = '';
    if($("#textoptionmodif").val() == ''){
        note = "non";
        $(".texterreurmodif").css("display", "block");
    }else{
        $(".texterreurmodif").css("display", "none");
    }
    if($("#titreoptionmodif").val() == ''){
        note = "non";
        $(".titrerreurmodif").css("display", "block");
    }else{
        $(".titrerreurmodif").css("display", "none");
    }
    if(note == ''){
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/modifoptiontocontrat/"+$("#id").val(),
            data: {idmodifoption: $("#idmodifoption").val(), titre: $("#titreoptionmodif").val(), variables: $("#pre-selected-options-modif").val(), text: $("#textoptionmodif").val()},
            success:function(xml){ 
                $("#titreoptionmodif").val('');  
                $('#pre-selected-options-modif').multiSelect('deselect_all');
                $("#textoptionmodif").val('');                 
                $(".optionidclass"+$("#idmodifoption").val()).html('<span class="optionidclass'+$("#idmodifoption").val()+'">'+xml.nouvellenom+' <button type="button" class="btn btn-warning afficheroption mr-10" onClick="detailoption('+$("#idmodifoption").val()+')"><i class="fa fa-eye"></i></button></span>');                 
                // var textnouvelleoption = xml.nouvellenom+' <button type="button" class="btn btn-warning afficheroption mr-10" onClick="detailoption('+xml.nouvelleid+')"><i class="fa fa-eye"></i></button>';
                // $(".optioncontrat").append(textnouvellenom);
                $('#popup_modif_option').modal('hide');
                //setTimeout(function () { location.reload(true); }, 1000);    
            }
        }); 
    }
});

function modifvarcontrat(id){
    $(".nommodiferreur").css("display", "none");
    $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/detailvar/",
        data: {id: id},
        success:function(xml){ 
            $("#nomvariablemodif").val(xml.nommodif);
            $("#idvariablemodif").val(xml.idmodif);
            $('#popup_modif_variable').modal('show');
        }
    }); 
    
}

    
    $('.textarea_editor').summernote({
                                height: 300,
                                lang:"fr-FR",
                                fontNames: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
                                fontNamesIgnoreCheck: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                    ['font', ['strikethrough', 'superscript', 'subscript']],
                                    ['fontname',['fontname']],
                                    ['fontsize', ['fontsize']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['picture',['picture']],
                                    ['link',['linkDialogShow', 'unlink']],
                                    ['fullscreen',['fullscreen']],
                                    ['codeview',['codeview']],
                                    ['undo',['undo']],
                                    ['redo',['redo']],
                                            ]
                        });
      
      
      
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Votre Modèle a été modifié',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 7000
                        });
    <?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>
    
<?php $this->start('cssTop'); ?>
    <style>
        .note-group-select-from-files {
            display: none;
        }
        .modal-body{
            margin-left:10px !important;
            margin-right:10px !important;
        }
        .note-btn{
            padding:10px !important;
        }
        .note-editable b, .note-editable strong { font-weight: bold; }
        .note-editable i { font-style: italic; }
        .note-editable ul { list-style: circle !important; }
    </style>
<?php $this->end(); ?>