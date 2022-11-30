<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reponsecontactprop Entity
 *
 * @property int $id
 * @property int $contactprops_id
 * @property string $message
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Contactprop $contactprop
 */
class Reponsecontactprop extends Entity
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
        'contactprops_id' => true,
        'message' => true,
        'created' => true,
        'modified' => true,
        'contactprop' => true
    ];
}
