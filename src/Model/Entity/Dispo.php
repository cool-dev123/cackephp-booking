<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dispo Entity.
 *
 * @property int $id
 * @property int $annonce_id
 * @property \App\Model\Entity\Annonce $annonce
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 * @property \Cake\I18n\Time $dbt_at
 * @property \Cake\I18n\Time $fin_at
 * @property float $prix
 * @property int $statut
 * @property int $utilisateur_id
 * @property \App\Model\Entity\Utilisateur $utilisateur
 * @property int $promo_yn
 * @property int $reservation_id
 * @property \App\Model\Entity\Reservation $reservation
 * @property float $promo_px
 */
class Dispo extends Entity
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
