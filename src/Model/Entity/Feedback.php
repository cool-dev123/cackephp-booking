<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Feedback Entity.
 *
 * @property int $id * @property string $titre * @property string $commentaire * @property int $annonce_id * @property \App\Model\Entity\Annonce $annonce * @property int $utilisateur_id * @property \App\Model\Entity\Utilisateur $utilisateur * @property \Cake\I18n\Time $created * @property \Cake\I18n\Time $modified * @property \App\Model\Entity\Rating[] $ratings */
class Feedback extends Entity
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
