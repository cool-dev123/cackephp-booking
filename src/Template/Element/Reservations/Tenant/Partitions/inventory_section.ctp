<?php
    $baseUrl = $this->Url->build('/', true);

    $urlInventairelocataire = $baseUrl . "annonces/uploadinventairelocataire/" . $reservation['id'] . "?token=".md5($reservation['utilisateur_id']);

    $uploadBtnHidden   = '';
    $downloadBtnHidden = ' hidden';
    $downloadUrl       = '';

    if (!empty(trim($reservation['inventaire_loc']))) {
        $uploadBtnHidden   = ' hidden';
        $downloadBtnHidden = '';
        $downloadUrl       = $baseUrl . "inventaireslocataire/" . $reservation['inventaire_loc'];
    }
?>
<div class="inventory_section">
    <h2><?= __('Etat des lieux d\'entrée') ?></h2>
    <a id="download_inventory_btn" href="<?= $downloadUrl ?>" class="bordered_button no-text-decoration inventory-btn<?=$downloadBtnHidden?>" type="button" download><?= __('Télécharger l\'état des lieux à compléter') ?></a>
    <button id="upload_inventory_btn" class="bordered_button inventory-btn my-mt-10<?=$uploadBtnHidden?>" type="button"><?= __('Envoyer l\'état des lieux completé') ?></button>


    <div class="my-mt-25">
        <b><?= __('Mes commentaires sur l\'état des lieux') ?></b>
        <?php $comment = trim($reservation['commentaire_inventaire']); ?>
        <form id="upload_inventory" action="<?= $urlInventairelocataire ?>" method="post" enctype="multipart/form-data">
            <input id="inventory_file" class="hidden" type="file" accept="application/pdf" name="uploadfile" />
            <textarea id="inventory_comment_filed" placeholder="" name="commentaire_inventaire"><?= $comment ?></textarea>
        </form>
    </div>
    <div class="alert alert-success hidden" role="alert"></div>
    <div class="alert alert-danger hidden" role="alert"><?= __('Ce champ est obligatoire') ?></div>
    <div class="alert alert-danger hidden required-alert" role="alert"><?= __('Ce champ est obligatoire') ?></div>
</div>
<hr>