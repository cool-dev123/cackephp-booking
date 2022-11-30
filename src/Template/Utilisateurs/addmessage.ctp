<style>
select#gestionnaire {
    background: #fff;
}
</style>
<div class="col-sm-12">
    <div class="form-group">
        <label for="">Destinataire : </label>
        <input type="hidden" class="full" id="de"  value="<?php echo $proprietaireId  ?>" >
        <select id="gestionnaire" class="custom-select rounded-0" multiple>
        <?php foreach($a_gest as $k=>$v):?>
        <option value="<?php echo $v->id?>"><?php if($v->id == 6) echo "Administrateur"; else echo $v->name?></option>
        <?php endforeach;?>
        </select>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group">
        <label for="">Sujet :</label>
        <input type="text" id="objet" class="form-control rounded-0">
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group">
        <label for="">Message :</label>
        <textarea  id="msg" class="form-control  rounded-0" rows=6 cols=10></textarea>
    </div>
</div>

<div class="section last" style=' padding: 0 20px 3px;'>
    <div>
<a title="Modification" href="javascript:void(0)" class="btn btn-blue  rounded-0 text-white  right" id="send_mail"><?= __("Envoyer") ?></a>
<a title="Modification" href="javascript:void(0)" class="btn btn-retour border rounded-0  left" id="envoi_annuler">Annuler</a>
</div>
  </div>
<script>
$("#send_mail").on('click',function() {
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/setmessage/",
			data:{vId:$('#de').val(),vType:$('#gestionnaire').val(),vSujet:$('#objet').val(),vMsg:$('#msg').val()},
			success:function(xml){
				//alert(xml)
					$('#creermessage').modal('hide');

				}
			});
});
$("#envoi_annuler").on('click',function() {
  $('#objet').val('');
  $('#msg').val('');
	$('#creermessage').modal('hide');
});
</script>
