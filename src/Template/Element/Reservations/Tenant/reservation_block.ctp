<?php
$baseUrl = $this->Url->build('/', true);

foreach ($reservations as $reservation) {
    $image = !empty($reservation['annonce']['photos']) ? $reservation['annonce_id'] . '/' . $reservation['annonce']['photos'][0]['titre'] ."?v=".(time()*1000) : "no_annonce_image.jpg";

    $annonceTitle = str_replace(
        ["é", "è", "ê", "à", "â", "ä", "î", "ï", "ô", "ö", "ù", "û", "ü", ",", "'", " ", "(", ")", "%", "œ", "Œ", "€", "/", "+", "ç", "*", "?", "!", "°", "<", ">", "----", "---", "--", "²"],
        ["e", "e", "e", "a", "a", "a", "i", "i", "o", "o", "u", "u", "u", "-", "-", "-", "", "", "pourcent", "oe", "oe", "euros", "-", "-", "c", "", "", "", "", "", "", "-", "-", "-", ""],
        $reservation['annonce']['titre']
    );
?>
    <div id="<?= $reservation['id'] ?>" class="reservations_row">
        <span class="hidden">Created : <?= $reservation['created_at'] ?></span>
        <span class="hidden">Updated : <?= $reservation['updated_at'] ?></span>
        <span class="hidden">Status : <?= $reservation['statut'] ?></span>
        <div class="image">
            <img src="<?= $baseUrl . 'images_ann/' . $image ?>" alt="">
        </div>
        <div class="reservation_body">
            <div class="my-flex-between">
                <span class="bordered_button"><?= $group['txt'] ?></span>
                <span><?= __('Réservation') ?> : #<?= $reservation['id'] ?></span>
            </div>
            <div class="arrivee_data">
                <h2><?= $reservation['annonce']['titre'] ?></h2>
                <div class="reservation_time">
                    <span><?= __('Arrivée') ?> : <span class="arrive_date"><?= $reservation['dbt_at']->i18nFormat('dd/MM/Y') ?></span></span>
                    <span class="dot"></span>
                    <span class="fin_at"><?= __('Départ') ?> : <span class="fin_date"><?= $reservation['fin_at']->i18nFormat('dd/MM/Y') ?></span></span>
                </div>
            </div>

            <?php if ($group['type'] == 'confirmed') { ?>
            <div class="opt">
                <h2><?= __('Contacter le propriétaire') ?></h2>
                <div class="action-buttons">
                    <button class="bordered_button send-message-btn" type="button"><?= __('Envoyer un message') ?></button>
                    <a href="tel:<?= $reservation['annonce']['utilisateur']['portable'] ?>" class="bordered_button no-text-decoration" type="button"><?= __('Appeler') ?></a>
                </div>
            </div>
            <div class="opt">
                <h2><?= __('Ma réservation') ?></h2>
                <button class="bordered_button see-details-btn" type="button"><?= __('Détails') ?></button>
            </div>
            <?php } //if ($group_name == 'confirmed')
                  else {
            ?>
            <div class="opt">
                <h2><?= __('Ma réservation') ?></h2>
                <div class="action-buttons">
                    <button class="bordered_button see-details-btn" type="button"><?= __('Détails') ?></button>
                    <button class="bordered_button send-message-btn" type="button"><?= __('Envoyer un message') ?></button>
                </div>
            </div>
            <?php if ($group['type'] == 'pending') {
                echo $this->element('Reservations/Tenant/Partitions/time_remaining_txt', [
                    'prenom'     => $reservation['annonce']['utilisateur']['prenom'],
                    'created_at' => $reservation['created_at']
                ]);
            } else { ?>
            <div class="opt">
                <h2><?= __('Réserver à nouveau') ?></h2>
                <a href="<?= $baseUrl . $urlLang; ?>detail/<?= $reservation['annonce_id'] ?>-<?= strtolower($annonceTitle) ?>" class="bordered_button no-text-decoration" target="_blank"><?= __('Voir l\'annonce') ?></a>
            </div>
            <?php } //if ($group_name == 'pending') else
               }//if ($group_name == 'confirmed') else
            ?>
        </div>
    </div>
<?php } ?>
