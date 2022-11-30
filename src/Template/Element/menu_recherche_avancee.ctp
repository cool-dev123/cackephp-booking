
<script>
function format_url()
{
//url=document.getElementById("annonceRechercheForm").action;
slt=$("#annonceLieugeo :selected").text();
var a_url=new Array();
a_url["Arcs 1600"]='location-arc-1600';
a_url["Arcs 1800"]='location-arc-1800';
a_url["Arcs 1800 (Chantel)"]='location-arc-1800/chantel';
a_url["Arcs 1800 (Charmettoger)"]='location-arc-1800/charmettoger';
a_url["Arcs 1800 (Charvet)"]='location-arc-1800/charvet';
a_url["Arcs 1800 (Les Villards)"]='location-arc-1800/les-villards';
a_url["Arcs 1950"]='location-arc-1950';
a_url["Arcs 2000"]='location-arc-2000';
a_url["Bourg St Maurice"]='bourg-st-maurice';
if(slt=="")
{
 rr="/annonces/rechercheavancee"
}
else
{
rr="/annonces/rechercheavancee/"+a_url[slt];
}
$("#annonceRechercheForm").attr("action", rr);

}
</script>
<div id="recherche_avancee" style="margin-left:4px;">
<?=$form->create("annonce",array("action"=>"rechercheavancee"))?>

<p><label for="lieugeo"> <?= __("Situation géographique") ?> </label>
 
    <?=$form->input("lieugeo",array(
                    'label'=>false,
                    'div'=>false,
                    'type'=>'select',
					'options'=>$l_lieugeos,
					"onchange"=>"format_url()",
					'size'=>'auto'))?>
  </p>
    
    <p>
  
  <p> <label for="dbt" style="margin-top:12px;">location :     du</label>
<?php if(preg_match("/firefox/i",$_SERVER['HTTP_USER_AGENT'] )){?>
     <?=$form->input('locationDe',array('label'=>false,'type'=>'text',"div"=>false,'size'=>7,'id'=>'annonceDbt'))?>au<?=$form->input('locationFin',array('label'=>false,'type'=>'text','div'=>false,'size'=>7,'id'=>'annonceFin'))?>
    <?php }else{?>
<?=$form->input('locationDe',array('label'=>false,'type'=>'text',"div"=>false,'size'=>6,'id'=>'annonceDbt'))?>au<?=$form->input('locationFin',array('label'=>false,'type'=>'text','div'=>false,'size'=>6,'id'=>'annonceFin'))?>
<?php }?>
   </p>
   
   <p>
   <label for="type">Type Location:</label>
   <input type="radio" value="CHA" id="AnnonceTypeLocationCHA" <?php if($this->data["annonce"]["typeLocation"]=="CHA") echo "CHECKED"?> name="data[annonce][typeLocation]" style="opacity: 0;">Chalet
   <input type="radio" value="APP" id="AnnonceTypeLocationAPP" <?php if($this->data["annonce"]["typeLocation"]=="APP") echo "CHECKED"?> name="data[annonce][typeLocation]" style="opacity: 0;">Appartement
   </p>
   <p>
   <label for="type">&nbsp;</label>
   <input type="radio" value="STD" id="AnnonceTypeLocationSTD" <?php if($this->data["annonce"]["typeLocation"]=="STD") echo "CHECKED"?> name="data[annonce][typeLocation]" style="opacity: 0;">Studio
   <input type="radio" value="GIT" id="AnnonceTypeLocationGIT" <?php if($this->data["annonce"]["typeLocation"]=="GIT") echo "CHECKED"?> name="data[annonce][typeLocation]" style="opacity: 0;">Gite
   </p>
   <p>
   <label for="couchage">Nombre de couchages:</label>
   <?=$form->input("nbCouchage",array(
									'label'=>false,
									'div'=>false,
									'type'=>'select',
									'options'=>array(0=>"",1=>"1",2=>"2",3=>"3",4=>"4",5=>"5",6=>"6",7=>"7",8=>"8",9=>"9",10=>"10",11=>"11",12=>"12",13=>"13",14=>"14",15=>"15"),
									'size'=>'auto'))?>
   </p>
   <p> <label for="surface" style="margin-top:12px;">Surface  :     de</label>
<?php if(preg_match("/firefox/i",$_SERVER['HTTP_USER_AGENT'] )){?>
     <?=$form->input('surfaceDe',array('label'=>false,'type'=>'text',"div"=>false,'size'=>6,'id'=>'surfaceDe'))?> &agrave; <?=$form->input('surfaceA',array('label'=>false,'type'=>'text','div'=>false,'size'=>6,'id'=>'surfaceA'))?>m&sup2;
    <?php }else{?>
<?=$form->input('surfaceDe',array('label'=>false,'type'=>'text',"div"=>false,'size'=>6,'id'=>'surfaceDe'))?>&agrave;<?=$form->input('surfaceA',array('label'=>false,'type'=>'text','div'=>false,'size'=>6,'id'=>'surfaceA'))?>m&sup2;
<?php }?>
   </p>
   <p>
   <label for="nbpiece">Nombre de pièces:</label>
   <?php //print_r($this->data);?>
   <input type="radio" value="1" id="AnnonceNbPiece1"  <?php if($this->data["annonce"]["nbPiece"]==1) echo "CHECKED"?>  name="data[annonce][nbPiece]" style="opacity: 0;">1
   <input type="radio" value="2" id="AnnonceNbPiece2" <?php if($this->data["annonce"]["nbPiece"]==2) echo "CHECKED"?> name="data[annonce][nbPiece]" style="opacity: 0;">2
   <input type="radio" value="3" id="AnnonceNbPiece3" <?php if($this->data["annonce"]["nbPiece"]==3) echo "CHECKED"?> name="data[annonce][nbPiece]" style="opacity: 0;">3
   <input type="radio" value="4" id="AnnonceNbPiece4" <?php if($this->data["annonce"]["nbPiece"]==4) echo "CHECKED"?> name="data[annonce][nbPiece]" style="opacity: 0;">4
   <input type="radio" value="5" id="AnnonceNbPiece5" <?php if($this->data["annonce"]["nbPiece"]==5) echo "CHECKED"?> name="data[annonce][nbPiece]" style="opacity: 0;">5
   </p>
   <p> <label for="surface" style="margin-top:12px;">Budget  :     de</label>
<?php if(preg_match("/firefox/i",$_SERVER['HTTP_USER_AGENT'] )){?>
     <?=$form->input('budgetDe',array('label'=>false,'type'=>'text',"div"=>false,'size'=>6,'id'=>'budgetDe'))?> &agrave; <?=$form->input('budgetA',array('label'=>false,'type'=>'text','div'=>false,'size'=>6,'id'=>'budgetA'))?>&euro;
    <?php }else{?>
<?=$form->input('budgetDe',array('label'=>false,'type'=>'text',"div"=>false,'size'=>6,'id'=>'budgetDe'))?>&agrave;<?=$form->input('budgetA',array('label'=>false,'type'=>'text','div'=>false,'size'=>6,'id'=>'budgetA'))?>&euro;
<?php }?>
   </p>
   <p>
	<?=$form->input("promotions",array(
									'label'=>false,
									'div'=>false,
									'style'=>'margin-left:5px',
									'type'=>'checkbox',
									'size'=>'auto'))?>Promotion
	<?=$form->input("parking",array(
									'label'=>false,
									'div'=>false,
									'style'=>'margin-left:5px',
									'type'=>'checkbox',
									'size'=>'auto'))?><?= __("Parking") ?>
	<?=$form->input("internet",array(
									'label'=>false,
									'div'=>false,
									'style'=>'margin-left:5px',
									'type'=>'checkbox',
									'size'=>'auto'))?><?= __("Internet") ?>
	</p>
	<p>
	<?=$form->input("drap",array(
									'label'=>false,
									'div'=>false,
									'style'=>'margin-left:5px',
									'type'=>'checkbox',
									'size'=>'auto'))?>Draps et ligne fournis
	<?=$form->input("animaux",array(
									'label'=>false,
									'div'=>false,
									'style'=>'margin-left:5px',
									'type'=>'checkbox',
									'size'=>'auto'))?>Animaux accept&eacute;s
   </p>
    <p> 
	<label for="ref" style="margin-top:10px" >Référence annonce : </label>
    <?=$form->input("reference",array(
									'label'=>false,
									'div'=>false,
									'type'=>'text',
									'size'=>6))?>
	</p>
	
<p>
<label for="prix" style="margin-top:12px">Mot cl&eacute;</label>
<?=$form->input("motcle",array(
									'label'=>false,
									'div'=>false,
									'type'=>'text',
									'size'=>20))?>
</p>
<p style="width:100%;text-align:right"><input name="action_recherche" value="Valider" type="submit" class="submit" ></p>
    <?=$form->end()?>
<p style="text-align:center;padding-top:6px;"><a href="/main/infos_plans_stations" style="color:#fff;font-weight:bold;line-height:13px;">Voir les donn&eacute;es et plans de Bourg <br/>St Maurice - Les Arcs</a></p>
</div>
