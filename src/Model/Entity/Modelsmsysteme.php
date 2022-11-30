<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Modelsmsysteme Entity
 *
 * @property int $id
 * @property string $titre
 * @property string $txtsms
 * @property string $indication
 * @property string $destinataire
 * @property string $txtsmsEn
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Modelsmsysteme extends Entity
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
        'txtsms' => true,
        'indication' => true,
        'destinataire' => true,
        'txtsmsEn' => true,
        'created' => true,
        'modified' => true
    ];
}
