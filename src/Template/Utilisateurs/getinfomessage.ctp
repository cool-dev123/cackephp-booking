<h6 class="blue"><?= __("Annonce N°") ?> <?php echo $m->id_annonce?>
<span class="right date">
<?php
  $a_date=explode(" ",$m->date_insert);
?>
<?php echo $m->date_insert;?>
</span>
</h6>
<p><span class="title_message">Nom : </span><?php echo $m->prenom." ".$m->nom?></p>
<p><span class="title_message">Objet : </span><?php echo $m->demande?></p>
<p><span class="title_message">Message :</span></p>
<p><?php echo $m->commentaire?></p>
<p><span class="title_message">Réponse : </span></p>
<?php foreach ($reponse as $value) { ?>
    <p> - <?php echo $value->message ?></p> 
<?php } ?>
<br><br>
<button type="button" class="btn btn-success pull-right" data-toggle="modal" onclick="show_popup_anser(<?php echo $m->id?>)" ><?= __("Répondre") ?></button>
