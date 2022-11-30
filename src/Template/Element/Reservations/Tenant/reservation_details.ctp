<?php
    $months = [
        1  => __('Janvier'),
        2  => __('Fevrier'),
        3  => __('Mars'),
        4  => __('Avril'),
        5  => __('Mai'),
        6  => __('Juin'),
        7  => __('Juillet'),
        8  => __('Août'),
        9  => __('Septembre'),
        10 => __('Octobre'),
        11 => __('Novembre'),
        12 => __('Décembre'),
    ];
    $annonceTitle = str_replace(
        ["é", "è", "ê", "à", "â", "ä", "î", "ï", "ô", "ö", "ù", "û", "ü", ",", "'", " ", "(", ")", "%", "œ", "Œ", "€", "/", "+", "ç", "*", "?", "!", "°", "<", ">", "----", "---", "--", "²"],
        ["e", "e", "e", "a", "a", "a", "i", "i", "o", "o", "u", "u", "u", "-", "-", "-", "", "", "pourcent", "oe", "oe", "euros", "-", "-", "c", "", "", "", "", "", "", "-", "-", "-", ""],
        $reservation['annonce']['titre']
    );

    $skiresort_URL = $urlLang == 'en/' ? $reservation['annonce']['village']['input_boutique_EN'] : $reservation['annonce']['village']['input_boutique'];

    $travellersInfo = [];
    if ($reservation['nb_adultes'] > 0) {
        $travellersInfo[] = $reservation['nb_adultes'] . ' ' . strtolower(__('Adulte(s)'));
    }

    if ($reservation['nb_enfants'] > 0) {
        $travellersInfo[] = $reservation['nb_enfants'] . ' ' . strtolower(__('Enfant(s)'));
    }
?>
<div>
    <h1><?= __('Détail de la réservation'); ?></h1>
    <span class="my-font-italic"><?= __("Annonce") ?> #<?= $reservation['annonce_id'] ?> • <?= $reservation['annonce']['titre'] ?></span>
</div>
<hr>

<div class="details-section">
    <div class="my-flex-between my-mb-10">
         <h2><?= __('Réservation'); ?></h2>
         <b class="bordered_button"><?= $group['txt'] ?></b>
    </div>

    <div class="my-flex-between my-mb-10">
        <b><?= __('Réservé le'); ?></b>
        <div><?= $reservation['created_at']->i18nFormat('dd/MM/yyyy') ?></div>
    </div>

    <div class="my-flex-between my-mb-10">
        <b><?= __('Date d\'arrivée') ?></b>
        <!--div class="bordered_button my-datepicker"><?= $reservation['dbt_at']->i18nFormat('dd/MM/yyyy') ?></div-->
        <input type="text" class="bordered_button my-datepicker " id="from" readonly='readonly' value="<?= $reservation['dbt_at']->i18nFormat('dd/MM/yyyy') ?>"/>
    </div>

    <div class="my-flex-between my-mb-10">
        <b><?= __('Date de départ') ?></b>
        <!--div class="bordered_button"><?= $reservation['fin_at']->i18nFormat('dd/MM/yyyy') ?></div-->
        <input type="text" class="bordered_button my-datepicker" id="end" readonly='readonly' value="<?= $reservation['fin_at']->i18nFormat('dd/MM/yyyy') ?>"/>
    </div>

    <?php if (!empty($travellersInfo)) { ?>
    <div class="my-flex-between my-mb-10">
        <b><?= __('Voyageurs') ?></b>
        <div><?= implode(' • ', $travellersInfo) ?></div>
    </div>
    <?php } ?>

    <div class="my-flex-between my-mb-10">
        <b><?= __('Identifiant de la réservation') ?></b>
        <div class="reservation-id"><?= $reservation['id'] ?></div>
    </div>

    <?php if (!in_array($group['type'], ['past', 'canceled'])) { ?>
    <?php
        $cancelBtnTxt = __('Annuler la réservation');
        if ($group['type'] == 'pending') {
            echo $this->element('Reservations/Tenant/Partitions/time_remaining_txt', [
                'prenom'     => $reservation['annonce']['utilisateur']['prenom'],
                'created_at' => $reservation['created_at'],
                'class'      => " my-mb-15",
            ]);

            $cancelBtnTxt = __('Annuler la demande de réservation');
        }
    ?>
    <span class='my-font-italic cancel-reservation-btn' data-start_date="<?= $reservation['dbt_at']->i18nFormat('dd/MM/yyyy') ?>" data-type="<?= $group['type'] ?>"><?= $cancelBtnTxt ?></span>
    <?php } ?>
</div>
<hr>

<?php if (!empty($skiresort_URL) && !in_array(strtolower($skiresort_URL), ["fr", "en"]) && !in_array($group['type'], ['past', 'canceled'])) { ?>
<div>
    <h2><?= __('Activités et services') ?></h2>
    <div class="my-mb-15 my-font-italic"><?= __('Continuez la préparation de vos vacances en réservant des activités (location de skis, cours de skis, forfaits) et des services (ménage professionnel, location de linge, matériel bébé)') ?></div>
    <a href="https://www.boutique.alpissime.com/<?= $skiresort_URL ?>" class="bordered_button no-text-decoration" target="_blank" style="font-weight: 500"><?= __('Préparer mes vacances') ?></a>
</div>
<hr>
<?php } ?>

<div>
    <h2><?= __('Mon hébergement') ?></h2>
    <div class="my-mb-25">
        <b><?= $reservation['annonce']['titre'] ?></b>
        <p class="my-font-italic">
            <span><?= __("Annonce") ?> #<?= $reservation['annonce_id'] ?></span> -
            <a href="<?= $this->Url->build('/', true) . $urlLang; ?>detail/<?= $reservation['annonce_id'] ?>-<?= strtolower($annonceTitle) ?>" class="underlined" target="_blank"><?= __('Voir l\'annonce') ?></a>
        </p>
    </div>
    <?php if (!in_array($group['type'], ['past', 'canceled'])) { ?>
    <?php if ($group['type'] == 'confirmed') {
        echo $this->element('Reservations/Tenant/Partitions/address_section', [
            'num_app'     => $reservation['annonce']['num_app'],
            'village'     => $reservation['annonce']['village']['name'],
            'residence'   => $reservation['annonce']['residence']['name'],
            'code_postal' => $reservation['annonce']['village']['frville']['code_postal'],
            'ville'       => $reservation['annonce']['village']['frville']['name'],
        ]);
    }
    ?>

    <div class="my-mb-25">
        <b><?= __('Mon arrivée en station') ?></b>
        <p><?= $reservation['annonce']['contrat'] == 0 ? str_replace('{{prenom}}', $reservation['annonce']['utilisateur']['prenom'], __("Remise de clés organisée par {{prenom}}")) : __("Remise de clés organisée par prenom") ?></p>
    </div>
    <?php } else {  ?>
        <button class="bordered_button send-message-long" type="button"><?= __('Réserver à nouveau') ?></button>
    <?php } ?>
</div>
<hr>

<div>
    <h2><?= __('A propos du propriétaire') ?></h2>
    <b><?= ucfirst($reservation['annonce']['utilisateur']['prenom']) ?> <?= ($group['type'] == 'confirmed' ? $reservation['annonce']['utilisateur']['nom_famille'] : $reservation['annonce']['utilisateur']['nom_famille'][0] . '.') ?></b>
    <p><?= __('Membre depuis') ?> <?= $months[$reservation['annonce']['utilisateur']['date_insert']->i18nFormat('M')] ?> <?= $reservation['annonce']['utilisateur']['date_insert']->i18nFormat('Y') ?></p>
    <?php if (!is_numeric($reservation['annonce']['utilisateur']['ville'])) { ?>
    <p><?= __('Habite à') ?> <?= ucfirst($reservation['annonce']['utilisateur']['ville']) ?></p>
    <?php } ?>
    <button class="bordered_button send-message-long send-message-btn" type="button" data-res_id="<?= $reservation['id'] ?>"><?= __('Envoyer un message') ?></button>

    <?php if (!in_array($group['type'], ['past', 'canceled'])) { ?>
    <?php if ($group['type'] == 'confirmed') { ?>
    <a href="tel:<?= $reservation['annonce']['utilisateur']['portable'] ?>" class="bordered_button send-message-long no-text-decoration" type="button"><?= __('Appeler le') ?> <?= $reservation['annonce']['utilisateur']['portable'] ?></a>
    <?php } else { ?>
    <p><?= str_replace('{{prenom}}', $reservation['annonce']['utilisateur']['prenom'], __("Vous accéderez au numéro de téléphone de {{prenom}} une fois la réservation acceptée")) ?></p>
    <?php } ?>
    <?php } ?>
</div>
<hr>

<?php if ($group['type'] != 'canceled') { ?>
<div>
    <h2><?= __('Commentaires') ?></h2>
    <p><?= __('Indiquez ici les commentaires relatifs à la réservation') ?></p>

    <?php if (in_array($group['type'], ['confirmed', 'past']) && !empty(trim($reservation['comment']))) {
        echo $this->element('Reservations/Tenant/Partitions/owner_comment_section', [
            'prenom'  => $reservation['annonce']['utilisateur']['prenom'],
            'comment' => $reservation['comment'],
        ]);
    } ?>

    <div class="my-mt-10">
        <b><?= __('Vos commentaires') ?></b>
        <?php
            $comment = trim($reservation['commentlocataire']);
            $placeHolderTxt = empty($comment) ? str_replace('{{prenom}}', $reservation['annonce']['utilisateur']['prenom'], __("Vous n'avez communiqué aucune remarque à {{prenom}}")) : '';
        ?>
        <input id="existing_comment" type="hidden" value="<?= $comment ?>" />
        <textarea id="comment_filed" placeholder="<?= $placeHolderTxt ?>"><?= $comment ?></textarea>
        <div class="alert alert-success hidden" role="alert"><?= __('Le commentair a été bien enregistré') ?></div>
        <div class="alert alert-danger hidden" role="alert"><?= __('Le commentair n\'a pas pu etre enregistré') ?></div>
        <button class="bordered_button add-comment-btn" type="button"><?= __('Enregistrer le commentaire') ?></button>
    </div>
</div>
<hr>
<?php } ?>

<?php if ($group['type'] == 'confirmed') {
    echo $this->element('Reservations/Tenant/Partitions/inventory_section', ['reservation' => $reservation]);
} ?>

<div>
    <?php if ($reservation['type'] ==0 || ($reservation['type'] == 1 && $reservation['taxe'] == 1)) { ?>
        <h2><?= __('Mon paiement') ?></h2>

        <?php if ($reservation['type'] == 0) {
            echo $this->element('Reservations/Tenant/Partitions/payments_section', ['reservation' => $reservation]);
        } else {
            echo "<b>" . __("Taxe de séjour à régler lors de la récupération des clés") . " : " . $reservation['prixtaxesejour'] . " € </b>";
        }

        if ($group['type'] == 'pending') { ?>
        <div class="my-mb-15"><?= str_replace('{{prenom}}', $reservation['annonce']['utilisateur']['prenom'], __("Vous serez débité lorsque {{prenom}} aura accepté votre demande de réservation")) ?></div>
        <?php }
    }
    ?>

    <?php if (!empty($skiresort_URL) && !in_array(strtolower($skiresort_URL), ["fr", "en"])) { ?>
    <a href="https://boutique.alpissime.com/<?= $skiresort_URL ?>/sales/order/history/ " class="underlined my-font-italic" target="_blank"><?= __('Voir ma commande') ?></a>
    <?php } ?>
</div>
