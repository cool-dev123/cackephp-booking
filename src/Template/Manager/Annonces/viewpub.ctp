<form>
    <div class="form-group">
            <label for="recipient-name" class="col-sm-3 control-label mb-10 font-16 txt-black">Titre : </label>
            <label class="txt-black font-15"><?php echo $image->titre?></label>
    </div>
    <div class="form-group">
            <label for="message-text" class="col-sm-3 control-label mb-10 font-16 txt-black">Lien : </label>
            <label class="txt-black font-15"><?php echo $image->lien?></label>
    </div>
    <div class="form-group">
            <label for="message-text" class="col-sm-3 control-label mb-10 font-16 txt-black">Lieu geographique : </label>
            <label class="txt-black font-15"><?php echo $station?></label>
    </div>
    <div class="form-group text-center">
        <div class="col-sm-12">
            <img style="max-width: 100%;" class="img-fluid" src="<?php echo $this->Url->build('/',true)?>img/uploads/<?php echo $image->image;?>" />
        </div>
    </div>
</form>