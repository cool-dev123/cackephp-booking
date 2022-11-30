<?php $this->start('cssTop'); ?>
    <style>
        @media screen and (min-width: 768px) and (max-width: 1163px) {
            .form-inline .form-control { width: 15% !important; }
            .costum_span{ font-size: 80% !important;}
        }
        @media screen and (max-width: 767px) {
            .form-inline .btn {margin-top: 1%; padding: 8px 25px;}
        }
        .dtr-data center a:first-of-type{ margin-bottom: 3px !important;  }
        td center a:first-of-type button{ margin-right: 5px;  }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="icon-home"></i> Annonces</span>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Toutes les Annonces</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/index">Annonces en attente de validation</a></li>
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
                    <div>
                        <blockquote style="text-align:center;">
                            <form class="form-inline">
                                <span>Chercher annonces sans periode</span><br><br>
                                <span>Date de début: </span>
                                <input autocomplete="off" class="form-control date" type="text" id="from_date" />
                                <span>Date de fin: </span>
                                <input autocomplete="off" class="form-control date" type="text" id="to_date" />
                                <button type="button" id="rechercher" href="#" class="btn btn-primary">Rechercher</button>
                                <button type="button" id="reset" href="#" class="btn btn-primary">Reset</button>
                            </form>
                        </blockquote>
                    </div>
                    <div class="table-wrap">
                        <div>
                            <table style="width:100% !important;" id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Bâtiment</th>
                                            <th>N°App</th>
                                            <th>Téléphone</th>
                                            <th>Portable</th>
                                            <th>E-mail</th>
                                            <th>Propr</th>
                                            <th>Gestionnaire</th>
                                            <th>Avis général</th>
                                            <th>Périodes</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Bâtiment</th>
                                            <th>N°App</th>
                                            <th>Téléphone</th>
                                            <th>Portable</th>
                                            <th>E-mail</th>
                                            <th>Propr</th>
                                            <th>Gestionnaire</th>
                                            <th>Avis général</th>
                                            <th>Périodes</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                </tfoot>
                                <tbody id="tbody_table">
                                    
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
                        <label class="control-label mb-10 font-16">Nouveau propriétaire :</label>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>
<!-- Select2 JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var table=null;
var oldProp=null;
var annonceForEdit=null;
var propEdited=false;

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
        
    $('#rechercher').on('click',function() {
        table.clear();
        $("#tbody_table").empty();
        $("#tbody_table").html("<tr><td style=\"text-align: center;\" colspan=\"11\">Traitement en cours...</td></tr>");
        table.ajax.reload(null, true);
    });
    $('#reset').on('click',function() {
        document.getElementById('from_date').value = "";
        document.getElementById('to_date').value = "";
        $("#tbody_table").empty();
        $("#tbody_table").html("<tr><td style=\"text-align: center;\" colspan=\"11\">Traitement en cours...</td></tr>");
        table.ajax.reload(null, true);
    });

    $(document).ready(function() {
        
        $("#modifiergest").on('click',function() {
            $.ajax({
              type: "POST",
              async: true,
              url: "<?php echo $this->Url->build('/',true)?>manager/annonces/modifiergest/",
              data:{vIdGest:$('#gest').val(), vIdAnnonce:$('#annonceId').val(), vCle:$('#poscle').val()},
              success:function(xml){
                  $('body').loadingModal({
                      position: 'auto',
                      text: 'Modification en cours...',
                      color: '#fff',
                      opacity: '0.7',
                      backgroundColor: 'rgb(0,0,0)',
                      animation: 'doubleBounce'
                  });
                  table.ajax.reload(null,false);
                  $('#responsive-modal').modal('hide');
                }
              });
        });
    
        $(document).on('click', ".buton_add", function () {
                var id = $(this).attr("data-key");
                $.ajax({
                type: "GET",
                url: "<?php echo $this->Url->build('/',true);?>manager/annonces/attribuergestionnaire/"+id,

                success:function(xml){
                    $('#modal-body').html(xml);
                  }
                });
        });
            
            $("#from_date" ).datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                    });
            $("#to_date" ).datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                    });
                    
            $("#from_date").on('dp.change', function(e){
            $('#to_date').data("DateTimePicker").destroy();

                $('#to_date').datetimepicker({
                                    useCurrent: false,
                                    format: 'DD-MM-YYYY',
                                    minDate: e.date.format("YYYY/MM/DD"),
                                    viewDate: e.date.format("YYYY/MM/DD"),
                                    icons: {
                                    date: "fa fa-calendar",
                                    up: "fa fa-arrow-up",
                                    down: "fa fa-arrow-down"
                                }
                                });
                });

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
            "ajax": {
                      "url": "<?php echo $this->Url->build('/',true)?>manager/annonces/arraysansperiodes",
                      "data": function ( d ) {
                        return $.extend( {}, d, {
                          "from": $('#from_date').val(),
                          "to": $('#to_date').val()
                        } );
                      }
                    },
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 },
                { responsivePriority: 2, targets: -2 },
                { responsivePriority: 2, targets: -3 },
                { responsivePriority: 2, targets: -4 },
                { responsivePriority: 3, targets: 1 },
                { responsivePriority: 3, targets: 2 },
                { responsivePriority: 4, targets: 5 },
                { responsivePriority: 6, targets: 3 },
                { responsivePriority: 5, targets: 4 },
                { responsivePriority: 5, targets: 6 },

            ],
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
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<!-- select2 CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>