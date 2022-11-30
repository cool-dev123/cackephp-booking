<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PrixContrat Entity
 *
 * @property int $id
 * @property int $contrat_id
 * @property float $prix
 * @property \Cake\I18n\FrozenDate $date_create
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Contrat $contrat
 */
class PrixContrat extends Entity
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
        'prix' => true,
        'date_create' => true,
        'created' => true,
        'modified' => true,
        'contrat' => true
    ];
}
