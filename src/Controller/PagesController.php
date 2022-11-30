<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
  /**
   * Displays a view
   *
   * @return void|\Cake\Network\Response
   * @throws \Cake\Network\Exception\NotFoundException When the view file could not
   *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
   */
  public function display(){
    $path = func_get_args();
    $count = count($path);
    if (!$count) {
        return $this->redirect('/');
    }
    $page = $subpage = null;
    if (!empty($path[0])) {
        $page = $path[0];
    }
    if (!empty($path[1])) {
        $subpage = $path[1];
    }
    $this->set(compact('page', 'subpage'));

    try {
      $this->render(implode('/', $path));
    } catch (MissingTemplateException $e) {
      if (Configure::read('debug')) {
          throw $e;
      }
      throw new NotFoundException();
    }
  }

	function infosplansstations(){
		$this->loadModel("Lieugeos");
    $this->loadModel("Images");
    $images=$this->Images->find()->where(['Images.visible = 1']);
    $this->set("images",$images);
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
    $ar[]="Destination";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);

		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('PLAN_STATION')]);
		$this->set("registres",$registre->first());
	}
	public function infosstationarc1600(){
    $this->loadModel("Lieugeos");
    $this->loadModel("Images");
    $images=$this->Images->find()->where(['Images.visible = 1']);
    $this->set("images",$images);
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
    $ar[]="Destination";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);

    $a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ARC1600')]);
		$this->set("registres",$registre->first());
  }

	public function infosstationarc1800(){
    $this->loadModel("Lieugeos");
    $this->loadModel("Images");
    $images=$this->Images->find()->where(['Images.visible = 1']);
    $this->set("images",$images);
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
    $ar[]="Destination";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);

    $a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ARC1800')]);
		$this->set("registres",$registre->first());
  }

	public function infosstationarc1950(){
    $this->loadModel("Lieugeos");
    $this->loadModel("Images");
    $images=$this->Images->find()->where(['Images.visible = 1']);
    $this->set("images",$images);

		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
    $ar[]="Destination";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);

    $a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ARC1950')]);
		$this->set("registres",$registre->first());
  }

	public function infosstationarc2000(){
    $this->loadModel("Lieugeos");
    $this->loadModel("Images");
    $images=$this->Images->find()->where(['Images.visible = 1']);
    $this->set("images",$images);

		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
    $ar[]="Destination";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);

    $a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ARC2000')]);
		$this->set("registres",$registre->first());
  }

	public function infosvillebourgsaintmaurice(){
    $this->loadModel("Lieugeos");

    $this->loadModel("Images");
    $images=$this->Images->find()->where(['Images.visible = 1']);
    $this->set("images",$images);

		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
    $ar[]="Destination";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);

    $a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);
		$this->loadModel("Registres");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('BOURG')]);
		$this->set("registres",$registre->first());
  }

  public function cartevacanceseuropeennes(){
    $this->viewBuilder()->layout('ajax');
    $this->loadModel("Vacances");
    $listevacances = $this->Vacances->getListeVacances();
    $this->set('listevacances', $listevacances);

    $tabvacance = [];
    $drapeauvacance = [];
    $tabzones = [];
    foreach ($listevacances as $value) {
      if($value->commentaire_vac != ""){
        $commvaca = " <strong>Remarques: </strong><span class='nouveauprix'>".$value->commentaire_vac."</span>";
      }else{
        $commvaca = "";
      }

      if($value->zone_champ_vac == ""){
        $valzoneinput = "";
      }else{
        $valzoneinput = " (".$value->zone_champ_vac.")";
      }
      $tabvacance[$value['Pays']['fr']][] = $value->titre.$valzoneinput." : </td><td><span class='nouveauprix'>du ".$value->dbt_vac." au ".$value->fin_vac."</span>".$commvaca;
    }
    $this->loadModel("Pays");
    $payslistedr = $this->Pays->find("all");
    foreach ($payslistedr as $value) {
      if($value->subdivision == 20){
        $zonevaca = "District";
      }else if($value->subdivision == 10){
        $zonevaca = "Canton";
      }else if($value->subdivision == 30){
        $zonevaca = "Lander";
      }else if($value->subdivision == 40){
        $zonevaca = "Province";
      }else if($value->subdivision == 50){
        $zonevaca = "Région";
      }else if($value->subdivision == 60){
        $zonevaca = "Zone";
      }else if($value->subdivision == 70){
        $zonevaca = "Comté";
      }else if($value->subdivision == 80){
        $zonevaca = "Voblast";
      }else if($value->subdivision == 90){
        $zonevaca = "Conseil régional";
      }
      if($value->subdivision == 0){
        $tabzones[$value->fr] = "";
      }else{
        $tabzones[$value->fr] = " <span class='aligner'>subdivisé par ".$zonevaca."</span>";
      }
      $drapeauvacance[$value->fr] = $value->code_pays;
    }
    $this->set('tabzones', $tabzones);
    $this->set('tabvacance', $tabvacance);
    $this->set('drapeauvacance', $drapeauvacance);
  }

}
