<div class="my-flex-between my-mb-10">
    <b><?= __('Montant des nuits réservées') ?></b>
    <div><?= $reservation['prixreservation'] ?></div>
</div>

<?php
$fees      = $reservation['prixreservation'] + $reservation['prixtaxesejour'] + $reservation['prixfraiservice'];
$otherFees = number_format((float)($reservation['prixapayer'] - $fees), 2);

if ($otherFees !== '0.00') {
    ?>
    <div class="my-flex-between my-mb-10">
        <b><?= __('Autres frais (Ménage, animaux)') ?></b>
        <div><?= $otherFees ?> €</div>
    </div>
<?php } ?>

<?php if ($reservation['prixfraiservice']) { ?>
    <div class="my-flex-between my-mb-10">
        <b><?= __('Frais de services') ?></b>
        <div><?= $reservation['prixfraiservice'] ?> €</div>
    </div>
<?php } ?>

<?php if ($reservation['prixtaxesejour']) { ?>
    <div class="my-flex-between my-mb-10">
        <b><?= __('Taxe de séjour') ?></b>
        <div><?= $reservation['prixtaxesejour'] ?> €</div>
    </div>
<?php } ?>

<?php if ($reservation['prixapayer']) { ?>
    <div class="my-flex-between my-mb-10">
        <b><?= __('Montant total de la réservation') ?></b>
        <div><?= $reservation['prixapayer'] ?> €</div>
    </div>
<?php } ?>