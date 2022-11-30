<?php $this->Html->css("/css/new/dataTables.bootstrap4.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/jquery.dataTables.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/new/dataTables.bootstrap4.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
/*$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-confirm" ).dialog({
		autoOpen:<?php echo !empty($accept_res)?'true':'false';?>,
		modal: true,
		width:400
		
	});
});*/
<?php $this->Html->scriptEnd(); ?>
<style>
	.showSweetAlert[data-animation=pop] {
		-webkit-animation: showSweetAlert 0.7s;
		animation: showSweetAlert 0.7s;
	}
	.hideSweetAlert[data-animation=pop] {
		-webkit-animation: hideSweetAlert 1s;
		animation: hideSweetAlert 1s;
	}
	.sweet-alert button {
		padding: 5px 15px;
		margin-top: 0px;
		border-radius: 0px;
	}
	#refuser:disabled, #accepter:disabled {
		cursor: no-drop;
	}
</style>
<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="reservation_en_attente" class="reservation_en_cours container">	
<?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>
<?php $i_r=0;?>
<div class="row justify-content-between mb-5">
<div class="col espace-menu">
<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
<?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
	<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
	<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
	<h3 class="border-bottom-menu-espace float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations") ?></a></h3>
	<?php }else{ ?>
		<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
		<?php } ?>
		<h3 class="float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
		</div>
		<?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
			<div class="col-auto align-self-end">
			<h3 class="text-blue"><?= __("Espace") ?> <?php if($this->Session->read('Auth.User.nature')=='CLT') echo "Locataire"; else echo "Propriétaire";?></h3>
			</div>
			<?php }?>
			</div>
			<div class="row">
			<div class="col-12 col-sm-6 col-md px-0">
			<a class="text-white btn-blue rounded-0 py-2 w-100 d-block text-decoration-none text-center" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations en attente") ?></a>
			</div>
			<div class="col-12 col-sm-6 col-md px-0">
			<a class="text-white btn-grey rounded-0 py-2 w-100 d-block text-decoration-none text-center py-2" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/view"><?= __("Réservations validées") ?></a>
			</div>
			<div class="col-12 col-sm-4 col-md px-0">
				<a class="text-white btn-grey rounded-0 py-2 w-100 d-block text-decoration-none text-center py-2" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/reservationcalendar"><?= __("Réservations Synchronisées") ?></a>
			</div>
			<div class="col pr-0 pl-0 pl-md-2  text-center text-md-right mt-3 mt-md-0">
			<a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_addres'];?>"><span class="btn text-white bg-orange px-5 px-md-3 px-lg-5"><?= __("Créer une réservation") ?></span></a>
			</div>
			</div>
			
			<div class="row mt-5">
			<div class="col-md-12"> 
			<?php echo $this->Flash->render() ?>
			<?php if (count($reservations)>0) {?>
				<?php echo $this->Form->create('Reservations',['url'=> SITE_ALPISSIME.$urlLang."reservations/validation", 'id' => 'validationForm']); } ?>
				<input type="hidden" name="note_refus" id="note_refus_hidden">
				<input type="hidden" name="raison_refus" id="raison_refus_hidden">
				
				<div class="table-responsive">
				<table id="table_id_valid2" class="table table-striped" width="100%">
				<thead><tr>
				<th><?= __("Annonce") ?></th>
				<th><?= __("Station") ?></th>
				<th><?= __("Locataire") ?></th>
				<th><?= __("Période") ?></th>
				<th><?= __("Prix") ?></th>
				<!-- <th><?= __("Contact") ?></th> -->
				<th></th>
				</tr></thead>
				<tbody>
				<?php if(empty($reservations->toArray())) echo "<tr><td colspan='7'>".__("Vous n'avez aucune réservation")."</td></tr>" ?>
				<?php $cpt=0;foreach($reservations as $enr) {?>																			
					<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
					$(function() {
						var block;
						$.ajax({
							type: "POST",
							dataType : 'json',
							async: false,
							url: "<?php echo $this->Url->build('/',true)?>reservations/blockreduction/",
							data: {debut: "<?php echo $enr->dbt_at->i18nFormat('dd-MM-yyyy') ?>", fin: "<?php echo $enr->fin_at->i18nFormat('dd-MM-yyyy') ?>", ann_id: "<?php echo $enr->annonce['id']?>", modelemail: "acceptationReservationClt"},
							success:function(xml){
								block = xml.blockdetail;
								$("#acceptationReservationCltHidden"+<?php echo $enr->id ?>).val(block);
							}
						});
						
					});
					<?php $this->Html->scriptEnd(); ?>
					
					<tr>
					<td data-title="Titre">
					<?php echo $enr->annonce['titre']?>
					</td>
					<td data-title="Station">
					<?php echo $enr->lieugeo['name']?>
					</td>
					<td data-title="Locataires">
					<?php if(empty($enr->annonce['contrat'])&&empty($enr->annonce['mise_relation'])):?>
						<center>-</center>
						<?php else:?>
							<?php echo $enr->utilisateur['nom_famille']." ".$enr->utilisateur['prenom']?>
	
							<?php endif;?>
							</td>
							
					<td data-title="Période">
						<?php echo $enr->dbt_at->i18nFormat('dd/MM/yyyy')?> - <?php echo $enr->fin_at->i18nFormat('dd/MM/yyyy')?>
					</td>
					
					
					<td data-title="Prix"><?php if($enr->prixreservation != 0) echo round(($enr->prixreservation-($enr->prixreservation*$tauxcommession/100)), 2); ?></td>
									
					<td >
					<div class="custom-control custom-checkbox custom-control-inline">
					<?php if(empty($enr->annonce['contrat'])&&empty($enr->annonce['mise_relation'])):?>
						<?php $i_r++;?>						
						<?php echo $this->Form->input('sel[]',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input','value'=>$enr->id, 'id'=>'sel'.$enr->id, 'disabled'])?>
						<?php else:?>
							<?php echo $this->Form->input('sel[]',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input','value'=>$enr->id, 'id'=>'sel'.$enr->id])?>
						<?php endif;?>						
						<label class="custom-control-label" for="sel<?php echo $enr->id ?>"></label>
						</div>
						<input type="hidden" id="acceptationReservationCltHidden<?php echo $enr->id ?>" name="acceptationReservationCltHidden<?php echo $enr->id ?>" />
					</td>
					</tr>
					<?php $cpt++;}?>
					</tbody></table>
													
													</div>
													<?php if (count($reservations)>0) { ?>
														<div class="row d-flex align-items-center">
															<p class="font-italic col-sm-12 col-md-8 mb-0 mt-3"><u><?php echo __('Sélectionnez une réservation pour accepter ou refuser la demande du vacancier'); ?></u></p>
															<div class="col-sm-12 col-md-4 mt-3">														
																<!-- <button type="submit" name="refuser" value="Refuser" class="btn btn-default rounded-0"> <?= __("REFUSER") ?> </button>
																<button type="submit" name="accepter" value="Accepter" class="btn btn-blue text-white rounded-0"> <?= __("ACCEPTER") ?> </button> -->
																<input type="hidden" name="refuser" id="refuserinput">
																<input type="hidden" name="accepter" id="accepterinput">
																<div class="pull-right">
																	<button type="button" id="refuser" name="refuser" value="Refuser" class="btn btn-default rounded-0" disabled> <?= __("REFUSER") ?> </button>
																	<button type="button" id="accepter" name="accepter" value="Accepter" class="btn btn-blue text-white rounded-0" disabled> <?= __("ACCEPTER") ?> </button>
																</div>																
															</div>
														</div>
														<?php echo $this->Form->end(); }?>
														
														
														
														<?php if($i_r>0):?>
															
															
															<div class="col-md-12 block">
															
															<p>
															<?= __('Vous êtes sur votre tableau de réservations.
															Ces options sont en attente de validation.
															Pour accéder à celles ci merci de bien vouloir prendre
															<a target="_blank" href="<?php echo BOUTIQUE_ALPISSIME ?>/mise-en-relation.html">
															un contrat de mise en relation
															</a>ou
															<a target="_blank" href="<?php echo BOUTIQUE_ALPISSIME ?>/contrat-de-gestion-de-cles.html">
															un contrat de gestion de séjours.
															</a>
															Avec nos remerciements<br/>
															l\'équipe de alpissime.com') ?>
															</p>
															
															
															</div>
															
														<?php endif;?>
															
															
															
															
															
															<input type="hidden" id="hdreservation"/>
															<div id="dialog-error" title="Fiche réservation">
															<div id="texte-error">
															</div>
															</div>
															
															</div>
															</div>
<hr>
<div class="row">
	<div class="col-sm-12 pr-0">
		<h4><?= __("Questions fréquemment posées") ?> : </h4>
		<i class="fa fa-angle-right"></i> <a href="https://help.alpissime.com/aide/quelles-sont-les-regles-lorsque-je-dois-annuler-une-reservation/" target="_blanck"><u><?= __("Comment accepter ou refuser une demande de réservation ?") ?></u></a>
		<br><i class="fa fa-angle-right"></i> <a href="https://help.alpissime.com/aide/quelles-sont-les-regles-lorsque-je-dois-annuler-une-reservation/" target="_blanck"><u><?= __("Quelles sont les règles lorsque je dois annuler une réservation ?") ?></u></a>
		<br><i class="fa fa-angle-right"></i> <a href="https://help.alpissime.com/aide/comment-modifier-les-informations-dune-reservation/" target="_blanck"><u><?= __("Comment modifier les informations d’une réservation ou la supprimer ?") ?></u></a>
		<br><i class="fa fa-angle-right"></i> <a href="https://help.alpissime.com/aide/je-suis-en-contrat-de-conciergerie-comment-informer-la-conciergerie-que-jai-eu-une-nouvelle-reservation/" target="_blanck"><u><?= __("Je suis en contrat de conciergerie, comment informer la conciergerie que j’ai eu une nouvelle réservation ?") ?></u></a>

		<br><i class="fa fa-angle-right"></i> <?= __("Consultez notre") ?> <a href="https://help.alpissime.com/" target="_blanck"><u> <?= __("Centre d'aide") ?></u></a>
	</div>
</div>

															</div>
															<div class="modal fade" id="popup_reser_creer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><?= __("Information") ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p><?= __("Vous allez créer une réservation") ?></p>
			<p><?= __("pour que cette réservation soit possible vous devez renseigner la période avant de passer celle ci sur le Statut réservé") ?></p>
			<p><?= __("si vous ne voyez pas votre semaine après avoir ouvert ce tableau") ?></p>
			<p><?= __("mettez la semaine sur libre, vous la retrouverez dans votre tableau création d'une réservation manuelle") ?></p>
			<p><?= __("une période est considérée \"réservé\" si elle est renseignée avec les coordonnées de votre locataire") ?></p>
      		<a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_addres'];?>" class="btn btn-blue text-white rounded-0 float-right"><?= __("Valider") ?></a>
			</div>
			
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalrefus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        La réservation a été refusée et votre message a bien été envoyé au vacancier.<br>
		Si la période qui a fait l'objet de la demande de réservation est déjà réservée, merci de bien vouloir mettre à jour votre planning pour éviter de futures demandes de réservation aux mêmes dates
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Fermer'); ?></button>
        <a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>" class="btn btn-primary">Mon planning</a>
      </div>
    </div>
  </div>
</div>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
	// <script>
		$( "input[name='sel[]']" ).on( "click", function() {
			var nbrselect = $( "input[name='sel[]']:checked" ).length;
			if(nbrselect > 0){
				$('#refuser').prop("disabled", false);
				$('#accepter').prop("disabled", false);
			}else{
				$('#refuser').prop("disabled", true);
				$('#accepter').prop("disabled", true);
			}
			// console.log(nbrselect+" selected");
		});
		var retourmsg = "<?php echo $retourmsg; ?>";
		if(retourmsg == "refusnote"){
			swal({   
				title: '<?= __("Réservation refusée"); ?>',   
				text: "<?= __("La réservation a été refusée et votre message a bien été envoyé au vacancier.<br>La période désormais notée indisponible dans votre calendrier.<br><span class='font-weight-bold'>Votre hébergement est disponible à ces dates ? Pensez à les réactiver</span>"); ?>",
				html: true,    
				showCancelButton: true,   
				confirmButtonColor: "#09f",   
				confirmButtonText: '<?= __("Mon planning"); ?>',
				cancelButtonText: '<?= __("Fermer"); ?>',  
				closeOnConfirm: false,
				customClass: 'rounded-0'
			}, function(){
				window.location.href = "<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>";
			});
		} 
	$("#accepter").click(function(){    
		swal({   
			title: '<?= __("Attention"); ?>',   
			text: "<?= __('Vous vous apprêtez à valider une demande de réservation.  En l\'acceptant, vous vous engagez à accueillir le locataire.   Souhaitez-vous confirmer ?'); ?>",
			// type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#09f",   
			confirmButtonText: '<?= __("Oui"); ?>',
			cancelButtonText: '<?= __("Annuler"); ?>',  
			closeOnConfirm: false,
			customClass: 'rounded-0'
		}, function(){
			$(".sweet-alert button").prop('disabled', true);
			$("#accepterinput").val("Accepter");
			$('#validationForm').submit();
		});
	});

	$("#refuser").click(function(){    
		swal({   
			title: '<?= __("Attention"); ?>',   
			text: '<?= __("Vous vous apprêtez à refuser une demande de réservation."); ?><?php if($proprietaire->nature != "PRES"){ ?>  <?= __("Une pénalité pourra être appliquée à votre compte après plusieurs refus."); ?><?php } ?><div class="form-group mt-3 text-left"><label class="text-left"><small><?= __("Dites-nous pourquoi vous souhaitez refuser la réservation") ?>.</small></label><select class="custom-select" name="raison" id="raison" required=""><option value="0"><?= __("Sélectionnez votre raison"); ?> *</option><option value="1"><?= __("Les prix n’ont pas été actualisés"); ?></option><option value="2"><?= __("Je souhaite occuper mon hébergement à ces dates"); ?></option><option value="3"><?= __("Je ne suis pas à l’aise lors de mes échanges avec ce(s) vacancier(s)"); ?></option><option value="4"><?= __("La période a déjà été réservée ailleurs"); ?></option><option value="5"><?= __("Autre"); ?></option></select></div><div class="form-group mt-3"><label class="text-left"><small><?= __("Rédigez un message à l\'attention du locataire lui indiquant pourquoi vous refusez sa demande de réservation.") ?></small></label><textarea class="form-control" id="note_refus" rows="3" placeholder="<?= __('Justifiez votre refus'); ?>"></textarea></div>  <?= __("Souhaitez-vous continuer ?"); ?>',
			html: true, 
			showCancelButton: true,   
			confirmButtonColor: "#09f",   
			confirmButtonText: '<?= __("Refuser et envoyer le message"); ?>',
			cancelButtonText: '<?= __("Annuler"); ?>',  
			closeOnConfirm: false,
			customClass: 'rounded-0'
		}, function(){
			inputValue = $("#note_refus").val();
			if (inputValue === "") {
				swal.showInputError('<?= __("Vous devez justifier votre refus!"); ?>');
				return false
			}
			
			selectValue = $("#raison").val();
			if (selectValue === 0 || selectValue === "") {
				swal.showInputError('<?= __("Vous devez choisir une raison!"); ?>');
				return false
			}

			var result = false; 

			var pattschaine = ["zéro", "zero", "z e r o", "zero.", "zéro.", "0six", "0sept", "z€ro", "z € r o", "pointcom", " om ", "il.c", "gma", "arobase", "(arobase)", "(at)", "(pointcom)", "(point)com", "yahoo", "gmail", "outlook", "hotmail", ". f r", ". b e", ". c h", "deux", "d e u x", "trois", "t r o i s", "quatre", "q u a t r e", "cinq", "c i n q", "six", "s i x", "sept", "s e p t", "huit", "h u i t", "neuf", "n e u f", "dix", "d i x", "vingt", "v i n g t", '@', ' tel', 'téléphone', 'telephone', 'portable', 'fixe', ' port.', 'adresse', '.com', '.fr', 'point com', 'point fr', '{at}', '{a}', 'mail', 'email', 'skype', '$kype', 'zero un', 'zero deux', 'zero trois', 'zero quatre', 'zero cinq', 'zero six', 'zero sept', 'zero huit', 'zero neuf', 'contacter au zero', 'contacter au 0', 'z e r o', 't e l', 'T-e-l', 'Z-e-ro', 'gmail', 'yahoo', 'hotmail', 'protonmail', 'outlook', 'orange', 'free', 'sfr', 'bouygues', 'icloud', 'gmx', 'caramail', 'tutanota', 'advalvas', 'aol', 'bluemail', 'bluewin', 'bbox', 'cyberposte', 'emailasso', 'fastmail', 'francite', 'hashmail', 'icqmail', 'iiiha', 'iname', 'juramail', 'katamail', 'laposte', 'libero', 'mailfence', 'mailplazza', 'mixmail', 'myway', 'No-log', 'openmailbox', 'peru', 'Safe-mail', 'tranquille.ch', 'vmail', 'vivalvi.net', 'webmail', 'webmails', 'yandex', 'zoho', '.com', '.fr', '.co.uk', '.ch', '.be', '.nl', '.at', '.es', '.cz', '.eu', '.de', '.gr', '.gal', '.it', '.li', '.lt', '.lu', '.pt', '.nl', '.se', '.eu', '.org', '.net', '.es', '.ee', '.fi', '(a)', '(at)', '[a]', '[at]', '+336', '+337', '06', '07', '+355', '+49', '+376', '+374', '+43', '+32', '+375', '+387', '+359', '+357', '+385', '+45', '+32', '+372', '+358', '+33', '+350', '+30', '+36', '+353', '+354', '+39', '+371', '+370', '+423', '+352', '+389', '+356', '+373', '+377', '+382', '+47', '+31', '+48', '+351', '+420', '+40', '+44', '+378', '+421', '+386', '+46', '+41', '+380', '+379']
			pattschaine.forEach(function(pattchaine, index){    
				if (inputValue.indexOf(pattchaine) != -1) {
					result = true;
				}
			});
			if (result) {
				swal.showInputError("<?= __("Votre message ne peut pas être envoyé car il viole les conditions générales de Alpissime.com.<br> Il est interdit de communiquer une adresse email ou un numéro de téléphone par la messagerie.") ?>");
				return false
			}

			$("#note_refus_hidden").val(inputValue);
			$("#raison_refus_hidden").val(inputValue);
			
			$(".sweet-alert button").prop('disabled', true);
			$("#refuserinput").val("Refuser");
			$('#validationForm').submit();
		});
	});
															$(document).ready(function () {
																
																$('#table_id_valid2').DataTable({
																	"columnDefs": [
																		{ responsivePriority: 1, targets: 0 },
																		{ responsivePriority: 4, targets: -3 },
																		{ responsivePriority: 2, targets: -1 },
																		{ responsivePriority: 5, targets: -4 },
																		{ responsivePriority: 6, targets: -5 },
																		{ responsivePriority: 7, targets: -6 },
																		{ responsivePriority: 3, targets: -2 }
																	],
																	responsive: true,
																	language: {
																		"url": "<?php echo $datatable_file; ?>",
																		// search: "_INPUT_",
																		// searchPlaceholder: "Recherche"
																	}
																});
																
																$("input[type=checkbox][id^=ReservationsSel]").click(function () {
																	$("div[id^=uniform-ReservationsSel] span").removeClass('checked');
																	$("#ReservationsValidationForm :checkbox").removeAttr("checked");
																	$(this).attr("checked","checked");
																	$("#uniform-"+$(this).attr("id")+" span").addClass('checked');
																	
																});
															});
															function show_popup_creer_res(){
        $('#popup_reser_creer').modal('show')
      }
															<?php $this->Html->scriptEnd(); ?>
