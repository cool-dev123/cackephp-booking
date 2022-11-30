<?php 
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
?>

<?php $this->start('cssTop'); ?>
    <style>
        .panel_content div {
            margin-top: 2%;
            margin-bottom: 1%;
        }
        #ui-datepicker-div .ui-widget-header {	
	background: #2D8CB9;	
        }
        .ui-state-default, .ui-widget-content .ui-state-default{
          background: transparent!important;
        }
        .ui-state-highlight, .ui-widget-content .ui-state-highlight{
          background: #fffa90!important;
        }
        .ui-datepicker-calendar th {
                color: #2D8CB9;
        }
        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover{
          color:#333!important;
        }
        .centerText{
            text-align: center;
        }
        .glyphicon{
            color: #2278dd !important;
            background-color: #eeeeee !important;
            margin: 0px !important;
            padding: 0px !important;
        }
        .input-group-addon:first-child {
            border-color: #f7f7f9;
            background-color: #f7f7f9;
        }
        .addon-90{
            font-size: 92% !important;
        }
        .text-white {
            color: white !important;
        }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="icon-user-following"></i> Gestion des arrivées</span>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Locataires non arrivés</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/newarrive">Locataires arrivés</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                    <div class="pull-left">
                            <h6 class="panel-title txt-dark">Les locataires non encore arrivés</h6>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <form id="form_searsh" class="form-inline">
                                <div class="elementOF_searchCle mt-5 input-group mt-5">
                                        <div class="input-group-addon addon-92 font-16">
                                                Date début:
                                        </div>
                                    <input class="form-control date" type="text" id="from_date" value="<?php echo $dateChoisis ?>" autocomplete="off" />
                                </div>
                                <div class="elementOF_searchCle mt-5 input-group mt-5">
                                        <div class="input-group-addon addon-92 font-16">
                                            Date fin :    
                                        </div>
                                    <input class="form-control date" type="text" id="to_date" value="<?php echo $dateFinChoisis ?>" autocomplete="off" />
                                </div>
                                <div class="elementOF_searchCle mt-5 input-group mt-5">
                                        <div class="input-group-addon addon-92 font-16">
                                                Rechercher :
                                        </div>
                                    <input class="form-control" type="text" id="supp-search" value="<?= $this->request->query['supp'] ?>" autocomplete="off" />
                                </div>
                                <button type="button" id="rechercher" href="#" class="mt-5 btn btn-primary">Rechercher</button>
                                <button type="button" id="reset" href="#" class="mt-5 btn btn-primary">reset</button>
                            </form>
                        </blockquote>
                        
                        <div class="col-sm-12 mt-15 pl-1">
                                <div class="button-list pl-0 mb-30">
                                    <button id="MyLocataires" type="button" class="pr-0 btn <?= isset($absent)?"btn-default":"btn-success" ?>"><span class="btn-text">Mes locataires</span> <sup> <span class="badge badge-light"> <?= $nbArrivees ?></span></sup></button>
                                    <?php if (count($res)>0):?>
                                    <?php foreach ($gestArr as $gest):?>
                                    <button type="button" data-key="<?= $gest['gestionaire']['id'] ?>" class="pr-0 btn <?= (isset($absent)&&$absent==$gest['gestionaire']['id'])?"btn-success":"btn-default" ?> gest_absent"><span class="btn-text">locataires de <?= $gest['gestionaire']['name'] ?></span><sup> <span class="badge badge-light bg-danger text-white"> <?= $gest['NonArrives'] ?></span></sup></button>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-10 ml-5">
                            <label>
                                Afficher 
                                <select id="list_1_length" class="">
                                    <?php $limits=[10,25,50,100]; foreach($limits as $i):?>
                                    <option <?php if($this->request->query['limite']==$i): ?>selected<?php endif;?> value="<?=$i?>"><?=$i?></option>
                                    <?php endforeach; ?>
                                </select>
                                éléments
                            </label>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="panel panel-primary card-view">
                                    <div class="panel-heading icantSelectIt">
                                            <div>
                                                <?php if(count($tabArr)>0): ?>
                                                <h6 class="panel-title txt-light">Les Locataires Non Encore Arrivés</h6>
                                                <?php else: ?>
                                                <h6 class="panel-title txt-light text-center" style="text-align: center;">Pas de locataires</h6>
                                                <?php endif; ?>
                                            </div>
                                            <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-wrapper collapse in">
                                        
                                            <?php $i=0; foreach ($tabArr as $arr): ?>
                                            <div class="panel-body">
                                                <div <?php $i++; if($i%2==0) echo 'style="background-color: #f2f2f2;"'; ?> class="row panel_content">
                                                    <!--0 -->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">Date d'arrivée :&nbsp;</span>&nbsp;<span class="txt-dark font-16"><?= $arr->dbt_at->i18nFormat('dd-MM-yyyy') ?></span></div>
                                                <!--1 -->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">Date de départ :&nbsp;</span>&nbsp;<span class="txt-dark font-16"><?= $arr->fin_at->i18nFormat('dd-MM-yyyy') ?></span></div>
                                                <!--2 -->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">Nom du locataire :&nbsp;</span>&nbsp;<span class="txt-dark font-16"><?= $arr['U']['prenom']." ".$arr['U']['nom_famille'] ?></span></div>
                                                <!--3 -->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font font-20">Téléphone :&nbsp;</span>&nbsp;<span class="txt-dark font-20"><?= getFormatFrenchPhoneNumber($arr['U']['portable'], true); ?></span></div>
                                                <!--4 -->    <div class="col-lg-6 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">E-mail :&nbsp;</span>&nbsp;<span class="txt-dark font-16"><?= $arr['U']['email'] ?></span></div>
                                                <!--5 -->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">NB adulte(s) :&nbsp;</span>&nbsp;<span class="txt-dark font-16"><?= $arr->nb_adultes ?></span></div>
                                                <!--6 -->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">enfant(s) :&nbsp;</span>&nbsp;<span class="txt-dark font-16"><?= $arr->nb_enfants ?></span></div>
                                                <!--7 -->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">Village :&nbsp;</span>&nbsp;<span class="txt-dark font-16"><?= $arr['V']['name'] ?></span></div>
                                                <!--8 -->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font font-20">Résidence :&nbsp;</span>&nbsp;<span class="txt-dark font-20"><?= $arr['RS']['name'] ?></span></div>
                                                <!--9 -->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font font-20">N° app :&nbsp;</span>&nbsp;<span class="txt-dark font-20"><?= $arr['A']['num_app'] ?></span></div>
                                                <!--10-->    <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">Position clé :&nbsp;</span>&nbsp;<span class="txt-dark font-16"><?= $arr['A']['position_cle'] ?></span></div>
                                                <!--11-->    <div class="col-lg-6 col-md-6"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">Taxe de séjour à collecter :&nbsp;</span>&nbsp;<span class="label font-16 <?= $arr->taxe==0?"label-danger":"label-success" ?>" ><?= $arr->taxe==0?"Non":"Oui" ?></span></div>
                                                <!--12-->    <div class="col-lg-4 col-md-4"><span class="pull-left weight-600 font-16 txt-dark uppercase-font">Taxe :&nbsp;</span>&nbsp;<span class="txt-dark font-16"><?= $taxes[$arr->id].' &euro; <p class="txt-danger font-16">'.$messageimpo[$arr->id].'</p>'; ?></span></div>
                                                <!--13-->    <div class="col-lg-6 col-md-6"><span class="pull-left weight-600 font-16 <?php if($arr->comment==''): ?>txt-dark <?php else: ?>txt-danger<?php endif; ?> uppercase-font">Commentaire Propriétaire :&nbsp;</span>&nbsp;<span class="<?php if($arr->comment==''): ?>txt-dark <?php else: ?>txt-danger<?php endif; ?> font-16"><?= $arr->comment ?></span></div>
                                                <!--14-->    <div class="col-lg-6 col-md-6"><span class="pull-left weight-600 font-16 <?php if($arr->commentlocataire==''): ?>txt-dark <?php else: ?>txt-danger<?php endif; ?> uppercase-font">Commentaire Locataire :&nbsp;</span>&nbsp;<span class="<?php if($arr->commentlocataire==''): ?>txt-dark <?php else: ?>txt-danger<?php endif; ?> font-16"><?= $arr->commentlocataire ?></span></div>
                                                <!--15-->    <div class="col-sm-12 button-list" data-key="<?= $arr->id ?>" data-tax="<?= $arr->taxe ?>">
                                                                <?php if($arr->taxe==1): ?>
                                                                    <button data-toggle="modal" data-target="#gestion_taxe-modal" data-href="<?= $url."manager/arrivees/gestiontaxesejourgest/".$arr->id ?>" class="btn btn-primary gestion_Taxe">Gestion Taxe</button>
                                                                <?php endif; ?>
                                                                <button data-toggle="modal" data-target="#gestion_cle-modal" data-href="<?= $url."manager/arrivees/gestionclearrigest/".$arr['A']['id']."/".$arr->id ?>" class="btn btn-warning gestion_clé font-16">Gestion Clé</button>
                                                                <button data-toggle="modal" data-target="#modalFicheProprietaire" class="btn btn-warning show_locataire font-16" data-href="<?= $url."manager/arrivees/ficheclient/".$arr['A']['id'] ?>">Fiche propriétaire</button>
                                                                <button data-toggle="modal" data-target="#send_mail-modal" class="btn btn-success show_mail font-16" data-href="<?= $url."manager/arrivees/sendmail/".$InfoGes['G']['id']."/".$arr->id ?>">Envoyer message</button>
                                                                <button data-toggle="modal" data-target="#edit_locataire-modal" class="btn btn-success edit_locataire font-16" data-href="<?= $url."manager/arrivees/fichearrivee/".$InfoGes['G']['id']."/".$arr->id ?>">Modifier l'arrivée</button>
                                                                <button class="btn btn-success valider_arrivee font-16" data-G="<?= $InfoGes['G']['id'] ?>" data-key="<?= $arr->id ?>" data-name="<?= $arr['U']['prenom']." ".$arr['U']['nom_famille'] ?>">Valider l'arrivée</button>
                                                            </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                    </div>
                            </div>
                        </div>
                        <?php if($this->Paginator->total() > 1): ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <ul class="pagination font-16">
                                <?php
                                echo $this->Paginator->first(__('Première', true), array('tag' => 'li', 'escape' => false), array('type' => "button",'model'=> 'Reservations', 'class' => "btn btn-default"));
                                echo $this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled','model'=> 'Reservations', 'tag' => 'li', 'escape' => false));
                                echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li','model'=> 'Reservations'));
                                echo $this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled','model'=> 'Reservations', 'tag' => 'li', 'escape' => false));
                                echo $this->Paginator->last(__('Dernière', true), array('tag' => 'li', 'escape' => false), array('type' => "button",'model'=> 'Reservations', 'class' => "btn btn-default"));
                                ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.modal -->
<div id="gestion_taxe-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title">Gestion Taxe</h5>
                        </div>
                        <div id="gestion_taxe-modal-body" class="modal-body">
                                
                        </div>
                        <div class="modal-footer">
                            <button id="modifiergesttaxearrivee" type="button" class="btn btn-danger">Modifier</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                        </div>
                </div>
        </div>
</div>
<!-- /.modal -->
<div id="gestion_cle-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title">Gestion Clé</h5>
                        </div>
                        <div id="gestion_cle_modal-body" class="modal-body">
                                
                        </div>
                        <div class="modal-footer">
                            <button id="modifiergestclearrivee" type="button" class="btn btn-danger">Modifier</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                        </div>
                </div>
        </div>
</div>

<!-- sample modal content -->
<div id="modalFicheProprietaire" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title" id="myLargeModalLabel">Fiche Propriétaire</h5>
                        </div>
                    <div id="modalFicheProprietaire-body" class="modal-body">
                        
                    </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
                        </div>
                </div>
                <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- /.modal -->
<div id="send_mail-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title">Envoyer message</h5>
            </div>
            <div id="send_mail-body" class="modal-body">

            </div>
            <div class="modal-footer">
                <button id="send_mail" type="button" class="btn btn-danger">Envoyer</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>

<!-- /.modal -->
<div id="edit_locataire-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title">Fiche arrivée</h5>
            </div>
            <div id="edit_locataire-modal-body" class="modal-body">

            </div>
            <div class="pb-15 centerText">
                    <a class="mt-20 btn btn-success btn-anim"><i class="fa fa-save" id="edit_res" onclick="valider()"></i><span class="btn-text">Modifier</span></a>
                    <button type="button" class="mt-20 btn btn-warning" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>
<!-- validation -->
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var $currentDiv=null;

function redraw(){
    $('body').loadingModal({
                    position: 'auto',
                    text: 'Chargement en cours',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
        var date = $('#from_date').val();
        var datefin = $('#to_date').val();
        if(date=="") date = "<?php echo date('d-m-Y'); ?>";
        if(datefin=="")
            window.location.replace("<?= $url ?>"+"manager/arrivees/nonarrive/"+date+"?supp="+$('#supp-search').val()+"&limite="+$('#list_1_length').val());
        else
            window.location.replace("<?= $url ?>"+"manager/arrivees/nonarrive/"+date+"?datefin="+datefin+"&supp="+$('#supp-search').val()+"&limite="+$('#list_1_length').val());
}

function valider(){
            $("#test_form").validate({
                        errorPlacement: function(error, element) {
                            if (element.attr("name") == "portable" )
                                error.insertAfter("#error-msg");
                            else
                                error.insertAfter(element);
                        },
                        rules: {
                            email: {
                                required: true,
                                email: true,
                            },
                            portable: {
                                required: true,
                            },
                            prenom: {
                                required: true,
                            },
                            dbt_at:{
                                required: true,
                                date:false,
                            },
                            fin_at:{
                                required: true,
                                date:false,
                            },
                            heure_arr:{
                                required: true,
                            },
                            heure_dep:{
                                required: true,
                            }
                        },
                 });
                var test = '';
                      var listnumtel = '';
                      var telInputrestel = $("#tel");
                      var errorMsggtel = $("#error-msg-tel");

                      if ($.trim(telInputrestel.val())) {
                        if (telInputrestel.intlTelInput("isValidNumber")) {
                          validNum = telInputrestel.intlTelInput("getNumber");
                          $("#tel").val(validNum);
                        } else {
                          test = "non";
                          validNum = "non";
                          telInputrestel.addClass("errorNumberTel");
                          errorMsggtel.removeClass("hide");
                          errorMsggtel.addClass("errorNumberTel");
                        }
                      }

                      var telInputport = $("#portable"),
                        errorMsgport = $("#error-msg");
                        if ($.trim(telInputport.val())) {
                          if (telInputport.intlTelInput("isValidNumber")) {
                            validNum = telInputport.intlTelInput("getNumber");
                            $("#portable").val(validNum);
                          } else {
                            test = "non";
                            validNum = "non";
                            telInputport.addClass("errorNumberTel");
                            errorMsgport.removeClass("hide");
                            errorMsgport.addClass("errorNumberTel");
                          }
                        }

                      for(i = 1; i < itel; i++){
                        var telInputres = $("#num_tel"+i);
                        var errorMsgg = $("#error-msg"+i);

                        if ($.trim(telInputres.val())) {
                          if (telInputres.intlTelInput("isValidNumber")) {
                            validNum = telInputres.intlTelInput("getNumber");
                            $("#num_tel"+i).val(validNum);
                            listnumtel = listnumtel + validNum + "/";
                          } else {
                            test = "non";
                            validNum = "non";
                            telInputres.addClass("errorNumberTel");
                            errorMsgg.removeClass("hide");
                            errorMsgg.addClass("errorNumberTel");
                          }
                        }
                      }

        if($("#test_form").valid()){
          if(test == ''){
                $('body').loadingModal({
                    position: 'auto',
                    text: 'Modification en cours',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
                if($('#taxe_0').is(':checked'))var taxe=0;
                if($('#taxe_1').is(':checked'))var taxe=1;
            $.ajax({
                        type: "POST",
                        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/editarrive/",
                        data:{vnbrrestel: $('#nbrrestel').val(), vidtels: $('#idtels').val(), vlistnumtel: listnumtel, vheureArr: $('#heure_arr').val(),vheureDep: $('#heure_dep').val(),vIdUtil:$('#utilisateur_id').val(),vNom:$('#nom_famille').val(),vPrenom:$('#prenom').val(),vEmail:$('#email').val(),vPort:$('#portable').val(),vTel:$('#tel').val(),vId:$('#hdid').val(),vArrive:$('#dbt_at').val(),vEnfant:$('#nb_child').val(),vAdult:$('#nb_adult').val(),vComment:$('#comment').val(),vCommentlocataire:$('#commentlocataire').val(),vTaxe:taxe,vCle:$('#p_cle').val()},
                        success:function(xml){
                                $('#edit_locataire-modal').modal('hide');
                                //màj des informations
                                $currentDiv.children().eq(0).children().eq(1).html($('#dbt_at').val());
                                $currentDiv.children().eq(2).children().eq(1).html($('#prenom').val()+' '+$('#nom_famille').val());
                                $currentDiv.children().eq(3).children().eq(1).html($('#portable').val());
                                $currentDiv.children().eq(4).children().eq(1).html($('#email').val());
                                
                                var hastaxe=$currentDiv.children().eq(15).attr("data-tax")=="1";
                                
                                if($('#taxe_0').is(':checked')){
                                    $currentDiv.children().eq(11).children().eq(1).html("Non");
                                    $currentDiv.children().eq(11).children().eq(1).attr("class","label label-danger");
                                    if( hastaxe==true ){
                                        $currentDiv.children().eq(15).children().eq(0).remove();
                                        $currentDiv.children().eq(15).attr("data-tax","0");
                                    }
                                }
                                if($('#taxe_1').is(':checked')){
                                    $currentDiv.children().eq(11).children().eq(1).html("Oui");
                                    $currentDiv.children().eq(11).children().eq(1).attr("class","label label-success");
                                    if( hastaxe==false ){
                                        $currentDiv.children().eq(15).prepend("<button data-toggle=\"modal\" data-target=\"#gestion_taxe-modal\" data-href=\"<?=$url?>manager/arrivees/gestiontaxesejourgest/"+$currentDiv.children().eq(15).attr("data-key")+"\" class=\"btn btn-primary gestion_Taxe\">Gestion Taxe</button>");
                                        $currentDiv.children().eq(15).attr("data-tax","1");
                                    }
                                }
                                $currentDiv.children().eq(5).children().eq(1).html($('#nb_adult').val());
                                $currentDiv.children().eq(6).children().eq(1).html($('#nb_child').val());
                                $currentDiv.children().eq(13).children().eq(1).html($('#comment').val());
                                $currentDiv.children().eq(14).children().eq(1).html($('#commentlocataire').val());
                                $currentDiv=null;
                                //end màj des informations :)                                
                                $.toast().reset('all');
                                $("body").removeAttr('class');
//                                $.toast({
//                                    heading: 'Vous venez de modifier une arrivée',
//                                    text: '',
//                                    position: 'bottom-right',
//                                    loaderBg:'#fec107',
//                                    icon: 'success',
//                                    hideAfter: 4000
//                                });                                
                                $('body').loadingModal('destroy');
                                redraw();
                                }
                                ,error: function(){
                                    $('body').loadingModal('destroy');
                                    $.toast().reset('all');
                                            $("body").removeAttr('class');
                                            $.toast({
                                                heading: 'Erreur',
                                                text: '',
                                                position: 'bottom-right',
                                                loaderBg:'#fec107',
                                                icon: 'error',
                                                hideAfter: 4000
                                            });
                                }
                        });
          }else{
            return false;
          }
        }

}

var table=null;
var oTable=null;
<?php foreach($res as $v):?>    var oTable_<?php echo $v->id?>=null;    <?php endforeach; ?>
    $('#MyLocataires').on('click',function() {
        $('body').loadingModal({
                    position: 'auto',
                    text: 'Chargement en cours',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
        var date = $('#from_date').val();
        var datefin = $('#to_date').val();
        if(date=="") date = "<?php echo date('d-m-Y'); ?>";
        window.location.replace("<?= $url ?>"+"manager/arrivees/nonarrive/"+date);
        window.location.replace("<?= $url ?>"+"manager/arrivees/nonarrive/"+date+"?datefin="+datefin+"&supp="+$('#supp-search').val()+"&limite="+$('#list_1_length').val());
    });
    
    $('#reset').on('click',function() {
        $('body').loadingModal({
                    position: 'auto',
                    text: 'Chargement en cours',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
        window.location.replace("<?= $url ?>"+"manager/arrivees/nonarrive/");
    });
    
    $('#rechercher').on('click',function() {
        redraw();
    });
    
    $('#list_1_length').on('change', function() {
        redraw();
    });
    
    $('.gest_absent').click(function(){
        var datefin = $('#to_date').val();
        $('body').loadingModal({
                    position: 'auto',
                    text: 'Chargement en cours',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
        var id_absent = $(this).attr("data-key");
        var date = $('#from_date').val();
        if(date=="") date = "<?php echo date('d-m-Y'); ?>";
        window.location.replace("<?= $url ?>"+"manager/arrivees/nonarrive/"+date+"?datefin="+datefin+"&absent="+id_absent+"&supp="+$('#supp-search').val()+"&limite="+$('#list_1_length').val());
    });

    $(document).ready(function() {
        
        $("#form_searsh input").keypress(function(e) {
                if(e.which == 13) {
                    redraw();
                }
            });
        
        //gestion taxe
        $(document).on('click', '.gestion_Taxe', function(){
                    $currentDiv = $(this).parent().parent();
                    var href = $(this).attr("data-href");

                            $.ajax({
                            type: "GET",
                            url: href,

                            success:function(xml){
                                $('#gestion_taxe-modal-body').html(xml);
                            }
                            });
                });
        $("#modifiergesttaxearrivee").on('click',function() {
            if($("#frm_gestiontaxesejour").valid()){
                $('body').loadingModal({
                            position: 'auto',
                            text: '',
                            color: '#fff',
                            opacity: '0.7',
                            backgroundColor: 'rgb(0,0,0)',
                            animation: 'doubleBounce'
                        });
                $.ajax({
                  type: "POST",
                  url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/modifiergesttaxearrivee/",
                  data:{vTaxepaye: $('#taxe_paye').val(), vMethodepaye: $('#methode_paye').val(), vReservid: $('#reservid').val()},
                  success:function(xml){
                        $('body').loadingModal('destroy');
                        $('#gestion_taxe-modal').modal('hide');
                        $.toast().reset('all');
                                        $("body").removeAttr('class');
                                        $.toast({
                                            heading: 'Taxe modifiée',
                                            text: '',
                                            position: 'bottom-right',
                                            loaderBg:'#fec107',
                                            icon: 'success',
                                            hideAfter: 3000
                                        });

                    }
                  });
              }
        });
        //end gestion taxe
        //gestion des clés
                $('.gestion_clé').click(function (){
                    $('body').loadingModal({
                        position: 'auto',
                        text: '',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'doubleBounce'
                    });
                    $('#gestion_cle_modal-body').empty();
                    $currentDiv = $(this).parent().parent();
                    var href = $(this).attr("data-href");

                            $.ajax({
                            type: "GET",
                            url: href,

                            success:function(xml){
                                $('#gestion_cle_modal-body').html(xml);
                                $('body').loadingModal('destroy');
                            },error: function(){
                                $('#gestion_cle-modal').modal('hide');
                                $('body').loadingModal('destroy');
                                $.toast().reset('all');
                                        $("body").removeAttr('class');
                                        $.toast({
                                            heading: 'Erreur',
                                            text: 'erreur chargement du popup',
                                            position: 'bottom-right',
                                            loaderBg:'#fec107',
                                            icon: 'error',
                                            hideAfter: 4000
                                        });
                            }
                            });
                });
                
                $("#modifiergestclearrivee").on('click',function() {
                    $('body').loadingModal({
                        position: 'auto',
                        text: '',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'doubleBounce'
                    });
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/modifiergestclearrivee/",
                        data:{vPoscle: $('#poscle').val(), vPcle: $('#p_cle').val(), vReservid: $('#reservid').val()},
                        success:function(xml){
                            $('body').loadingModal('destroy');
                            $currentDiv.children().eq(10).children().eq(1).text(xml);
                            $currentDiv=null;
                            $('#gestion_cle-modal').modal('hide');
                            $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'Vous avez modifié la clé',
                                    text: '',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'success',
                                    hideAfter: 3000
                                });
                        },error: function(){
                        $('body').loadingModal('destroy');
                        $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'Erreur',
                                    text: '',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'error',
                                    hideAfter: 4000
                                });
                    }
                    });
                });
        //fin gestion des clés
        
        //show locataire
        $('.show_locataire').click(function (){
                    $('#modalFicheProprietaire-body').empty();
                    $('body').loadingModal({
                        position: 'auto',
                        text: '',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'doubleBounce'
                    });
                    var href = $(this).attr("data-href");

                            $.ajax({
                            type: "GET",
                            url: href,

                            success:function(xml){
                                $('body').loadingModal('destroy');
                                $('#modalFicheProprietaire-body').html(xml);
                            },error: function(){
                                $('#modalFicheProprietaire').modal('hide');
                                $('body').loadingModal('destroy');
                                $.toast().reset('all');
                                        $("body").removeAttr('class');
                                        $.toast({
                                            heading: 'Erreur',
                                            text: 'erreur chargement du popup',
                                            position: 'bottom-right',
                                            loaderBg:'#fec107',
                                            icon: 'error',
                                            hideAfter: 4000
                                        });
                            }
                            });
                });
        //end show locataire
        
        //send mail
        $('.show_mail').click(function (){
            $('body').loadingModal({
                        position: 'auto',
                        text: '',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'doubleBounce'
                    });
            $('#send_mail-body').empty();
                    var href = $(this).attr("data-href");

                            $.ajax({
                            type: "GET",
                            url: href,

                            success:function(xml){
                                $('body').loadingModal('destroy');
                                $('#send_mail-body').html(xml);
                            },error: function(){
                                $('#send_mail-modal').modal('hide');
                                $('body').loadingModal('destroy');
                                $.toast().reset('all');
                                        $("body").removeAttr('class');
                                        $.toast({
                                            heading: 'Erreur',
                                            text: 'erreur chargement du popup',
                                            position: 'bottom-right',
                                            loaderBg:'#fec107',
                                            icon: 'error',
                                            hideAfter: 4000
                                        });
                            }
                            });
                });
        
        $("#send_mail").on('click',function() {
                $('body').loadingModal({
                position: 'auto',
                text: 'envoi message...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'doubleBounce'
                });

                $.ajax({
                        type: "POST",
                        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/sendmailvalidate/",
                        data:{vFrom:$('#from').val(),vTo:$('#to').val(),vObjet:$('#objet').val(),vMsg:$('#msg').val()},
                        success:function(xml){
                                    $('#send_mail-modal').modal('hide');
                                    $('body').loadingModal('destroy');
                                    $.toast().reset('all');
                                    $("body").removeAttr('class');
                                    $.toast({
                                        heading: 'Message envoyé',
                                        text: '',
                                        position: 'bottom-right',
                                        loaderBg:'#fec107',
                                        icon: 'success',
                                        hideAfter: 3000
                                    });
                                },
                        error: function(){
                            $('body').loadingModal('destroy');
                            $.toast().reset('all');
                            $("body").removeAttr('class');
                            $.toast({
                                heading: 'Erreur',
                                text: '',
                                position: 'bottom-right',
                                loaderBg:'#fec107',
                                icon: 'error',
                                hideAfter: 4000
                            });
                        }
                        });
            });
        //end send mail
        
        //valider l'arrivee
        $(".valider_arrivee").on('click',function() {
		var name = $(this).attr("data-name");
		var id = $(this).attr("data-key");
		var id_g= $(this).attr("data-G");
                $currentDiv = $(this).parent().parent();
                swal({   
                                title: "Validation de l\'arrivée d\'un locataire",   
                                text: "Voulez-vous valider l'arrivée de "+ name +" '", 
                                type: "warning",   
                                showCancelButton: true,   
                                confirmButtonColor: "#e6b034",   
                                confirmButtonText: "OK",
                                cancelButtonText: "ANNULER",  
                                closeOnConfirm: true 
                        }, function(){
                                $('body').loadingModal({
                                    position: 'auto',
                                    text: 'ATTENDEZ SVP...',
                                    color: '#fff',
                                    opacity: '0.9',
                                    backgroundColor: 'rgb(0,0,0)',
                                    animation: 'doubleBounce'
                                  });
                                $.ajax({
                                type: "GET",
                                url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/valider/"+id_g+"/"+id,

                                success:function(xml){
                                        location.reload();
                                  },error: function(){
                                    $('body').loadingModal('destroy');
                                    $.toast().reset('all');
                                            $("body").removeAttr('class');
                                            $.toast({
                                                heading: 'Erreur',
                                                text: '',
                                                position: 'bottom-right',
                                                loaderBg:'#fec107',
                                                icon: 'error',
                                                hideAfter: 4000
                                            });
                                }
                                }); 
                });
        });
        //fin valider l'arrivee
        
        //edit locataire
        $('.edit_locataire').click(function (){
                    $('body').loadingModal({
                        position: 'auto',
                        text: 'envoi message...',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'doubleBounce'
                    });
                    $('#edit_locataire-modal-body').empty();
                    $currentDiv = $(this).parent().parent();
                    var href = $(this).attr("data-href");

                            $.ajax({
                            type: "GET",
                            url: href,

                            success:function(xml){
                                $('#edit_locataire-modal-body').html(xml);
                                $('body').loadingModal('destroy');
                            },error: function(){
                                $('#edit_locataire-modal').modal('hide');
                                $('body').loadingModal('destroy');
                                $.toast().reset('all');
                                        $("body").removeAttr('class');
                                        $.toast({
                                            heading: 'Erreur',
                                            text: '',
                                            position: 'bottom-right',
                                            loaderBg:'#fec107',
                                            icon: 'error',
                                            hideAfter: 4000
                                        });
                            }
                            });
                });
             //function valider appartient a ce bloc  :)   

        //end edit locataire
            	$(".validation_<?php echo $InfoGes['G']['id']?>").on('click',function() {
		var name = $(this).attr("data-name");
		var id = $(this).attr("data-key");
		var id_g= $(this).attr("data-G");
                swal({   
						title: "Validation de l\'arrivée d\'un locataire",   
                                                text: "Voulez-vous valider l'arrivée de "+ name +" '", 
						type: "warning",   
						showCancelButton: true,   
						confirmButtonColor: "#e6b034",   
						confirmButtonText: "OK",
						cancelButtonText: "ANNULER",  
						closeOnConfirm: false 
					}, function(){
                                                $('body').loadingModal({
                                                    position: 'auto',
                                                    text: '',
                                                    color: '#fff',
                                                    opacity: '0.7',
                                                    backgroundColor: 'rgb(0,0,0)',
                                                    animation: 'doubleBounce'
                                                  });
						$.ajax({
						type: "GET",
						url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/valider/"+id_g+"/"+id,

						success:function(xml){
							redraw();
                                                        $('body').loadingModal('destroy');
						  }
						}); 
					});
            });
            
            $("#from_date").datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        defaultDate:new Date(),
                        widgetPositioning:{
                            horizontal: 'right',
                            vertical: 'bottom'
                        },
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
            });
            $("#to_date" ).datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        defaultDate:new Date(),
                        widgetPositioning:{
                            horizontal: 'right',
                            vertical: 'bottom'
                        },
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
            });
            $("#from_date").on('dp.change', function(e){
            $('#to_date').data("DateTimePicker").destroy();

                $('#to_date').datetimepicker({
                                    useCurrent: false,
                                    format: 'DD-MM-YYYY',
                                    defaultDate: e.date.format("YYYY/MM/DD"),
                                    minDate: e.date.format("YYYY/MM/DD"),
                                    icons: {
                                    date: "fa fa-calendar",
                                    up: "fa fa-arrow-up",
                                    down: "fa fa-arrow-down"
                                },
                });
            });
                    

        <?php foreach($res as $v):?>

            $(".validation_<?php echo $v['G']['id']?>").on('click',function() {

		var name = $(this).attr("data-name");
		var id = $(this).attr("data-key");
		var id_g= $(this).attr("data-G");
		var id_g2= <?php echo $v['G']['id']?>;
                swal({   
						title: "Validation de l\'arrivée d\'un locataire",   
                                                text: "Voulez-vous valider l'arrivée de "+ name +" '", 
						type: "warning",   
						showCancelButton: true,   
						confirmButtonColor: "#e6b034",   
						confirmButtonText: "OK",
						cancelButtonText: "ANNULER",  
						closeOnConfirm: false 
					}, function(){
                                                $('body').loadingModal({
                                                    position: 'auto',
                                                    text: '',
                                                    color: '#fff',
                                                    opacity: '0.7',
                                                    backgroundColor: 'rgb(0,0,0)',
                                                    animation: 'doubleBounce'
                                                  });
						$.ajax({
						type: "GET",
						url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/valider/"+id_g+"/"+id+"/"+id_g2,

						success:function(xml){
							redraw();
                                                        $('body').loadingModal('destroy');
						  }
						}); 
					});
            });
            
        <?php endforeach; ?>
            "use strict";
	
	var SweetAlert = function() {};

    //examples 
    SweetAlert.prototype.init = function() {
   
    },
    //init
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert;
	
	$.SweetAlert.init();
              
    } );
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>