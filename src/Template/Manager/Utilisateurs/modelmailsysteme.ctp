<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-settings  mr-10"></i> Configuration</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/pub">Publicités</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/packs/index">Packs De Services</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/parametrage/gps">Points GPS</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/index">Liste Des Gestionaires</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/8">Gestion Des Pages</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/cautions/index">Résidences de tourisme</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/stations/">Stations</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/vacances/">Vacances</a></li>
      <li class="active"><a href="#">Gestion de modèles</a></li>
    </ul>
  </div>
</nav>

<div class="row icantSelectIt">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view mt-0 pt-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="text-center button-list">
                            <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelmail">Modèle mail</a>
                            <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelsms">Modèle sms</a>
                            <?php if($InfoGes['G']['role']!="admin"): ?><a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/blocmailgestionnaire">Blocs Mails Système</a><?php endif; ?>
                            <?php if($InfoGes['G']['role']=="admin"): ?>
                            <button class="btn btn-success mt-5">Modèle Mail Systéme</button>
                            <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelsmsysteme">Modèle Sms Systéme</a>
                            <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/modelcontrat">Modèle Contrat</a>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row icantSelectIt">
    <div class="col-sm-12">
        <div class="panel panel-default card-view mt-0 pt-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="text-center button-list">
                            <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/blocmailgestionnaire">Blocs Mails Système</a>
                            <a class="btn btn-default mt-5" href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/blocservicemailgestionnaire">Blocs Services Mails Système</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                        <h6 class="panel-title txt-dark">Modele mail système</h6>
                </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th>Modele</th>
                                            <th>Indication</th>
                                            <th>Destinataire</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                            <th>Modele</th>
                                            <th>Indication</th>
                                            <th>Destinataire</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach($modelmessage as $key=>$enr):?>
                                        <tr>
                                                <td><?php echo $enr->titre?></td>
                                                <td><?php echo $enr->indication?></td>
                                                <td><?php echo $enr->destinataire?></td>
                                                <td>
                                                    <center>
                                                        <button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href='<?php echo $this->Url->build('/',true)?>manager/utilisateurs/editmodelsysteme/<?php echo $enr->id;?>'" ><i class="fa fa-pencil"></i></button>
                                                    </center>
                                                </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    $(document).ready(function() {

            $('#datable_1').DataTable({
            responsive: true,
            "language": language_data_table
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

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>