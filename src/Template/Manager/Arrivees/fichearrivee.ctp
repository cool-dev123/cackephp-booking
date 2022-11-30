<?php
 $dates_arr = explode(' ', $reservation->heure_arr);
 $time_arr = $dates_arr[1];
 $dates_dep = explode(' ', $reservation->heure_dep);
 $time_dep = $dates_dep[1];
 ?>
<div class="form-wrap col-sm-12 col-xs-12">
    <form id="test_form" style="form-horizontal">
        <input type="hidden" id="utilisateur_id" value="<?php echo $reservation->utilisateur_id ?>">
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left font-16 align-left">Nom de famille: <sup class='text-danger'>*</sup></label>
            <div class="col-lg-7 col-sm-10">
                <?php echo $this->Form->input('prenom',['value'=>$user->nom_famille,'type'=>'text','id'=>'nom_famille','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left font-16">Prenom:</label>
            <div class="col-lg-7 col-sm-10">
                <?php echo $this->Form->input('nom_famille',['value'=>$user->prenom,'type'=>'text','id'=>'prenom','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left font-16">Email: <sup class='text-danger'>*</sup></label>
            <div class="col-lg-7 col-sm-10">
                <?php echo $this->Form->input('email',['value'=>$user->email,'type'=>'text','id'=>'email','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left font-16">Liste numéros de portable: <sup class='text-danger'>*</sup></label>
            <input type="hidden" id="nbrrestel" name="nbrrestel" value="<?php echo $nbrrestel?>" />
            <input type="hidden" id="nbrrestelajout" name="nbrrestelajout" value="<?php echo $nbrrestel?>" />
            <div class="col-lg-7 col-sm-10">
                <div class="col-lg-12 pr-0 pl-0 col-sm-10" >
                    <?php echo $this->Form->input('portable',['value'=>$user->portable,'type'=>'text','id'=>'portable','label'=>false,'class'=>'form-control']);  ?>
                    <span id="error-msg" class="hide">Numéro invalide</span>
                </div>
                <?php $idtels = ''; $itel = 1; foreach ($restel as $key => $value) { ?>
                <div id='blocajouttel<?php echo $itel ?>' class="col-lg-12 pr-0 pl-0 mt-20 col-sm-12" >  
                    <div class="col-sm-12 pl-0 pr-0 pt-0 pb-0">
                        <div class="col-sm-10 pl-0 pr-0 pt-0 pb-0">
                            <?php echo $this->Form->input('telephoneNum'.$itel,['value'=>$value->num_tel,'type'=>'text','id'=>'num_tel'.$itel ,'label'=>false,'class'=>'form-control']);  ?>
                        </div>
                    <button type="button" onclick="deleteResTel(<?php echo $value->id?>, <?php echo $itel ?>)" class="pull-right btn btn-icon-anim btn-danger btn-square"><i class="fa fa-trash"></i></button>
                    </div>
                    <input type="hidden" id="hdidtel<?php echo $itel ?>" name="hdidtel<?php echo $itel ?>" value="<?php echo $value->id?>" />
                    <?php $idtels = $idtels.$value->id."/"; ?>
                    <span id="error-msg<?=$itel?>" class="hide">Numéro invalide</span>
                </div>
                <?php $itel = $itel+1;} ?>
                <input type="hidden" id="idtels" name="idtels" value="<?php echo $idtels?>"/>
                <div id="ajoutel">
                    <!--tels here-->
                </div>
                <div class="col-sm-12 pt-10 pl-0 pr-0">
                    <div id="boutonajouttel"><button type="button" class="btn btn-default" onclick="ajoutertel()">Ajouter Numéro</button></div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left font-16">Téléphone:</label>
            <div class="col-lg-7 col-sm-10">
                <?php echo $this->Form->input('telephone',['value'=>$user->telephone,'type'=>'text','id'=>'telephone','label'=>false,'class'=>'form-control']);  ?>
                <span id="error-msg-tel" class="hide">Numéro invalide</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left font-16">Date d'arrivée: <sup class='text-danger'>*</sup></label>
            <input type="hidden" id="hdid" value="<?php echo $reservation->id ?>">
            <div class="col-lg-7 col-sm-10">
                <?php echo $this->Form->input('dbt_at',['value'=>$reservation->dbt_at->i18nFormat('dd-MM-yyyy'),'type'=>'text','id'=>'dbt_at','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left font-16">Heure d'arrivée: <sup class='text-danger'>*</sup></label>
            <div class="col-lg-7 col-sm-10">
                <?php echo $this->Form->input('heure_arr',['value'=>$time_arr,'type'=>'text','id'=>'heure_arr','label'=>false,'class'=>'form-control time_pick']);  ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left">Date de départ:</label>
            <div class="col-lg-7 col-sm-10">
                <?php echo $this->Form->input('fin_at',['readonly'=>'readonly','value'=>$reservation->fin_at->i18nFormat('dd-MM-yyyy'),'type'=>'text','id'=>'fin_at','label'=>false,'class'=>'form-control']);  ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left">Heure depart: <sup class='text-danger'>*</sup></label>
            <div class="col-lg-7 col-sm-10">
                <?php echo $this->Form->input('heure_dep',['value'=>$time_dep,'type'=>'text','id'=>'heure_dep','label'=>false,'class'=>'form-control time_pick']);  ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left">Nombre d'adultes (à partir de 18 ans) <sup class='text-danger'>*</sup></label>
            <div class="col-lg-4 col-sm-4">
                <select name="nb_adult" class="form-control" id="nb_adult">
                    <?php for($i=1;$i<19;$i++):?>
                    <option <?php if($i==$reservation->nb_adultes) echo "SELECTED"?> value="<?php echo $i?>"><?php echo $i ?></option>
                    <?php endfor;?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left">Nombre d'enfants de 0 à 18 ans <sup class='text-danger'>*</sup></label>
            <div class="col-lg-4 col-sm-4">
                <select name="nb_child" class="form-control" id="nb_child">
                    <?php for($i=0;$i<17;$i++):?>
                    <option <?php if($i==$reservation->nb_enfants) echo "SELECTED"?> value="<?php echo $i?>"><?php echo $i ?></option>
                    <?php endfor;?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left">TAXE DE SÉJOUR GÉRÉE PAR ALPISSIME <sup class='text-danger'>*</sup></label>
            <div class="col-lg-4 col-sm-4">
                <div class="radio-list">
                        <div class="radio-inline pl-0">
                                <span class="radio radio-primary">
                                        <input type="radio" name="taxe" id="taxe_0" <?php if($reservation->taxe==0) echo "CHECKED"?>>
                        <label for="taxe_0">Non</label>
                        </span>
                        </div>
                        <div class="radio-inline">
                                <span class="radio radio-primary">
                                        <input type="radio" name="taxe" id="taxe_1" <?php if($reservation->taxe==1) echo "CHECKED"?>>
                        <label for="taxe_1">Oui</label>
                        </span>
                        </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left">Commentaire</label>
            <div class="col-lg-7 col-sm-6">
                <textarea  id="comment" class="form-control" rows="5"><?php echo $reservation->comment ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 mt-10 col-sm-5 text-left">Commentaire locataire</label>
            <div class="col-lg-7 col-sm-6">
                <textarea  id="commentlocataire" class="form-control" rows="5"><?php echo $reservation->commentlocataire ?></textarea>
            </div>
        </div>
        <div class="row mt-20 pl-0">
            <div class="col-sm-12">
                <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
            </div>
        </div>
        
    </form>
</div>



<script type="text/javascript">
    
var itel = <?php echo $itel; ?>;
function ajoutertel(){
    
    $('#ajoutel').append('<div id="blocajouttel'+itel+'" class="col-lg-12 pr-0 pl-0 mt-20 col-sm-10"><div class="col-sm-12 pl-0 pr-0 pt-0 pb-0"><div class="col-sm-10 pl-0 pr-0 pt-0 pb-0"><input class="form-control" type="text" name="telephoneNum" id="num_tel'+itel+'"></div><button type="button" onclick="deleteTelNou('+itel+')" class="pull-right btn btn-icon-anim btn-danger btn-square"><i class="fa fa-trash"></i></button></div><span id="error-msg'+itel+'" class="hide">Numéro invalide</span></div>');
    var telInput = $("#num_tel"+itel),
      errorMsg = $("#error-msg"+itel);
      telInput.intlTelInput({
                    utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                    initialCountry: 'fr',
                    autoPlaceholder: true
                  });
    var reset = function() {
      telInput.removeClass("errorNumberTel");
      errorMsg.addClass("hide");
    };

    // on keyup / change flag: reset
    telInput.on("keyup change", reset);
    itel = itel+1;
}

function deleteTelNou(numtel){
  document.getElementById("blocajouttel"+numtel).style.display = 'none';
}
    
function deleteResTel(id, numtel){
    swal({   
                title: "Suppression d\'un numéro",   
                text: "Vous voulez supprimer ce numéro ?",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#e6b034",   
                confirmButtonText: "OK",
                cancelButtonText: "ANNULER",  
                closeOnConfirm: true 
        }, function(){
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>reservations/supprimertel/",
                data: {idtel:id},
                success:function(xml){
                  document.getElementById("blocajouttel"+numtel).style.display = 'none';
                }
            });
        });

  }

$(document).ready(function() {
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
  
for (i = 1; i <= $("#nbrrestel").val(); i++) {
    var telInput = $("#num_tel"+i),
      errorMsg = $("#error-msg"+i);
      telInput.intlTelInput({
                    utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                    initialCountry: 'fr',
                    autoPlaceholder: true
                  });
                  var reset = function() {
                    telInput.removeClass("errorNumberTel");
                    errorMsg.addClass("hide");
                  };
    // on keyup / change flag: reset
    telInput.on("keyup change", reset);
    setTimeout('var telInput = $("#num_tel"+i),	errorMsg = $("#error-msg"+i),	validMsg = $("#valid-msg"); if ($.trim(telInput.val())) {	if (telInput.intlTelInput("isValidNumber")) {		validMsg.removeClass("hide");		validNum = telInput.intlTelInput("getNumber");	} else {		validNum = "non";		telInput.addClass("errorNumberTel"); errorMsg.removeClass("hide");		errorMsg.addClass("errorNumberTel"); }}', 500);
}
  //datetime picker
    $('#dbt_at').datetimepicker({
                          useCurrent: false,
                          format: 'DD-MM-YYYY',
//                          minDate: moment($('#dbt_at').val(), "DD-MM-YYYY"),
                          viewDate: moment($('#dbt_at').val(), "DD-MM-YYYY"),
//                          maxDate: moment($('#fin_at').val(), "DD-MM-YYYY").add(-1, 'days'),
                          icons: {
                          date: "fa fa-calendar",
                          up: "fa fa-arrow-up",
                          down: "fa fa-arrow-down"
                      },
                      });
    
    $('.time_pick').datetimepicker({
			format: 'HH:mm',
			useCurrent: false,
			icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "glyphicon glyphicon-chevron-up",
                    down: "glyphicon glyphicon-chevron-down"
                },
		});
  //end datetime picker
    });
</script>