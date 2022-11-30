<?php
namespace App\Model\Table;

use App\Model\Entity\Utilisateur;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
/**
 * Utilisateurs Model
 *
 */
class UtilisateursTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('utilisateurs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Informationbancaires', [
          'foreignKey' => 'informationbancaire_id',
          'joinType' => 'LEFT'
        ]);

        $this->hasMany('Annonces', [
          'foreignKey' => 'proprietaire_id'
        ]);

        $this->belongsToMany('Cautions', [
          'joinTable' => 'utilisateurs_cautions',
          'foreignKey'=>'utilisateur_id',
          'targetForeignKey'=> 'caution_id'
        ]);

        $this->belongsToMany('Paiements', [
          'joinTable' => 'utilisateurs_paiements',
          'foreignKey'=>'utilisateur_id',
          'targetForeignKey'=> 'paiement_id'
        ]);

        $this->belongsToMany('Annulations', [
          'joinTable' => 'utilisateurs_annulations',
          'foreignKey'=>'utilisateur_id',
          'targetForeignKey'=> 'annulation_id'
        ]);
        
    }
    /**
     *
     **/
	function get_json_user($url,$get)
    {
			$utilCount=$this->find();
      $utilCount->join([
              'PV' => [
                'table' => 'pvilles',
                'type' => 'left',
                'conditions' => ['Utilisateurs.ville=PV.id'],
              ],
              'P' => [
                  'table' => 'pays',
                  'type' => 'left',
                  'conditions' => ['Utilisateurs.pays=P.id_pays'],
              ]
            ]);
			$util = $this->find();
      $util->join([
              'PV' => [
                'table' => 'pvilles',
                'type' => 'left',
                'conditions' => ['Utilisateurs.ville=PV.id'],
              ],
              'P' => [
                  'table' => 'pays',
                  'type' => 'left',
                  'conditions' => ['Utilisateurs.pays=P.id_pays'],
              ]
            ]);
			$util->select(['Utilisateurs.valide_at', 'PV.name','Utilisateurs.id', 'Utilisateurs.nom_famille','Utilisateurs.nature', 'Utilisateurs.prenom', 'Utilisateurs.email','Utilisateurs.telephone', 'Utilisateurs.portable', 'Utilisateurs.code_postal','Utilisateurs.ville','Utilisateurs.pays']);
			$utilCount->select(['nbr' => $utilCount->func()->count('*')]);
			$count=$utilCount->first();
      $output = array(
                  "sEcho" => intval($get['sEcho']),
                  "iTotalRecords" => $count["nbr"],
                  "iTotalDisplayRecords" => $count["nbr"],
                  "nbProps" => 0,
                  "nbLocs" => 0,
                  "data" => array()
                  );
      foreach($util as $c)
      {
        $row = array();
        $row[0]=$c->prenom;
        $row[1]=$c->nom_famille;
				if($c->nature=='CLT')
                                {
					$row[2]="<span class='label label-warning'>Locataire</span>";
                                        $output['nbLocs']++;
                                }
        else if($c->nature=='PRES'){
          $row[2]="<span class='label label-info'>Propriétaire Résidence</span>";
          $output['nbProps']++;
        }
				else
                                {
					$row[2]="<span class='label label-success'>Propriétaire</span>";
                                        $output['nbProps']++;
                                }
        $row[3]=$c->valide_at!=null?"<center><span class='label label-success'>OUI</span></center>":"<center><button class='label label-danger' onclick='validermailuser(".$c->id.")'>NON</button></center>";
        $row[4]="<center>".$c->email."</center>";
        $row[5]=$this->getFormatFrenchPhoneNumber($c->portable,true);
        $row[6]=$this->getFormatFrenchPhoneNumber($c->telephone,true);
        $row[7]=$c->code_postal;
        
        if($c->pays == 67){            
            $frville = TableRegistry::get('Frvilles');
            $paysutilis = $frville->find()->where(['id' => $c->ville])->first();     
            $row[8]=$paysutilis->name;
        }else{
            $row[8]=$c['PV']['name'];
        }        
       
        $row[9]="<button class=\"btn btn-sm btn-default btn-icon-anim btn-circle edite_station\" onclick=\"edite(".$c->id.")\" data-prenom=\"".$c->prenom."\" data-toggle=\"modal\" data-target=\"#myModal\" ><i class=\"fa fa-pencil\"></i></button>"
                ."<button class=\"ml-10 btn btn-sm btn-info btn-icon-anim btn-circle delete_station\" data-name=\"".$c->prenom."\" data-key=\"".$c->id."\" ><i class=\"icon-trash\"></i></button>";
        $output['data'][] = $row;
      }
    return  $output ;
  }
  /**
   *
   **/
  function arrayutilisateurspdf($id){
    $util = $this->find();
    $util->join([
      'Annonce' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Utilisateurs.id = Annonce.proprietaire_id','Annonce.id_gestionnaires'=>$id]
      ],
      'Village' => [
        'table' => 'villages',
        'type' => 'inner',
        'conditions' => ['Village.id=Annonce.village']
      ],
      // 'AG' => [
      //         'table' => 'annoncegestionnaires',
      //         'type' => 'inner',
      //         'conditions' => ["Annonce.id=AG.id_annonces","AG.id_gestionnaires='".$id."'"],
      // ]
        'PV' => [
          'table' => 'pvilles',
          'type' => 'left',
          'conditions' => ['Utilisateurs.ville=PV.id'],
        ],
        'P' => [
            'table' => 'pays',
            'type' => 'left',
            'conditions' => ['Utilisateurs.pays=P.id_pays'],
        ]
      ]);
    $util->select(['PV.name','Utilisateurs.id', 'Utilisateurs.prenom', 'Utilisateurs.nom_famille', 'Utilisateurs.email', 'Utilisateurs.portable', 'Utilisateurs.code_postal', 'Utilisateurs.ville', 'Utilisateurs.pays']);
    $util->group(['Utilisateurs.id']);
    $output = array(
      "data" => array()
      );
    foreach($util as $c)
    {
        $row = array();
        $row[0]="<div class='text-center'><div class=\"checkbox\"><input id=\"locataire_$c->id\" data-id=\"$c->id\" type=\"checkbox\"><label></label></div></div>";
        $row[1]=$c->prenom;
        $row[2]=$c->nom_famille;
        $row[3]=$c->portable;
        $row[4]=$c->email;
        $row[5]=$c->code_postal;
        if($c->pays == 67){            
            $frville = TableRegistry::get('Frvilles');
            $paysutilis = $frville->find()->where(['id' => $c->ville])->first();     
            $row[6]=$paysutilis->name;
        }else{
            $row[6]=$c['PV']['name'];
        }   
        
        $output['data'][] = $row;
    }
    return  $output ;
  }
  /**
   * 
   */
  function getFormatFrenchPhoneNumber($phoneNumber, $international = false){
    //Supprimer tous les caractères qui ne sont pas des chiffres
    $phoneNumber = preg_replace('/[^0-9]+/', '', $phoneNumber);
    //On commence par traiter les cas des numéros en france
    $returnValue = preg_match('#^(33|0033)[0-9]{9}$#', $phoneNumber);
    $value = preg_match('#^(06)[0-9]{8}$#', $phoneNumber);
    $valueFR = preg_match('#^(073|074|075|076|077|078|079)[0-9]{7}$#', $phoneNumber);
    $returnValueBelge = preg_match('/^((32|0032)\s?|0)4(60|[56789]\d)(\s?\d{2}){3}$/', $phoneNumber);
    $returnValueUK = preg_match('#^(44|0044)[0-9]{10}$#', $phoneNumber);
    $valueUK = preg_match('#^(07|7)[0-9]{9}$#', $phoneNumber);
    $returnValueES = preg_match('#^(34|0034)[0-9]{9}$#', $phoneNumber);
    $valueES = preg_match('#^(6)[0-9]{8}$#', $phoneNumber);
    $returnValueRU = preg_match('#^(7|007)[0-9]{10}$#', $phoneNumber);
    $valueRU = preg_match('#^(4|8|9)[0-9]{9}$#', $phoneNumber);
    $returnValueLUX = preg_match('#^(352|00352)[0-9]{9}$#', $phoneNumber);
    $returnValueAL = preg_match('#^(49|0049)[0-9]{11}$#', $phoneNumber);
    $valueAL = preg_match('#^(15|16|17|015|016|017)[0-9]{9}$#', $phoneNumber);
    $returnValuePB = preg_match('#^(31|0031)[0-9]{9}$#', $phoneNumber);
    $valuePAB = preg_match('#^(03|3|01|1|04|4|05|5)[0-9]{8}$#', $phoneNumber);
    $valuePB = preg_match('#^(071|71|070|70|072|72)[0-9]{7}$#', $phoneNumber);
    $returnValueSUI = preg_match('#^(41|0041)[0-9]{9}$#', $phoneNumber);
    $returnValueSUED = preg_match('#^(46|0046)[0-9]{9}$#', $phoneNumber);
    $returnValueDANEM = preg_match('#^(45|0045)[0-9]{8}$#', $phoneNumber);
    if(($returnValue == 1) || ($value == 1) || ($valueFR == 1)){
      //On l'ecrit sous la forme +33(9chiffres)
      $phoneNumber = substr($phoneNumber, -9);
      $motif = $international ? '+33\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+33";
      $phoneNumber = str_replace("+33", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif ($returnValueBelge == 1) {
      //On traite les cas des numéro en belgique
      $phoneNumber = substr($phoneNumber, -9);
      $motif = $international ? '+32\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+32";
      $phoneNumber = str_replace("+32", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif (($returnValueUK == 1) || ($valueUK == 1)) {
      //On traite les cas des numéro en UK
      $phoneNumber = substr($phoneNumber, -10);
      $motif = $international ? '+44\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+44";
      $phoneNumber = str_replace("+44", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif (($returnValueES == 1) || ($valueES == 1)) {
      //On traite les cas des numéro en espagne
      $phoneNumber = substr($phoneNumber, -9);
      $motif = $international ? '+34\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+34";
      $phoneNumber = str_replace("+34", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif (($returnValueRU == 1) || ($valueRU == 1)) {
      //On traite les cas des numéro en russie
      $phoneNumber = substr($phoneNumber, -10);
      $motif = $international ? '+7\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+7";
      $phoneNumber = str_replace("+7", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif ($returnValueLUX == 1) {
      //On traite les cas des numéro en luxembourg
      $phoneNumber = substr($phoneNumber, -9);
      $motif = $international ? '+352\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+352";
      $phoneNumber = str_replace("+352", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif (($returnValueAL == 1) || ($valueAL == 1)) {
      //On traite les cas des numéro en allemagne
      $phoneNumber = substr($phoneNumber, -11);
      $motif = $international ? '+49\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+49";
      $phoneNumber = str_replace("+49", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif (($returnValuePB == 1) || ($valuePAB == 1) || ($valuePB == 1)) {
      //On traite les cas des numéro en pays-bas
      $phoneNumber = substr($phoneNumber, -9);
      $motif = $international ? '+31\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+31";
      $phoneNumber = str_replace("+31", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif ($returnValueSUI == 1) {
      //On traite les cas des numéro en suisse
      $phoneNumber = substr($phoneNumber, -9);
      $motif = $international ? '+41\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+41";
      $phoneNumber = str_replace("+41", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif ($returnValueSUED == 1){
      //On traite les cas des numéro en suède
      $phoneNumber = substr($phoneNumber, -9);
      $motif = $international ? '+46\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+46";
      $phoneNumber = str_replace("+46", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }elseif ($returnValueDANEM == 1) {
      //On traite les cas des numéro en danemark
      $phoneNumber = substr($phoneNumber, -8);
      $motif = $international ? '+45\1\2\3\4\5' : '0\1\2\3\4\5';
      $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
      $finalPort = "+45";
      $phoneNumber = str_replace("+45", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }else{
      $finalPort = "";
      $phoneNumber = str_replace(".", "", $phoneNumber); 
      if(strlen($phoneNumber) % 2 == 0) $finalPort .= " ".wordwrap($phoneNumber,2," ",1);
      else $finalPort .= " ".wordwrap("0".$phoneNumber,2," ",1);
      return $finalPort;
    }
  }
  /**
   *
   **/
  function get_json_user_gestionnaire($url,$get,$id)
    {
      $utilProp = $this->find();
        $utilProp->join([
          'Annonce' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['Utilisateurs.id = Annonce.proprietaire_id','Annonce.id_gestionnaires'=>$id],
          ],
          'Contrat' => [
            'table' => 'contrats',
            'type' => 'inner',
            'conditions' => ['Contrat.annonce_id=Annonce.id','Contrat.visible'=>1]
          ],
          'PV' => [
            'table' => 'pvilles',
            'type' => 'left',
            'conditions' => ['Utilisateurs.ville=PV.id'],
          ],
          'P' => [
              'table' => 'pays',
              'type' => 'left',
              'conditions' => ['Utilisateurs.pays=P.id_pays'],
          ]
        ]);
  			$utilProp->select(['Utilisateurs.valide_at', 'PV.name','P.fr','Utilisateurs.id', 'Utilisateurs.nom_famille','Utilisateurs.nature', 'Utilisateurs.prenom', 'Utilisateurs.email','Utilisateurs.telephone', 'Utilisateurs.portable', 'Utilisateurs.code_postal','Utilisateurs.ville','Utilisateurs.pays']);
  			
        $utilProp->group(['Utilisateurs.id']);

        $utilLoc = $this->find()
        ->join([
          'Annonce' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['Annonce.id_gestionnaires'=>$id],
          ],
          'Res' => [
            'table' => 'reservations',
            'type' => 'inner',
            'conditions' => ['Annonce.id = Res.annonce_id','Res.utilisateur_id=Utilisateurs.id'],
          ],
          'Contrat' => [
            'table' => 'contrats',
            'type' => 'inner',
            'conditions' => ['Contrat.annonce_id=Annonce.id','Contrat.visible'=>1]
          ],
          'PV' => [
            'table' => 'pvilles',
            'type' => 'left',
            'conditions' => ['Utilisateurs.ville=PV.id'],
          ],
          'P' => [
              'table' => 'pays',
              'type' => 'left',
              'conditions' => ['Utilisateurs.pays=P.id_pays'],
          ]
        ]);

        $utilLoc->select(['Utilisateurs.valide_at', 'PV.name','P.fr','Utilisateurs.id', 'Utilisateurs.nom_famille','Utilisateurs.nature', 'Utilisateurs.prenom', 'Utilisateurs.email','Utilisateurs.telephone', 'Utilisateurs.portable', 'Utilisateurs.code_postal','Utilisateurs.ville','Utilisateurs.pays']);
  			
        $utilLoc->group(['Utilisateurs.id']);

        $util=$utilLoc->union($utilProp);
  			
        $output = array(
                    "iTotalRecords" => 0,
                    "data" => array()
                    );
        foreach($util as $c)
        {
          $row = array();
          $row[0]=$c->prenom;
          $row[1]=$c->nom_famille;
          $row[2]=$c->getNature();
          $row[3]=$c->valide_at!=null?"<center><span class='label label-success'>OUI</span></center>":"<center><button class='label label-danger' onclick='validermailuser(".$c->id.")'>NON</button></center>";
          $row[4]=$c->email;
          $row[5]=$this->getFormatFrenchPhoneNumber($c->portable,true);
          $row[6]=$this->getFormatFrenchPhoneNumber($c->telephone,true);
            $row[7]=$c->code_postal;
            if($c->pays == 67){
            $frville = TableRegistry::get('Frvilles');
            $paysutilis = $frville->find()->where(['id' => $c->ville])->first();     
            $row[8]=$paysutilis->name;
        }else{
            $row[8]=$c['PV']['name'];
        }               
          $row[9]="<center>"
                  . "<button class=\"btn btn-sm btn-default btn-icon-anim btn-circle edite_station\" onclick=\"edite(".$c->id.")\" data-prenom=\"".$c->prenom."\" data-toggle=\"modal\" data-target=\"#myModal\" ><i class=\"fa fa-pencil\"></i></button>"
                  . "<button class=\"btn btn-sm btn-info btn-icon-anim btn-circle delete_station\" data-name=\"".$c->prenom."\" data-key=\"".$c->id."\" ><i class=\"icon-trash\"></i></button>"
                  . "</center>";
          $output['data'][] = $row;
          $output['iTotalRecords']+=$c->getNature()=='Propriétaire'?1:0;
        }
      return  $output ;
    }
    /**
     *
     **/
	function get_array_utilisateur($url,$get)
    {
      $aColumns = array( 'Utilisateurs.id','Annonce.id_filemaker','Annonce.id','Utilisateurs.nom_famille', 'Utilisateurs.prenom', 'Annonce.contrat','Annonce.mise_relation' );
      $sOrder = array();
      if ( isset( $get['iSortCol_0'] ) )
      {
          for ( $i=0 ; $i<intval($get['iSortingCols'] ) ; $i++ )
          {
              if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" )
              {
                  $sOrder[$i]= $aColumns[ intval( $get['iSortCol_'.$i] ) ]." ".$get['sSortDir_'.$i];
              }
          }
      }
      $orWhere = array();
      if ( isset($get['sSearch']) && $get['sSearch'] != "" )
      {
          for ( $i=0 ; $i<count($aColumns) ; $i++ )
          {
              $orWhere[$i]= "LOWER(".$aColumns[$i].") LIKE '%". strtolower($get['sSearch'])."%'";
          }
      }
			$awhere=array();
      for ( $i=0 ; $i<count($aColumns) ; $i++ )
      {
          if ( isset($get['bSearchable_'.$i]) && $get['bSearchable_'.$i] == "true" && $get['sSearch_'.$i] != '' )
          {
              $awhere[$i]= $aColumns[$i]." LIKE '%".$get['sSearch_'.$i]."%'";
          }
      }
			$utilCount=$this->find();
			$util = $this->find();
			$util->join([
							'Annonce' => [
								'table' => 'annonces',
								'type' => 'inner',
								'conditions' => 'Utilisateurs.id = Annonce.proprietaire_id',
							]])
						->select(['Utilisateurs.id', 'Utilisateurs.nom_famille', 'Utilisateurs.prenom', 'Utilisateurs.email','Annonce.id_filemaker', 'Annonce.id', 'Annonce.contrat','Annonce.mise_relation']);
			$utilCount->join([
							'Annonce' => [
								'table' => 'annonces',
								'type' => 'inner',
								'conditions' => 'Utilisateurs.id = Annonce.proprietaire_id',
							]])
						->select(['nbr' => $utilCount->func()->count('*')]);
			if(!empty($orWhere)){
				$util->where([$awhere,"OR"=>$orWhere]);
				$utilCount->where([$awhere,"OR"=>$orWhere]);
			}
			$start=1;
			if($get['iDisplayStart']>0){
				$start=($get['iDisplayStart']/$get['iDisplayLength'])+1;
			}
			$util->order($sOrder);
//				 ->limit($get['iDisplayLength'])
//				 ->page($start);
			$count=$utilCount->first();
      $output = array(
                  "sEcho" => intval($get['sEcho']),
                  "iTotalRecords" => $count["nbr"],
                  "iTotalDisplayRecords" => $count["nbr"],
                  "data" => array()
                  );
      $i=0;
      foreach($util as $res)
      {
        $row = array();
        $img="";
        $fin="";
        $row[0]=$res->id;
				if(empty($res['Annonce']['id_filemaker'])){
                                   $row[1]= $res['Annonce']['id_filemaker'];
					//$row[1]="<span class='".$res['Annonce']['id']."'><img style='cursor:pointer' onclick='open_dialog(\"".$res['Annonce']['id']."\")' src='".$url."images/plusalp.png' id='filemaker_".$res['Annonce']['id']."' /></span>";
				}else{
                                    $row[1]= $res['Annonce']['id_filemaker'];
					//$row[1]="<span class='".$res['Annonce']['id']."'>".$res['Annonce']['id_filemaker']."<img style='cursor:pointer' onclick='open_dialog_edit(\"".$res['Annonce']['id_filemaker']."\",\"".$res['Annonce']['id']."\")' src='".$url."images/plusalp.png' id='filemaker_".$res['Annonce']['id']."' /></span>";
				}
				$row[2]=$res['Annonce']['id'];
        $row[3]=$res->nom_famille;
        $row[4]=$res->prenom;
				if($res['Annonce']['contrat']){
					$fin="<a onclick='activate(\"".$res['Annonce']['id']."\")' class=\"check-circle\" style='cursor:pointer' id='coeur_".$res['Annonce']['id']."'><i class=\"fa fa-check-circle\"></i></a>";
				}else{
					$fin="<a onclick='activate(\"".$res['Annonce']['id']."\")' class=\"exclamation-circle\" style='cursor:pointer' id='coeur_".$res['Annonce']['id']."'><i class=\"fa fa-exclamation-circle\"></i></a>";
				}
        $row[5]=$fin;
				if($res['Annonce']['mise_relation']){
					$fin2="<a onclick='activate_relation(\"".$res['Annonce']['id']."\")' class=\"check-circle\" style='cursor:pointer' id='coeur_re_".$res['Annonce']['id']."'><i class=\"fa fa-check-circle\"></i></a>";
				}else{
					$fin2="<a onclick='activate_relation(\"".$res['Annonce']['id']."\")' class=\"exclamation-circle\" style='cursor:pointer' id='coeur_re_".$res['Annonce']['id']."'><i class=\"fa fa-exclamation-circle\"></i></a>";
				}
				$row[6]=$fin2;
        $output['data'][] = $row;
      }
    return  $output ;
  }
  
  
  	function get_array_contrats_disabled($url,$get)
    {
      $aColumns = array( 'Utilisateurs.id','Annonce.id_filemaker','Annonce.id','Utilisateurs.nom_famille', 'Utilisateurs.prenom', 'Annonce.contrat','Annonce.mise_relation' );
      $sOrder = array();
      if ( isset( $get['iSortCol_0'] ) )
      {
          for ( $i=0 ; $i<intval($get['iSortingCols'] ) ; $i++ )
          {
              if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" )
              {
                  $sOrder[$i]= $aColumns[ intval( $get['iSortCol_'.$i] ) ]." ".$get['sSortDir_'.$i];
              }
          }
      }
      $orWhere = array();
      if ( isset($get['sSearch']) && $get['sSearch'] != "" )
      {
          for ( $i=0 ; $i<count($aColumns) ; $i++ )
          {
              $orWhere[$i]= "LOWER(".$aColumns[$i].") LIKE '%". strtolower($get['sSearch'])."%'";
          }
      }
			$awhere=array();
      for ( $i=0 ; $i<count($aColumns) ; $i++ )
      {
          if ( isset($get['bSearchable_'.$i]) && $get['bSearchable_'.$i] == "true" && $get['sSearch_'.$i] != '' )
          {
              $awhere[$i]= $aColumns[$i]." LIKE '%".$get['sSearch_'.$i]."%'";
          }
      }
			$utilCount=$this->find();
			$util = $this->find();
			$util->join([
							'Annonce' => [
								'table' => 'annonces',
								'type' => 'inner',
								'conditions' => ['Utilisateurs.id = Annonce.proprietaire_id','Annonce.contrat=0'],
							],
                                                        // 'AG' => [
                                                        //         'table' => 'annoncegestionnaires',
                                                        //         'type' => 'left',
                                                        //         'conditions' => 'AG.id_annonces=Annonce.id',
                                                        // ],
                                                        'G' => [
                                                                'table' => 'gestionnaires',
                                                                'type' => 'left',
                                                                'conditions' => 'G.id=Annonce.id_gestionnaires',
                                                        ],
                                                        'R' => [
                                                                'table' => 'residences',
                                                                'type' => 'left',
                                                                'conditions' => 'Annonce.batiment=R.id',
                                                        ]
                            ])
						->select(['Utilisateurs.id', 'Utilisateurs.nom_famille', 'Utilisateurs.prenom', 'Utilisateurs.email','Annonce.id_filemaker', 'Annonce.id', 'Annonce.contrat','Annonce.mise_relation']);
			$utilCount->join([
							'Annonce' => [
								'table' => 'annonces',
								'type' => 'inner',
								'conditions' => ['Utilisateurs.id = Annonce.proprietaire_id','Annonce.contrat=0'],
							]])
						->select(['nbr' => $utilCount->func()->count('*')]);
			if(!empty($orWhere)){
				$util->where([$awhere,"OR"=>$orWhere]);
				$utilCount->where([$awhere,"OR"=>$orWhere]);
			}
			$start=1;
			if($get['iDisplayStart']>0){
				$start=($get['iDisplayStart']/$get['iDisplayLength'])+1;
			}
			$util->order($sOrder);
//				 ->limit($get['iDisplayLength'])
//				 ->page($start);
			$count=$utilCount->first();
      $output = array(
                  "sEcho" => intval($get['sEcho']),
                  "iTotalRecords" => $count["nbr"],
                  "iTotalDisplayRecords" => $count["nbr"],
                  "aaData" => array()
                  );
      $i=0;
      foreach($util as $res)
      {
        $row = array();
        $row[0]=$res->id;
        $row[1]=$res['Annonce']['id'];
        $row[2]=$res->nom_famille;
        $row[3]=$res->prenom;
        $row[4]="<a onclick='activate(\"".$res['Annonce']['id']."\")' class=\"exclamation-circle\" style='cursor:pointer' id='coeur_".$res['Annonce']['id']."'><i class=\"fa fa-exclamation-circle\"></i></a>";
        $output['aaData'][] = $row;
      }
    return  $output ;
  }
  /**
   *
   **/
  function get_array_utilisateur_gestionnaire($url,$get,$id)
    {
      $aColumns = array( 'Utilisateurs.id','Annonce.id_filemaker','Annonce.id','Utilisateurs.nom_famille', 'Utilisateurs.prenom', 'Annonce.contrat','Annonce.mise_relation' );
      $sOrder = array();
      if ( isset( $get['iSortCol_0'] ) )
      {
          for ( $i=0 ; $i<intval($get['iSortingCols'] ) ; $i++ )
          {
              if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" )
              {
                  $sOrder[$i]= $aColumns[ intval( $get['iSortCol_'.$i] ) ]." ".$get['sSortDir_'.$i];
              }
          }
      }
      $orWhere = array();
      if ( isset($get['sSearch']) && $get['sSearch'] != "" )
      {
          for ( $i=0 ; $i<count($aColumns) ; $i++ )
          {
              $orWhere[$i]= "LOWER(".$aColumns[$i].") LIKE '%". strtolower($get['sSearch'])."%'";
          }
      }
			$awhere=array();
      for ( $i=0 ; $i<count($aColumns) ; $i++ )
      {
          if ( isset($get['bSearchable_'.$i]) && $get['bSearchable_'.$i] == "true" && $get['sSearch_'.$i] != '' )
          {
              $awhere[$i]= $aColumns[$i]." LIKE '%".$get['sSearch_'.$i]."%'";
          }
      }
			$utilCount=$this->find();
			$util = $this->find();
      $util->join([
        'Annonce' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['Utilisateurs.id = Annonce.proprietaire_id','Annonce.contrat=0'],
        ],
        'G' => [
          'table' => 'gestionnaires',
          'type' => 'inner',
          'conditions' => ['G.id'=>$id,'Annonce.id_gestionnaires=G.id']
        ],
        // 'AG' => [
        //         'table' => 'annoncegestionnaires',
        //         'type' => 'inner',
        //         'conditions' => ["Annonce.id=AG.id_annonces","AG.id_gestionnaires='".$id."'"],
        // ],
        'C' => [
                'table' => 'contrats',
                'type' => 'inner',
                'conditions' => ["Annonce.id=C.annonce_id", "C.visible = 1"],
        ]
      ])
			->select(['Utilisateurs.id', 'Utilisateurs.nom_famille', 'Utilisateurs.prenom', 'Utilisateurs.email','Annonce.id_filemaker', 'Annonce.id', 'Annonce.contrat','Annonce.mise_relation']);
      $utilCount->join([
        'Annonce' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['Utilisateurs.id = Annonce.proprietaire_id','Annonce.contrat=0'],
        ],
        'G' => [
          'table' => 'gestionnaires',
          'type' => 'inner',
          'conditions' => ['G.id'=>$id,'Annonce.id_gestionnaires=G.id']
        ],
        // 'AG' => [
        //         'table' => 'annoncegestionnaires',
        //         'type' => 'inner',
        //         'conditions' => ["Annonce.id=AG.id_annonces","AG.id_gestionnaires='".$id."'"],
        // ],
        'C' => [
                'table' => 'contrats',
                'type' => 'inner',
                'conditions' => ["Annonce.id=C.annonce_id", "C.visible = 1"],
        ]
      ])
			->select(['nbr' => $utilCount->func()->count('*')]);
  			if(!empty($orWhere)){
  				$util->where([$awhere,"OR"=>$orWhere]);
  				$utilCount->where([$awhere,"OR"=>$orWhere]);
  			}
  			$start=1;
  			if($get['iDisplayStart']>0){
  				$start=($get['iDisplayStart']/$get['iDisplayLength'])+1;
  			}
  			$util->order($sOrder);
  			$count=$utilCount->first();
        $output = array(
                    "sEcho" => intval($get['sEcho']),
                    "iTotalRecords" => $count["nbr"],
                    "iTotalDisplayRecords" => $count["nbr"],
                    "aaData" => array()
                    );
        $i=0;
        foreach($util as $res)
        {
          $row = array();
          $img="";
          $fin="";
          $row[0]=$res->id;
          $row[1]=$res['Annonce']['id'];
          $row[2]=html_entity_decode($res->prenom." ".$res->nom_famille);
          $row[3]=$res->email;
            if($res['Annonce']['contrat']){
                    $fin="<a id='coeur_".$res['Annonce']['id']."' alt='desactiver' style='cursor:pointer' onclick='activate(\"".$res['Annonce']['id']."\")' class=\"check-circle\" href=\"#\"><i class=\"fa fa-check-circle\"></i></a>";
            }else{
                    $fin="<a id='coeur_".$res['Annonce']['id']."' alt='activer' style='cursor:pointer' onclick='activate(\"".$res['Annonce']['id']."\")' class=\"exclamation-circle\" href=\"#\"><i class=\"fa fa-exclamation-circle\"></i></a>";
            }
          $row[4]=$fin;
          $output['aaData'][] = $row;
        }
      return  $output ;
    }
    /**
     *
     **/
    function get_array_stat($url,$get,$id){
    		$util = $this->find();
    		$util->join([
                'R' => [
                         'table' => 'reservations',
                         'type' => 'inner',
                         'conditions' => 'R.utilisateur_id = Utilisateurs.id',
                ],
                'A' => [
                        'table' => 'annonces',
                        'type' => 'inner',
                        'conditions' => 'R.annonce_id = A.id',
                ],

               'B' => [
                        'table' => 'residences',
                        'type' => 'left',
                        'conditions' => 'A.batiment = B.id',
               ]
            ]);
            if($id["G"]['role']=='gestionnaire'){
                $util->where(['A.id_gestionnaires'=>$id["G"]['id']]);
              }
            if($get['from'] != ""){
              $fromdate = Time::parse($get['from']);
              $util->where(['R.dbt_at >= '=>$fromdate->i18nFormat('yyyy-MM-dd')]);
            } 
            if($get['to'] != ""){
              $todate = Time::parse($get['to']);
              $util->where(['R.dbt_at <= '=>$todate->i18nFormat('yyyy-MM-dd')]);
            }
            if($get['id_a'] != ""){
              $util->where(['A.id '=>$get['id_a']]);
            }
            $util->select(['A.id', 'A.num_app','Utilisateurs.ville','Utilisateurs.code_postal', 'Utilisateurs.prenom', 'Utilisateurs.nom_famille','Utilisateurs.telephone', 'Utilisateurs.portable', 'R.dbt_at', 'R.fin_at', 'R.nb_enfants', 'R.nb_adultes']);
          
      $util->group(['R.id']);
      $output = array(
                "data" => array()
                  );
      $i=0;
      foreach($util as $res)
      {
          $row = array();
          $row[0]=$res['A']['id'];
         	$row[1]=$res['A']['num_app'];
          $row[2]=html_entity_decode($res->nom_famille." ".$res->prenom);
          $row[3]=$res->ville;
          $row[4]=$res->code_postal;
          $row[5]=$res->portable;
          $dbt_at = Time::parse($res['R']['dbt_at']);
          $fin_at = Time::parse($res['R']['fin_at']);
          $row[6]=$dbt_at->i18nFormat('dd/MM/yyyy');
          $row[7]=$fin_at->i18nFormat('dd/MM/yyyy');
          $row[8]=$res['R']['nb_enfants'];
          $row[9]=$res['R']['nb_adultes'];
          $output['data'][] = $row;
      }
    return  $output ;
  }
  /**
   *
   **/
  public function getListeProp($gest_id=NULL){
    $liste = $this->find();
    if($gest_id != NULL){
      $liste->join([
          'A' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['Utilisateurs.id=A.proprietaire_id'],
          ],
          'G' => [
            'table' => 'gestionnaires',
            'type' => 'inner',
            'conditions' => ['G.id'=>$gest_id,'A.id_gestionnaires=G.id']
          ],
          // 'AG' => [
          //     'table' => 'annoncegestionnaires',
          //     'type' => 'inner',
          //     'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires"=>$gest_id],
          // ]
        ]);
    }
    $liste->where(["Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT'"])
      ->select(["Utilisateurs.id", "Utilisateurs.prenom", "Utilisateurs.nom_famille", "Utilisateurs.email"])
      ->order(["Utilisateurs.prenom ASC"])
      ->group(["Utilisateurs.id"]);
    return $liste;
  }
  /**
   *
   **/
  function getdetailuser($id){
    $user = $this->find();
    $user->join([
            'PV' => [
              'table' => 'pvilles',
              'type' => 'left',
              'conditions' => ['Utilisateurs.ville=PV.id'],
            ],
            'P' => [
                'table' => 'pays',
                'type' => 'left',
                'conditions' => ['Utilisateurs.pays=P.id_pays'],
            ]
          ]);
    $user->where(['Utilisateurs.id = '.$id])
         ->select(["Utilisateurs.id", "Utilisateurs.civilite", "Utilisateurs.description", "Utilisateurs.nature", "Utilisateurs.ville", "Utilisateurs.pays", "Utilisateurs.region", "Utilisateurs.nom_famille", "Utilisateurs.prenom", "Utilisateurs.adresse", "Utilisateurs.adr2", "Utilisateurs.adr3", "Utilisateurs.adr3", "Utilisateurs.code_postal", "Utilisateurs.telephone", "Utilisateurs.portable", "Utilisateurs.naissance", "Utilisateurs.email", "P.id_pays", "P.fr", "PV.id", "PV.name"]);
    return $user->first();
  }
  /**
   * 
   */
  function getProprietaires(){
        return $this->find()->where(['nature != '=>'CLT'])->order(['email' => 'ASC'])->select(['id','email','nom_famille']);
    }
  /**
   * 
   */
  public function getStatsPays($pays,$pattern=null,$anne){
    $where = [];
    $where[] = "(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT' OR Utilisateurs.nature = 'CLT')";
    $where[] = '(Utilisateurs.telephone != "" OR Utilisateurs.portable != "")';
    $where[] = '(Utilisateurs.telephone IS NOT NULL OR Utilisateurs.portable IS NOT NULL)';
    if($pattern==null){
        $where[] = "(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(06)[0-9]{8}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(/+33|33|0033|330)[0-9]{9}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(073|074|075|076|077|078|079)[0-9]{7}$')";   
    }
    else
        $where[] = $pattern;
    if(strtoupper($anne)!='ALL'){
        $anne=intval($anne);
        $where[] = "( (date_insert >= STR_TO_DATE('".($anne-1)."-09-01','%Y-%m-%d')) AND (date_insert <= STR_TO_DATE('".($anne)."-08-31','%Y-%m-%d')) )";
    }
    else
    {
        $where[] = "( (date_insert >= STR_TO_DATE('2017-09-01','%Y-%m-%d')) )";
    }
    $totalUtilTel = $this->find()->where($where);
    $totalUtilTel = $totalUtilTel->select(["Country"=>"'".$pays."'",'total' => $totalUtilTel->func()->count('*')]);
    return $totalUtilTel;
  }
/**
 * 
 */
  public function populationfrancais($anne,$all=false){
    $franceStats=$this->find()
                ->where(['pays'=>67])->join([
                  'D' => [
                          'table' => 'departements',
                          'type' => 'inner',
                          'conditions' => 'D.id=Utilisateurs.region',
                      ]
                  ]);
    if(strtoupper($anne)!='ALL'){
      $franceStats->where("( (Utilisateurs.date_insert >= STR_TO_DATE('".($anne-1)."-09-01','%Y-%m-%d')) AND (Utilisateurs.date_insert <= STR_TO_DATE('".($anne)."-08-31','%Y-%m-%d')) )");
    }
    else
    {
      $franceStats->where("( (Utilisateurs.date_insert >= STR_TO_DATE('2018-09-01','%Y-%m-%d')) )");
    }
    if($all==true){
  //                                      ->where(function ($exp, $q) {
  //                                        return $exp->in('D.name', ['AIN', 'ALLIER', 'ARDECHE', 'CANTAL', 'DROME', 'ISERE', 'LOIRE', 'HAUTE LOIRE', 'PUY DE DOME',
  //                                                                                'RHONE', 'SAVOIE', 'HAUTE SAVOIE']);
  //                                    })
      $franceStats->group(['D.id'])
      ->limit(30)
      ->order(['total DESC']);
      return $franceStats->select(['D.name','total' => $franceStats->func()->count('*')]);
    }
    return $franceStats->count();
  }
  /**
   * 
   */
  public function populationregion($anne,$all=false){
    $franceStats=$this->find()
                                  ->where(['pays'=>67])->join([
                                    'D' => [
                                      'table' => 'departements',
                                      'type' => 'inner',
                                      'conditions' => 'D.id=Utilisateurs.region',
                                    ],
                                    'R' => [
                                      'table' => 'regions',
                                      'type' => 'inner',
                                      'conditions' => 'R.id=D.region_id',
                                    ],
                                  ]);
    if(strtoupper($anne)!='ALL'){
      $franceStats->where("( (Utilisateurs.date_insert >= STR_TO_DATE('".($anne-1)."-09-01','%Y-%m-%d')) AND (Utilisateurs.date_insert <= STR_TO_DATE('".($anne)."-08-31','%Y-%m-%d')) )");
    }
    else
    {
      $franceStats->where("( (Utilisateurs.date_insert >= STR_TO_DATE('2018-09-01','%Y-%m-%d')) )");
    }
    $franceStats->group(['R.id'])
    ->limit(30)
    ->order(['total DESC']);
    return $franceStats->select(['R.name','total' => $franceStats->func()->count('*')]);
  }
  /**
   * 
   */
  public function populationzones($anne){
    $zoneA=[1,2,8];
    $zoneB=[11,9,5,3,7,12,4];
    $zoneC=[13,6];
    return $this->populationzone($anne,$zoneA,'Zone A')
    ->union($this->populationzone($anne,$zoneB,'Zone B'))
    ->union($this->populationzone($anne,$zoneC,'Zone C'));
  }
  /**
   * 
   */
  private function populationzone($anne,Array $idregions,String $zone_name){
    $zone=$this->find()
    ->where(['pays'=>67])->join([
      'D' => [
        'table' => 'departements',
        'type' => 'inner',
        'conditions' => 'D.id=Utilisateurs.region',
      ],
      'R' => [
        'table' => 'regions',
        'type' => 'inner',
        'conditions' => 'R.id=D.region_id',
      ],
    ])
    ->where(['R.id IN'=>$idregions]);
    if(strtoupper($anne)!='ALL'){
      $zone->where("( (Utilisateurs.date_insert >= STR_TO_DATE('".($anne-1)."-09-01','%Y-%m-%d')) AND (Utilisateurs.date_insert <= STR_TO_DATE('".($anne)."-08-31','%Y-%m-%d')) )");
    }else
    {
      $zone->where("( (Utilisateurs.date_insert >= STR_TO_DATE('2018-09-01','%Y-%m-%d')) )");
    }
    return $zone->select(["zone"=>"'".$zone_name."'",'total' => $zone->func()->count('*')]);
  }

}
