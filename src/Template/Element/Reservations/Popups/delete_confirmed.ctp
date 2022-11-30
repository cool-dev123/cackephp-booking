<div class="modal fade delete-confirmation-modal" id="delete_confirmed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= __("Supprimer la réservation") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <center><p><?= __("Voulez-vous supprimer cette reservation") ?></p></center>
                <form id="formjustificatif" name="formjustificatif" method ="post" enctype="multipart/form-data">
                    <input type="hidden" name="bdteservation" id="dbtreservation">
                    <input type="hidden" name="prixremboursement" id="prixremboursement">
                    <input type="hidden" id="inputMailSansJustification" name="inputMailSansJustification"></input>
                    <input type="hidden" id="inputMontantProp" name="inputMontantProp" val=""></input>
                    <input type="hidden" id="inputSansJustification" name="inputSansJustification" />
                    <input type="hidden" id="idannulation" name="idannulation" />

                    <div class="custom-control custom-radio">
                        <input type="radio" id="avecjustificatif" class="custom-control-input" name="justificatif" value="1">
                        <label class="custom-control-label" for="avecjustificatif"><?= __("Annulation avec justificatif") ?></label>
                    </div>
                    <div id="divJustification" class="m-3 hidden">
                        <p><strong><?= __("Expliquez-nous le motif de votre annulation") ?> : </strong></p>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="motif" value="maladie" id="motifmaladie"><label class="custom-control-label" for="motifmaladie"><?= __("Maladies ou blessures graves") ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="motif" value="deces" id="motifdeces"><label class="custom-control-label" for="motifdeces"><?= __("Décès d'un des locataires, proche ou parent") ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="motif" value="officielle" id="motifofficielle"><label class="custom-control-label" for="motifofficielle"><?= __("Obligations officielles") ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="motif" value="autre" id="motifautre"><label class="custom-control-label" for="motifautre"><?= __("Autres") ?></label>
                        </div>
                        <label id="motifobligatoire" class="required-err-msg hidden"><span class="error_formul"> <?= __("Ce champ est obligatoire") ?></span></label>

                        <!--file input example -->
                        <div class="mt-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="fileJustificatif" id="fileJustificatif" accept=".gif,.jpg,.jpeg,.png,.pdf">
                                <label for="fileJustificatif" class="custom-file-label" data-browse="Sélectionner"><?= __("Justificatif à uploader pdf/image") ?></label>
                                <label id="fileobligatoire" class="required-err-msg hidden"><span class="error_formul"> <?= __("Ce champ est obligatoire") ?></span></label>
                            </div>
                        </div>
                        <!--./file input example -->

                        <div class="form-group my-3">
                            <label for="comment"><?= __("Commentaire") ?>:</label>
                            <textarea class="form-control" rows="5" name="commentaire" id="commentaire"></textarea>
                            <label id="commentaireobligatoire" class="required-err-msg hidden"><span class="error_formul"> <?= __("Ce champ est obligatoire") ?></span></label>
                        </div>

                    </div>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="sansjustificatif" class="custom-control-input" name="justificatif" value="0">
                        <label class="custom-control-label" for="sansjustificatif"><?= __("Annulation sans justificatif") ?></label>
                    </div>
                    <div id="divSansJustification" class="m-3 hidden"></div>
                    <label id="justificatifobligatoire" class="required-err-msg hidden"><span class="error_formul"> <?= __("Ce champ est obligatoire") ?></span></label>

                </form>

            </div>

            <div class="row justify-content-end">
                <div class="col-auto m-3">
                    <button type="button" class="btn btn-retour border rounded-0" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
                    <button type="button" class="btn btn-blue rounded-0 text-white confirm-delete-btn" data-type="confirmed"><?= __("Oui") ?></button>
                </div>
            </div>
        </div>
    </div>
</div>