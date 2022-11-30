<form>
    <input type="hidden" class="full" id="de"  value="<?php echo $id_gest  ?>" >
        <div class="form-group">
                <label for="recipient-name" class="control-label mb-10">Destinataire:</label>
                <select multiple  type="text" class="selectpicker" id="gestionnaire">
                    <?php foreach($a_gest as $k=>$v):?>
                        <?php if($k!=$id_gest):?>
                            <option value="<?php echo $k?>"><?php echo $v?></option>
                        <?php endif;?>
                    <?php endforeach;?>
                </select>
        </div>
        <div class="form-group">
                <label for="message-text" class="control-label mb-10">Sujet:</label>
                <input autocomplete="off" type="text" class="form-control" id="objet">
        </div>
        <div class="form-group">
                <label for="message-text" class="control-label mb-10">Message:</label>
                <textarea rows="5" class="form-control" id="msg"></textarea>
        </div>
</form>
<script>
    /* Select2 Init*/
        $("#gestionnaire").select2();
</script>