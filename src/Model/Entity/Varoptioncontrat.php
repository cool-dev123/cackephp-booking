<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Varoptioncontrat Entity
 *
 * @property int $id
 * @property int $contrat_id
 * @property string $variable_valeur
 * @property int $option_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Contrat $contrat
 * @property \App\Model\Entity\Option $option
 */
class Varoptioncontrat extends Entity
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
        'variable_valeur' => true,
        'option_id' => true,
        'created' => true,
        'modified' => true,
        'contrat' => true,
        'option' => true
    ];
}
