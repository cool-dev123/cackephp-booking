<?php $this->Session->flash() ?>
<div class="sectiondroite">
  <?php echo $this->element("mon_compte")?>
  <?php echo $this->element("menu_recherche")?>
  <?php echo $this->element("cadre_promotion")?>

</div>
<div class="sectioncentre">
<div class="cadrecentre">
<h1>Informations et plans de la station Arc 1600</h1>

<br />
<div style="background-color: #e9eefb; width: 350px; height: 17px; border-bottom: 1px solid #cedaf7; padding-left: 10px;">+ Renseignements sur la station</div>
<br />
<br />
Arc 1600 est une station piétonne de 4190 lits touristiques et 30 commerces.<br />
L'enneigement artificiel à l'aide de canons à neige assure un retour station toute la saison.<br />
<br />
Pour les piétons ou les skieurs étourdis, des navettes gratuites<br />
relient les stations Arc 1600, Arc 1800, Arc 1950 et Arc 2000.<br />
Le funiculaire vous permettra aussi de redescendre à Bourg Saint Maurice dans la vallée.
<br />
<br />
<br />
<div style="background-color: #e9eefb; width: 350px; height: 17px; border-bottom: 1px solid #cedaf7; padding-left: 10px;">+ Plan de la station</div>
<br />
<br />
<div id="plan_arc_1600"><?php echo $html->link("","/pdf/plan-arc-1600.pdf",array('target'=>'_blank',"title"=>"Plan station Arc 1600"),null,false)?>
</div>



</div></div>
</div>
</body></html>
