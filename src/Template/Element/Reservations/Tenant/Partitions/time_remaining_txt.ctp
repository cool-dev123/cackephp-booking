<?php
use Cake\I18n\FrozenTime;
$currentDateTime = new FrozenTime();

$createdDateTime = new FrozenTime($created_at);
$acceptDateTime = $createdDateTime->modify('+48 hours');

if ($currentDateTime <= $acceptDateTime) {
    $diff = $acceptDateTime->diff($currentDateTime);
    $hours = ($diff->y * 8760) + ($diff->m * 730) + ($diff->d * 24) + $diff->h;
    $txt = str_replace(['{{prenom}}', '{{hrs}}', '{{mins}}'], [$prenom, $hours, $diff->i], __("{{prenom}} a encore <b><span class='remained-hrs'>{{hrs}}</span> heure(s) et <span class='remained-mins'>{{mins}}</span> minute(s)</b> pour répondre à votre demande de réservation"));
?>
<div class="opt my-mt-10 description-timer">
    <span><?= $txt ?></span>
</div>
<?php } else { ?>
    <div class="opt my-mt-10 description-timer">
        <span><?= __("Le délai pour répondre à votre demande de réservation est expiré") ?></span>
    </div>
<?php } ?>
