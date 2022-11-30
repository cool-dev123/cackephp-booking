<style>
    .modal-dialog.modal-dialog-centered {
        width: 80%;
    }
</style>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="icon-home"></i> Annonces</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/periodeannonces">Toutes les annonces</a></li>
      <li class="active"><a href="#">Annonces en attente de validation</a></li>
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
                            <h6 class="panel-title txt-dark">Annonces en attente de validation</h6>
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
                                                <th>Création</th>
                                                <th>Modification</th>
                                                <th>Situation géo</th>
                                                <th>Type</th>
                                                <th>Propriétaire</th>
                                                <th>E-mail</th>
                                                <th>Gestionnaire</th>
                                                <th>Justificatif de domicile</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>Création</th>
                                                <th>Modification</th>
                                                <th>Situation géo</th>
                                                <th>Type</th>
                                                <th>Propriétaire</th>
                                                <th>E-mail</th>
                                                <th>Gestionnaire</th>
                                                <th>Justificatif de domicile</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </tfoot>
                                <tbody>
                                    <?php $i=0; foreach($annonces as $key=>$enr) {?>				
                                        <tr>
                                                <td>
                                                <?php $i++; if($enr->created_at != null) echo $enr->created_at->i18nFormat('dd-MM-yyyy'); else echo $enr->created_at;?>
                                                </td>
                                                <td>
                                                <?php if($enr->updated_at != null) echo $enr->updated_at->i18nFormat('dd-MM-yyyy'); else echo $enr->updated_at;?>
                                                </td>
                                                <td><?php echo $enr['Lieugeo']['name']?></td>

                                                <td><?php echo ($enr->nature!="") ? $l_natures_location[$enr->nature] : ""?></td>
                                                <td><?php echo $enr['Utilisateur']['nom_famille']." ".$enr['Utilisateur']['prenom']?></td>

                                                <td><a href="mailto:<?php echo $enr['Utilisateur']['email']?>" class="<?php if($enr['Utilisateur']['valide_at'] != null) echo "text-success"; else echo "text-danger"; ?>"><?php echo $enr['Utilisateur']['email']?></a></td>
                                                 <td><?php
                                                 if($enr['G']['name'] == '') 
                                                 echo '<span class="label label-warning">Sans Gestionnaire</span>';
                                                 //  echo "<button  data-toggle=\"modal\" data-target=\"#responsive-modal\" class=\"buton_add btn btn-primary btn-icon-anim btn-square btn-sm\" data-key=\"$enr->id\" ><i class=\"fa fa-plus\"></i></button>";
                                                 else echo $enr['G']['name'];
                                                 ?></td>
                                                 <td>
                                                    <?php if($enr->justificatif_domicile != ""){ ?>
                                                        <button onclick="aPlanPistes('<?php echo $enr->justificatif_domicile;?>')" class="btn btn-sm btn-default btn-icon-anim btn-circle"><i class="fa fa-file-pdf-o"></i></button>
                                                    <?php } ?>
                                                    <!-- <a onclick="aPlanPistes(<?php // echo $enr->justificatif_domicile;?>)" id="aPlanPistes"><i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></a> -->
                                                 </td>
                                                <td><center>
                                                        <a target="_blank" href="<?php echo $this->Url->build('/',true)?>annonces/edit/<?php echo $enr->id;?>"><button class="btn btn-sm btn-default btn-icon-anim btn-circle"><i class="fa fa-pencil"></i></button></a>
                                                        <a target="_blank" href="<?php echo $this->Url->build('/',true)?>annonces/view/<?php echo $enr->id;?>"><button class="view btn btn-sm btn-warning btn-icon-anim btn-circle"><i class="fa fa-search"></i></button></a>
                                                </center></td>
                                                <td><center>
                                                    <div class="btn-group">
                                                        <a class='accept btn btn-sm btn-success accepter btn-rounded' data-id="<?php echo $enr->id;?>" href="#" alt="<?php echo $this->Url->build('/',true)?>manager/annonces/accepter/<?php echo $enr->id;?>">
                                                                 <i class="icon-like"></i>Accepter
                                                        </a>

                                                        <a class='refus btn btn-sm btn-danger refuser btn-rounded' href="#" alt="<?php echo $this->Url->build('/',true)?>manager/annonces/refuser/<?php echo $enr->id;?>">
                                                                <i class="icon-dislike"></i> &nbsp;&nbsp;Refuser&nbsp;&nbsp;
                                                        </a>
                                                    </div>
                                                </td>

                                        </tr>
                                  <?php }?>
                                    <?php  if($i==0) { ?>
                                        <tr>
                                            <td class="text-center" colspan="10">Aucune annonce à afficher</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Plan Pistes -->
<div class="modal fade" id="planPistes" tabindex="-1" role="dialog" aria-labelledby="planPistes">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header p-3">
                <span class="orange h1modal text-center"><h2 class="font-weight-bold">Justificatif de domicile</h2></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            </div>
            <div class="modal-body p-1">                              
                <div class="row">
                    <div class="col-md-12" id="object_inventaire">
                        
                    </div>                    
                </div>                          
            </div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Plan Pistes -->
<!-- /.modal -->
<!-- <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title">Choisir Gestionnaire</h5>
            </div>
            <div id="modal-body" class="modal-body">  -->
                <!--content loaded by ajax-->
            <!-- </div> 
            <div class="modal-footer">
                    <button id="recherche_annuler" type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="modifiergest" type="button" class="btn btn-danger">Modifier</button>
            </div>
        </div>
    </div>
</div> -->

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>

function aPlanPistes(id_reservation){
    $("#object_inventaire").html('<object data="<?php echo SITE_ALPISSIME."justificatifdomicile/"; ?>'+id_reservation+'" type="application/pdf" width="100%" height="500"><span class="text-center"> <?= __("Le lien est inaccessible pour le moment. Merci de réessayer plus tard.") ?> </span></object>');
    $("#planPistes").modal("show");
}

    $( window ).resize(function() {
        resizeButtons();
    });
    function resizeButtons(){
        if($( window ).width()>= 577 && $( window ).width()<= 1659){
            $('.btn-group').addClass('btn-group-vertical');
        }
        else{
            $('.btn-group').removeClass('btn-group-vertical');
        }
    }
    resizeButtons();
    
    	$('.accepter').on('click',function(e){
        var url=$(this).attr("alt");
        var id_a=$(this).attr("data-id");
        swal({   
            title: "Acceptation de l'annonce",   
            text: "Vous allez valider une annonce,celle-ci après validation sera en ligne.",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#5cb85c",
            cancelButtonColor: "#ff354d",
            confirmButtonText: "OK",   
            cancelButtonText: "Annuler",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {
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
                        dataType : 'json',
                        url: url,
                        success:function(xml){
                            $('body').loadingModal('destroy');
                            swal("Acceptée", "Votre annonce est en ligne", "success");
                            setTimeout(function(){
                                location.reload();
                              }, 500);
                        },
                        error:function (){
                            $('body').loadingModal('destroy');
                            $.toast().reset('all');
                            $("body").removeAttr('class');
                            $.toast({
                                heading: 'Erreur',
                                text: '',
                                position: 'bottom-right',
                                loaderBg:'#fec107',
                                icon: 'error',
                                hideAfter: 7000
                            });
                        }
                    });   
            } else {     
                swal("Annulé", "", "error");   
            } 
        });
		return false;
    });
    
    $('.refuser').on('click',function(e){
        var url=$(this).attr("alt");
        swal({
            title: "Refus de l'annonce",   
            text: "Vous êtes sur le point de refuser cette annonce",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#5cb85c",
            cancelButtonColor: "#ff354d",
            confirmButtonText: "OK",   
            cancelButtonText: "Annuler",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){
            if (isConfirm) {
                window.location.href = url;
            } else {     
                swal("Annulé", "", "error");   
            } 
        });
		return false;
    });


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

    $('.view_station').on('click',function(e){
        var id = $(this).attr("data-key");
        $.ajax({
            type: "GET",
            url: "<?php echo $this->Url->build('/',true);?>manager/annonces/viewpub/"+id,

            success:function(xml){
                $('#modal-fiche-publicité-body').empty();
                $('#modal-fiche-publicité-body').append(xml);
              }
            });
    });
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-uk-pre": function ( a ) {
            if(a!=null){
                var ukDatea = a.split('/');
                return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            }
        },

        "date-uk-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-uk-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );
    $(document).ready(function() {

            $('#datable_1').DataTable({
            "columnDefs": [
                { "type": 'date-uk', "targets": 1 },
                { "type": 'date-uk', "targets": 0 },
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 },
                { responsivePriority: 3, targets: -2 },
                { responsivePriority: 4, targets: -3 },
                { responsivePriority: 2, targets: -4 }
            ],
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
              
    });
    
    <?php if(!empty($confirm_refuser)): ?>
            $.toast().reset('all');
                $("body").removeAttr('class');
                $.toast({
                    heading: 'Annonce refusée',
                    text: '',
                    position: 'bottom-right',
                    loaderBg:'#fec107',
                    icon: 'success',
                    hideAfter: 4000
                });
    <?php endif;?>
    <?php if(!empty($confirm_accepter)): ?>
            $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Votre annonce est en ligne',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 4000
                        });
    <?php endif;?>
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>