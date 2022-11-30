<div class="modal fade date-confirmation-modal" id="date_confirmed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <center><p id="startText"><?= __("Attention, vous allez modifier votre date d'arrivée. Êtes-vous sûr(e) de vouloir continuer ?") ?></p></center>
                <center><p id="endText"><?= __("Attention, vous allez modifier votre date de départ. Êtes-vous sûr(e) de vouloir continuer ?") ?></p></center>

            </div>

            <div class="row justify-content-end">
                <div class="col-auto m-3">
                    <button type="button" class="btn btn-retour border rounded-0" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
                    <button type="button" class="btn btn-blue rounded-0 text-white confirm-date-btn" data-type="confirmed"><?= __("Confirmer le changement") ?></button>
                </div>
            </div>
        </div>
    </div>
</div>