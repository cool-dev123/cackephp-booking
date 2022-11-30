<form>
    <div class="form-group">
            <label for="recipient-name" class="col-sm-3 control-label mb-10">De : </label>
            <?php if($deId > 50){
                if($gestionnaire->nature == 'ANNO' || $gestionnaire->nature == 'MIXT') $derole = "Propriétaire";
                else $derole = "Locataire";
                ?>
              <?php echo $gestionnaire->prenom." ".$gestionnaire->nom_famille ?> (<?php echo $derole ?>)
              <?php }else{ ?>
              <?php echo $gestionnaire->name ?>(<?php echo $gestionnaire->role ?>)
            <?php } ?>
    </div>
    <div class="form-group">
            <label for="message-text" class="col-sm-3 control-label mb-10">Objet : </label>
            <?php echo $info->sujet ?>
    </div>
    <div class="form-group">
        <label for="message-text" class="col-sm-3 control-label mb-10">Message : </label>
        <div class="col-sm-9" style="padding: 0 !important;margin: 0 !important;"><?php echo $info->message ?></div>
    </div>
</form>