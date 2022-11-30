<?php
use Cake\I18n\Date;

$reservationStatuses = [
    '0'                => __('Réservation en cours'),
    '10'               => __('Réservation expirée'),
    '50'               => __('Réservation en attente'),
    '60'               => __('Réservation non finalisée'),
    '90'               => __('Réservation confirmée'),
    '90_arrival_today' => __('Arrivée Aujourd\'hui'),
    '90_arrival'       => __('Arrivée dans %d jour%s'),
    '90_past'          => __('Réservation passée'),
    '100'              => __('Annulation demandée'),
    '110'              => __('Réservation annulée')
];

$currentDate = new Date();
?>
<?php foreach ($messages as $k => $msg) {
    $isNotRead = ($msg->lut == 0 && $msg->locataire_id != $this->Session->read('Auth.User.id')) || $unreadCount[$msg->id] != 0;
    $active = '';

    if (!empty($selectedMessageId)) {
        if ($msg->id == $selectedMessageId) {
            $active = ' _active';
        }
    } elseif ($k == 0) {
        $active = ' _active';
    }

    $reservationStatusText = '';
    $userFullName = $msg['U']['prenom'] . ' ' . $msg['U']['nom_famille'][0] . '.';
    $startDate = '';
    $endDate   = '';

    if ($msg->reservation_id) {
        $startDate = new Date($msg['Rs']['dbt_at']);
        $endDate   = new Date($msg['Rs']['fin_at']);

        if ($msg['Rs']['statut']) {
            $reservationStatusText = $reservationStatuses[$msg['Rs']['statut']];

            if ($msg['Rs']['statut'] == 90) {
                if ($currentDate > new Date($endDate)) {
                    $reservationStatusText = $reservationStatuses['90_past'];
                } else {
                    $userFullName = $msg['U']['prenom'] . ' ' . $msg['U']['nom_famille'];
                    $diff = $currentDate->diff($startDate);

                    if ($diff->days <= 5) {
                        if ($diff->days == 0) {
                            $reservationStatusText = $reservationStatuses['90_arrival_today'];
                        } else {
                            $reservationStatusText = sprintf($reservationStatuses['90_arrival'], $diff->days, ($diff->days > 1 ? 's' : ''));
                        }
                    }
                }
            }
        }
    } else {
        list($fromTxt, $toTxt) = explode(' -- ', $msg->commentaire);
        $fromDate    = end(explode(' : ', $fromTxt));
        $toDate      = end(explode(' : ', $toTxt));

        try {
            $startDate = new Date($fromDate);
        } catch (\Exception $e) {}

        try {
            $endDate   = new Date($toDate);
        } catch (\Exception $e) {}
    }

    $archiveOptTxt   = __("Archiver");
    $archiveOptClass = ' not-archived';
    if ($msg->archived) {
        $archiveOptTxt = __("Non archiver");
        $archiveOptClass = ' archived';
    }

    $readOptTxt              = __("Marquer comme non lu");
    $readStatusLabel         = __("Message lu");
    $readOptClass            = ' read';
    $unreadClass             = '';

    if ($isNotRead && $k !== 0) {
        $readOptTxt              = __("Marquer comme lu");
        $readStatusLabel         = __("Message non lu");
        $readOptClass            = ' not-read';
        $unreadClass             = ' font-weight-bold';
    }
?>
    <div id="<?= $msg->id ?>" class="members-member<?= $unreadClass ?><?= $active ?>" data-reservation_id="<?= $msg->reservation_id ?>" data-user_id="<?= $msg->user_id ?>">
        <div class="member__top">
            <?php if ($msg->reservation_id) { ?>
                <div class="member__type content__block booking-status"><?= $reservationStatusText ?></div>
            <?php } ?>
            <div class="member__txt member__view">
                <span class="read-label"><?= $isNotRead ? __("Message non lu") : __("Message lu"); ?></span>
                <?php if($msg->archived) { ?> <span class="member-info-dot"></span><span><?= ' ' . __("Archivé"); }?></span>
            </div>
            <div class="member__select SelectBody">
                <div class="dropdown">
                    <div class="dropdown-btn member__btn" data-toggle="dropdown">+</div>
                    <div class="dropdown-menu membSelect__list" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item membSelect__item read-opt<?= $readOptClass ?>" href="#"><?= $readOptTxt ?></a>
                        <a class="dropdown-item membSelect__item archive-opt<?= $archiveOptClass ?>" href="#"><?= $archiveOptTxt ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="member__body">
            <div class="member__title"><?= $userFullName ?></div>
            <div class="member__info">
                <div class="member__bTxt">
                    <?php if (!empty($startDate) && !empty($endDate)) { ?>
                        <span><?= __('Du') ?> <?= $startDate->format('d-m-Y'); ?> <?= strtolower(__('Au')) ?> <?= $endDate->format('d-m-Y'); ?></span>
                        <span class="member-info-ic" >.</span>
                    <?php } ?>
                    <span><?= $msg['L']['name'] ?></span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>