<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Calendarsynchro Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $url
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Dispo[] $dispos
 * @property \App\Model\Entity\Reservation[] $reservations
 */
class Calendarsynchro extends Entity
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
        'nom' => true,
        'url' => true,
        'created' => true,
        'modified' => true,
        'annonce_id' => true,
        'actif' => true,
        'dispos' => true,
        'reservations' => true
    ];
}
