<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DatesOptionContrat Entity
 *
 * @property int $id
 * @property int $contrat_id
 * @property int $option_id
 * @property string $dates
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Contrat $contrat
 * @property \App\Model\Entity\Option $option
 */
class DatesOptionContrat extends Entity
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
        'contrat_id' => true,
        'option_id' => true,
        'dates' => true,
        'created' => true,
        'modified' => true,
        'contrat' => true,
        'option' => true
    ];
}
