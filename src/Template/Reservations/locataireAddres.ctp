<?php
//echo "test";
$a_adult=array();
for($i=1;$i<19;$i++){
	$a_adult[$i]=$i;
}
$a_child=array();
for($i=0;$i<17;$i++){
	$a_child[$i]=$i;
}
?>


<script type="text/javascript" src="<?php echo $this->base;?>/manager-arr/components/validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo $this->base;?>/manager-arr/components/validationEngine/jquery.validationEngine-en.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $this->base ?>/manager-arr/components/validationEngine/validationEngine.jquery.css" />
<style type="text/css" media="screen">

		#info_menage{background:#fff;border:1px solid #8c6;width:230px;}
	</style>
<script type="text/javascript" src="<?php echo $this->base ?>/manager-arr/js/jquery.simpletooltip-min.js"></script>
<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function() {
        jQuery("#FormReservation").validationEngine({
                prettySelect : true,
                useSuffix: "_chzn"
        });
});
</script>
<script>
$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
   $( "#dialog-confirm" ).dialog({
            autoOpen:<?php echo !empty($confirm_res)?'true':'false';?>,
            modal: true,
			width:520,

    });
	$("#tarif_dispo").colorbox({width:"610",height:"400"});
	$('#btn_dispo_valider').live('click', function () {
		$("#ReservationDebut").val($("input[type=radio][id^=dispo_]:checked").attr('data-dbt'));
		$("#ReservationFin").val($("input[type=radio][id^=dispo_]:checked").attr('data-fin'));
		$("#ReservationAnnonceId").val($("input[type=radio][id^=dispo_]:checked").val());
	   $.colorbox.close();
	 });
   /* testm = 0;
	$("#ReservationDebut" ).datepicker({
	dateFormat: "dd-mm-yy",
	minDate: 0,
	onSelect: function( selectedDate ) {
	//alert(selectedDate);
	dd=selectedDate.split('-');
	testm = new Date(dd[2]+"-"+dd[1]+"-"+dd[0]);
	testm.setDate(testm.getDate() + 1);
	//alert(testm);
	$( "#ReservationFin" ).datepicker( "option", "minDate", testm );
	}
	});
	$("#ReservationFin" ).datepicker({
		dateFormat: "dd-mm-yy",
		minDate: new Date($("#ReservationDebut").val())
	});*/
	$("#uniform-ReservationListMenage1").attr('href','#info_menage');
	$("#ReservationListMenage1").click(function(){$("#ReservationMenage").val(1)});
	$("#ReservationListMenage0").click(function(){$("#ReservationMenage").val(0)});
	$("#uniform-ReservationListMenage1").simpletooltip({ click: true, hideOnLeave: false });

	 /*var tooltips = $( "[title]" ).tooltip({
		position: {
		my: "left top",
		at: "right+5 top-5"
		}
		});
		$( "#ReservationMenage1" ).click(function() {
			tooltips.tooltip( "open" );
		});*/

   });
</script>
<div style="padding-top:30px;">

<div class="sectiondroite">
  <?=$this->element("mon_compte")?>
  <?=$this->element("menu_recherche")?>
  <? //=$this->element("cadre_promotion")?>
  <? //=$this->element("offre_inscription")?>
</div>
<div class="sectioncentre">
    <div class="cadreresultatannonce" style="min-height:1024px;">

        <div class="loc_bondeau_top" style="float:none;width:110%;margin-top:27px;">
			<div class="bondeau_top"></div>
			<div class="bondeau_content">
				<?= __("Créer une réservation") ?>
			</div>
			<div class="bondeau_footer"></div>
		</div>

		<div style='padding: 20px 0px 0px 32px;'>
			<? $session->flash()?>
			<?=$form->create('Reservation',array('id'=>'FormReservation','url'=>'/reservations/locataire_addres/'));?>
			<?=$form->input('proprietaire_id',array('type'=>'hidden','value'=>$session->read('Auth.Utilisateur.id')));?>
			<?php echo $form->input('manuelle',array('type'=>'hidden','value'=>'reservation'));?>
			<fieldset>
				<p style="color:green;font-weight:bold;">
					<?= __("Lors de votre prochaine location demandez à votre futur locataire de réserver par alpissime.com de façon à alimenter automatiquement votre tableau de réservation") ?>
				</p>
			</fieldset>
			<fieldset style='border:1px solid #000'>
				<legend><?= __("Info locataire") ?></legend>
				<table style='padding-left:20px;'>
					<tr><td><b><?= __("Civilité") ?> :</b></td>
						<td>
							<?=$form->input("civilite",array(
							   'label'=>'',
							   'div'=>'',
							   'type'=>'select','options'=>array('Mr'=>'Mr','Mme'=>'Mme','Mlle'=>'Mlle'),'class'=>'select'))?>
						</td>
					</tr>
					<tr><td><b><?= __("Nom") ?> (*):</b></td>
						<td>
							<?=$form->input("nom",array(
								'label'=>'',
								'size'=>'45',
								'type'=>'text',
								'maxlength'=>'60','class'=>'select validate[required]'))?>
						</td>
					</tr>
					<tr><td><b><?= __("Prénom") ?> (*):</b></td>
						<td>
							<?=$form->input("prenom",array(
								'label'=>'',
								'size'=>'45',
								'maxlength'=>'60','class'=>'select validate[required]'))?>
						</td>
					</tr>
					<tr><td><b><?= __("Code postal") ?> (*):</b></td>
						<td>
							<?=$form->input("code_postal",array(
								'label'=>'',
								'size'=>'45',
								'maxlength'=>'40','class'=>'select validate[required]'))?>
						</td>
					</tr>
					<tr><td><b><?= __("Ville") ?> (*):</b></td>
						<td>
							<?=$form->input("ville",array(
								'label'=>'',
								'size'=>'45',
								'maxlength'=>'100','class'=>'select validate[required]'))?>
						</td>
					</tr>
					<tr><td><b>Mail (*):</b></td>
						<td>
							<?=$form->input("email",array(
								'label'=>'',
								'size'=>'45',
								'maxlength'=>'100','class'=>'select validate[required,custom[email]]'))?>
						</td>
					</tr>
					<tr><td><b><?= __("Numéro portable") ?> (*):</b></td>
						<td>
							<?=$form->input("portable1",array(
								'label'=>'',
								'size'=>'45',
								'maxlength'=>'40','class'=>'select validate[required]'))?>
						</td>
					</tr>
					<tr><td><b>2ème numéro portable:</b></td>
						<td>
							<?=$form->input("portable2",array(
								'label'=>'',
								'size'=>'45',
								'maxlength'=>'40','class'=>'select'))?>
						</td>
					</tr>
					<tr><td valign='top'><b><?= __("Commentaire") ?>:</b></td>
						<td>
							<?=$form->input("comment",array(
								'label'=>'',
								'div'=>'',
								'type'=>'textarea','rows'=>'3','cols'=>'40','maxlength'=>'1000'))?>
						</td>
					</tr>
				</table>
			</fieldset>

			<fieldset style='border:1px solid #000'>
				<legend><?= __("Réservation") ?></legend>
				<table style='padding-left:20px;'>

					<tr>
						<td>
							<a class="btn-search" style="margin-top:-60px;color:#fffbff;padding:5px;" href="<?php echo $this->base?>/reservations/tarifdispo" id="tarif_dispo"><?= __("Créer une réservation") ?></a>
							<?=$form->input('annonce_id',array('type'=>'hidden'))?>
						</td>
						<td>
							<?=$form->input("debut",array(
							   'label'=>'',
							   'div'=>'',
							   'maxlength'=>'40','readonly'=>'readonly','style'=>'width:184px','class'=>'select validate[required]'))?>

						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							<?=$form->input("fin",array(
							   'label'=>'',
							   'div'=>'',
							   'maxlength'=>'40','readonly'=>'readonly','style'=>'width:184px','class'=>'select validate[required]'))?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Nombre d'enfants de 0 à 18 ans (inclus):</b>
						</td>
						<td>
							<?=$form->input('enfant',array(
														'label'=>'',
														'div'=>'',
														'type'=>'select',
														'options'=>$a_child,'class'=>'select'))?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Nombre d'adultes (à partir de 19 ans):</b>
						</td>
						<td>
							<?=$form->input('adult',array(
														'label'=>'',
														'div'=>'',
														'type'=>'select',
														'options'=>$a_adult,'class'=>'select'))?>
						</td>
					</tr>
					<tr><td><b><?= __("Taxe de séjour gérée par alpissime") ?> (*):</b></td>
						<td>
							<?=$form->input("taxe",array(
								'legend'=>'',
								'div'=>'',
								'type'=>'radio','options'=>array(0=>"Non",1=>"Oui"),'class'=>'validate[required]'))?>
						</td>
					</tr>
					<tr><td><b> Ménage (*):</b></td>
						<td>
							<?=$form->input("list_menage",array(
								'legend'=>'',
								'div'=>'',

								'type'=>'radio','options'=>array(0=>"Non",1=>"Oui")))?>
								<?=$form->input("menage",array('type'=>'hidden','value'=>0))?>
						</td>
					</tr>


				</table>
				<div id='info_menage'>
					 <a target="_blank" href='<?php echo BOUTIQUE_ALPISSIME ?>/services/menage.html'>
					 <img src="<?php echo $this->base?>/img/menage_alpissime.jpg"/>
					 </a>
					 <a style="padding:5px;float:right;" href="#" rel="close"><?= __("Fermer") ?></a>
				</div>
			</fieldset>

			<fieldset style='border:1px solid #000'>
				<legend>Supplémentaires</legend>
				<table style="border-spacing:1px;margin-top:3px;font-size:10px;background-color: #E0E0E0">
					<tr>
						<td  class="black">Service</td>
						<td  class="black">Coût en &euro;</td>
						<td  class="black">Commentaire dddd</td>
						<td class="black">Je suis interessé</td>
					</tr>
					<? foreach ($packs as $index => $pack) { ?>
						<tr <?php if($index %2==0){?> style="background-color:#fff"<?php }?>>
							<td><?=$pack["Pack"]["titre"]?></td>
							<td ><?=$pack["Pack"]["cout"]?></td>
							<td ><?=html_entity_decode(str_replace(array("\n","<pre>","</pre>"),array("<br>","",""),$pack["Pack"]["comment"]))?></td>
							<td style="text-align:center;">
								<input type="checkbox" name="data[Reservation][Pack][<?=$index?>]" value="<?=html_entity_decode($pack["Pack"]["id"])?>">
							</td>
						</tr>
					<? } ?>
                </table>
			</fieldset>
			<fieldset style='border:1px solid #fff'>
			<div class="submit"><input type="submit" style="float:right; margin-right: -10px;" class="submit_reserv" value="Valider" name="maj_annonce"></div>
			</fieldset>
			<?=$form->end();?>
		</div>

    </div>
</div>
</div>
<div id="dialog-confirm" title="<?= __('Confirmation réservation sur alpissime.com') ?>">
        <div id="texte-error">
			<br/>
			<p>Cette réservation a été prise en compte</p>
			<p>vous la retrouverez sur votre planning de réservation</p>
			<p>la semaine est aussi validée sur votre espace</p>
		</div>
</div>
