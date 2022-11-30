<?php $this->append('cssTopBlock', '<style>


</style>'); ?>

<div class="divparametrestoshow" style="display:none;">
    <div class="px-4">
        <?php echo $this->Form->create(null,['id'=>'addDisponibiliteParametres','class'=>'form-horizontal','url' => ['controller' => 'Dispos', 'action' => 'calendarAddParametres']]);?>
            <input type="hidden" name="annonce_id" id="annonce_id" value="<?php echo $annonce_id ?>" >
            <h3><?= __("Préférences de réservation") ?><span class="tooltipsvc ml-2" data-toggle="tooltip" data-placement="bottom" title="<h4><?= __('Préférences de réservation') ?></h4><p><?= __('Les préférences de réservations sont affichées à titre informatifs sur votre annonce pour aider les vacanciers à réserver votre hébergement.') ?></p>"><i class="fa fa-question-circle-o"></i></span></h3>
            <div class="row">
                <div class="col pr-0 mt-2">
                    <label for=""><?= __("Préférences de réservation") ?></label>
                </div>
                <div class="col-6">
                    <select class="custom-select" id="sejourflexible" name="sejour_flexible">
                        <option selected><?= __('Choisir') ?></option>
                        <option value="1"><?= __("Réservations flexibles toute l'année") ?></option>
                        <option value="2"><?= __('Réservations flexibles hors vacances scolaires') ?></option>
                        <option value="3"><?= __('Réservations du samedi au samedi privilégiées') ?></option>
                    </select>
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
var sejourflexible = "<?php echo $annonce_detail->sejour_flexible; ?>";
if(sejourflexible != 0){
    $("#sejourflexible").val(sejourflexible);
}

<?php $this->Html->scriptEnd(); ?>