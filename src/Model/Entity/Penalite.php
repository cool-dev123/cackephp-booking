<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Penalite Entity
 *
 * @property int $id
 * @property int $utilisateur_id
 * @property int $reservation_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $nbr_penalite
 *
 * @property \App\Model\Entity\Utilisateur $utilisateur
 * @property \App\Model\Entity\Reservation $reservation
 */
class Penalite extends Entity
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
        'utilisateur_id' => true,
        'reservation_id' => true,
        'created' => true,
        'modified' => true,
        'nbr_penalite' => true,
        'utilisateur' => true,
        'reservation' => true
    ];
}
