<?php $this->start('cssTop'); ?>
    <style>
        .heading-bg {
            height: 100% !important;
        }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-settings  mr-10"></i> Configuration</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/pub">Publicités</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/packs/index">Packs De Services</a></li>
      <li class="active"><a href="#">Points GPS</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/index">Liste Des Gestionaires</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/8">Gestion Des Pages</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/cautions/index">Résidences de tourisme</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/stations/">Stations</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/vacances/">Vacances</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelmail">Gestion de modèles</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Points GPS</h6>
                </div>
                <div class="pull-right">
                    <a href="<?php echo $this->Url->build('/',true)?>manager/parametrage/gps/add" class="btn  btn-primary pull-right">Ajouter</a>
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
                                                <th></th>
                                                <th>Nom</th>
                                                <th>Nbr d'hébergements</th>
                                                <th>Village</th>
                                                <th>Bibliothèque</th>
                                                <th width="20%" ></th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th></th>
                                                <th>Nom</th>
                                                <th>Nbr d'hébergements</th>
                                                <th>Village</th>
                                                <th>Bibliothèque</th>
                                                <th></th>
                                        </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach($residences as $key=>$residence):?>
                                        <tr>
                                                <td>
                                                    <?php if($residence->bibliotheque->name == "residence"){ ?>
                                                        <div class="checkbox">
                                                            <input id="residence_<?php echo $residence->id ?>" data-id="<?php echo $residence->id ?>" data-nom="<?php echo $residence->name ?>" type="checkbox">
                                                            <label style="color: #272B34;font-size: 12px;font-weight: 500;" for="residence_<?php echo $residence->id ?>"></label>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $residence->name ?></td>
                                                <td><?php if($residence->bibliotheque->name == "residence"){
                                                    echo $nbrAnnonce[$residence->id];
                                                } ?></td>
                                                <td><?php echo $residence->village->name ?></td>
                                                <td><?php echo $residence->bibliotheque->name ?></td>
                                                <td>
                                                    <center>
                                                        <button class="mr-10 btn btn-sm btn-default btn-icon-anim btn-circle" onclick="window.open('<?php echo $this->Url->build('/',true)?>manager/parametrage/gps/edit/<?php echo $residence->id;?>')" ><i class="fa fa-pencil"></i></button>
                                                        <button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_station" data-key="<?php echo $residence->id;?>" ><i class="icon-trash"></i></button>
                                                    </center>
                                                </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-20 ml-10">
                        <button id="rassemblerdoublon" class="btn btn-primary pr-10 pl-10"><i class="icon-arrow-right mr-10"></i>Assembler les résidences sélectionnées</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.modal -->
<div id="modal-addrassemplage" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title">Choisir la résidence à garder pour la liste sélectionnée : </h5>
            </div>
            <div id="modal-body" class="modal-body">
                <input type="hidden" name="listeIdRes" id="listeIdRes">
                <div id="listechoixresidence"></div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="saverassemplage" type="button" class="btn btn-danger">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var table;
    $('#rassemblerdoublon').click(function(){
        var resId = "";
        // var resIdModal = [];
        // var resNom = [];
        var i = 0;
        $("#listechoixresidence").html("");
        $("#listechoixresidence").append('<div class="radio-list">');
            
            
        $('input[type=checkbox][id^=residence_]').each(function() {
            if(this.checked){
                if(i==0) {
                    resId+=$(this).attr('data-id');
                }
                else {
                    resId+="||"+$(this).attr('data-id');
                }
                i++;
                $("#listechoixresidence").append('<div class="pl-0"><span class="radio radio-primary"><input type="radio" value="'+$(this).attr('data-id')+'" id="choixResidence'+$(this).attr('data-id')+'" name="choixResidence"><label for="choixResidence'+$(this).attr('data-id')+'">'+$(this).attr('data-nom')+'</label></span></div>');
                // resNom.push($(this).attr('data-nom'));
                // resIdModal.push($(this).attr('data-id'));
            }
        });
        $("#listechoixresidence").append('</div>');
        $("#listeIdRes").val(resId);
        // console.log(resNom);
        if(i == 0 || i == 1){
            swal({
                type: 'error',
                title: 'Il faut choisir au moin deux résidences',
            });
        }else{
            $('#modal-addrassemplage').modal('toggle');
            $('#modal-addrassemplage').modal('show');
        }
    });

    $('#saverassemplage').click(function(){
        $.ajax({
            type: "post",
            url: "<?php echo $this->Url->build('/',true)?>/manager/gps/rassemplageresidences",
            data :{
                listeIdRes:$('#listeIdRes').val(),
                choixResidence:$("input[name*='choixResidence']:checked").val(),
            },
            success:function(data){
                $('body').loadingModal('destroy');
                nbrassemblage = data.nbrassemblage;
                data = data.data;
                if(data=='residence added')
                {
                    // table.ajax.reload();
                    $('#modal-addrassemplage').modal('toggle');
                    $('#modal-addrassemplage').modal('hide');
                    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: "Vous avez rassemblé "+nbrassemblage+" résidences",
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'success',
                        hideAfter: 7000
                    });
                    setTimeout(function(){ location.reload(); }, 3500);                    
                }
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

    $(document).on('click', ".delete_station", function () {
        var id = $(this).attr("data-key");
                    swal({   
						title: "Suppression d\'une coordonné",   
                                                text: "Êtes-vous sûr de vouloir supprimer cette coordonné ?",
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
						type: "delete",
                                                url: "<?php echo $this->Url->build('/',true)?>/manager/parametrage/gps/delete/"+id,

						success:function(xml){
                                                        $('body').loadingModal('destroy');
							swal("", "Vous venez de supprimer une coordonné", "success");
							setTimeout(function(){ window.location.reload(); }, 500);
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
    
    $(document).ready(function() {

            table = $('#datable_1').DataTable({
            responsive: true,
            "language": language_data_table,
            order: [1, 'asc'],
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

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
