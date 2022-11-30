<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Clic Entity.
 *
 * @property int $id
 * @property int $annonce_id
 * @property \App\Model\Entity\Annonce $annonce
 * @property \Cake\I18n\Time $clic_at
 * @property int $clic_nb
 */
class Clic extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
