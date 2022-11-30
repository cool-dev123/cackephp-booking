<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pack Entity.
 *
 * @property int $id
 * @property string $titre
 * @property float $cout
 * @property int $actif_yn
 * @property string $comment
 * @property \App\Model\Entity\Reservation[] $reservations
 */
class Pack extends Entity
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
