<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AnnulationReservation Entity
 *
 * @property int $id
 * @property int $justificatif
 * @property string $motif_annulation
 * @property string $file
 * @property string $commentaire
 * @property int $reservation_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Reservation $reservation
 */
class AnnulationReservation extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'justificatif' => true,
        'motif_annulation' => true,
        'file' => true,
        'commentaire' => true,
        'reservation_id' => true,
        'created' => true,
        'modified' => true,
        'reservation' => true,
        'statut' => true,
        'montant_rembourser' => true,
        'annulationpar' => true
    ];
}
