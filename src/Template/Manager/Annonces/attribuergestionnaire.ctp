 <?php
 $dates_arr = explode(' ', $reservation->heure_arr);
 $time_arr = $dates_arr[1];
 $dates_dep = explode(' ', $reservation->heure_dep);
 $time_dep = $dates_dep[1];
 ?>
<form>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10 font-16">Annonce:</label>
        <label class="font-15"><?php echo $annonce->id; ?></label>
        <input type="hidden" value="<?php echo $annonce->id; ?>" id="annonceId">
    </div>
    <div class="form-group">
        <label for="message-text" class="control-label mb-10 font-16">Village:</label>
        <label class="font-15"><?php echo $annonce->village->name; ?></label>
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10 font-16">Gestionaire:</label>
        <select class="form-control" id='gest'>
                <option value="-1">------</option>
                                <?php foreach ($gestionnaire as $key => $value) {
                if($value->name != '') {?>
                                <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
            <?php } ?>
              <?php }?>
        </select>
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10 font-16">Position Clé:</label>
        <input class="form-control" type="text" value="" id="poscle" />
    </div>
</form>