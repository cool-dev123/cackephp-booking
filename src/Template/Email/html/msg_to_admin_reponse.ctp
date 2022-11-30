<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<p>Bonjour,</p>

<p>Le propriétaire <?php echo $proprietaire->prenom." ".$proprietaire->nom_famille." ( ".$proprietaire->email." )" ?> a répondu au message de <?php echo $locataire->prenom." ".$locataire->nom_famille; ?> <?php echo $locMail ?> par le message suivant :</p>
<p><?php echo $msg?></p>

        