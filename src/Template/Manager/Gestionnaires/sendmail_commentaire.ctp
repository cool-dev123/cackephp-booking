<form class="form-horizontal">
    <div class="form-group">
            <label class="col-sm-3 control-label">De</label>
            <div class="col-sm-9">
                <input style="cursor: no-drop;" type="text" class="form-control" id="from" readonly="readonly" value="<?php echo $gestionn['G']['email']  ?>">
            </div>
    </div>
    <div class="form-group">
            <label class="col-sm-3 control-label">Destinataire</label>
            <div class="col-sm-9">
                <input style="cursor: no-drop;" type="text" class="form-control" id="to" readonly="readonly" value="<?php echo $propmail  ?>">
            </div>
    </div>
    <div class="form-group">
            <label class="col-sm-3 control-label">Objet</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="objet">
            </div>
    </div>
    <div class="form-group">
            <label class="col-sm-3 control-label">Message</label>
            <div class="col-sm-9">
                <textarea  id="msg" rows="8" cols="50"></textarea>
            </div>
    </div>

</form>