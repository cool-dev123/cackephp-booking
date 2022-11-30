


<?php  $c=0; foreach($annonces as $annonce) {
      if($c++==0) continue;
      echo "<li><div class='info'>";

			echo 		"<span class='cat'>";
            echo $annonceFormater->vignette_petite($annonce,$l_distances);
echo "</span>";
				echo "</div><div class='clear'></div></li>";
    }
?>
