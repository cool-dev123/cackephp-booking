<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Annulation Entity
 *
 * @property int $id
 * @property string $name
 * @property int $interval_1
 * @property int $interval_2
 * @property int $service_pourc
 * @property int $reservation_pourc
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Annulation extends Entity
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
        'name' => true,
        'interval_1' => true,
        'interval_2' => true,
        'service_pourc' => true,
        'reservation_pourc' => true,
        'created' => true,
        'modified' => true
    ];
}
