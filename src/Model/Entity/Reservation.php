<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reservation Entity.
 *
 * @property int $id
 * @property int $annonce_id
 * @property \App\Model\Entity\Annonce $annonce
 * @property int $utilisateur_id
 * @property \App\Model\Entity\Utilisateur $utilisateur
 * @property \Cake\I18n\Time $dbt_at
 * @property \Cake\I18n\Time $fin_at
 * @property int $statut
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 * @property int $nb_enfants
 * @property int $nb_adultes
 * @property string $comment
 * @property int $taxe
 * @property int $menage
 * @property int $arrivee
 * @property int $p_cle
 * @property \App\Model\Entity\Dispo[] $dispos
 * @property \App\Model\Entity\Pack[] $packs
 */
class Reservation extends Entity
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
