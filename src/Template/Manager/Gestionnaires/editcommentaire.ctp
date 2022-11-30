<div class="row">
    <?php foreach ($listerations as $key) { ?>
        <div class="col-sm-4" align="center">
            <h6><?php if($key->caracteristique == "qualiteprix") echo "Qualité-Prix"; else echo ucfirst($key->caracteristique); ?></h6>
            <input id="<?php echo $key->caracteristique; ?>rating" name="<?php echo $key->caracteristique; ?>rating" value="<?php echo $key->note; ?>" class="rating-loading">
        </div>
    <?php } ?>
</div>
<div class="row">
    <br><br>
    <div class="col-sm-4"><h6>Titre :</h6></div>
    <div class="col-sm-8"><p><?php echo $commentaire->titre; ?></p></div>
</div>
<div class="row">
    <div class="col-sm-4"><h6>Commentaire :</h6></div>
    <div class="col-sm-8"><p><?php echo $commentaire->commentaire; ?></p></div>
</div>

<script>
   $("#emplacementrating").rating({
     displayOnly: true,
     step: 0.5,
     size: 'xxs',
     //theme: 'krajee-fa'
   });
   $("#confortrating").rating({
     displayOnly: true,
     step: 0.5,
     size: 'xxs',
     //theme: 'krajee-fa'
   });
   $("#qualiteprixrating").rating({
     displayOnly: true,
     step: 0.5,
     size: 'xxs',
     //theme: 'krajee-fa'
   });
</script>