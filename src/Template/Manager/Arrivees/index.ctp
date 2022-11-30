<?php $this->start('cssTop'); ?>
<style>
    .input-group-addon:first-child {
        border-color: white;
        background-color: white;
    }
    .pointer {cursor: pointer;}
    .backGroundFonce{
        background-color: #fcfcfc !important;
    }
    .weather-info .left-block-wrap {
        background: #74B9FF !important;
    }
    .font-40{
        font-size: 40px;
    }
    .fullred{
        border-radius: 0px !important;
        background: #74B9FF !important;
    }
    .mt-24{
        border-radius: 0px !important;
        /*margin-top: 24px !important;*/
        background: #74B9FF !important;
        border-color: #74B9FF !important;
        /*position: initial !important;*/
        bottom: 0 !important;
    }
    .hover-div:hover{
        background-color: #f3f3f3;
    }
    .fa-envelope{
        color: #E50B42;
    }
    .icon-envelope-open{
        color:green;
    }
    span.list-group-item {
        color: #272B34;
        border-color: #f5f5f5;
        border-image: none;
        border-radius: 0 !important;
        border-style: solid none;
        border-width: 1px medium;
        border-bottom: none;
        padding: 15px;
    }
    .background_grayleg{
        background-color: #f3f3f3 !important;
    }
    @media only screen and (min-width: 1200px) {
        .meteo-pc{
            height: 226px !important;
        }
        .smt-80{
            position: absolute;
            bottom: 22px;
            width: 85%;
            text-align: center;
        }
        .smt-70{
            position: absolute;
            bottom: 22px;
            width: 73%;
            text-align: center;
        }
        .input-sm{
            width: 20% !important;
        }
        .addon-92{
            font-size: 92% !important;
        }
    }
    @media only screen and (max-width: 1199px) {
        .block_cle{padding-left: 20px !important; padding-right: 20px !important;}
        .smt-80{text-align: center; margin-left: 15%;bottom: 10px;position: relative;}
        .smt-70{text-align: center;bottom: 10px;position: relative;}
    }
</style>
<?php $this->end(); ?>

<div class="row mt-30 meteo-pc">
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
        <div id="weather_3" class="panel panel-default card-view pa-0 weather-info overflow-hide">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="row ma-0">
                        <div class="col-xs-6 pa-0 fullred" id="weatherleft">
                            <div class="left-block-wrap pl-15 pt-30 pb-30">
                                <p class="block nowday font-24"></p>
                                <span class="block nowdate font-20"></span>
                                <div class="left-block  mt-15"></div>
                            </div>
                        </div>
                        <div class="col-xs-6 pa-0" id="weatherright">
                            <div class="right-block-wrap">
                                <div class="right-block pl-30 pr-30"></div>
                            </div>
                            <!--<a class="mt-24 btn btn-block btn-sm btn-danger btn-lable-wrap left-label"> <span class="btn-label"><i class="icon-screen-desktop"></i></span><span class="btn-text">Webcam</span></a>-->
                            <a href="<?php echo $this->Url->build('/',true)?>manager/routes" class="mt-24 btn btn-block btn-sm btn-danger btn-lable-wrap left-label"> <span class="btn-label"><i class="icon-screen-desktop"></i></span><span class="btn-text">Webcam</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($InfoGes['G']['role']!=='admin'): ?>
    <a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/nonarrive">
    <?php else: ?>
    <a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/adminnonarrive">
    <?php endif; ?>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="height: 100%;">
            <div id="card1" class="hover-div panel card-view" style="height: 100%;">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box pb-10">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-2 font-40 text-center data-wrap-left mt-20">
                                        <i class="icon-user-unfollow data-right-rep-icon txt-danger"></i>
                                    </div>
                                    <div class="col-xs-10 text-center data-wrap-right">
                                        <span class="txt-danger block counter"><span id="locNonArrivenb"></span> Locataires non arrivés</span>
                                        <?php foreach ($nonArrivee as $nonArr): ?>
                                            <span class="block"><span class="weight-500"><?= substr($nonArr->heure_arr, -5) ?> : <?= $nonArr['U']['prenom'].' '.$nonArr['U']['nom_famille'] ?></span></span>
                                        <?php endforeach; ?>
                                        <?php if(count($nonArrivee->toArray())>2): ?>
                                        <span class="block"><span class="weight-500 uppercase-font txt-danger">voir liste <span id="locNonArrive"></span></span></span>
                                        <?php endif; ?>
                                    </div>
                                </div>	
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(count($nonArrivee->toArray())<2): ?>
                    <span class="block smt-80"><span class="weight-500 uppercase-font txt-danger">voir liste <span id="locNonArrive"></span></span></span>
                <?php endif; ?>
            </div>
        </div>
    </a>
    <?php if($InfoGes['G']['role']!=='admin'): ?>
    <a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/newarrive">
    <?php else: ?>
    <a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/adminnonarrive">
    <?php endif; ?>
        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" style="height: 100%;">
            <div id="card2" class="panel hover-div card-view" style="height: 100%;">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box pb-10">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 text-center font-40">
                                        <i class="icon-user-following data-right-rep-icon txt-success"></i>
                                    </div>
                                    <div class="col-xs-12 text-center mt-0">
                                        <span class="txt-success block font-20 mb-20 counter"><?= $nbArrivee ?><br> Locataires arrivés</span>	
                                    </div>
                                </div>	
                            </div>
                        </div>
                    </div>
                </div>
                <span class="block smt-70"><span class="weight-500 uppercase-font txt-success">voir liste <?= $nbArrivee>3?('+ '.($nbArrivee-3).' autres'):'' ?></span></span>
            </div> 
        </div>
    </a>
    <div style="height: 100%;" class="col-lg-4 col-md-12 col-sm-12 col-xs-12 <?php if(count($Taxes)>0):?> pointer <?php endif; ?> " <?php if(count($Taxes)>0): ?>data-toggle="modal" data-target="#modal-Taxes_non_payé" <?php endif; ?> >
        <div id="card3" class="panel hover-div card-view" style="height: 100%;">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box pb-10">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-2 text-center data-wrap-left mt-25">
                                    <i class="fa fa-euro fa-3x data-right-rep-icon txt-warning"></i>
                                </div>
                                <div class="col-xs-10 text-center data-wrap-right">
                                    <span class="txt-warning block counter icantSelectIt">Taxes non payées</span>
                                    <?php if(count($Taxes)==0): ?>
                                    <span class="block pt-50"><span class="icantSelectIt weight-500 uppercase-font txt-warning">Pas de taxes pour cette semaine</span></span>
                                    <?php endif; ?>
                                    <?php for ($i = 0; $i < 3 && $i < count($Taxes); $i++): ?>
                                    <span class="block"><span class="weight-500"><?= $Taxes[$i]->dbt_at->i18nFormat('dd/MM').' - '.$Taxes[$i]->fin_at->i18nFormat('dd/MM').' : '.$Taxes[$i]->heure_dep->i18nFormat('HH:mm') ?>: <?= $Taxes[$i]['U']['prenom'].' '.$Taxes[$i]['U']['nom_famille'] ?>, <span class="txt-danger"><span class="counter-anim"><?= $Taxes[$i]['taxe'] ?></span> €</span></span></span>
                                    <!-- <span class="block"><span class="weight-500"><?php // echo substr($Taxes[$i]->dbt_at,0,5).' - '.substr($Taxes[$i]->fin_at,0,5).' : '.substr($Taxes[$i]->heure_dep, -5, 5) ?>: <?php // echo $Taxes[$i]['U']['prenom'].' '.$Taxes[$i]['U']['nom_famille'] ?>, <span class="txt-danger"><span class="counter-anim"><?php // echo $Taxes[$i]['taxe'] ?></span> €</span></span></span> -->
                                    <?php endfor; ?>
                                    <?php if(count($Taxes)>2):?>
                                    <span class="block"><span class="weight-500 uppercase-font txt-warning">voir plus <?= count($Taxes)>3?('+ '.(count($Taxes)-3).' autres'):'' ?></span></span>
                                    <?php endif; ?>
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
            <?php if(count($Taxes)<=2): ?>
                <span class="block smt-80"><span class="weight-500 uppercase-font txt-warning">voir plus <?= count($Taxes)>3?('+ '.(count($Taxes)-3).' autres'):'' ?></span></span>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row ma-0 pa-0"></div>
<div class="row mt-20">
    <div class="col-lg-6 col-md-8 col-sm-12">
        <div class="panel card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box pt-10 pb-10">
                        <div class="container-fluid pa-0">
                            <div class="row ma-0 pa-0 text-center data-wrap-right">
                                <span class="txt-primary block counter"><i class="icon-key data-right-rep-icon txt-primary"></i> Emplacement d'une clé</span>
                            </div>
                            <span class="block block_cle">
                                <span class="weight-500">
                                    <form action="#" id="form_Cle" class="form-inline text-center">
                                        <div class="elementOF_searchCle mt-5 input-group">
                                            <div class="input-group-addon addon-92">
                                                Chercher Par:
                                            </div>
                                            <select id="cleSelect" name="cleSelect" class="form-control input-small">
                                                <option value="appart">Appartement</option>
                                                <option value="prop">propriétaire</option>
                                            </select>
                                        </div>
                                        <input class="form-control input-sm elementOF_searchCle mt-5" type="text" id="cleInput" name="cleInput" autocomplete="off">
                                        <button type="submit" href="#" class="mt-5 pl-10 pr-10 elementOF_searchCle btn btn-primary"><i class="icon-magnifier"></i></button>
                                    </form>
                                </span>
                            </span>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($InfoGes['G']['role']!=='admin'): ?>
    <a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/mescontrat/">
    <?php else: ?>
    <a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/admincontrat">
    <?php endif; ?>
        <div class="col-lg-3 col-sm-6">
            <div class="panel hover-div card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box pt-10 pb-10">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-9 text-center data-wrap-left">
                                        <span class="txt-dark block counter"><span class="counter-anim"><?= $NbContratsDiabled ?></span></span>
                                        <span class="block"><span class="weight-500 uppercase-font">CONTRATS À ACTIVER</span></span>	
                                        <span class="block"><span class="weight-500 uppercase-font">Voir tous</span></span>	
                                    </div>
                                    <div class="col-xs-3 text-center data-wrap-right">
                                        <i class="icon-briefcase data-right-rep-icon txt-success mb-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <a/>
    <?php if($InfoGes['G']['role']!=='admin'): ?>
    <a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/annonce/">
    <?php else: ?>
    <a href="<?php echo $this->Url->build('/',true)?>manager/annonces/index">
    <?php endif; ?>
        <div class="col-lg-3 col-sm-6">
            <div class="panel hover-div card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box pt-10 pb-10">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-9 text-center data-wrap-left">
                                        <span class="txt-dark block counter"><span class="counter-anim"><?= $annoncesWaitingForConfurm ?></span></span>
                                        <span class="block"><span class="weight-500 uppercase-font">ANNONCES À VALIDER</span></span>
                                        <span class="block"><span class="weight-500 uppercase-font">Voir tous</span></span>	
                                    </div>
                                    <div class="col-xs-3 text-center data-wrap-right">
                                        <i class=" icon-book-open data-right-rep-icon txt-success mb-30"></i>
                                    </div>
                                </div>	
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-default border-panel card-view" id="messageContainer">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                        <h6 class="panel-title txt-dark">Boîte de réception</h6>
                </div>
                <div class="pull-right pointer">
                    <a data-toggle="modal" data-target="#modal_add" id="add_message_button" class="btn btn-sm mr-5 btn-success">Nouveau</a>
                    <a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/message" class="btn btn-sm mr-5 btn-default">Ma boite mail</a>
                    <span id="refreshMessages" class="data-text weight-500 pr-5">rafraîchir <i class="zmdi zmdi-replay"></i></span>	
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <table id="datable_1" class="table table-hover display  pb-30" >
                            <thead>
                                    <tr>
                                        <th data-priority="5">&nbsp;</th>
                                        <th data-priority="2">De</th>
                                        <th data-priority="1">Rôle</th>
                                        <th data-priority="3">Sujet</th>
                                        <th data-priority="4">Date</th>
                                    </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="panel panel-default border-panel card-view">
            <div class="panel-heading icantSelectIt">
                    <div class="pull-left">
                            <h6 class="panel-title txt-dark">Activités récentes</h6>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper task-panel collapse in">
                <div class="panel-body row pa-0">
                    <div class="list-group mb-0">
                        <span href="#" class="list-group-item">
                            <span id="timeline1-date" class="badge transparent-badge badge-success capitalize-font"></span>
                                <p class="pull-left">
                                    <span id="timeline1-icon-container" class=""></span>
                                    <span id="timeline1-title" class="txt-black"></span>
                                </p>
                                <div class="clearfix"></div>
                        </span>
                        <span href="#" class="list-group-item background_grayleg">
                            <span id="timeline2-date" class="badge transparent-badge badge-success capitalize-font"></span>
                                <p class="pull-left">
                                    <span id="timeline2-icon-container" class=""></span>
                                    <span id="timeline2-title" class="txt-black"></span>
                                </p>
                                <div class="clearfix"></div>
                        </span>
                        <span href="#" class="list-group-item">
                            <span id="timeline3-date" class="badge transparent-badge badge-success capitalize-font"></span>
                                <p class="pull-left">
                                    <span id="timeline3-icon-container" class=""></span>
                                    <span id="timeline3-title" class="txt-black"></span>
                                </p>
                                <div class="clearfix"></div>
                        </span>
                        <span href="#" class="list-group-item background_grayleg">
                            <span id="timeline4-date" class="badge transparent-badge badge-success capitalize-font"></span>
                                <p class="pull-left">
                                    <span id="timeline4-icon-container" class=""></span>
                                    <span id="timeline4-title" class="txt-black"></span>
                                </p>
                                <div class="clearfix"></div>
                        </span>
                        <span href="#" class="list-group-item">
                            <span id="timeline5-date" class="badge transparent-badge badge-success capitalize-font"></span>
                                <p class="pull-left">
                                    <span id="timeline5-icon-container" class=""></span>
                                    <span id="timeline5-title" class="txt-black"></span>
                                </p>
                                <div class="clearfix"></div>
                        </span>
                        <span href="#" class="list-group-item background_grayleg">
                            <span id="timeline6-date" class="badge transparent-badge badge-success capitalize-font"></span>
                                <p class="pull-left">
                                    <span id="timeline6-icon-container" class=""></span>
                                    <span id="timeline6-title" class="txt-black"></span>
                                </p>
                                <div class="clearfix"></div>
                        </span>
                        <span href="#" class="list-group-item">
                            <span id="timeline7-date" class="badge transparent-badge badge-success capitalize-font"></span>
                                <p class="pull-left">
                                    <span id="timeline7-icon-container" class=""></span>
                                    <span id="timeline7-title" class="txt-black"></span>
                                </p>
                                <div class="clearfix"></div>
                        </span>
                        <span href="#" class="list-group-item background_grayleg">
                            <span id="timeline8-date" class="badge transparent-badge badge-success capitalize-font"></span>
                                <p class="pull-left">
                                    <span id="timeline8-icon-container" class=""></span>
                                    <span id="timeline8-title" class="txt-black"></span>
                                </p>
                                <div class="clearfix"></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.add modal -->
<div id="modal_add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title">Envoyer message</h5>
            </div>
            <div id="modal_add_body" class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label mb-10">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label mb-10">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button id="send_mail" type="button" class="btn btn-danger">Envoyer</button>
            </div>
        </div>
    </div>
</div>

<!-- sample modal content -->
<div id="modal-Taxes_non_payé" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Taxes non payées</h5>
            </div>
            <div class="modal-body">
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table id="datable_taxe" class="table table-hover display  pb-30" >
                            <thead>
                                <tr>
                                    <th data-priority="1">date d'arrivée</th>
                                    <th data-priority="1">date de départ</th>
                                    <th data-priority="5">gestionnaire</th>
                                    <th data-priority="3">email</th>
                                    <th data-priority="4">portable</th>
                                    <th data-priority="2">taxe</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_table">
                                <?php foreach ($Taxes as $taxe): ?>
                                <tr>
                                    <td><?= $taxe->dbt_at->i18nFormat('dd/MM/yy') ?></td>
                                    <td><?= $taxe->fin_at->i18nFormat('dd/MM/yy') ?></td>
                                    <td><?= $taxe['G']['name'] ?></td>
                                    <td><?= $taxe['U']['email'] ?></td>
                                    <td><?= $taxe['U']['portable'] ?></td>
                                    <td class="text-danger"><?= $taxe['taxe'] ?> &euro;</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- view modal content -->
<div id="View_Message" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Message</h5>
            </div>
            <div id="View_Message_body" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
            <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- view modal content -->
<div id="View_cle" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title">Emplacement clé</h5>
                </div>
            <div id="View_cle_body" class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 pa-0">
                        <div class="table-wrap">
                            <div id="View_cle_datable_container" class="table-responsive">
                                <table id="View_cle_datable" class="table table-hover display  pb-30" >
                                    <thead>
                                        <tr>
                                            <th>Position de clé</th>
                                            <th>Résidence</th>
                                            <th>ID Appartement</th>
                                            <th>Numéro d'appartement</th>
                                            <th>Propriétaire </th>
                                            <th>Email </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
            <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery.counterup/jquery.counterup.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<!-- simpleWeather JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/locale/fr.js", array('block' => 'scriptBottom')); ?>

<!-- Select2 JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
      /*Current Time Cal*/
    var getCurrentTime = function(){
        moment.locale('fr');
        var nowDate = moment().format('L');
        var nowDay = moment().format('dddd');
        $('.nowday').html(nowDay);
        $('.nowdate').html(nowDate);
    };
    
    var table_cle=null;
    
    function getTimeline(){
        $.ajax({
            type: "get",
            url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getChanges<?= $InfoGes['G']['role']!='admin'?'/'.$InfoGes['G']['id']:'' ?>",
            success:function(data){
                var element="#timeline";
                var i =1;
                for(row in data){
                    if(data[row].creation == "1"){
                        var day = moment(data[row].created_at);
                        var clas="badge transparent-badge badge-success  font-15 capitalize-font";
                        var icon = '<i class="icon-note font-15 text-success"></i>';
                        var tit = data[row].utilisateur.nom_famille+'.'+data[row].utilisateur.prenom.substr(0, 1)+' a créé une annonce N°'+data[row].id;
                    }
                    else{
                        var day = moment(data[row].updated_at);
                        var clas="badge transparent-badge badge-warning  font-15 capitalize-font";
                        var icon = '<i class="icon-wrench font-15 text-warning"></i>';
                        var tit = data[row].utilisateur.nom_famille+'.'+data[row].utilisateur.prenom.substr(0, 1)+' a modifié l\'annonce N°'+data[row].id;
                    }
                    $(element+i+'-date').html(day.format("D/M/YY - H:m:s"));
                    var ntitre= tit.length>50?tit.substr(0, 50)+'...':tit;
                    $(element+i+'-title').html(ntitre);
                    //$(element+i+'-parag').html(data[row].utilisateur.nom_famille+" "+data[row].utilisateur.prenom);
                    $(element+i+'-date').attr("class",clas);
                    $(element+i+'-icon-container').html(icon);
                    i++;
                }
                setTimeout("getTimeline();",10000);
            },
            error:function(){

            },
        });
    }

    $( document ).ready(function() {
        $( "#form_Cle" ).on( "submit", function( event ) {
            event.preventDefault();
            var cond=$('#cleSelect').val();
            var arg=$('#cleInput').val();
            if(table_cle!=null)
            table_cle.destroy();
            write_table_cle();
            $('#View_cle').modal('show');
            table_cle.columns.adjust().responsive.recalc();;
        });

        getTimeline();
        
        $("#send_mail").on('click',function() {
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
                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/setmessage/",
                data:{vId:$('#de').val(),vType:$('#gestionnaire').val(),vSujet:$('#objet').val(),vMsg:$('#msg').val()},
                success:function(xml){
                    $('#modal_add').modal('hide');
                    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: 'Message envoyé',
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'success',
                        hideAfter: 5000
                    });
                    table.ajax.reload(null, false);
                    $('body').loadingModal('destroy');
                },
                error:function(){
                    $('#modal_add').modal('hide');
                    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: 'Erreur',
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'error',
                        hideAfter: 5000
                    });
                    $('body').loadingModal('destroy');
                }
            });
	});
    
        $("#add_message_button").click(function(){
            $("#modal_add_body").empty();
            $.ajax({
                type: "get",
                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/addmessage/",
                success:function(xml){
                    $("#modal_add_body").html(xml);
                },
                error:function(){
                    $('#modal_add').modal('hide');
                    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: 'Erreur',
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'error',
                        hideAfter: 5000
                    });
                    $('body').loadingModal('destroy');
                }
            });
        });
        
        $('#datable_taxe').DataTable({
            "ordering": false,
            "pageLength": 5,
            "info":     false,
            "searching": false,
            "lengthChange" : false,
            responsive: true,
            "columnDefs": [
                { "type": 'date-euro', "targets": 0 },
                { "type": 'date-euro', "targets": 1 },
            ],
            "language": language_data_table
        });
        
        getCurrentTime();
        //Get the initial weather.
        if( $('#weather_3').length > 0 ){
            var $this = $('#weather_3');
            $.ajax({
                url: "https://api.openweathermap.org/data/2.5/weather?id=3030949&appid=8d7b049e71efa4f8d0edc701ace1e19c&lang=fr&units=metric",
              }).done(function(weather) {
                var html='<span class="block temprature">'+Math.round(weather.main.temp)+'<span class="unit">&deg;'+ 'C' +'</span></span>';
                    $this.find('.left-block').html(html);
                    //html='<span class="block temprature-icon"><img src="http://openweathermap.org/img/w/'+weather.weather[0].icon+'.png"/></span><h6>'+weather.name+'</h6>';
                    html='<span class="block temprature-icon"><img src="<?php echo $this->Url->build('/',true)?>manager-arr/weathericons-img/'+weather.weather[0].icon+'.svg"/></span><h6>'+weather.name+'</h6>';
                    $this.find('.right-block').html(html);
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    /*Without Forcast*/
                    $.ajax({
                        url: "https://api.openweathermap.org/data/2.5/weather?lat="+position.coords.latitude+"&lon="+position.coords.longitude+"&appid=8d7b049e71efa4f8d0edc701ace1e19c&lang=fr&units=metric",
                      }).done(function(weather) {
                        var html='<span class="block temprature">'+Math.round(weather.main.temp)+'<span class="unit">&deg;'+ 'C' +'</span></span>';
                            $this.find('.left-block').html(html);
                            //html='<span class="block temprature-icon"><img src="http://openweathermap.org/img/w/'+weather.weather[0].icon+'.png"/></span><h6>'+weather.name+'</h6>';
                            html='<span class="block temprature-icon"><img src="<?php echo $this->Url->build('/',true)?>manager-arr/weathericons-img/'+weather.weather[0].icon+'.svg"/></span><h6>'+weather.name+'</h6>';
                            $this.find('.right-block').html(html);
                    });
                });
            }
            var divone = $this.find('#weatherleft').height();
            var divtwo = $this.find('#weatherright').height();
            
            var maxdiv = Math.max(divone, divtwo);
            
            $this.find('#weatherleft').height(maxdiv);
            $this.find('#weatherright').height(maxdiv);
       }
        
        $('#rechercher').click(function(){
            <?php if($InfoGes['G']['role']=='admin'): ?>
                window.location.assign("<?php echo $this->Url->build('/',true)?>manager/arrivees/adminnonarrive?date="+$('#from_date').val());
            <?php else: ?>
                window.location.assign("<?php echo $this->Url->build('/',true)?>manager/arrivees/nonarrive/"+$('#from_date').val());
            <?php endif; ?>
        });
        
        $.ajax({
            type: "GET",
            url: "<?php echo $this->Url->build('/',true);?>manager/arrivees/nonarriveForLayout/",
            success:function(xml){
                $('#locNonArrivenb').html(xml);
                nb=parseInt(xml);
                if(nb>3)
                $('#locNonArrive').html('+ '+(nb-3)+' autres');
            }
        });
        //messages
        write_table();
        
        $(document).on('click', ".modifier_taxe", function () {
            $('body').loadingModal({
                position: 'auto',
                text: '',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'rotatingPlane'
            });
            $("#View_Message_body").empty();
            var id = $(this).attr("data-key");
            $.ajax({
                type: "get",
                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/viewmessage/"+id,
                success:function(xml){
                        $("#View_Message_body").html(xml);
                        table.ajax.reload(null, false);
                        $('body').loadingModal('destroy');
                        },
                error:function(){
                    $('#View_Message').modal('hide');
                    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: 'Erreur',
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'error',
                        hideAfter: 5000
                    });
                    $('body').loadingModal('destroy');
                }
            });
        });
        
        $("#refreshMessages").click(function(){
            $('#messageContainer').loadingModal({
                position: 'auto',
                text: '',
                color: '#fff',
                opacity: '0.9',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'rotatingPlane'
            });
            table.ajax.reload();
        });
    });
    //end messages
    
    function formatDate() {
        var d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('-');
    }
    
    
    
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-euro-pre": function ( a ) {
            var x;

            if ( $.trim(a) !== '' ) {
                var frDatea = $.trim(a).split(' ');
                var frTimea = (undefined != frDatea[1]) ? frDatea[1].split(':') : [00,00,00];
                var frDatea2 = frDatea[0].split('/');
                x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + ((undefined != frTimea[2]) ? frTimea[2] : 0)) * 1;
            }
            else {
                x = Infinity;
            }

            return x;
        },

        "date-euro-asc": function ( a, b ) {
            return a - b;
        },

        "date-euro-desc": function ( a, b ) {
            return b - a;
        }
    });
    
    function write_table_cle(){
    table_cle=$('#View_cle_datable').DataTable({
            "ordering": false,
            "pageLength": 4,
            "searching": false,
            "lengthChange" : false,
            "info":     false,
            "ajax": {
                "url": "<?php echo $this->Url->build('/',true)?>manager/arrivees/arraygestioncle/",
                "data": function ( d ) {
                    d.cond = $('#cleSelect').val();
                    d.arg = $('#cleInput').val();;
                }
              },
            "language": language_data_table,

        });
    }
    
    function write_table(){
        table=$('#datable_1').DataTable({
            "ordering": false,
            "pageLength": 4,
            "info":     false,
            "searching": false,
            "lengthChange" : false,
            responsive: true,
            "ajax": "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/arraymessage?limit=10",
            "createdRow": function ( row, data, index ) {
                if ( data[4].includes("data-oppened='true'") ) {
                    $(row).addClass('backGroundFonce');
                }
            },
            "columnDefs": [
                { "type": 'date-euro', "targets": 3 },
                { responsivePriority: 1, targets: [0,-1] },
            ],
            "drawCallback": function() {
                $('#messageContainer').loadingModal('destroy');
            },
            "language": language_data_table
        });
    }

<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>