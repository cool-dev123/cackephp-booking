<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green; font-size: 20px; }
        .exclamation-circle{ color:red; font-size: 20px; }
        .dtr-data center a:first-of-type{ margin-right: 10px !important;  }
        @media only screen and (min-width: 1200px) and (max-width: 1899px) {
            td center a:first-of-type button {margin-bottom: 3px;} 
        }
        @media only screen and (min-width: 1900px) {
            td center a:first-of-type button {margin-right: 10px !important;  } 
        }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="icon-home"></i> Annonces</span>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Toutes les Annonces</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/annonce/">Annonces en attente de validation</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/commentaires/">Valider Commentaires</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                    <div class="pull-left">
                            <h6 class="panel-title txt-dark">Liste Des Annonces</h6>
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
                                                <th>ID</th>
                                                <th>Modification</th>
                                                <th>Bâtiment</th>
                                                <th>N°App</th>
                                                <th>E-mail</th>
                                                <th>Propr</th>
                                                <th>Avis Général</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>ID</th>
                                                <th>Modification</th>
                                                <th>Bâtiment</th>
                                                <th>N°App</th>
                                                <th>E-mail</th>
                                                <th>Propr</th>
                                                <th>Avis Général</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.modal -->
<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title">Choisir Gestionnaire</h5>
            </div>
            <div id="modal-body" class="modal-body">
                <!--content loaded by ajax-->
            </div>
            <div class="modal-footer">
                    <button id="recherche_annuler" type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="modifiergest" type="button" class="btn btn-danger">Modifier</button>
            </div>
        </div>
    </div>
</div>
<!-- /.editProp-modal -->
<div id="editProp-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="editProp-modal-title">Modifier Propriétaire</h5>
            </div>
            <div id="editProp-modal-body" class="modal-body">
                <!--content loaded by ajax-->
                <form id="AnnoncePropForm">
                    <div class="form-group">
                        <label class="control-label mb-10">Nouveau propriétaire</label>
                        <select class="form-control select2" id="AnnonceNewProp">
                            <?php foreach ($props as $prop): ?>
                                <option value="<?= $prop->id ?>"><?= $prop->email.' | '.$prop->nom_famille ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                    <button id="modifierProp_annuler" type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="modifierProp" type="button" class="btn btn-danger">Modifier</button>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var table =null;
    var oldProp=null;
    var annonceForEdit=null;
    var propEdited=false;
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-eu-pre": function ( date ) {
      if(date == null) date = "";

        date = date.replace(" ", "");

        if ( ! date ) {
            return 0;
        }

        var year;
        var eu_date = date.split(/[\.\-\/]/);

        /*year (optional)*/
        if ( eu_date[2] ) {
            year = eu_date[2];
        }
        else {
            year = 0;
        }

        /*month*/
        var month = eu_date[1];
        if ( month.length == 1 ) {
            month = 0+month;
        }

        /*day*/
        var day = eu_date[0];
        if ( day.length == 1 ) {
            day = 0+day;
        }

        return (year + month + day) * 1;
    },

    "date-eu-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-eu-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );

    $(document).on('click', ".editProp", function () {
        propEdited=false;
        oldProp=$(this).attr("data-prop");
        annonceForEdit=$(this).attr("data-annonce");
        $('#AnnonceNewProp').val(oldProp).trigger('change');
        $('#AnnonceNewProp').select2();
        $('#editProp-modal').modal('show');
    });
    
    $('#modifierProp').click(function(){
        var prop=$('#AnnonceNewProp').val();
        if(prop!=oldProp||oldProp==null){
            $.ajax({
                type: "POST",
                async: true,
                url: "<?php echo $this->Url->build('/',true)?>manager/annonces/setProprietaire",
                data:{IDprop:prop, IdAnnonce:annonceForEdit},
                success:function(xml){
                    $('body').loadingModal({
                        position: 'auto',
                        text: 'Modification en cours...',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'doubleBounce'
                    });
                    propEdited=true;
                    table.ajax.reload(null,false);
                  }
            });
        }
    });
    
    $(document).ready(function() {

            table = $('#datable_1').DataTable({
            responsive: true,
            "rowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                $('body').loadingModal('destroy');
                $('#editProp-modal').modal('hide');
                if(propEdited==true){
                    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: 'Vous avez modifié le propriétaire de l\'annonce',
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'success',
                        hideAfter: 5000
                    });
                }
            },
            "ajax": "<?php  echo $this->Url->build('/',true) ?>manager/gestionnaires/arrayannonce",
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
              
    });
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: '<?php echo $confirm_res ?>',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 4000
                        });
    <?php endif;?>
                        
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
    
<!-- select2 CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>