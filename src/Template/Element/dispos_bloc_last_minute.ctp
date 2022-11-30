<?php $this->append('cssTopBlock', '<style>

#delaislastminute, #montantlastminute {
    height: 35px;
    border-radius: 10px !important;
}
</style>'); ?>

<div class="divlastminutetoshow" style="display:none;">
    <div class="px-4">
        <form class="automation-promotion-form" data-type="last_minute">
            <input type="hidden" name="annonce_id" id="annonce_id" value="<?php echo $annonce_id ?>" >
            <h3><?= __("Promotion Last Minute") ?><span class="tooltipsvc ml-2" data-toggle="tooltip" data-placement="bottom" title="<h4><?= __('Last Minute') ?></h4><p><?= __('La réduction sera proposée aux vacanciers pour les séjours réservés à la dernière minute.<br><br>Par exemple, vous pouvez proposer une réduction de 20% pour les périodes qui n’ont pas été réservées 20 jours avant leur début.') ?></p>"><i class="fa fa-question-circle-o"></i></span></h3>
            <div class="row">
                <div class="col">
                    <label for=""><?= __("Proposer une promotion Last Minute") ?></label>
                </div>
                <div class="col-2">
                    <label class="switch">
                        <input id="proposerlastminute" name="proposerlastminute" type="checkbox">
                        <span class="slider round shadow-sm"></span>
                    </label>
                </div>
            </div>
            <div class="montantlastminutebloc montant-block" style="display:none;">
                <div class="row mt-3">
                    <div class="col">
                        <label for=""><?= __("Délais (jusqu'à - jours avant)") ?>*</label>
                    </div>
                    <div class="col-3 mr-4 pl-0">
                        <input id="delaislastminute" name="delaislastminute" type="number" min="1" max="100" value="<?= $annonce_detail->delaislastminute; ?>" class="form-control text-center shadow-sm ">
                        <p class="range-info">(1 - 100)</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col d-flex align-items-center">
                        <label for="" class="mb-0"><?= __("Montant (pourcentage)") ?>*</label>
                    </div>
                    <div class="col-4">
                        <div class=" d-flex align-items-center">
                            <input id="montantlastminute" name="montantlastminute" type="number" min="1" max="60" value="<?= $annonce_detail->montantlastminute; ?>" step="0.01" class="form-control text-center shadow-sm mr-1">
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