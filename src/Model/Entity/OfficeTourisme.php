<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OfficeTourisme Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $lien
 * @property string $code_postale
 * @property string $adresse
 * @property string $latitude
 * @property string $longitude
 * @property int $lieugeo_id
 * @property int $categorie_office_id
 *
 * @property \App\Model\Entity\CategorieOffice $categorie_office
 */
class OfficeTourisme extends Entity
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
    /**
     * function to get formatted gategorie
     */
    public function getCategorie(){
        switch ($this->categorie) {
            case 1:
                return 'Catégorie I';
                break;
            case 2:
                return 'Catégorie II';
                break;
            case 3:
                return 'Catégorie III';
                break;
            default:
                return '';
                break;
        }
    }
}
