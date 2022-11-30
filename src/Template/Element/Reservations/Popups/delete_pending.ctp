<div class="modal fade delete-confirmation-modal" id="delete_pending" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= __("Supprimer la réservation") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <center><p><?= __("Voulez-vous supprimer cette reservation") ?></p></center>
                <div class="text-right">
                    <button type="button" class="btn btn-retour rounded-0 border" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
                    <button type="button" class="btn btn-blue rounded-0 text-white confirm-delete-btn" data-type="pending"><?= __("Oui") ?></button>
                </div>

            </div>
        </div>
    </div>
</div>