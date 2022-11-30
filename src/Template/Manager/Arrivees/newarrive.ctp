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
        @media screen and (max-width: 767px) {
            #rechercher {margin-top: 1%;}
        }
        .panel_content div {
            margin-top: 2%;
            margin-bottom: 1%;
        }
        .input-group-addon:first-child {
            border-color: #f7f7f9;
            background-color: #f7f7f9;
        }
        .addon-90{
            font-size: 92% !important;
        }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="icon-user-following"></i> Gestion des arrivées</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/nonarrive">Locataires non arrivés</a></li>
      <li class="active"><a href="#">Locataires arrivés</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Les locataires arrivés</h6>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <form id="form_searsh" class="form-inline">
                                <div class="elementOF_searchCle mt-5 input-group mt-5">
                                        <div class="input-group-addon addon-92">
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
                                        <div class="input-group-addon addon-92">
                                                Rechercher :
                                        </div>
                                    <input class="form-control" type="text" id="supp-search" value="<?= $this->request->query['supp'] ?>" autocomplete="off" />
                                </div>
                                <button type="button" id="rechercher" href="#" class="mt-5 btn btn-primary">Rechercher</button>
                                <button type="button" id="reset" href="#" class="mt-5 btn btn-primary">reset</button>
                            </form>
<!--                            <form class="form-inline">
                                <span>Date :</span>
                                <input class="form-control date" type="text" id="from_date" value="<?php echo $dateChoisis ?>" autocomplete="off" />
                                <button type="button" id="rechercher" href="#" class="btn btn-primary">Rechercher</button><br><br>
                                <p class="nb_non_arrvee"></p>
                            </form>-->
                        </blockquote>
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
                                                <?php if(count($arrives)>0): ?>
                                                <h6 class="panel-title txt-light">LES LOCATAIRES ARRIVÉS  <span class="badge badge-light ml-5 mb-5"> <?=$countArrives?></span></h6>
                                                <?php else: ?>
                                                <h6 class="panel-title txt-light text-center" style="text-align: center;">Pas de locataires</h6>
                                                <?php endif; ?>
                                            </div>
                                            <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-wrapper collapse in">
                                        
                                            <?php $i=0; foreach ($arrives as $arr): ?>
                                            <div class="panel-body">
                                            <div <?php $i++; if($i%2==0) echo 'style="background-color: #f2f2f2;"'; ?> class="row panel_content">
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">Date d'arrivée : </span> <span class="pl-5"><?= $arr->dbt_at->i18nFormat('dd-MM-yyyy') ?></span></div>
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">Date de départ : </span> <span class="pl-5"><?= $arr->fin_at->i18nFormat('dd-MM-yyyy') ?></span></div>
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">Nom du locataire : </span> <span class="pl-5"><?= $arr['U']['prenom']." ".$arr['U']['nom_famille'] ?></span></div>
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">Téléphone : </span> <span class="pl-5"><?= getFormatFrenchPhoneNumber($arr['U']['portable'], true); ?></span></div>
                                                <div class="col-lg-6 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">E-mail :&nbsp;</span>&nbsp;<?= $arr['U']['email'] ?></div>
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">NB adulte(s) :&nbsp;</span>&nbsp;<?= $arr->nb_adultes ?></div>
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">enfant(s) :&nbsp;</span>&nbsp;<?= $arr->nb_enfants ?></div>
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">Village :&nbsp;</span>&nbsp;<?= $arr['V']['name'] ?></div>
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">Résidence :&nbsp;</span>&nbsp;<?= $arr['RS']['name'] ?></div>
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">N° app :&nbsp;</span>&nbsp;<?= $arr['A']['num_app'] ?></div>
                                                <div class="col-lg-3 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">Position clé :&nbsp;</span>&nbsp;<span><?= $arr['A']['position_cle'] ?></span></div>
                                                <div class="col-lg-6 col-md-6"><span class="pull-left weight-600 txt-dark uppercase-font">Taxe de séjour à collecter :&nbsp;</span>&nbsp;<span class="label  <?= $arr->taxe==0?"label-danger":"label-success" ?>" ><?= $arr->taxe==0?"Non":"Oui" ?></span></div>
                                                <div class="col-lg-4 col-md-4"><span class="pull-left weight-600 txt-dark uppercase-font">Taxe :&nbsp;</span>&nbsp;<?= $taxes[$arr->id].' &euro; <p class="txt-danger font-16">'.$messageimpo[$arr->id].'</p>'; ?></div>
                                                <div class="col-lg-6 col-md-6"><span class="pull-left weight-600 txt-dark uppercase-font">Commentaire Propriétaire :&nbsp;</span>&nbsp;<?= $arr->comment ?></div>
                                                <div class="col-lg-6 col-md-6"><span class="pull-left weight-600 txt-dark uppercase-font">Commentaire Locataire :&nbsp;</span>&nbsp;<?= $arr->commentlocataire ?></div>
                                                <div class="col-sm-12">
                                                    <button data-href="<?= $url."manager/arrivees/gestionclearrigest/".$arr['A']['id']."/".$arr->id."/new" ?>" data-toggle="modal" data-target="#gestion_cle-modal" class="gestion_clé btn btn-warning pull-right">Gestion clé</button>
                                                </div>
                                            </div>
                                            </div>
                                            <?php endforeach; ?>
                                    </div>
                            </div>
                        </div>
                        <?php if($this->Paginator->total() > 1): ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <ul class="pagination">
                                    <?php
                                    echo $this->Paginator->first(__('Premier', true), array('tag' => 'li', 'escape' => false), array('type' => "button",'model'=> 'Reservations', 'class' => "btn btn-default"));
                                    echo $this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled','model'=> 'Reservations', 'tag' => 'li', 'escape' => false));
                                    echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active','model'=> 'Reservations', 'currentTag' => 'a'));
                                    echo $this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled','model'=> 'Reservations', 'tag' => 'li', 'escape' => false));
                                    echo $this->Paginator->last(__('Dernier', true), array('tag' => 'li', 'escape' => false), array('type' => "button",'model'=> 'Reservations', 'class' => "btn btn-default"));
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    
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
            window.location.replace("<?= $url ?>"+"manager/arrivees/newarrive/"+date+"?supp="+$('#supp-search').val()+"&limite="+$('#list_1_length').val());
        else
            window.location.replace("<?= $url ?>"+"manager/arrivees/newarrive/"+date+"?datefin="+datefin+"&supp="+$('#supp-search').val()+"&limite="+$('#list_1_length').val());
    }
    
    $('#list_1_length').on('change', function() {
        redraw();
    });
    
    $('#rechercher').on('click',function() {
        redraw();
    });

    var $currentSpan=null;
    $(document).ready(function() {
        
        $("#reset").click(function (){
            window.location.replace("<?= $url ?>"+"manager/arrivees/newarrive");
        });
        
        $("#form_searsh input").keypress(function(e) {
                if(e.which == 13) {
                    redraw();
                }
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
                    $currentSpan.text(xml);
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
                }
            });
        });
        
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
            $currentSpan = $(this).parent().parent().children().eq(10).children().eq(1);
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
                                    text: '',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'error',
                                    hideAfter: 4000
                                });
                    }
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