<?php $this->append('cssTopBlock', '<style>

#delaislongsejours, #montantlongsejours {
    height: 35px;
    border-radius: 10px !important;
}
</style>'); ?>

<div class="divlongsejourstoshow" style="display:none;">
    <div class="px-4">
        <form class="automation-promotion-form" data-type="long_stay">
            <input type="hidden" name="annonce_id" id="annonce_id" value="<?php echo $annonce_id ?>" >
            <h3><?= __("Promotion Longs séjours") ?><span class="tooltipsvc ml-2" data-toggle="tooltip" data-placement="bottom" title="<h4><?= __('Longs séjours') ?></h4><p><?= __('Incitez les vacanciers à rester plus longtemps en proposant une réduction sur les séjours longs.<br><br>Par exemple, vous pouvez proposer une réduction de 20% pour les séjours comportant plus de 14 nuitées.') ?></p>"><i class="fa fa-question-circle-o"></i></span></h3>
            <div class="row">
                <div class="col">
                    <label for=""><?= __("Proposer une promotion Longs séjours") ?></label>
                </div>
                <div class="col-2">
                    <label class="switch">
                        <input id="proposerlongsejours" name="proposerlongsejours" type="checkbox">
                        <span class="slider round shadow-sm"></span>
                    </label>
                </div>
            </div>
            <div class="montantlongsejoursbloc montant-block" style="display:none;">
                <div class="row mt-3">
                    <div class="col">
                        <label for=""><?= __("Durée (séjour de plus de - jours)") ?>*</label>
                    </div>
                    <div class="col-3 mr-4 pl-0">
                        <input id="delaislongsejours" name="delaislongsejours" type="number" min="1" max="100" value="<?= $annonce_detail->delaislongsejours ; ?>" class="form-control text-center shadow-sm">
                        <p class="range-info">(1 - 100)</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col d-flex align-items-center">
                        <label for="" class="mb-0"><?= __("Montant (pourcentage)") ?>*</label>
                    </div>
                    <div class="col-4">
                        <div class=" d-flex align-items-center">
                            <input id="montantlongsejours" name="montantlongsejours" type="number" min="1" max="60" value="<?= $annonce_detail->montantlongsejours; ?>" step="0.01" class="form-control text-center shadow-sm mr-1">
                            <span>%</span>
                        </div>
                        <p class="range-info percent-range">(1 - 60)</p>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-sm btn-primary btn-valider-tarif"><?= __('Enregistrer') ?></button>                              
                </div>
            </div>
        </form>
    </div> 
</div>