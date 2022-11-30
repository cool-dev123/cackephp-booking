<?php
namespace App\Model\Table;

use App\Model\Entity\Tax;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * Taxes Model
 *
 */
class TaxesTable extends Table
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

        $this->table('taxes');
        $this->displayField('id');
        $this->primaryKey('id');
    }
    /**
     *
     **/
    public function getArrayTaxe($url,$get){
    $gestion= $this->find();
        $gCount = $this->find();
            $gestion->join([
                        'V' => [
                            'table' => 'frvilles',
                            'type' => 'inner',
                            'conditions' => 'V.id=Taxes.id_villes',
                        ]
 
                    ])
                    ->select(['V.name','Taxes.id','Taxes.du','Taxes.au','Taxes.nb_etoile','Taxes.valeur']);
      $output = array(
                  "data" => array()
                  );
      foreach($gestion as $c)
      {
        $row = array();
        $row[0]=$c['V']['name'];
        $row[1]=$c->du->i18nFormat('dd-MM-yyyy');
        $row[2]=$c->au->i18nFormat('dd-MM-yyyy');
        $row[3]=$c->nb_etoile;
        if($c->nb_etoile == 0 && $c->du->i18nFormat('yyyy') > 2018)
           $row[4]=$c->valeur." %"; 
        else
            $row[4]=$c->valeur." &euro;";
        $row[5]="<button data-key=\"$c->id\" data-toggle=\"modal\" data-target=\"#responsive-modal-add\" class=\"btn btn-sm btn-default btn-icon-anim btn-circle edit_taxe\"><i class=\"fa fa-pencil\"></i></button>"
                ."<button class=\"btn btn-sm btn-info btn-icon-anim btn-circle delete_taxe\" data-name=\"$c->valeur\" data-key=\"$c->id\" ><i class=\"icon-trash\"></i></button>";
        $output['data'][] = $row;
      }
    return  $output ;
  }
  
}
