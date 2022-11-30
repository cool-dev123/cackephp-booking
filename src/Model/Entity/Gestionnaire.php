<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Gestionnaire Entity.
 *
 * @property int $id
 * @property string $role
 * @property string $name
 * @property string $login
 * @property string $password
 * @property string $telephone
 * @property string $email
 * @property string $code_postal
 * @property string $ville
 * @property string $adresse
 * @property string $num_tva
 * @property string $forme_juridique
 * @property string $capital_social
 * @property int $commission_maint
 * @property int $commission_sejour
 * @property int $commission_relation
 */
class Gestionnaire extends Entity
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

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
