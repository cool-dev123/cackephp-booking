<form class="form-horizontal">
    <div class="form-group">
        <label class="control-label text-left col-sm-6" for="email_hr"><h6>De:</h6></label>
        <div class="col-sm-6">
            <input readonly type="text" value="<?php echo $gestionn['G']['email']  ?>" class="form-control" id="from">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label text-left col-sm-6" for="email_hr"><h6>Destinataire:</h6></label>
        <div class="col-sm-6">
            <input type="text" value="<?php echo $reservation->utilisateur->email  ?>" class="form-control" id="to">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label text-left col-sm-6" for="email_hr"><h6>Objet:</h6></label>
        <div class="col-sm-6">
                <input type="text" class="form-control" id="objet">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label text-left col-sm-6" for="email_hr"><h6>Message:</h6></label>
        <div class="col-sm-6">
                <textarea  id="msg" rows="5" cols="30"></textarea>
        </div>
    </div>
</form>