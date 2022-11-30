<?php $this->Html->css("/css/update.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/jquery.dataTables.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>

<style>
i.fa.fa-search.fa-lg {
    color: #ff8700;
}
.mt-20{
  margin-top: 20px;
}
.ml-20{
  margin-left: 20px;
}
.mb-20{
  margin-bottom: 20px;
}
</style>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
// <script>
        $(document).ready(function() {
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

				  $.each(xml.listeannulation, function(index, value) {
                    if((value.interval_1 == 0 && Diff <= value.interval_2) || (value.interval_2 == 100 && Diff >= value.interval_1) || (Diff >= value.interval_1 && Diff <= value.interval_2)){
                        totalPrixPayer = (((parseFloat(prixTotal)/100)*(100-value.reservation_pourc)) + (parseFloat(taxeDeSejour))).toFixed(2);
                        if(value.reservation_pourc == 100) msgSansJustifp1 = "<?php echo __('Aucun remboursement du montant de la location'); ?> ";
                        else msgSansJustifp1 = "<p><?php echo __('Remboursement de'); ?> "+(100-value.reservation_pourc)+"% <?php echo __('du montant de la location'); ?> ";
                        // if(value.service_pourc == 0) msgSansJustifp2 = "et aucun remboursement pour les frais de service.";
                        // else msgSansJustifp2 = "et de "+value.service_pourc+"% des frais de service.</p>";
						msgSansJustifp2 = " <?php echo __('Remboursement à 100% de la taxe de séjour. Les frais de service ne sont pas remboursés.'); ?>";
                        msgSansJustif = msgSansJustifp1+msgSansJustifp2+"<p><?php echo __('Remboursement de'); ?> : "+totalPrixPayer+" €</p>";
                    }
                  });

				  if(msgSansJustif == ""){
					if(Diff > 30){
						totalPrixPayer = (parseFloat(prixTotal) + parseFloat(taxeDeSejour)).toFixed(2);
						msgSansJustif = "<p><?php echo __('Aucun remboursement pour les frais de service.'); ?></p><p><?php echo __('Remboursement de'); ?> : "+totalPrixPayer+" €</p>";
					}else if(Diff >= 7 && Diff <= 30){
						totalPrixPayer = ((parseFloat(prixTotal)/2) + parseFloat(taxeDeSejour)).toFixed(2);
						msgSansJustif = "<p><?php echo __('Remboursement de 50% du montant de la location.'); ?></p><p><?php echo __('Remboursement de'); ?> : "+totalPrixPayer+" €</p>";
					}else if(Diff < 7){
						totalPrixPayer = taxeDeSejour;
						msgSansJustif = "<p><?php echo __('Aucun remboursement du montant de la location et des frais de service.'); ?></p><p><?php echo __('Remboursement Total de la taxe de séjour'); ?> : "+totalPrixPayer+" €</p>";
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
												url: "<?php echo $this->Url->build('/',true)?>annulations/edit_reservation_locataire",
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
												url: "<?php echo $this->Url->build('/',true)?>annulations/deletereservation/"+$('#hdreservation').val(),
												success:function(xml){
													oTable.fnDraw();
													$('#listUtilisateur_processing').attr('style','visibility: hidden;');

												}
											});

							}
					}
			});

		});
		function open_dialog(id_a){

			$('#listUtilisateur_processing').attr('style','visibility: visible;');
			$.ajax({
						type: "POST",
						url: "<?php echo $this->Url->build('/',true)?>annulations/get_reservation_locataire/",
						data: {id : id_a},
						success:function(xml){
							$('#texte-error').html(xml);
							$('#dialog-error').dialog('open');
							$('#listUtilisateur_processing').attr('style','visibility: hidden;');
						}
					});
		}
    function open_dialog_delete(id){
			$('#hdreservation').val(id);
			$('#dialog-delete').dialog('open');
		}
		/*function open_dialog_delete(id_a){
			//$('#filemakertxt').val(id_f);
			$('#id_annonce').val(id_a);
			$('#dialog-error').dialog('open');
		}*/

		function activate_relation(id){
			$('#listUtilisateur_processing').attr('style','visibility: visible;');
			$.ajax({
						type: "POST",
						url: "<?php echo $this->Url->build('/',true)?>annulations/annulations_locataire",
						data: {id : id},
						success:function(xml){
							if(xml=="ok") $('#coeur_re_'+id).attr('src','<?php echo $this->Url->build('/',true)?>images/pass-icon.png');
							else $('#coeur_re_'+id).attr('src','<?php echo $this->Url->build('/',true)?>images/fail-icon.png');
							$('#listUtilisateur_processing').attr('style','visibility: hidden;');
						}
					});
		}
    <?php $this->Html->scriptEnd(); ?>

<div id="annulations">
    <?php echo $this->Flash->render() ?>
				<div class="row">
					<?php echo $this->element("menu_locataire")?>
          <?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>
					<div class="col-md-9">
						<div class="row">
							<div class="col-md-12">
								<h1><?= __("Espace locataire") ?> - <span class="orange">Mes annulations</span></h1>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="header_title">
									<h4 class="gray-fonce"><i class="fa fa-calendar fa-lg"></i> Consulter mes annulations</h4>
								</div>
							</div>
						</div>
							<div class="row">
                        <div class="col-md-12 block">
                            <div class="table-responsive">

                                <table id="table_id_valid" class="table table-striped table-bordered" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Période de location </th>
                                        <th>Etat</th>
                                        <th>Annulation par</th>
                                        <th>ID Annonce</th>
                                        <th>Date demande</th>
                                        <th>Total payé (€)</th>
                                        <th>Montant à rembourser (€)</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php if(empty($annulations->toArray())) echo "<tr><td colspan='8'>Vous n'avez aucune annulation</td></tr>" ?>

									<?php foreach ($annulations as $enr): ?>
                                    <tr>
                                        <td><?php echo $enr['reservation']['dbt_at']." au ".$enr['reservation']['fin_at']; ?></td>
                                        <td><?php 
                                            if($enr->statut == "Demande en attente") echo "<span class='text-warning'>".$enr->statut."</span>"; 
                                            if($enr->statut == "Annulation validée") echo "<span class='text-danger'>".$enr->statut."</span>";
                                            if($enr->statut == "Annulation remboursée") echo "<span class='text-success'>".$enr->statut."</span>";
                                            if($enr->statut == "Justificatif refusé") echo "<span class='text-danger'>".$enr->statut."</span>";
										?></td>
                                        <td><?php echo $enr->annulationpar; ?></td>
                                        <td><?php echo $enr['reservation']['annonce_id']; ?></td>
                                        <td><?php echo $enr->created; ?></td>
                                        <td><?php echo $enr['reservation']['prixapayer']; ?></td>
                                        <td><?php echo $enr->montant_rembourser; ?></td>
                                    </tr>
									<?php endforeach; ?>


                                    </tbody>
                                </table>
                                <div class="pagination">
                            <ul class="list-inline"><?php if(!empty($this->Paginator->first('<<'))){ ?>
                 <li><button class="btn btn-default"><?php echo $this->Paginator->first('<<'); ?></button></li>
                            <?php } ?>
                     <?php $affichePages=$this->Paginator->numbers(); if ($affichePages=='') {} else { $affichePages=$this->Paginator->numbers(); echo ($affichePages); } ?>
                 <?php if(!empty($this->Paginator->last('>>'))){ ?>
                 <li><button class="btn btn-default"><?php echo $this->Paginator->last('>>'); ?></button></li>
                   <?php } ?>
                            </ul>
			</div><!--end pagination-->
                            </div>
                        </div>
                    </div>
                     
					</div>
          
          <div id="dialog-error" title="Fiche réservation">
              <div id="texte-error">

          	</div>
          </div>
          

					<div class="col-md-12">
						<hr class="dashed">
					</div>
				</div>
			</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
 
<?php $this->Html->scriptEnd(); ?>
