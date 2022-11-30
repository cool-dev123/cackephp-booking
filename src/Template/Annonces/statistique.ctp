<h5 class="blue">
  Statistiques des visites de l'annonce n° <?php echo $annonce_id?>
</h5>
<br>
<?php if(empty($clics->toArray())) echo "<center>Aucun visiteur pour cette annonce</center>";?>
<?php foreach($clics as $clic) {
     $visiteur = ($clic->clic_nb>1) ? "visiteurs" : "visiteur";
     echo "<center><span class='title_message'>Date : </span><b>".$clic->clic_at." : </b>".$clic->clic_nb." $visiteur</center>";
  }
?>
