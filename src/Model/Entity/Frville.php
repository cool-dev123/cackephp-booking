<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Frville Entity
 *
 * @property int $id
 * @property string $name
 * @property int $departement_id
 * @property int $code_postal
 * @property int $code_insee
 *
 * @property \App\Model\Entity\Departement $departement
 */
class Frville extends Entity
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
        'departement_id' => true,
        'code_postal' => true,
        'code_insee' => true,
        'departement' => true
    ];
}
