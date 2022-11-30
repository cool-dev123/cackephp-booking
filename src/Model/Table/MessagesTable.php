<?php
namespace App\Model\Table;

use App\Model\Entity\Message;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
/**
 * Messages Model
 *
 */
class MessagesTable extends Table
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

        $this->table('messages');
        $this->displayField('id');
        $this->primaryKey('id');
    }
    /**
     *
     **/
	function getArrayMessage($url,$get,$idgest)
    {
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
                        if(isset($get['limit']) && $get['limit'] != "")
                        $util->limit(10);
                        
			$util->select(['Messages.id_gestionnaire','Messages.de','Messages.id','Messages.d_create','Messages.sujet','Messages.lu'])
      ->where(['Messages.id_gestionnaire = '.$idgest]);
                        
			$utilCount->select(['nbr' => $utilCount->func()->count('*')])->where(['Messages.id_gestionnaire = '.$idgest]);

			if(!empty($orWhere)){
				$util->where([$awhere,"OR"=>$orWhere]);
				$utilCount->where([$awhere,"OR"=>$orWhere]);
			}
			$start=1;
			if($get['iDisplayStart']>0){
				$start=($get['iDisplayStart']/$get['iDisplayLength'])+1;
			}
      if(!empty($sOrder))	$util->order($sOrder);
      else $util->order(['d_create'=>'DESC']);
			$count=$utilCount->first();
      $output = array(
                  "sEcho" => intval($get['sEcho']),
                  "iTotalRecords" => $count["nbr"],
                  "iTotalDisplayRecords" => $count["nbr"],
                  "aaData" => array()
                  );
        $i=0;
       foreach($util as $c)
        {
          if($c->de > 50){
            $Utilisateurs = TableRegistry::get('Utilisateurs');
            $utilisatgest = $Utilisateurs->get($c->de);
            $dename = $utilisatgest->prenom." ".$utilisatgest->nom_famille;
            if($utilisatgest->nature == 'ANNO' || $utilisatgest->nature == 'MIXT') $derole = '<span class="label label-warning">Propriétaire</span>';
            else $derole = '<span class="label label-warning">Locataire</span>';
          }else{
            $Gestionnaires = TableRegistry::get('Gestionnaires');
            $utilisatgest = $Gestionnaires->get($c->de);
            $dename = $utilisatgest->name;
            $derole = $utilisatgest->role=='admin'?'<span class="label label-danger">'.$utilisatgest->role.'</span>':'<span class="label label-success">'.$utilisatgest->role.'</span>';
          }
          $row = array();

  				$date="";
          if($dename == '')	$dename="Administrateur";
  				if(!empty($c->d_create))
  					$date= $c->d_create->i18nFormat('dd/MM/YYYY hh:mm:ss');
  				if($c->lu==0){
                                    $row[0]="<center><a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='true' data-key=\"$c->id\" class='modifier_taxe grab'><i class='fa fa-envelope'></i></a></center>";
                                    $row[1]="<a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='true' data-key=\"$c->id\" class='modifier_taxe grab'><font style='font-weight:bold'>".$dename."</font></a>";
                                    $row[2]="<a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='true' data-key=\"$c->id\" class='modifier_taxe grab'><font style='font-weight:bold'>".$derole."</font></a>";
                                    $row[3]="<a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='true' data-key=\"$c->id\" class='modifier_taxe grab'><font style='font-weight:bold'>".$c->sujet."</font></a>";
                                    $row[4]="<a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='true' data-key=\"$c->id\" class='modifier_taxe grab'>".$date."</a>";
  				}else{
                                    $row[0]="<center><a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='false' data-key=\"$c->id\" class='modifier_taxe grab'><i class='icon-envelope-open'></i></a></center></a>";
                                    $row[1]="<a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='false' data-key=\"$c->id\" class='modifier_taxe grab'>".$dename."</a>";
                                    $row[2]="<a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='false' data-key=\"$c->id\" class='modifier_taxe grab'>".$derole."</a>";
                                    $row[3]="<a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='false' data-key=\"$c->id\" class='modifier_taxe grab'>".$c->sujet."</a>";
                                    $row[4]="<a data-toggle=\"modal\" data-target=\"#View_Message\" data-oppened='false' data-key=\"$c->id\" class='modifier_taxe grab'>".$date."</a>";
  				}
  				$output['aaData'][] = $row;
  				$i++;
        }
      return  $output ;
		}
    /**
     *
     **/
    function getnbmessage($id){
        $utilCount=$this->find();
        $utilCount->select(['nbr' => $utilCount->func()->count('*')])
                  ->where(['id_gestionnaire'=>$id,'lu'=>0]);
        $count=$utilCount->first();
        return $count["nbr"];
    }
}
