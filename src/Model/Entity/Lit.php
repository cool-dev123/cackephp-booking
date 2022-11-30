<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lit Entity
 *
 * @property int $id
 * @property int $meublesClasses
 * @property int $rtClassesNon
 * @property int $hotels
 * @property int $litsCamping
 * @property int $litsDivers
 * @property int $litsRefuges
 * @property int $clesVacancesGites
 * @property int $anne
 * @property int $lieugeo_id
 *
 * @property \App\Model\Entity\Lieugeo $lieugeo
 */
class Lit extends Entity
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
        'meublesClasses' => true,
        'rtClassesNon' => true,
        'hotels' => true,
        'litsCamping' => true,
        'litsDivers' => true,
        'litsRefuges' => true,
        'clesVacancesGites' => true,
        'anne' => true,
        'lieugeo_id' => true,
        'lieugeo' => true
    ];
}
