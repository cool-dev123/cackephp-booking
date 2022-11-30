<?php 
    use Cake\I18n\Time;
?>
<?php $this->start('cssTop'); ?>
    <style>
        @media screen and (min-width: 768px) and (max-width: 1163px) {
            .form-inline .form-control { width: 15% !important; }
            .costum_span{ font-size: 80% !important;}
            .form-inline .btn {padding: 8px 25px;}
        }
        @media screen and (max-width: 767px) {
            .form-inline .btn {margin-top: 2%;}
        }
        
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="fa fa-euro"></i> Taxe de séjour</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/taxedesejour/">Récapitulatif</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/paiementtaxedesejour">Gestion des paiements</a></li>
      <li class="active"><a href="#">Envoi de la taxe</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                    <div class="pull-left">
                            <h6 class="panel-title txt-dark">Envoie Taxe de séjour</h6>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <form class="form-inline">
                                <span class="costum_span">Création Rapport Taxe De Séjour</span><br><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="costum_span">Du :</span>
                                <input class="form-control date" type="text" id="from_date_perid" autocomplete="off" />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="costum_span">Au :</span>
                                <input class="form-control date" type="text" id="to_date_perid" autocomplete="off" />
                                <button type="button" id="envoyer_pdf_taxe" href="#" class="btn btn-primary">Envoyer aux propriétaires</button>
                            </form>
                        </blockquote>
                    </div>
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                    <tr>
                                        <th style="text-align : center;" width="7%">
                                                <div class="checkbox">
                                                    <input id="checkAll" type="checkbox">
                                                    <label style="color: #272B34;font-size: 12px;font-weight: 500;" for="checkAll">Toutes</label>
                                                </div>
                                            </th>
                                        <th style="text-align : center;" width="10%">Prénom</th>
                                        <th style="text-align : center;" width="15%">Nom de famille</th>
                                        <th style="text-align : center;" width="15%">Num Portable</th>
                                        <th style="text-align : center;" width="15%">E-mail</th>
                                        <th style="text-align : center;" width="11%">Code Postal</th>
                                        <th style="text-align : center;" width="5%">Ville</th>
                                        </tr>
                                </thead>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>

var table=null;

    $(document).ready(function() {
        
      $('#envoyer_pdf_taxe').click(function(){
  	listeproptaxe="";
  	i=0;
  	$('input[type=checkbox][id^=locataire_]').each(
  			function() {
  				if(this.checked){

  				 if(i==0) {
  					listeproptaxe+=$(this).attr('data-id');
  				} else {
  					listeproptaxe+="||"+$(this).attr('data-id');
  				}
  				 i++;

  				}
  			});
    if($("#from_date_perid").val() == "" && $('#to_date_perid').val() == ""){
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Veuillez choisir une date de début et une date de fin',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 5000
                        });
    }
    else if($("#from_date_perid").val() == ""){
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Veuillez choisir une date de début',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 5000
                        });
    }else if ($('#to_date_perid').val() == ""){
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Veuillez choisir une date de fin',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 5000
                        });
    }else{
      if(listeproptaxe!=""){
    	
    	$('body').loadingModal({
            position: 'auto',
            text: 'Chargement...',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
      
      $.ajax({
          type: "POST",
          url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/generatepdftaxe/",
          data:{vDatedebut:$("#from_date_perid").val(),vDatefin:$('#to_date_perid').val(),vPropid:listeproptaxe},
          success:function(xml){
            $('body').loadingModal('destroy');
            $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Taxe envoyée',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 6000
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

    	}else{
                $('body').loadingModal('destroy');
                $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: "Veuillez choisir les propriétaires",
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 5000
                        });
    	}

    }

  });
        
    $('input[type=checkbox][id^=checkAll]').on('click',function(){
	if($(this).is(':checked')){
		$('input[type=checkbox][id^=locataire_]').each(
				function() {
					 $(this).prop( "checked", true );
				}
			);
            }else{
                $('input[type=checkbox][id^=locataire_]').each(
				function() {
					 $(this).prop( "checked", false );
				}
			);
            }
    });
            
    $('.date').datetimepicker({
                useCurrent: false,
                format: 'DD-MM-YYYY',
                icons: {
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            });

    $("#from_date_perid").on('dp.change', function(e){
    $('#to_date_perid').data("DateTimePicker").destroy();
    
    $('#to_date_perid').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        minDate: e.date.format("YYYY/MM/DD"),
                        viewDate: e.date.format("YYYY/MM/DD"),
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
    });
            table = $('#datable_1').DataTable({
            paging: false, info: false, "ordering": false,
            "ajax": "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/arrayproptaxe/",
            responsive: true,
            "language": language_data_table,
        });
              
    } );
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
