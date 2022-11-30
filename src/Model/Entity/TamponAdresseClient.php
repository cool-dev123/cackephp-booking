<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TamponAdresseClient Entity
 *
 * @property int $id
 * @property int $client_id_loc
 * @property string $suffix
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $vat_number
 * @property string $phone_shipping
 * @property string $fax_shipping
 * @property string $country_shipping
 * @property string $postcode_shipping
 * @property string $city_shipping
 * @property string $company_shipping
 * @property string $region_shipping
 * @property string $street_shipping
 * @property string $phone_biling
 * @property string $fax_biling
 * @property string $country_biling
 * @property string $postcode_biling
 * @property string $city_biling
 * @property string $company_biling
 * @property string $region_biling
 * @property string $street_biling
 * @property int $source
 * @property int $is_sync
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $sync_at
 */
class TamponAdresseClient extends Entity
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
        'client_id_loc' => true,
        'suffix' => true,
        'firstname' => true,
        'lastname' => true,
        'middlename' => true,
        'vat_number' => true,
        'phone_shipping' => true,
        'fax_shipping' => true,
        'country_shipping' => true,
        'postcode_shipping' => true,
        'city_shipping' => true,
        'company_shipping' => true,
        'region_shipping' => true,
        'street_shipping' => true,
        'phone_biling' => true,
        'fax_biling' => true,
        'country_biling' => true,
        'postcode_biling' => true,
        'city_biling' => true,
        'company_biling' => true,
        'region_biling' => true,
        'street_biling' => true,
        'source' => true,
        'is_sync' => true,
        'created_at' => true,
        'sync_at' => true
    ];
}
