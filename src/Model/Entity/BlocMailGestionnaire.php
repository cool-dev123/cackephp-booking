<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BlocMailGestionnaire Entity
 *
 * @property int $id
 * @property int $gestionnaire_id
 * @property string $bloc_info_arrivee
 * @property string $bloc_info_depart
 * @property string $bloc_info_horaires
 * @property string $bloc_service_proprietaire
 * @property string $bloc_menage_depart
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Gestionnaire $gestionnaire
 */
class BlocMailGestionnaire extends Entity
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
        'gestionnaire_id' => true,
        'bloc_info_arrivee' => true,
        'bloc_info_arrivee_en' => true,
        'bloc_info_depart' => true,
        'bloc_info_depart_en' => true,
        'bloc_info_horaires' => true,
        'bloc_info_horaires_en' => true,
        'bloc_service_proprietaire' => true,
        'bloc_service_proprietaire_en' => true,
        'bloc_menage_depart' => true,
        'bloc_menage_depart_en' => true,
        'created' => true,
        'modified' => true,
        'gestionnaire' => true
    ];
}
