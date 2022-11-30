<?php $this->append('cssTopBlock', '<style>

#montantfrais, #montantfraisanimaux {
    height: 35px;
    border-radius: 10px !important;
}
</style>'); ?>

<div class="divfraisfixestoshow" style="display:none;">
    <div class="px-4">
        <?php echo $this->Form->create(null,['id'=>'addDisponibiliteFraixFixes','class'=>'form-horizontal','url' => ['controller' => 'Dispos', 'action' => 'calendarAddFraisFixes']]);?>
            <input type="hidden" name="annonce_id" id="annonce_id" value="<?php echo $annonce_id ?>" >
            <h3><?= __("Frais de ménage") ?><span class="tooltipsvc ml-2" data-toggle="tooltip" data-placement="bottom" title="<h4><?= __('Frais de ménage') ?></h4><p><?= __('Vous passez par les services d’une conciergerie ou d’un prestataire externe ? Incluez le prix de votre prestation ménage à vos séjours. Si vous activez cette option, le montant indiqué sera automatiquement ajouté à chacune de vos réservations.<br><br>Attention, si vous êtes client d’une conciergerie Alpissime, vous devrez tout de même commander votre prestation ménage lorsque vous confirmerez la demande de réservation du vacancier.') ?></p>"><i class="fa fa-question-circle-o"></i></span></h3>
            <div class="row">
                <div class="col">
                    <label for=""><?= __("Demander des frais de ménage") ?></label>
                </div>
                <div class="col-2">
                    <label class="switch">
                        <input id="fraismenage" name="demande_frais_menage" type="checkbox">
                        <span class="slider round shadow-sm"></span>
                    </label>
                </div>
            </div>
            <div class="montantfraisbloc" style="display:none;">
                <div class="row">
                    <div class="col d-flex align-items-center">
                        <label for="" class="mb-0"><?= __("Montant des frais de ménage") ?></label>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <input id="montantfrais" name="montant_frais_menage" type="number" min="1" value="1" step="0.01" class="form-control text-center shadow-sm "><span class="ml-2">€</span>
                    </div>
                </div>   
            </div>
            <hr class="hrblack">
            <h3 class="mt-3"><?= __("Frais pour animaux") ?><span class="tooltipsvc ml-2" data-toggle="tooltip" data-placement="bottom" title="<h4><?= __('Frais pour animaux') ?></h4><p><?= __('Vous souhaitez autoriser les animaux de compagnie dans votre hébergement moyennant une compensation financière ? Activez l’option ’’Animaux acceptés’’ puis indiquez le montant que vous souhaitez ajouter à la réservation.<br><br>Les Frais pour Animaux seront ajoutés à chaque réservation pour lesquelles les vacanciers ont indiqué voyager avec un animal de compagnie.') ?></p>"><i class="fa fa-question-circle-o"></i></span></h3>
            <div class="row">
                <div class="col">
                    <label for=""><?= __("Accepter les animaux") ?></label>
                </div>
                <div class="col-2">
                    <label class="switch">
                        <input id="accepteranimaux" name="accept_animaux" type="checkbox">
                        <span class="slider round shadow-sm"></span>
                    </label>
                </div>
            </div>
            <div class="montantfraisanimauxbloc" style="display:none;">
                <div class="row">
                    <div class="col">
                        <label for=""><?= __("Demander des frais pour les animaux") ?></label>
                    </div>
                    <div class="col-2">
                        <label class="switch">
                            <input id="fraispouranimaux" name="demande_frais_animaux" type="checkbox" checked>
                            <span class="slider round shadow-sm"></span>
                        </label>
                    </div>
                </div>
                <div class="montantanimauxbloc">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <label for="" class="mb-0"><?= __("Montant des frais pour animaux") ?></label>
                        </div>
                        <div class="col-4 d-flex align-items-center">
                            <input id="montantfraisanimaux" name="montant_frais_animaux" type="number" min="1" value="1" step="0.01" class="form-control text-center shadow-sm "><span class="ml-2">€</span>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-sm btn-primary btn-valider-tarif"><?= __('Enregistrer') ?></button>                              
                </div>
            </div>
        <?php echo $this->Form->end();?> 
    </div> 
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
// <script>
var montantfraismenage = "<?php echo $annonce_detail->montant_frais_menage; ?>";
if(montantfraismenage != 0){
    $('#fraismenage').attr('checked', 'checked');
    $(".montantfraisbloc").slideDown(500, "swing"); 
    $("#montantfrais").val(montantfraismenage);
}

var acceptanimaux = "<?php echo $annonce_detail->accept_animaux; ?>";
if(acceptanimaux != 0){
    $('#accepteranimaux').attr('checked', 'checked');
    $(".montantfraisanimauxbloc").slideDown(500, "swing");
    var demandefraisanimaux = "<?php echo $annonce_detail->demande_frais_animaux; ?>";
    if(demandefraisanimaux != 0){
        $(".montantanimauxbloc").slideDown(500, "swing"); 
        var montantfraisanimaux = "<?php echo $annonce_detail->montant_frais_animaux; ?>";
        if(montantfraisanimaux != 0){
            $("#montantfraisanimaux").val(montantfraisanimaux);
        }else{
            $("#fraispouranimaux").removeAttr('checked');
            $(".montantanimauxbloc").slideUp(500, "swing"); 
        }
    }else{
        $("#fraispouranimaux").removeAttr('checked');
        $(".montantanimauxbloc").slideUp(500, "swing");
    }
}else{
    $('#accepteranimaux').removeAttr('checked');
    $(".montantfraisanimauxbloc").slideUp(500, "swing"); 
}

$('#fraismenage').change(function () {
    $(".tooltipsvc").tooltip('hide');
    if($(this).is(':checked')){
        $(".montantfraisbloc").slideDown(500, "swing"); 
    }else{
        $(".montantfraisbloc").slideUp(500, "swing"); 
    }
    // $(".montantfraisbloc").slideToggle(500, "swing"); 
});

$('#accepteranimaux').change(function () {
    if($(this).is(':checked')){
        $(".montantfraisanimauxbloc").slideDown(500, "swing"); 
    }else{
        $(".montantfraisanimauxbloc").slideUp(500, "swing"); 
    }
});

$("#fraispouranimaux").change(function () {
    if($(this).is(':checked')){
        $(".montantanimauxbloc").slideDown(500, "swing"); 
    }else{
        $(".montantanimauxbloc").slideUp(500, "swing"); 
    }
});
<?php $this->Html->scriptEnd(); ?>