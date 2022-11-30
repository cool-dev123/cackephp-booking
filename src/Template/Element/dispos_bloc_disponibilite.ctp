<?php $this->Html->css("/css/modif_datepicker.css", array('block' => 'cssTop')); ?>

<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->append('cssTopBlock', '<style>
#ui-datepicker-div {
    z-index: 2147483647 !important;
}
.input-group-text {
    background-color: white;
    border-radius: 10px;
    border-left: none;
}
#dbt_at, #fin_at {
    border-right: none;
    border-top-left-radius: 10px!important;
    border-bottom-left-radius: 10px!important;
    border-top-right-radius: 0px!important;
    border-bottom-right-radius: 0px!important;
    height: 30px;
}

/* SWITCHER */
.switch {
    position: relative;
    display: inline-block;
    width: 45px;
    height: 21px;
}
.switch input { 
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}
.slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    left: 2px;
}
input:checked + .slider {
    background-color: white;
}
input:checked + .slider:before {
    background-color: #2196F3;
}
input:focus + .slider {
    box-shadow: 0 0 1px white;
}
input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}
/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}
.slider.round:before {
    border-radius: 50%;
}

#nbr_nuitee_min, #prix_nuitee, #prix_promotion {
    height: 35px;
    border-radius: 10px !important;
}
.hrblack {
    border-color: #ced0d1;
}
.btn-valider-tarif{
    background-color: #0099ff;
    border-radius: 10px;
    border: 1px solid #0099ff;
    width: 100%;
    font-size: 17px;
}
label.error.fail-alert {
    color: red;
    margin-left: 5%;
    width: 100%;
    font-size: 13px;
}
.spaninfoplustatut {
    font-size: 12px;
    font-style: italic;
}
/* Chrome, Safari, Edge, Opera */
#montantfrais::-webkit-outer-spin-button,
#montantfrais::-webkit-inner-spin-button,
#montantfraisanimaux::-webkit-outer-spin-button,
#montantfraisanimaux::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox */
#montantfrais, #montantfraisanimaux {
  -moz-appearance: textfield;
}
</style>'); ?>

<div class="divdisponibilitestoshow" style="display:none;">
    <div class="px-4">
        <?php echo $this->Form->create(null,['id'=>'addDisponibilite','class'=>'form-horizontal','url' => ['controller' => 'Dispos', 'action' => 'calendarAddNew']]);?>
            <input type="hidden" name="annonce_id" id="annonce_id" value="<?php echo $annonce_id ?>" >
            <input type="hidden" name="statut" id="statut" value="0" >
            <h3><?= __("Dates sélectionnées") ?></h3>
            <div class="row">
                <div class="col-1 pr-0 mt-1">
                    <label for=""><?= __("Du") ?></label>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input id="dbt_at" name="dbt_at" type="text" class="form-control rounded-left" placeholder="<?= __('jj-mm-aaaa') ?>">
                        <div class="input-group-append">
                            <div class="input-group-text py-0">
                                <label class="add-on mb-0" for="dbt_at">
                                    <i class="fa fa-calendar"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-1 px-0 mt-1">
                    <label for=""><?= __("au") ?></label>
                </div>
                <div class="col pl-0">
                    <div class="input-group">
                        <input id="fin_at" name="fin_at" type="text" class="form-control rounded-left" placeholder="<?= __('jj-mm-aaaa') ?>">
                        <div class="input-group-append">
                            <div class="input-group-text py-0">
                                <label class="add-on mb-0" for="fin_at">
                                    <i class="fa fa-calendar"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="row mb-3">
                <div class="col-3">
                    <label id="disponiblelabel" for=""><?= __("Disponible") ?></label>
                </div>
                <div class="col-2">
                    <label class="switch">
                        <input id="statutdispo" name="statutdispo" type="checkbox">
                        <span class="slider round shadow-sm"></span>
                    </label>
                </div>
                <div class="col-4 p-0 nuiteminlabel" style="display:none;">
                    <label for="" class="float-right"><?= __("Nuitées minimales") ?></label>
                </div>
                <div class="col-2 nuitemininput" style="display:none;">
                    <input id="nbr_nuitee_min" name="nbr_jour" type="number" min="1" value="1" class="form-control pr-0 pl-2 shadow-sm text-center">
                </div>
                <span class="col-12 spaninfoplustatut"></span>
            </div>             
            <div class="nocheckeddispo" style="display:none;">
                <h3><?= __("Tarification") ?></h3>  
                <div class="row mb-1 justify-content-between">
                    <div class="col-6 d-flex align-items-center">
                        <label for="" class="mb-0"><?= __("Prix par nuitée") ?></label>
                    </div>
                    <div class="col-5 d-flex align-items-center">
                        <input id="prix_nuitee" name="prix_jour" type="number" min="1" value="1" class="form-control text-center shadow-sm " onKeyUp='calculerPrixtotal()'><span class="ml-2">€</span>
                    </div>                                
                </div> 
                <div class="row mb-3 justify-content-between">
                    <div class="col-6 d-flex align-items-center">
                        <label for="" class="mb-0"><?= __("Prix promotionnel") ?><span class="tooltipsvc ml-2" data-toggle="tooltip" data-placement="bottom" title="<h4><?= __('Prix promotionnel') ?></h4><p><?= __('Au delà des promotions Early Booking, Last Minute et Séjours Longs, vous pouvez proposer une réduction sur une période spécifique.<br><br>Laissez vide pour ne pas proposer de réduction sur la période sélectionnée.<br><br>Pour supprimer une promotion, retirez le montant puis cliquez sur le bouton de validation pour enregistrer les paramètres de la période.') ?></p>"><i class="fa fa-question-circle-o"></i></span></label>
                    </div>
                    <div class="col-5 d-flex align-items-center">
                        <input id="prix_promotion" name="promo_jour" min="0" type="number" class="form-control text-center shadow-sm " onKeyUp='calculerPrixtotal()'><span class="ml-2">€</span>
                    </div>                                
                </div> 
                <hr class="hrblack"> 
                <div class="row justify-content-between">
                    <div class="col pr-0">
                        <label for=""><?= __("Prix total (x "); ?><span id="labelnbrnuitee"></span><?= __(" nuitées)") ?></label>
                    </div>
                    <div class="col divprixtotal">
                        
                    </div>                                
                </div> 
                <div class="row justify-content-between divpaiementcavancier" style="display:none;">
                    <div class="col pr-0">
                        <label for=""><?= __("Prix payé par le vacancier") ?></label>
                    </div>
                    <div class="col divprixtotalcavancier">
                        
                    </div>                               
                </div> 
                <div class="row justify-content-between">
                    <div class="col">
                        <label for=""><?= __("Vous recevrez") ?></label>
                    </div>
                    <div class="col divprixtotalrecu">
                        
                    </div>                                
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-sm btn-primary btn-valider-tarif"><?= __('Valider la tarification') ?></button>                              
                </div>
            </div>            
        <?php echo $this->Form->end();?>              
    </div> 
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
// <script>
$(document).ready(function(){
    if($('#statutdispo').is(':checked')){
        $("#disponiblelabel").html('<?= __("Disponible") ?>');
        $(".nocheckeddispo").slideDown(500, "swing"); 
        $(".nuiteminlabel").slideDown(500, "swing"); 
        $(".nuitemininput").slideDown(500, "swing");  
    }else{
        $("#disponiblelabel").html('<?= __("Indisponible") ?>');
        $(".nocheckeddispo").slideUp(500, "swing"); 
        $(".nuiteminlabel").slideUp(500, "swing"); 
        $(".nuitemininput").slideUp(500, "swing");
    } 
});

jQuery.validator.addMethod("prixpromoinf", function(value, element, param) {
    if(parseFloat($('#prix_promotion').val()) >= parseFloat($('#prix_nuitee').val())) return false;
    else return true;
}, '<?= __("Le prix promotionnel doit etre inférieur au prix initial !") ?>');

jQuery.validator.addMethod("datedebutadd", function(value, element, param) {
    if(moment($('#dbt_at').val(), ['DD-MM-YYYY']) < moment()) return false;
    else return true;
}, "<?= __("Le début d'une période valide ne doit pas être à une date passée !") ?>");

$(document).ready(function() {
    $("#addDisponibilite").validate({
        lang: '<?php echo $language_header_name; ?>',
        errorClass: "error fail-alert",
        errorPlacement: function (error, element) {               
            error.insertAfter(element.closest('div'));               
        },
        rules: {
            promo_jour : {
                prixpromoinf: true,
            },
            dbt_at : {
                datedebutadd: true,
            },
        }
    });
});

$.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);
$("#dbt_at" ).datepicker({
    dateFormat: "dd-mm-yy",
});
$("#fin_at" ).datepicker({
    dateFormat: "dd-mm-yy"
});
$('#dbt_at').on( "change", function() {
    var d = moment(this.value,"DD-MM-YYYY").add(1, 'd');    
    $('#fin_at').datepicker( "option", "minDate", d.format('DD-MM-YYYY') );
});

$('#fin_at').on( "change", function() {
    // chercher nbr evenement durant la période sélectionnée
    $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>dispos/cherchernbrdispoperiode/<?php echo $annonce_id ?>",
        data: {debut:$('#dbt_at').val(), fin:$("#fin_at" ).val()},
        success:function(xml){
            console.log(xml.totalperiodecount);
            if(xml.totalperiodecount > 1) $(".spaninfoplustatut").html("<?= __('La période sélectionnée contient plusieurs statuts de disponibilité.') ?>");
            else $(".spaninfoplustatut").html("");
        }
    });
    calculerPrixtotal();
});
$('#prix_nuitee').on( "change", function() {
    $("#prix_promotion").attr({
       "max" : $("#prix_nuitee").val()         // values (or variables) here
    });
    calculerPrixtotal();
});
$("#prix_promotion").on( "change", function() {
    calculerPrixtotal();
});

$("#nbr_nuitee_min").on( "change", function() {
    var debut = moment($("#dbt_at").val(),"DD-MM-YYYY");
    var fin = moment($("#fin_at").val(),"DD-MM-YYYY");
    var differencedays = parseInt(fin.diff(debut, 'days'));
    if(differencedays <= parseInt($('#nbr_nuitee_min').val())){
        $('#fin_at').datepicker('setDate', debut.add(parseInt($('#nbr_nuitee_min').val()), 'd').format('DD-MM-YYYY'));
    }
    calculerPrixtotal();
});
$("#nbr_nuitee_min").keyup( function() {
    var debut = moment($("#dbt_at").val(),"DD-MM-YYYY");
    var fin = moment($("#fin_at").val(),"DD-MM-YYYY");
    var differencedays = parseInt(fin.diff(debut, 'days'));
    if(differencedays <= parseInt($('#nbr_nuitee_min').val())){
        $('#fin_at').datepicker('setDate', debut.add(parseInt($('#nbr_nuitee_min').val()), 'd').format('DD-MM-YYYY'));
    }
    calculerPrixtotal();
});

$('#statutdispo').change(function () {
    if($(this).is(':checked')){
        $("#disponiblelabel").html('<?= __("Disponible") ?>');
        $(".nocheckeddispo").slideDown(500, "swing"); 
        $(".nuiteminlabel").slideDown(500, "swing"); 
        $(".nuitemininput").slideDown(500, "swing");  
    }else{
        $("#disponiblelabel").html('<?= __("Indisponible") ?>');
        $(".nocheckeddispo").slideUp(500, "swing"); 
        $(".nuiteminlabel").slideUp(500, "swing"); 
        $(".nuitemininput").slideUp(500, "swing");
        $("#prix_nuitee").val(1);
        $("#prix_promotion").val("");
        $("#nbr_nuitee_min").val(1);
    }    
});
<?php $this->Html->scriptEnd(); ?>