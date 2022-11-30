<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Behavior\Translate\TranslateTrait;

/**
 * Lieugeo Entity
 *
 * @property \App\Model\Entity\Lieugeo $parent_lieugeo
 * @property \App\Model\Entity\Annonce[] $annonces
 * @property \App\Model\Entity\Lieugeo[] $child_lieugeos
 */
class Lieugeo extends Entity
{
    use TranslateTrait;
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
        '*' => true
    ];
}
