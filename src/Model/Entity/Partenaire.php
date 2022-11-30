<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Partenaire Entity
 *
 * @property int $id
 * @property int $lieugeo_id
 * @property int $part_code
 * @property int $part_id
 * @property string $type
 * @property string $type2
 * @property string $type3
 * @property string $type4
 * @property string $type5
 * @property \Cake\I18n\FrozenDate $date_creation
 * @property string $aContacter
 * @property string $langue
 * @property string $lat
 * @property string $lng
 * @property string $forme_juridique
 * @property string $raison_sociale
 * @property string $genre
 * @property string $nom
 * @property string $prenom
 * @property string $fonction
 * @property string $adresse
 * @property int $code_postal
 * @property int $ville_id
 * @property int $pays_id
 * @property string $tel
 * @property string $portable
 * @property string $fax
 * @property string $email
 * @property string $skype
 * @property string $ftp
 * @property string $url_adress
 * @property string $code_ape
 * @property string $siriet
 * @property float $capital
 * @property int $effectif
 * @property string $description
 *
 * @property \App\Model\Entity\Lieugeo $lieugeo
 * @property \App\Model\Entity\Part $part
 * @property \App\Model\Entity\Ville $ville
 * @property \App\Model\Entity\Pay $pay
 */
class Partenaire extends Entity
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
        '*' => true
    ];
}
