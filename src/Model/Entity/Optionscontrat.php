<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Optionscontrat Entity
 *
 * @property int $id
 * @property string $titre
 * @property string $text
 * @property string $variables_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Variable $variable
 */
class Optionscontrat extends Entity
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
        'titre' => true,
        'text' => true,
        'variables_id' => true,
        'created' => true,
        'modified' => true,
        'variable' => true
    ];
}
