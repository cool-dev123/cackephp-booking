<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RemonteMecanique Entity
 *
 * @property int $id
 * @property int $lieugeo_id
 * @property string $nom
 * @property string $type
 * @property string $descreption
 * @property int $nbrpistes_verte
 * @property int $nbrpistes_bleu
 * @property int $nbrpistes_rouge
 * @property int $nbrpistes_noir
 * @property float $km_pistes
 *
 * @property \App\Model\Entity\Lieugeo $lieugeo
 */
class RemonteMecanique extends Entity
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
        '*' => true
    ];
}
