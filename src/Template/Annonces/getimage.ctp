
	<?php if ($annonce) { ?>
	<?php $cpt=4; foreach($annonce as $photo) {
	$nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;
	?>
	<li>
	<img src="<?php echo $this->Url->build('/',true)?>images_ann/<?php echo $photo->annonce_id?>/<?php echo $nomImg?>.G.jpg"/>
  </li>
	<?php
	}} else { //echo "Aucune photo n'est disponible pour le moment";?>
	<li>
		<img src="<?php echo $this->Url->build('/',true)?>img/default_G.png"/>
	</li>
	<?php }?>
	<script>
//
//	    $(document).ready(function () {
//
//	        $('.bxslider').bxSlider({
//	            pagerCustom: '#bx-pager',
//	            auto: true,
//	            pause: 7000,
//							/*slideWidth: 670*/
//	        });
//	        //$("html").niceScroll({styler:"fb",cursorcolor:"#000"});
//	        $("#bx-pager").niceScroll({cursorcolor: "#ff8700"});
//	    });</script>
