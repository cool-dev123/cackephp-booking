<?php //$this->Html->css("/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
<?php //$this->Html->css("/css/new/dataTables.bootstrap4.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/reservations/common.css", ['block' => 'cssTop']); ?>
<?php $this->Html->css("/css/reservations/main.css", ['block' => 'cssTop']); ?>
<?php $this->Html->css("/css/reservations/media.css", ['block' => 'cssTop']); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>
<?php //$this->Html->script("/js/jquery.dataTables.js", array('block' => 'scriptBottom')); ?>
<?php //$this->Html->script("/js/new/dataTables.bootstrap4.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php setlocale(LC_ALL, 'fr_FR.UTF8'); ?>


<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
    var noRefundTxt = '<?= __('Aucun remboursement pour les frais de service') ?>';
    var reimbursementTxt = '<?= __('Remboursement de') ?>';
    var refundOf50Txt = '<?= __('Remboursement de 50% du montant de la location.') ?>';
    var noRefundRentalAmountAndServiceTxt = '<?= __('Aucun remboursement du montant de la location et des frais de service.') ?>';
    var noRefundRentalAmountTxt = '<?= __('Aucun remboursement du montant de la location') ?>';
    var totalRefundTxt = '<?= __('Remboursement Total de la taxe de séjour') ?>';
    var amountOfTheRentalTxt = '<?= __('du montant de la location') ?>';
    var refund100PercentTxt = '<?= __('Remboursement à 100% de la taxe de séjour. Les frais de service ne sont pas remboursés.') ?>';
    var selectedReservationId = <?= (!empty($selected_reservation_id) ? $selected_reservation_id : 0 )?>;
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->script("/js/reservation/teanant_view.js", ['block' => 'scriptBottom']); ?>

<?php

$modalError = $_GET['error'];
if ($modalError == 1 && $this->Session->read('Auth.User.nature') != '') {
  echo "<script type='text/javascript'>
  setTimeout(function() {
    $('#msgerrorphone').removeClass('d-none');
    $('#popup_contact').modal('show');
    // Execute recaptcha
    // grecaptcha.execute();
  }, 1000);
  </script>";
}
?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="reservations" class="container">
    <?php echo $this->Flash->render() ?>
    <div class="row flex-column-reverse flex-md-row justify-content-md-between mb-5">
      <div class="col espace-menu">
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
        <?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
        <?php }?>
        <h3 class="border-bottom-menu-espace float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
        <h3 class="float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
      </div>
      <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
      <div class="col-auto">
      <a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>" class="text-decoration-none">
        <h3 class="text-blue espace-type"><?= __("Espace locataire") ?></h3>
      </a>
      </div>
      <?php }?>
	</div>
        <?php if(empty($reservations)) {
            echo $this->element('Reservations/Tenant/no_reservations_block');
        } else {
            $groups = [
                '50'      => ['txt' => __('En attente'), 'type' => 'pending'],
                '90'      => ['txt' => __('Confirmée'), 'type' => 'confirmed'],
                '90_past' => ['txt' => __('Passée'), 'type' => 'past'],
                '100'     => ['txt' => __('Annulée'), 'type' => 'canceled']
            ];

            foreach ($reservations as $key => $group) {
                if (!empty($group['data'])) {
        ?>
        <h2><?= sprintf($group['title'], (count($group['data']) > 1 ? 's' : '')) ?></h2>
        <div class="reservation_container" data-group="<?= $groups[$key]['name'] ?>">
            <?= $this->element('Reservations/Tenant/reservation_block', [
                'reservations' => $group['data'],
                'group'        => $groups[$key],
            ]); ?>
        </div>
        <?php }
            }
        }
        ?>

          <div id="dialog-error" title="<?= __('Fiche réservation') ?>">
              <div id="texte-error">

          	</div>
          </div>
          <div style="display:none" id="dialog-res" title="Alpissime.com">
              <div id="texte-error1">
          	<p><?= __("Si vous avez modifié votre date d'arrivée") ?></p>
          	<p><?= __("le gestionnaire sur place est informé de cette modification") ?></p>
          	</div>
          </div>
				</div>
			</div>

<!-- Modals -->
<?= $this->element('Reservations/Popups/tenant_details'); ?>
<?= $this->element('Reservations/Popups/send_message'); ?>
<?= $this->element('Reservations/Popups/delete_confirmed'); ?>
<?= $this->element('Reservations/Popups/delete_pending'); ?>
<?= $this->element('Reservations/Popups/date_confirmed'); ?>


    <div class="modal fade" id="plusdetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?= __("Modifier la réservation") ?></h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			      </div>
			      <div class="modal-body">
							<div id="reservation_list" class="col-md-12 gray_background block">

							</div>
			      </div>
			    </div>
			  </div>
			</div>

      <?php $this->Html->css("/manager-arr/components/validationEngine/validationEngine.jquery.css", array('block' => 'cssTop')); ?>
      <?php $this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine.js", array('block' => 'scriptBottom')); ?>
      <?php //$this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine-en.js", array('block' => 'scriptBottom')); ?>
      <?php $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-".$language_header_name.".min.js", array('block' => 'scriptBottom')); ?>

			<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('propform');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }

              var str = $('#elmt').val();
              var messagesansmail = str.replace(/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/, '');
              $('#messagehiddensans').val(messagesansmail);
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();



      $(document).ready(function() {
        $('#table_id_valid').DataTable({
          language: {
            "url": "<?php echo $datatable_file; ?>",
              // search: "_INPUT_",
              // searchPlaceholder: "Recherche"
          },
          'columns': [
            { 'data': 0 },
            { 'data': 1 },
            { 'data': 2 ,'type': 'date-eu'},
            { 'data': 3 },
            { 'data': 4 },
            { 'data': 5 },
            { 'data': 6 },
          ],
          order: [2, 'desc'],
        });
          $("#divJustification").css("display", "none");
          $("#divSansJustification").css("display", "none");

          $("#motifobligatoire").css("display", "none");
          $("#fileobligatoire").css("display", "none");
          $("#commentaireobligatoire").css("display", "none");
          $("#justificatifobligatoire").css("display", "none");

          $('input[name="justificatif"]').click(function(){
            //console.log($(this).val());
            if($(this).val() == 0){
              $("#divJustification").css("display", "none");  
              $("#divSansJustification").css("display", "block"); 
              var fnDiff = moment($("#dbtreservation").val(), "DD-MM-YYYY");
              var today = new Date();
              var dd = today.getDate();
              var mm = today.getMonth()+1; 
              var yyyy = today.getFullYear();
              if(dd < 10){
                dd='0'+dd;
              } 
              if(mm < 10) 
              {
                mm='0'+mm;
              } 
              today = dd+'-'+mm+'-'+yyyy;
              var dbtDiff = moment(today, "DD-MM-YYYY");    
              var Diff = fnDiff.diff(dbtDiff, 'days');

              $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>dispos/calculertotalprixperiodebyidreservation",
                data: {id_reservation:$("#idreservation").val()},
                success:function(xml){
                  $("#blockdetailprix").show();
                  var prixTotal = (xml.resultatDetail['total_price']).toFixed(2);

                  var taxeDeSejour = (xml.resultatDetail['prixtaxeapayer']).toFixed(2);

                  var fraisAlpissime = ((xml.resultatDetail['total_price'] - xml.resultatDetail.automaticPromo.value)/100 * 10.6);
                  var fraisStripe = ((xml.resultatDetail['total_price'] - xml.resultatDetail.automaticPromo.value)/100 * 1.4);
                  var fraisService = (fraisAlpissime + fraisStripe).toFixed(2);

                  prixTotal = (parseFloat(prixTotal) - parseFloat(xml.resultatDetail.automaticPromo.value)).toFixed(2);

                  var msgSansJustif = "";
                  var msgSansJustifp1 = "";
                  var msgSansJustifp2 = "";
                  var totalPrixPayer;
                  var tauxcommission = 3;
                  if(xml.tauxcommissionprop != 0) tauxcommission = xml.tauxcommissionprop;
                  $.each(xml.listeannulation, function(index, value) {
                    if((value.interval_1 == 0 && Diff <= value.interval_2) || (value.interval_2 == 100 && Diff >= value.interval_1) || (Diff >= value.interval_1 && Diff <= value.interval_2)){
                      totalPrixPayer = (((parseFloat(prixTotal)/100)*(100-value.reservation_pourc)) + (parseFloat(taxeDeSejour))).toFixed(2);
                      if(value.reservation_pourc == 100) msgSansJustifp1 = "<?php echo __('Aucun remboursement du montant de la location'); ?> ";
                        else msgSansJustifp1 = "<p><?php echo __('Remboursement de'); ?> "+(100-value.reservation_pourc)+"% <?php echo __('du montant de la location'); ?> ";
                        // if(value.service_pourc == 0) msgSansJustifp2 = "et aucun remboursement pour les frais de service.";
                        // else msgSansJustifp2 = "et de "+value.service_pourc+"% des frais de service.</p>";
						            msgSansJustifp2 = " <?php echo __('Remboursement à 100% de la taxe de séjour. Les frais de service ne sont pas remboursés.'); ?>";
                        msgSansJustif = msgSansJustifp1+msgSansJustifp2+"<p><?php echo __('Remboursement de'); ?> : "+totalPrixPayer+" €</p>";
                        montantProp = ((parseFloat(prixTotal)/100)*(value.reservation_pourc)).toFixed(2) - ((parseFloat(prixTotal)/100)*tauxcommission).toFixed(2);
                        $("#inputMontantProp").val(montantProp);
                    }
                  });

                  if(msgSansJustif == ""){
                    if(Diff > 30){
                      totalPrixPayer = (parseFloat(prixTotal) + parseFloat(taxeDeSejour)).toFixed(2);
                      msgSansJustif = "<p><?php echo __('Aucun remboursement pour les frais de service.'); ?></p><p><?php echo __('Remboursement de'); ?> : "+totalPrixPayer+" €</p>";
                      $("#inputMailSansJustification").val("annulationreservationlocMois");
                      montantProp = 0;
                      $("#inputMontantProp").val(montantProp);
                    }else if(Diff >= 7 && Diff <= 30){
                      totalPrixPayer = ((parseFloat(prixTotal)/2) + parseFloat(taxeDeSejour)).toFixed(2);
                      msgSansJustif = "<p><?php echo __('Remboursement de 50% du montant de la location.'); ?></p><p><?php echo __('Remboursement de'); ?> : "+totalPrixPayer+" €</p>";
                      $("#inputMailSansJustification").val("annulationreservationlocSemaineMois");
                      montantProp = ((parseFloat(prixTotal)/2) - ((parseFloat(prixTotal)/100)*tauxcommission)).toFixed(2);
                      $("#inputMontantProp").val(montantProp);
                    }else if(Diff < 7){
                      totalPrixPayer = taxeDeSejour;
                      msgSansJustif = "<p><?php echo __('Aucun remboursement du montant de la location et des frais de service.'); ?></p><p><?php echo __('Remboursement Total de la taxe de séjour'); ?> : "+totalPrixPayer+" €</p>";
                      $("#inputMailSansJustification").val("annulationreservationlocSemaine");
                      montantProp = (parseFloat(prixTotal) - ((parseFloat(prixTotal)/100)*tauxcommission)).toFixed(2);
                      $("#inputMontantProp").val(montantProp);
                    }
                  }

                  $("#divSansJustification").html(msgSansJustif);
                  $("#prixremboursement").val(totalPrixPayer);

                }
              });
              
              
            }else{
              $("#formjustificatif")[0].reset();
              $(this).attr("checked", "checked");
              $("#divJustification").css("display", "block");
              $("#divSansJustification").html("");
              $("#divSansJustification").css("display", "none"); 
            } 
          });

          $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

		   $("#dbt_at").datepicker({ dateFormat: "dd-mm-yy"});
		   $( "#dialog:ui-dialog" ).dialog( "destroy" );
		    $( "#dialog-res" ).dialog({
					autoOpen: false,
					modal: true,
					width:350});
		   $( "#dialog-error" ).dialog({
					autoOpen: false,
					modal: true,
					width:500,
					buttons: {
							"Annuler": function() {
									$( this ).dialog( "close" );
							},
							"Valider":function(){
									$( this ).dialog( "close" );
									//alert($('#id_prop').val());
									a_data="";
									a_data+='vDate='+$('#dbt_at').val();
									a_data+='&vID='+$('#hdid').val();
									a_data+='&vUtil='+$('#utilisteur_id').val();
									a_data+='&vEmail='+$('#email').val();
									a_data+='&vTelephone='+$('#tel').val();

									$('#listUtilisateur_processing').attr('style','visibility: visible;');
									//a_data['vDrap']=new Array();
									/*$('select[id^=nb_drap_]').each(function(){
										//alert($(this).val());
										if($(this).val()!=0){
										a_data+='&vDrap_'+$(this).attr('data-key')+"="+$(this).val();
										}
									})*/
									$.ajax({
												type: "POST",
												url: "<?php echo $this->Url->build('/',true)?>reservations/edit_reservation_locataire",
												data: a_data,
												success:function(xml){
													//alert(xml);
													$('#dialog-res').dialog('open');
													oTable.fnDraw();
													$('#listUtilisateur_processing').attr('style','visibility: hidden;');

												}
											});

							}
					}
			});

      $( "#dialog-delete" ).dialog({
					autoOpen: false,
					modal: true,
					width:500,
					buttons: {
							"Non": function() {
									$( this ).dialog( "close" );
							},
							"Oui":function(){
									$( this ).dialog( "close" );

									$('#listUtilisateur_processing').attr('style','visibility: visible;');
									$.ajax({
												type: "GET",
												url: "<?php echo $this->Url->build('/',true)?>reservations/deletereservation/"+$('#hdreservation').val(),
												success:function(xml){
													oTable.fnDraw();
													$('#listUtilisateur_processing').attr('style','visibility: hidden;');

												}
											});

							}
					}
			});

		});

		function activate_relation(id){
			$('#listUtilisateur_processing').attr('style','visibility: visible;');
			$.ajax({
						type: "POST",
						url: "<?php echo $this->Url->build('/',true)?>reservations/reservations_locataire",
						data: {id : id},
						success:function(xml){
							if(xml=="ok") $('#coeur_re_'+id).attr('src','<?php echo $this->Url->build('/',true)?>images/pass-icon.png');
							else $('#coeur_re_'+id).attr('src','<?php echo $this->Url->build('/',true)?>images/fail-icon.png');
							$('#listUtilisateur_processing').attr('style','visibility: hidden;');
						}
					});
		}


			function open_dialog(id_a){
				$('#reservation_list').html('<center><img src="<?php echo $this->Url->build('/',true)?>/images/loading.gif"/></center>');
						$('#plusdetails').modal('show');
            var validNum = "non";
						$.ajax({
			            type: "POST",
			            url: "<?php echo $this->Url->build('/',true)?>reservations/get_reservation_locataire/",
						data: {id : id_a},
			            success:function(xml){
			                $('#reservation_list').html(xml);

                          for (i = 1; i <= $("#nbrrestel").val(); i++) {
                          var telInput = $("#num_tel"+i),
                            errorMsg = $("#error-msg"+i);
                            telInput.intlTelInput({
                                          utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                          initialCountry: 'fr',
                                          autoPlaceholder: true
                                        });
                                        var reset = function() {
                                          telInput.removeClass("errorNumberTel");
                                          errorMsg.addClass("hide");
                                        };
                          // on keyup / change flag: reset
                          telInput.on("keyup change", reset);
                          setTimeout('var telInput = $("#num_tel"+i),	errorMsg = $("#error-msg"+i),	validMsg = $("#valid-msg"); if ($.trim(telInput.val())) {	if (telInput.intlTelInput("isValidNumber")) {		validMsg.removeClass("hide");		validNum = telInput.intlTelInput("getNumber");	} else {		validNum = "non";		telInput.addClass("errorNumberTel"); errorMsg.removeClass("hide");		errorMsg.addClass("errorNumberTel"); }}', 500);
                        }

                      var telInput = $("#tel"),
                        errorMsg = $("#error-msg"),
                        validMsg = $("#valid-msg");
                        telInput.intlTelInput({
                                      utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                      initialCountry: 'fr',
                                      autoPlaceholder: true
                                    });
                                    //telInput.intlTelInput("setNumber", telInput.val());
                                    var reset = function() {
                                      telInput.removeClass("errorNumberTel");
                                      errorMsg.addClass("hide");
                                      validMsg.addClass("hide");
                                    };


                                    // on blur: validate
                     telInput.blur(function() {
                       reset();
                        if ($.trim(telInput.val())) {
                          if (telInput.intlTelInput("isValidNumber")) {
                            validMsg.removeClass("hide");
                            validNum = telInput.intlTelInput("getNumber");
                            //alert(telInput.intlTelInput("getNumber"));
                          } else {
                            validNum = "non";
                            telInput.addClass("errorNumberTel");
                            errorMsg.removeClass("hide");
                            errorMsg.addClass("errorNumberTel");
                          }
                        }
                      });

                      // on keyup / change flag: reset
                      telInput.on("keyup change", reset);

                      setTimeout('var telInput = $("#tel"),	errorMsg = $("#error-msg"),	validMsg = $("#valid-msg"); if ($.trim(telInput.val())) {	if (telInput.intlTelInput("isValidNumber")) {		validMsg.removeClass("hide");		validNum = telInput.intlTelInput("getNumber");	} else {		validNum = "non";		telInput.addClass("errorNumberTel"); errorMsg.removeClass("hide");		errorMsg.addClass("errorNumberTel"); }}', 500);

                      var telInputP = $("#portable"),
                        errorMsg2 = $("#error-msgl"),
                        validMsg2 = $("#valid-msg2");
                        telInputP.intlTelInput({
                                      utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                                      initialCountry: 'fr',
                                      autoPlaceholder: true
                                    });
                                    //telInput.intlTelInput("setNumber", telInput.val());
                                    var reset = function() {
                                      telInputP.removeClass("errorNumberTel");
                                      errorMsg2.addClass("hide");
                                      validMsg2.addClass("hide");
                                    };


                                    // on blur: validate
                      telInputP.blur(function() {
                       reset();
                        if ($.trim(telInputP.val())) {
                          if (telInputP.intlTelInput("isValidNumber")) {
                            validMsg2.removeClass("hide");
                            validNum2 = telInputP.intlTelInput("getNumber");
                            //alert(telInput.intlTelInput("getNumber"));
                          } else {
                            validNum2 = "non";
                            telInputP.addClass("errorNumberTel");
                            errorMsg2.removeClass("hide");
                            errorMsg2.addClass("errorNumberTel");
                          }
                        }
                      });

                      // on keyup / change flag: reset
                      telInputP.on("keyup change", reset);

                      setTimeout('var telInputP = $("#portable"),	errorMsg2 = $("#error-msgl"),	validMsg2 = $("#valid-msg2"); if ($.trim(telInputP.val())) {	if (telInputP.intlTelInput("isValidNumber")) {		validMsg2.removeClass("hide");		validNum2 = telInputP.intlTelInput("getNumber");	} else {		validNum2 = "non";		telInputP.addClass("errorNumberTel"); errorMsg2.removeClass("hide");		errorMsg2.addClass("errorNumberTel"); }}', 500);


			            }
						});

			}

					<?php $this->Html->scriptEnd(); ?>
