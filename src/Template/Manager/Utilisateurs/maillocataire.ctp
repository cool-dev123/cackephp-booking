<script>
$(function() {
	$("select[id^=UtilisateurDateRes]").change(function () {
		$('#hdres').val($(this).val());
		$('#sendDateRes').submit();
});
$('input[type=checkbox][id^=check_]').click(function(){
    num_tel="";
	v_id="";
	i=0;
	$('input[type=checkbox][id^=check_]').each(
			function() {
				if(this.checked){
					//a_t=$(this).val().split("_");
				  if(i==0) {
					num_tel+=$("#td_content_"+$(this).val()).html();
					v_id+=$(this).val();
				 }
				 else  {
					num_tel+=";"+$("#td_content_"+$(this).val()).html();
					v_id+=";"+$(this).val();
				 }
				 i++;
				}
			});
			$("#hdidloc").val(v_id);
			$("#smstelephone").val(num_tel);
});
$('input[type=checkbox][id^=checkAll]').click(function(){
	if(this.checked){
		$('input[type=checkbox][id^=check_]').each(
				function() {
					$('div[id^=uniform-check_] span').attr("class","checked") 
					 $(this).attr("checked","checked");
				}
			);
	}else{
		$('input[type=checkbox][id^=check_]').each(
				function() {
				    $('div[id^=uniform-check_] span').removeAttr("class") 
					$(this).removeAttr("checked");
				}
			);
	}
    num_tel="";
	v_id="";
	i=0;
	$('input[type=checkbox][id^=check_]').each(
			function() {
				if(this.checked){
					//a_t=$(this).val().split("_");
				 if(i==0) {
					num_tel+=$("#td_content_"+$(this).val()).html();
					v_id+=$(this).val();
				 }
				 else  {
					num_tel+=";"+$("#td_content_"+$(this).val()).html();
					v_id+=";"+$(this).val();
				 }
				 i++;
				}
			});
			$("#hdidloc").val(v_id);
			$("#smstelephone").val(num_tel);
});
});
function reset_frm(){
		$('#hdres').val("");
		$('#sendDateRes').submit();
}
function txtreste(){
//int nb_c=$("#message").val().length;
txtres=160-$("#message").val().length;
//else txtres=160;
$("#txtmessage").html("Message (reste "+txtres+" caractère) :");
}
function verfier_champ(){
    msg="";
	if($("#smstelephone").val()==""){
	 msg+="Veuillez sélectionner au moins un locataire\n";
	}
	if($("#message").val()==""){
	 msg+="Veuillez saisir votre message";
	}
	if(msg.length>0){
		alert(msg);
		return false;
	}else{
		return true;
	}
	
}
</script>
		<div id="contacthotel" class="widget  span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-table"></i> Envoi email depuis alpissime.com </span>
        </div><!-- End widget-header -->	
        <div class="widget-content">
        <!-- Table UITab -->
        <div  style="position:relative;">
		<div style='width:80%;float:left;margin-top:10px'>
			<form action="" method="post" enctype="multipart/form-data" id="frm_send-sms" onsubmit="return verfier_champ()" >
				<fieldset>
					<table width='100%'>
						<tr style='padding:5px 0;'>
							<td style="width:200px;padding:5px 0;text-align:left">Date reservation :</td>
							<td>
							<select name="data[Utilisateur][date_res]" id="UtilisateurDateRes">
								<option></option>
								<?php foreach($a_loc as $d):?>
								
								<option value="<?php echo $d?>" <?php if($d==$date_select) echo "SELECTED"?>><?php echo date("d-m-Y", strtotime($d));?></option>
								<?php endforeach;?>
							</select>
							</td>
						</tr>
						<tr style='padding:5px 0;'>
						<td colspan=2>
						<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" style="width:100%">
							<thead>
							<tr style="font-weight:bold;">
								<td class="black"><input type="checkbox" id="checkAll" name="data[checkAll]" /></td>
								<td class="black">Prénom</td>
								<td class="black">Nom de famille</td>
								<td class="black">Ville</td>
								<td class="black">Mail</td>
								<!--<td class="black">reçu un mail</td>-->
							</tr>
							</thead>
							<? if (count($a_list_loc)>0) {?>
							<tbody>
							  <? $cpt=0;foreach($a_list_loc as $enr) {?>
								<tr <?php if($cpt%2==0){?>style="background-color:#E4E4E4" <?php }?>>
									<td>
										<input type="checkbox" id="check_<?php echo $enr['U']['id']?>" value="<?php echo $enr['U']['id']?>" name="data[sel][]" >
									</td>
									<td><?=$enr['U']['prenom']?></td>
									<td><?=$enr['U']['nom_famille']?></td>
									<td><?=$enr['U']['ville']?></td>
									<td id='td_content_<?php echo $enr['U']['id']; ?>'><?=str_replace(" ","",$enr['U']['email'])?></td>
									
									<!--<td>
									<?php /*if(!empty($enr['U']['sms'])):?>
										<img src='<?=$this->base?>/images/val-sel.png'/>
									<?php endif;*/?>
									</td>-->
									</tr>
							  <?$cpt++;}?>
							</tbody>
						<?}?>
						</table>
						</td>
						</tr>
						
					</table>
						<div class="section">
							<label for="PackSujet">E-Mail :</label>
							<input id="smstelephone" type="text" value="" style="width:261px;"  name="data[telephone]"/>
							<input id="hdidloc" type="hidden" value="" style="width:261px;" readOnly name="data[idlocataire]"/>
						</div>
						<div class="section">
							<label for="PackSujet">Model sms :</label>
								<?php foreach($model as $m):?>
								<div><input type="radio" name="data[model]" value="<?php echo $m['Modelmail']['id']?>"/><?php echo $m['Modelmail']['titre']?></div>
								<?php endforeach;?>
						</div>
						<div class="section">
							<label for="PackSujet">Piece jointe :</label>
							<input id="image" type="file" style="width:261px;"  name="data[fichier]"/>
							
						</div>
						<div class="submit">
						<input type="submit" value="Envoyer" name="add" style="margin-top:10px" class="uibutton icon add">
						<input type="submit" name="data[Tester]" value="Tester" style="margin-top:10px" class="uibutton icon add">
						<a href="javascript:void(0)" onclick="reset_frm()" class="uibutton special answer"> Reset </a>
						</div>
				</fieldset>
				
			</form>
		</div>
		<?php echo $sms_message;?>	
    </div>
	
	<form id='sendDateRes' method="post" >
		<input type="hidden" id="hdres" name="UtilRes" />
	</form>
</div>
</div>