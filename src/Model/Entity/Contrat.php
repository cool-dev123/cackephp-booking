<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contrat Entity.
 *
 * @property int $id
 * @property int $annonce_id
 * @property \App\Model\Entity\Annonce $annonce
 * @property int $type
 * @property \Cake\I18n\Time $date_create
 * @property \Cake\I18n\Time $date_rappel
 * @property \Cake\I18n\Time $date_echeance
 * @property int $taxe
 * @property int $visible
 * @property float $prix
 */
class Contrat extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
