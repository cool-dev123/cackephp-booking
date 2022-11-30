<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Annonce Entity.
 *
 * @property int $id
 * @property int $contrat
 * @property int $mise_relation
 * @property \Cake\I18n\Time $date_contrat
 * @property \Cake\I18n\Time $date_mise_relation
 * @property int $lits_nb
 * @property int $nb_etoiles
 * @property int $id_ville
 * @property int $proprietaire_id
 * @property \App\Model\Entity\Proprietaire $proprietaire
 * @property int $lieugeo_id
 * @property \App\Model\Entity\Lieugeo $lieugeo
 * @property int $statut
 * @property string $titre
 * @property string $num_app
 * @property string $nature
 * @property int $surface
 * @property int $pieces_nb
 * @property int $chambres_nb
 * @property int $personnes_nb
 * @property int $sdb_nb
 * @property int $wc_nb
 * @property int $wc_sep_nb
 * @property int $parking_yn
 * @property int $balcon_yn
 * @property int $terasse_yn
 * @property int $jardin_yn
 * @property int $c_montagne_yn
 * @property int $kmcomm_id
 * @property \App\Model\Entity\Kmcomm $kmcomm
 * @property int $kmcvil_id
 * @property \App\Model\Entity\Kmcvil $kmcvil
 * @property int $kmstat_id
 * @property \App\Model\Entity\Kmstat $kmstat
 * @property string $description
 * @property \Cake\I18n\Time $accept_at
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 * @property string $texte1
 * @property string $texte2
 * @property string $texte3
 * @property string $texte4
 * @property string $texte5
 * @property string $texte6
 * @property string $texte7
 * @property string $texte8
 * @property string $texte9
 * @property string $texte10
 * @property string $texte11
 * @property string $texte12
 * @property string $texte13
 * @property string $texte14
 * @property string $texte15
 * @property string $texte16
 * @property string $texte17
 * @property string $texte18
 * @property string $texte19
 * @property string $texte20
 * @property string $comment
 * @property int $ani_co_yn
 * @property int $ski_pied_yn
 * @property string $village
 * @property string $batiment
 * @property int $exposition
 * @property string $etage
 * @property int $ascenseur_yn
 * @property int $wifi
 * @property int $vue
 * @property int $parking_type
 * @property int $personne_reduite
 * @property int $non_fumeur
 * @property int $baignoire_nb
 * @property int $douche_nb
 * @property int $stationnement
 * @property int $parking_couvert
 * @property int $serv_acc_type
 * @property int $serv_linge_type
 * @property int $serv_drap_type
 * @property int $serv_serviett_type
 * @property int $serv_lit_fait_type
 * @property int $serv_menage_type
 * @property int $serv_entretien_type
 * @property int $serv_adap_type
 * @property int $serv_lit_bebe_type
 * @property int $serv_chaise_bebe_type
 * @property int $serv_chauffe_biberon_type
 * @property int $serv_ski
 * @property int $serv_garagist
 * @property int $serv_taxi
 * @property int $serv_babysetting
 * @property int $restaurant
 * @property int $velos
 * @property int $loc_ski
 * @property int $remontee_caisse
 * @property int $transport_public
 * @property int $bar
 * @property int $pub
 * @property int $Disco
 * @property int $ski_pied
 * @property int $cours_tennis
 * @property int $golf
 * @property int $piscine
 * @property int $squash
 * @property int $spa
 * @property int $hammam
 * @property int $sauna
 * @property int $jacuzzi
 * @property int $massage
 * @property int $luge
 * @property int $club_enfant
 * @property int $garderie
 * @property int $ecole_ski
 * @property int $lave_linge
 * @property int $seche_linge
 * @property int $Radiateur_seche
 * @property int $lave_vaissel_type
 * @property int $refrigerateur_top
 * @property int $micro_onde
 * @property int $multi_fonction
 * @property int $four
 * @property int $table_cuisson
 * @property int $cafetiere
 * @property int $grill_pain
 * @property int $bouilloire
 * @property int $autocuiseur
 * @property int $mixeur
 * @property int $raclette
 * @property int $aspirateur
 * @property int $pierrade
 * @property int $crepiere
 * @property int $fondue
 * @property int $wok
 * @property int $seche_cheveux
 * @property int $fer_repasser
 * @property int $table_repasser
 * @property int $tube_cathod
 * @property int $cable_sat
 * @property int $decodeur_canal
 * @property int $ecran_plat
 * @property int $tnt
 * @property int $decodeur_sky
 * @property int $ecran_plasma
 * @property int $chaine_etranger
 * @property int $dvd
 * @property int $cd
 * @property int $hifi
 * @property int $jeux_video
 * @property int $jeux_societe
 * @property int $placard
 * @property int $penderie
 * @property int $chaises
 * @property int $tabouret
 * @property int $literie_70
 * @property int $banquette_clic_130
 * @property int $banquette_bz_80
 * @property int $oreillers
 * @property int $couvertures
 * @property int $couettes
 * @property int $protege_matelas
 * @property int $robinetterie_mitig
 * @property int $baignoire_hydro
 * @property int $appart_hammam
 * @property int $appart_sauna
 * @property int $table_cuisson_feu
 * @property int $hotte
 * @property int $chauffage_elect
 * @property int $chauffage_gaz
 * @property int $chauffage_fuel
 * @property int $robinetterie_melang
 * @property int $banquette_bz_120
 * @property int $banquette_bz_140
 * @property int $banquette_bz_160
 * @property int $banquette_clic_140
 * @property int $literie_80
 * @property int $literie_90
 * @property int $literie_140
 * @property int $literie_160
 * @property int $literie_2_70
 * @property int $literie_sup_2_80
 * @property int $literie_rev
 * @property int $literie_cig
 * @property int $literie_peign
 * @property int $table_120
 * @property int $table_140
 * @property int $table_160
 * @property int $table_180
 * @property int $table_200
 * @property int $table_allonge
 * @property int $four_mini
 * @property int $refrigerateur_comp
 * @property int $refrigerateur_sup
 * @property int $lave_vaissel_4
 * @property int $lave_vaissel_8
 * @property int $lave_vaissel_12
 * @property int $cheminee
 * @property int $moins_50_piste
 * @property int $moins_50_sentiers
 * @property int $centre_comm
 * @property int $lieux_anim
 * @property int $espace_sportif
 * @property int $sentier_pedestre
 * @property int $bien_etre
 * @property int $espace_enfant
 * @property int $espace_plein_air
 * @property int $espace_piscine
 * @property string $adress
 * @property string $b_title
 * @property string $m_description
 * @property int $id_filemaker
 * @property \App\Model\Entity\Clic[] $clics
 * @property \App\Model\Entity\Contrat[] $contrats
 * @property \App\Model\Entity\Dispo[] $dispos
 * @property \App\Model\Entity\Photo[] $photos
 * @property \App\Model\Entity\Reservation[] $reservations
 * @property \App\Model\Entity\Selection[] $selections
 * @property int $sejour_flexible
 * @property int $proposerlastminute
 * @property int $delaislastminute
 * @property int $montantlastminute
 * @property int $proposerearlybooking
 * @property int $delaisearly
 * @property int $montantearlybooking
 * @property int $proposerlongsejours
 * @property int $delaislongsejours
 * @property int $montantlongsejours
 */
class Annonce extends Entity
{

    const WIFI_appartment = 1;
    const WIFI_gratuit = 2;
    const WIFI_payant = 4;

    protected $_virtual = ['wifi_appartment', 'wifi_gratuit', 'wifi_payant'];

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
	public function setPasswordLocation($login=null,$password=null,$email=null,$npassword=null)
    {
	    $ar=array('test'=>'test');
		return json_encode($ar);
	}
//wifi_appartment
    public function hasWifiAppartment(){
        return ($this->wifi & self::WIFI_appartment)?1:0;
    }
//wifi_gratuit
    public function hasWifiResidence(){
        return ($this->wifi & self::WIFI_gratuit)?1:0;
    }
//wifi_payant
    public function hasPaidWifi(){
        return ($this->wifi & self::WIFI_payant)?1:0;
    }

    protected function _getWifiAppartment() {
        return $this->hasWifiAppartment();
    }

    protected function _getWifiGratuit() {
        return $this->hasWifiResidence();
    }

    protected function _getWifiPayant() {
        return $this->hasPaidWifi();
    }
}
