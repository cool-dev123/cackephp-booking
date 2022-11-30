<?php $this->start('cssTop'); ?>
    <style>
         <?php if($InfoGes['G']['role']=='admin'):?>
         @media screen and (max-width: 767px) {
            .costum_span{ font-size: 80% !important;}
            .form-inline .btn {margin-top: 1%; padding: 8px 25px;}
        }
        @media screen and (min-width: 768px) and (max-width: 1135px) {
            .form-inline .form-control { width: 14% !important; }
            .costum_span{ font-size: 80% !important;}
            .form-inline .btn {margin-top: 1%; padding: 8px 25px;}
        }
        @media screen and (min-width: 1136px) and (max-width: 1349px) {
            .form-inline .form-control { width: 14% !important; }
            .costum_span{ font-size: 80% !important;}
            #reset {margin-top: 1%; padding: 8px 25px;}
            #rechercher {padding: 8px 25px;}
        }
        @media screen and (min-width: 1350px) and (max-width: 1400px) {
            .form-inline .btn {margin-top: 1%;}
        }
        @media screen and (min-width: 1401px) and (max-width: 1549px) {
            .form-inline .form-control { width: 14% !important; }
            .costum_span{ font-size: 80% !important;}
            #reset {margin-top: 1%; padding: 8px 25px;}
            #rechercher {padding: 8px 25px;}
        }
        @media screen and (min-width: 1550px) {
            .form-inline .form-control { width: 14% !important; }
            .costum_span{ font-size: 80% !important;}
            #reset {padding: 8px 25px;}
            #rechercher {padding: 8px 25px;}
        }
        <?php else: ?>
        @media screen and (min-width: 768px) and (max-width: 1163px) {
            .form-inline .form-control { width: 15% !important; }
            .costum_span{ font-size: 80% !important;}
            .form-inline .btn {padding: 8px 25px;}
        }
        @media screen and (max-width: 809px) {
            #reset {margin-top: 1%; padding: 8px 25px;}
        }
        @media screen and (max-width: 767px) {
            #rechercher {margin-top: 1%; padding: 8px 25px;}
        }
        <?php endif; ?>
        .flag{
            position: relative;
            top: 10px;
        }
    </style>
<?php $this->end(); ?>
<?php if($InfoGes['G']['role']=="admin"): ?>
    <nav class="navbar navbar-deepskyblue icantSelectIt">
      <div class="container-fluid">
        <div class="navbar-header">
          <span class="navbar-brand" href="#"><i class="ti-comment-alt"></i> SMS & MAIL</span>
        </div>
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Envoyer un modèle</a></li>
          <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/sms">SMS Gestionaires</a></li>
          <li><a href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/smscsv">SMS Propriétaires</a></li>
        </ul>
      </div>
    </nav>
<?php else: ?>
    <div class="row heading-bg icantSelectIt">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <h5 class="txt-dark">Envoi Mail & SMS</h5>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <?php if($InfoGes['G']['role']=="admin"): ?>
                <div class="panel-heading icantSelectIt">
                    <div class="pull-left">
                            <h6 class="panel-title txt-dark">Envoi Mail & SMS</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php endif; ?>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                        <blockquote style="text-align:center;">
                            <?php if($InfoGes['G']['role']=='admin'):?>
                                <form class="form-inline">
                                    <span class="costum_span">Station géographique</span>
                                    <select class="form-control" id="lieugeo">
                                        <option value=0>Toutes les stations</option>
                                        <?php foreach($l_lieugeos as $k=>$v):?>
                                        <option value="<?php echo $k?>"><?php echo $v?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <span class="costum_span">Locataire :</span>
                                    <select class="form-control" id="locatairearriv">
                                        <option value="2">Tous</option>
                                        <option value="0">Pas arrivés</option>
                                        <option value="1">Arrivés</option>
                                    </select>
                                    <span class="costum_span">Du :</span>
                                    <input class="form-control date" type="text" id="from_date" value="<?php echo date('d-m-Y')?>" />
                                    <span class="costum_span">Au :</span>
                                    <input class="form-control date" type="text" id="to_date" value="<?php echo date('d-m-Y', strtotime('+1 days'))?>" />
                                    <button type="button" id="rechercher" href="#" class="btn btn-primary">Rechercher</button>
                                    <button type="button" id="reset" href="#" class="btn btn-primary">Reset</button>
                                </form>
                            <?php else: ?>
                                <form class="form-inline">
                                    <input type="hidden" value=0 id="lieugeo"/>
                                    <span>Locataire :</span>
                                    <select class="form-control" id="locatairearriv">
                                        <option value="2">Tous</option>
                                        <option value="0">Pas arrivés</option>
                                        <option value="1">Arrivés</option>
                                    </select>
                                    <span>Du :</span>
                                    <input class="form-control date" type="text" id="from_date" value="<?php echo date('d-m-Y')?>" />
                                    <span>Au :</span>
                                    <input class="form-control date" type="text" id="to_date" value="<?php echo date('d-m-Y', strtotime('+1 days'))?>" />
                                    <button type="button" id="rechercher" href="#" class="btn btn-primary">Rechercher</button>
                                    <button type="button" id="reset" href="#" class="btn btn-primary">Reset</button>
                                </form>
                            <?php endif; ?>
                        </blockquote>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="table-wrap">
                                <table id="datable_1" class="table table-hover display pb-30" >
                                    <thead>
                                            <tr>
                                                <th data-priority="1"><div class="checkbox">
                                                                    <input id="checkAll" type="checkbox">
                                                                    <label style="color: #272B34;font-size: 12px;font-weight: 500;" for="checkAll">
                                                                            Toutes
                                                                    </label>
                                                                </div></th>
                                                <th data-priority="6">Locataire</th>
                                                <th data-priority="5">Num Portable</th>
                                                <th data-priority="6">E-mail</th>
                                                <th data-priority="5">Date d'arrivée</th>
                                                <th data-priority="3">Résidence</th>
                                                <th data-priority="3">N° App</th>
                                                <th data-priority="2"></th>
                                            </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-wrap col-sm-12 col-xs-12">
                            <form class= 'form-horizontal'>
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <label class="control-label text-left">TYPE</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="radio-inline">
                                            <span class="radio radio-primary">
                                                <input type="radio" name="type" id="sms" value="annuler">
                                                <label for="sms">SMS</label>
                                            </span>
                                        </div>
                                        <div class="radio-inline">
                                            <span class="radio radio-primary">
                                                <input checked type="radio" name="type" id="mail" value="valider">
                                                <label for="mail">Mail</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <label class="control-label mb-10 text-left">Choisir un modèle</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div id="modelsms" style="display:none">
                                            <?php foreach($modelsms as $sms):?>
                                                <div class="radio">
                                                    <span class="radio radio-primary">
                                                        <input type="radio" name="modele" id="model_sms_<?php echo $sms->id ?>" value="<?php echo $sms->id ?>">
                                                        <label for="model_sms_<?php echo $sms->id ?>"><?php echo $sms->titre?></label> <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="<?php echo $sms->txtsms; ?>"></i>
                                                    </span>
                                                </div>
                                            <?php endforeach;?>
                                        </div>
                                        <div id="modelmail">
                                            <?php foreach($modelmail as $mail):?>
                                                <div class="radio">
                                                    <span class="radio radio-primary">
                                                        <input type="radio" name="modele" id="model_mail_<?php echo $mail->id?>" value="<?php echo $mail->id ?>">
                                                        <label for="model_mail_<?php echo $mail->id?>"><?php echo $mail->titre?></label> <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="<?php echo strip_tags($mail->txtmail); ?>"></i>
                                                    </span>
                                                </div>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <button id="send" type="button" class="btn btn-success ml-20">Valider</button>
                                    </div>
                                </div>
                            </form>
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
                <h5 class="modal-title">Fiche locataire</h5>
            </div>
            <div id="modalBody" class="modal-body">
                <!--This content loaded by ajax-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="valider_res" type="button" class="btn btn-danger">Modifier</button>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var Dtable=null;
    
    $(document).on('click', ".modifier_loc", function () {
    console.log($(this).attr('data-href'));
        $.ajax({
            url: $(this).attr('data-href'),
            success:function(xml){
                    $('#modalBody').html(xml);
                    }
        });
    });
    
    $(document).ready(function() {
    
    	$("#valider_res").on('click',function() {
		//loading('loading...');

		var test = '';
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

		if(test == ''){
			$.ajax({
				type: "POST",
				url: "<?php  echo $this->Url->build('/',true) ?>manager/gestionnaires/setlocataire/",
				data:{vUtil:$('#utilisateur_id').val(),vPrenom:$('#prenom').val(),vNomFamille:$('#nom_famille').val(),vEmail:$('#email').val(),vPortable:$('#portable').val()},
				success:function(xml){
					//$.fancybox.close();
					//unloading();
					$('#responsive-modal').modal('hide');
                                        $('body').loadingModal({
                                            position: 'auto',
                                            text: '',
                                            color: '#fff',
                                            opacity: '0.7',
                                            backgroundColor: 'rgb(0,0,0)',
                                            animation: 'doubleBounce'
                                        });
					Dtable.ajax.reload( null, false );
				}
			});

		}else{
			//unloading();
			return false;
		}

	});

    $('#rechercher').on('click',function(){
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        Dtable.destroy();
        write_table();   
        //Dtable.ajax.reload(null, true).responsive.recalc().columns.adjust();
	});
    $('#reset').on('click',function(){
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        $("#locatairearriv").val(2);
        $('#from_date').val('<?php echo date('d-m-Y')?>');
        $('#to_date').val('<?php echo date('d-m-Y', strtotime('+1 days'))?>');
        $('#sujet').val('');
        $('#comment').val('');
        Dtable.destroy();
        write_table(); 
    });
    
    $('#send').click(function(){
	type="";
	if($('#sms').is(':checked')) type='SMS';
	else type='MAIL';
        num_tel="";
	email="";
	model="";
	i=0;
	$('input[type=checkbox][id^=locataire_]').each(
			function() {
				if(this.checked){

				 if(i==0) {
					num_tel+=$(this).attr('data-portable');
					email+=$(this).attr('data-mail');
				}
				 else {
					num_tel+="||"+$(this).attr('data-portable');
					email+="||"+$(this).attr('data-mail');
				}

				 i++;
				}
			});
	$('input[type=radio][id^=model_]').each(
			function() {
				if(this.checked){
					model=$(this).val();
				}
			});
	if(email!="" && model!=""){
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
                    url: "<?php  echo $this->Url->build('/',true) ?>manager/gestionnaires/sendmailandsms/",
                    data:{vPortable:num_tel,vMail:email,vType:type,vMsg:model},
                    success:function(xml){
                        $('body').loadingModal('destroy');
                        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                                heading: xml+' Messages envoyé',
                                text: '',
                                position: 'bottom-right',
                                loaderBg:'#fec107',
                                icon: 'success',
                                hideAfter: 4000
                        });
                    },error: function(){
                        $('body').loadingModal('destroy');
                        $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'Erreur d\'envoi',
                                    text: '',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'error',
                                    hideAfter: 4000
                                });
                    }
            });
	}else{  
                $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Veuillez choisir les locataires et le modèle à envoyer',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 4000
                        });
	}

    });
    
    $('input[type=checkbox][id^=checkAll]').on('click',function(){
        if($(this).is(':checked') ){
		$('input[type=checkbox][id^=locataire_]').each(
				function() {
					 $(this).prop( "checked", true );
				}
			);
            }
        else{
                $('input[type=checkbox][id^=locataire_]').each(
				function() {
					 $(this).prop( "checked", false );
				}
			);
        }
    });
    
    $('#sms').click(function(){
	$('#labelmodel').html('modele sms');
	$("#modelsms").show();
	$("#modelmail").hide();
	$('input[type=radio][id^=model_]').each(
				function() {

					$(this).removeAttr("checked");
				}
			)
    });
    $('#mail').click(function(){
            $('#labelmodel').html('modele mail');
            $("#modelsms").hide();
            $("#modelmail").show();
            $('input[type=radio][id^=model_]').each(
                                    function() {
                                            $(this).removeAttr("checked");
                                    }
                            )
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
                    

    $("#from_date").on('dp.change', function(e){
    $('#to_date').data("DateTimePicker").destroy();

    $('#to_date').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        minDate: e.date.format("YYYY/MM/DD"),
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
    });

                write_table();
    } );
    
    function write_table(){
        Dtable = $('#datable_1').DataTable({
            "responsive": true,
            "drawCallback": function(settings, json) {
                $('body').loadingModal('destroy');
            },
            "ajax": {
                    "url": "<?php  echo $this->Url->build('/',true) ?>manager/gestionnaires/arraylocataires/",
                    "data": function ( d ) {
                        d.debut = $('#from_date').val();
                        d.fin = $('#to_date').val();
                        d.station = $('#lieugeo').val();
                        d.locataire = $('#locatairearriv').val();
                    }
                    },
            "searching": false, "paging": false, "info": false, "ordering": false,
            "language": language_data_table
        }); 
    }
<?php $this->Html->scriptEnd(); ?>
<!-- flags CSS -->
<?php $this->Html->css("/css/flags.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>