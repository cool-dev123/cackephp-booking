<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Utilisateur Entity.
 *
 * @property int $id
 * @property string $code_client
 * @property string $email
 * @property string $mot_passe
 * @property string $priv
 * @property string $civilite
 * @property string $prenom
 * @property string $nom_famille
 * @property string $societe
 * @property \Cake\I18n\Time $naissance
 * @property string $telephone
 * @property string $fax
 * @property string $portable
 * @property string $adresse
 * @property string $code_postal
 * @property string $ville
 * @property int $pays
 * @property int $cnil
 * @property int $newsletter
 * @property int $commercial
 * @property float $remise_percent
 * @property float $remise_valeur
 * @property int $points
 * @property string $format
 * @property string $message
 * @property string $siret
 * @property string $ape
 * @property string $code_banque
 * @property string $code_guichet
 * @property string $numero_compte
 * @property string $cle_rib
 * @property string $domiciliation
 * @property string $iban
 * @property string $bic
 * @property string $url
 * @property string $description
 * @property string $message_client
 * @property \Cake\I18n\Time $date_insert
 * @property \Cake\I18n\Time $date_update
 * @property string $alerte
 * @property string $nom_utilisateur
 * @property string $region
 * @property string $ident
 * @property string $pwd
 * @property int $avoir
 * @property string $statut_coupon
 * @property string $type
 * @property int $etat
 * @property int $id_parrain
 * @property int $id_groupe
 * @property string $adr2
 * @property string $adr3
 * @property string $nature
 * @property \Cake\I18n\Time $accept_at
 * @property int $prof_yn
 * @property \Cake\I18n\Time $valide_at
 * @property int $statut
 * @property int $info_cle_yn
 * @property int $info_ctt_yn
 * @property int $offres_promo_yn
 * @property int $club_alpissime
 * @property int $sms
 */
class Utilisateur extends Entity
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

    protected function _setPassword($value) {
        return (new DefaultPasswordHasher)->hash($value);
    }

    public function getNature(){
        return $this->nature=='CLT'?'Locataire':'Propriétaire';
    }

}
