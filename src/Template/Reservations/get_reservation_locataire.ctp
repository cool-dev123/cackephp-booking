<?php
use Cake\I18n\Date;

$availableStatuses = [10,50,90,100,110];

if (!empty($reservation)) {
    if (in_array($reservation['statut'], $availableStatuses)) {
        $groups = [
            '50'      => ['txt' => __('En attente'), 'type' => 'pending'],
            '90'      => ['txt' => __('Confirmée'), 'type' => 'confirmed'],
            '90_past' => ['txt' => __('Passée'), 'type' => 'past'],
            '100'     => ['txt' => __('Annulée'), 'type' => 'canceled']
        ];

        $group       = $groups[$reservation['statut']];
        $currentDate = new Date();
        $endDate     = new Date($reservation['fin_at']);

        switch ($reservation['statut']) {
            case 90:
                if ($currentDate > new Date($endDate)) {
                    $group = $groups['90_past'];
                }
                break;
            case 10:
            case 100:
            case 110:
                $group = $groups['100'];
                break;
        }


        echo $this->element('Reservations/Tenant/reservation_details', ['group' => $group]);
    } else {
        echo __('Mauvais statut');
    }
} else {
    echo __('Non réservation');
}
?>