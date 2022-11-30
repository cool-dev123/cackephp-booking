<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BlocServicesMail Entity
 *
 * @property int $id
 * @property string $bloc_services_mail
 * @property string $liste_id_gestionnaire
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class BlocServicesMail extends Entity
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
        'bloc_services_mail' => true,
        'bloc_services_mail_en' => true,
        'liste_id_station' => true,
        'created' => true,
        'modified' => true
    ];
}
