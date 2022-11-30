<form class="form-horizontal">
    <input type="hidden" value="<?php echo $cleid; ?>" id="cleid" />
    <div class="form-group">
        <label class="control-label mb-10 col-sm-4 text-right font-16">Position Clé :</label>
        <div class="col-lg-6 col-sm-10 col-md-6">
            <input class="form-control" type="text" value="<?php if($clepos->position_cle != 0) echo $clepos->position_cle ?>" id="poscle" />
        </div>
    </div>
</form>
