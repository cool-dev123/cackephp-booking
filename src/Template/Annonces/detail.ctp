<style>
    #tab_annonce {
        border-spacing: none;
        background-color:#ccc;
        margin-top: 25px;
        width:100%;

    }
    #tab_annonce .black{
        font-size: 10px;
    }
    #tab_annonce .bleu{
        background-color: #00C3FF;
    }
    #tab_annonce td{
        /*background-color: #999;*/
        width:50%;

        height:25px;
    }
    #tab_annonce b{
        margin-right:40px;

        color:#fff;

    }

</style>
<?php

$choix=array('Non','Oui');

$chauffe=array('0'=>'Non','1'=>'Radiateurs Electriques ','2'=>'Chaudière Gaz','3'=>' Chaudière Fuel');
$stationnement=array('0'=>' Garage ','1'=>' Parking ','2'=>' &agrave; Proximit&eacute;');
$i=0;
?>

<table id='tab_annonce'>




       <tr><td colspan="2" class="black"><h2 > D&eacute;tail de l'annonces n&ordm; <?php echo $annonce->id;?></h2></td></tr>
        <tr class="bleu"><td > <b><?= __("Ascenseur") ?></b> <?php echo $choix[$annonce->ascenseur_yn]?>

             </td>

<td ><b>Acces Aux personnes &#224; mobilité reduite</b> <?php  if($choix[$annonce->personne_reduite]=='') {echo 'Non';} else {echo $choix[$annonce->personne_reduite];}?>

             </td>
        </tr>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><b><?= __("Non-fumeur") ?> </b> <?php  if($choix[$annonce->personne_reduite]=="") {echo 'Non';} else {echo $choix[$annonce->non_fumeur];} ?>

             </td>


<td ><b> Exposition </b>
<?php
$exposition=array('0'=>'Non précisée','1'=>'Nord','2'=>'Sud','3'=>'Est','4'=>'Ouest','5'=>'Nord-Est','6'=>'Nord-Ouest', '7'=>'Sud-Est', '8'=>'Sud-Ouest');


echo $exposition[$annonce->exposition];

?>


            </td>
        </tr>

 <tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><b>Stationnement  </b><?php  if($annonce->stationnement==''){echo 'Non';} else{ echo $stationnement[$annonce->stationnement] ; if($annonce->parking_couvert==1){ echo ' Couvert';}}
 ?>

            </td>
        <td >
           <b><?= __('Extérieurs') ?></b> <?php if($annonce->balcon_yn==1) echo 'Balcon ';?><?php if($annonce->terasse_yn==1) echo 'Terasse ';?><?php if($annonce->jardin_yn==1) echo 'Jardin ';?>

        	</td>
        </tr>
<?php if($annonce->centre_comm==1|| $annonce->transport_public==1){?>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><b><?= __("Situation") ?></b><?php if($annonce->centre_comm==1){ echo 'Proche d\'un centre Commercial';?>
<?php if($annonce->restaurant==1){ echo ',Restaurants';}?>
<?php if($annonce->velos==1){ echo ',Location des Velos';}?>
<?php if($annonce->loc_ski==1){ echo ',Location de ski';}?>
<?php if($annonce->remontee_caisse==1){ echo ',Caisses de remontés mécaniques';}?>
             <?php }?>
            </td>
        <td >

           <?php if($annonce->transport_public==1){ echo 'Proche des transports publics';}?>
        	</td>
        </tr>
<?php }?>


<?php if($annonce->espace_sportif==1|| $annonce->bien_etre==1){?>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>>
        <td >

           <?php if($annonce->bien_etre==1){ echo 'Proche des centres de bien etre';?>
<?php if($annonce->spa==1){ echo ',Spas';}?>
<?php if($annonce->hammam==1){ echo ',Hammam';}?>
<?php if($annonce->sauna==1){ echo ',Sauna';}?>
<?php if($annonce->jacuzzi==1){ echo ',Jacuzzi';}?>
<?php if($annonce->massage==1){ echo ',Massage';}?>

<?php }?>
        	</td><td >

           <?php if($annonce->espace_sportif==1){ echo 'Proche des espaces sportifs été/hiver';?>
<?php if($annonce->ski_pied==1){ echo ',Skis aux pieds';}?>
<?php if($annonce->moins_50_piste==1){ echo ',Moins de 50 m';}?>
<?php if($annonce->cours_tennis==1){ echo ',Cours de Tennis';}?>
<?php if($annonce->piscine==1){ echo ',Piscine';}?>
<?php if($annonce->squash==1){ echo ',Squash';}?>
<?php if($annonce->patinoire==1){ echo ',Patinoire';}?>
<?php if($annonce->golf==1){ echo ',Golf';}?>
<?php }?>
        	</td>
        </tr><?php }?>
<?php if($annonce->lieux_anim==1|| $annonce->espace_enfant==1){?>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><?php if($annonce->espace_enfant==1){ echo 'Proche des espaces enfants';?>
<?php if($annonce->luge==1){ echo ',Luge';}?>
<?php if($annonce->club_enfant==1){ echo ',Club Enfant';}?>
<?php if($annonce->garderie==1){ echo ',Garderie';}?>
<?php if($annonce->ecole_ski==1){ echo ',Ecole de Ski';}?>



             <?php }?>
            </td><td ><?php if($annonce->lieux_anim==1){ echo 'Proche des lieux d\'animation';?>
<?php if($annonce->bar==1){ echo ',Bars';}?>
<?php if($annonce->pub==1){ echo ',Pubs';}?>
<?php if($annonce->Disco==1){ echo ',Discothèques';}?>

             <?php }?>
            </td></tr>

<?php }?>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>>
<td> <b>Espace Ludique </b>
<?php if($annonce->jeux_video)echo ' Jeux Vidéos';?>
<?php if($annonce->jeux_societe)echo ' jeux de société';
if(($choix[$annonce->jeux_video]=='') && ($choix[$annonce->jeux_societe]=='')){echo 'Non';}
?>
</td>
        <td >
  <?php if($annonce->placard|| $annonce->penderie){?>  <b>Mobilier </b><?php }?>
<?php if($annonce->placard)echo ' Placards ';?>
<?php if($annonce->penderie)echo ' Penderie ';?>
<?php if($annonce->table_120 || $annonce->table_140 || $annonce->table_160|| $annonce->table_180|| $annonce->table_200|| $annonce->table_allonge){?>
<br>&nbsp;Table:
<?php if($annonce->table_120)echo ' 120 ';?>
<?php if($annonce->table_140)echo ' 140 ';?>
<?php if($annonce->table_160)echo ' 160 ';?>
<?php if($annonce->table_180)echo ' 180 ';?>
<?php if($annonce->table_200)echo ' 200 ';?>
<?php if($annonce->table_allonge)echo ' Allongé ';?>
<?php }?>
<?php if($annonce->chaises)echo ' Chaises ';?>
<?php if($annonce->tabouret)echo ' Tabourets ';?>
 <?php if($annonce->literie_70 || $annonce->literie_80 || $annonce->literie_90|| $annonce->literie_140|| $annonce->literie_160|| $annonce->literie_2_70||$annonce->literie_sup_2_80||$annonce->literie_rev||$annonce->literie_cig||$annonce->literie_peign){?><br>&nbsp;Literie:<?php }?>
<?php if($annonce->literie_70)echo ' Lit 70 x 190 ';?>
<?php if($annonce->literie_80)echo ' Lit 80 x 190 ';?>
<?php if($annonce->literie_90)echo ' Lit 90 x 190 ';?>
<?php if($annonce->literie_140)echo ' Lit 140 x 190 ';?>
<?php if($annonce->literie_160)echo ' Lit 160 x 190 ';?>
<?php if($annonce->literie_2_70)echo ' Lits Superposés 2 x70 x 190 ';?>
<?php if($annonce->literie_sup_2_80)echo ' Lits Superposés 2 x80 x 190 ';?>
<?php if($annonce->literie_rev)echo ' Banquette Révisible ';?>
<?php if($annonce->literie_cig)echo ' Banquette Gigogne ';?>
<?php if($annonce->literie_peign)echo ' Banquette Lits Peignes 2 x 70 x 190 ';?>
<br>
</td></tr>

        	</td>
        </tr>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><b>Surface </b><?php echo $annonce->surface;?>  m&sup2;.
            </td>
        <td ><b>Nombre de salles de bain</b><?php if($annonce->sdb_nb==''){echo "0";} else{ echo ($annonce->sdb_nb=="99"?"5 +":$annonce->sdb_nb);} ?>
</td></tr>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><b>Nombre de baignoires</b><?php if($annonce->baignoire_nb==''){echo "0";} else{echo $annonce->baignoire_nb;} ?>

</td><td><b>Nombre de douches</b><?php if($annonce->douche_nb==''){echo "0";} else{echo $annonce->douche_nb;} ?></td></tr>

<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td><b>Nombre de wc</b><?php if($annonce->wc_nb==''){echo "0";} else{echo $annonce->wc_nb;} ?></td>
<td><b>Dont </b><?php echo $annonce->wc_sep_nb; ?>&nbsp; wc séparé(s)</td></tr>

<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td>

<b>Sanitaires :</b>
<?php if($annonce->baignoire_hydro|| $annonce->appart_hammam|| $annonce->appart_sauna||$annonce->robinetterie_melang||$annonce->robinetterie_mitig){?>
<?php if($annonce->baignoire_hydro){
 echo ' Baignoire Hydromassage ';
 }?>
 <?php if($annonce->appart_hammam){
echo ' Hammam ';
 }?><?php if($annonce->appart_sauna){
 echo ' Sauna ';
 }?>

<?php if($annonce->robinetterie_melang){
 echo 'Robinetterie Mélangeurs ';
 }
if($annonce->robinetterie_mitig){
 echo 'Robinetterie Mitigeurs ';
 }
?>
</td>  <?php } else {echo "non précisé";} ?> <td>
<b>Chauffage</b>
<?php
if(!($annonce->chauffage_elect)&&!($annonce->chauffage_gaz)&&!($annonce->chauffage_fuel)&& !($annonce->cheminee)){echo "non précisé";}
else{
if($annonce->chauffage_elect){
 echo ' Radiateurs Electriques ';
 }
if($annonce->chauffage_gaz){
 echo ' Chaudière Gaz ';
 }
if($annonce->chauffage_fuel){
 echo ' Chaudière Fuel ';
 }?>


<?php
if($annonce->cheminee){
 echo ' Cheminée ';
 } }?>
 </td></tr>

<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>>
<td ><b><?= __("Services") ?> </b>
<?php if($annonce->serv_acc==1){?>
Accueil personalis&eacute; sur site et club Alpissime A la demande <br/>
<?php }elseif($annonce->serv_acc==2){?>
Accueil personalis&eacute; sur site et club Alpissime Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_linge==1){?>
Linge de Toilette A la demande<br/>
<?php }elseif($annonce->serv_linge==2){?>
Linge de Toilette Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_drap==1){?>
Draps A la demande<br/>
<?php }elseif($annonce->serv_drap==2){?>
Draps Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_serviett==1){?>
Serviettes et Torchons A la demande<br/>
<?php }elseif($annonce->serv_serviett==2){?>
Serviettes et Torchons Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_lit_fait==1){?>
Lits Faits &agrave l'arrivèe A la demande<br/>
<?php }elseif($annonce->serv_lit_fait==2){?>
Lits Faits &agrave l'arrivèe Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_menage==1){?>
Service de M&eacute;nage A la demande<br/>
<?php }elseif($annonce->serv_menage==2){?>
Service de M&eacute;nage Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_entretien==1){?>
Produits d'entretient A la demande<br/>
<?php }elseif($annonce->serv_entretien==2){?>
Produits d'entretient Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_adap==1){?>
Adaptateur &eacute;lectrique (selon disponibilit&eacute;s) A la demande<br/>
<?php }elseif($annonce->serv_adap==2){?>
Adaptateur &eacute;lectrique (selon disponibilit&eacute;s) Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_lit_bebe==1){?>
Lits B&eacute;b&eacute; (selon disponibilit&eacute;s) A la demande<br/>
<?php }elseif($annonce->serv_lit_bebe==2){?>
Lits B&eacute;b&eacute; (selon disponibilit&eacute;s) Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_chaise_bebe==1){?>
Chaise B&eacute;b&eacute; (selon disponibilit&eacute;s) A la demande<br/>
<?php }elseif($annonce->serv_chaise_bebe==2){?>
Chaise B&eacute;b&eacute; (selon disponibilit&eacute;s) Inclus Club Alpissime<br/>
<?php }?>
<?php if($annonce->serv_chauffe_biberon==1){?>
Chauffe Biberon (selon disponibilit&eacute;s) A la demande<br/>
<?php }elseif($annonce->serv_chauffe_biberon==2){?>
Chauffe Biberon (selon disponibilit&eacute;s) Inclus Club Alpissime<br/>
<?php }?></td><td>
<b>Services Suppl&eacute;mentaires &agrave; la demande</b>
<?php if($annonce->serv_ski==1){?>
Cours de skis avec l'esf(club Alpissime)<br/>
<?php }?>
<?php if($annonce->serv_garagist==1){?>
Coordonn&eacute;es t&eacute;l&eacute;phoniques garagiste(club Alpissime)<br/>
<?php }?>
<?php if($annonce->serv_taxi==1){?>
Coordonn&eacute;es t&eacute;l&eacute;phoniques Taxi(club Alpissime)<br/>
<?php }?>
<?php if($annonce->serv_babysetting==1){?>
Coordonn&eacute;es t&eacute;l&eacute;phoniques pour Baby sitting(club Alpissime)<br/>
<?php }?>
</td></tr>
        <tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><b>Animaux de compagnie autorisés</b> <?php if($choix[$annonce->ani_co_yn]==''){echo "non précisé";} else{echo $choix[$annonce->ani_co_yn];}?>

             </td><td ><b> Acces Internet  </b>
<?php if($annonce->wifi){echo ' Wifi Gratuit (box dans l\'appartement)';} elseif ($annonce->wifi_payant){echo '  Wifi Payant';}
else {echo ' Non';}?>

</td></tr>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td colspan="2"><b><?= __("Equipements") ?> </b></td></tr>

       <tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><b>Electromenager </b>
<?php if($annonce->lave_linge==1){?>
    <?= __("Lave-linge") ?>
<?php }?>
<?php if($annonce->seche_linge==1){?>
    <?= __("Sèche-linge") ?>
<?php }?>
<?php if($annonce->Radiateur_seche==1){?>
    <?= __("Radiateur sèche-serviettes") ?>
<?php }?>
<?php if($annonce->lave_vaissel_4|| $annonce->lave_vaissel_8 || $annonce->lave_vaissel_12){?>
    <?= __("Lave vaisselle") ?>
<?php if($annonce->lave_vaissel_4)echo '4 Couverts';?>
<?php if($annonce->lave_vaissel_8)echo '8 Couverts';?>
<?php if($annonce->lave_vaissel_12)echo '12 Couverts';?>
<?php }?>
<?php if($annonce->refrigerateur_top|| $annonce->refrigerateur_comp || $annonce->refrigerateur_sup){?>
    <?= __("Réfrigerateur") ?> :
<?php if($annonce->refrigerateur_top)echo ' Table Top 140 Litres';?>
<?php if($annonce->refrigerateur_comp)echo ' Table Top et Compartiment Congélateur';?>
<?php if($annonce->refrigerateur_sup)echo ' Supérieur &#224; 140 litres';?>
<?php }?>
<?php if($annonce->micro_onde==1){?>
    <?= __("Micro-ondes") ?> <?php if($annonce->multi_fonction==1){?><?= __("Multi-fonctions") ?> <?php }?>
<?php }?>
<?php if($annonce->hotte==1){?>
    <?= __("Hotte") ?>
<?php }?>
<?php if($annonce->four)echo ' Four';?>
<?php if($annonce->four_mini)echo ' Mini Four';?>
</td>
<td>
<b><?= __('Table de Cuisson') ?> </b><?php
$cuisson=array('0'=>'Non','1'=>'Electrique','2'=>' Gaz','3'=>' Vitrocéramique','4'=>' Induction');
$cuissonfeu=array('1'=>' 2 feux','2'=>' 3 feux','3'=>' 4 feux');
if($annonce->table_cuisson){echo $cuisson[$annonce->table_cuisson]; echo $cuissonfeu[$annonce->table_cuisson_feu];} ?></td></tr>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td><b>Petit Menager :</b>
<?php if($annonce->cafetiere)echo ' Cafetière';?>
<?php if($annonce->grill_pain)echo '  Grille-pain';?>
<?php if($annonce->bouilloire)echo ' Bouilloire';?>
<?php if($annonce->autocuiseur)echo ' Auto-cuiseur';?>
<?php if($annonce->autocuiseur)echo ' Mixeur';?>
<?php if($annonce->mixeur)echo ' Raclette';?>
<?php if($annonce->pierrade)echo ' Pierrade';?>
<?php if($annonce->crepiere)echo ' Crépière';?>
<?php if($annonce->fondue)echo ' Fondue';?>
<?php if($annonce->wok)echo ' Wok';?>
<?php if($annonce->seche_cheveux)echo ' Sèche-cheveux';?>
<?php if($annonce->fer_repasser)echo ' Fer &#224; repasser';?>
<?php if($annonce->table_repasser)echo ' Table &#224; repasser';?>
</td>
<td ><b>Multimédia </b>
<?php if($annonce->tube_cathod)echo ' Tube Cathodique';?>
<?php if($annonce->cable_sat)echo ' Cable Satellite';?>
<?php if($annonce->decodeur_canal)echo ' Décodeur Canal+';?>
<?php if($annonce->ecran_plat)echo ' Ecran Plat LCD-LED';?>
<?php if($annonce->tnt)echo ' TNT';?>
<?php if($annonce->decodeur_sky)echo ' Décodeur Sky';?>
<?php if($annonce->ecran_plasma)echo ' Ecran Plasma';?>
<?php if($annonce->chaine_etranger)echo 'Chaines Etrangères';?>
<?php if($annonce->dvd)echo '  Lecteur DVD';?>
<?php if($annonce->cd)echo ' Lecteur CD';?>
<?php if($annonce->hifi)echo 'Chaine HIFI';?>
</td></tr>




<?php if($annonce->banquette_clic_140 || $annonce->banquette_clic_130  ){?>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><b>Banquette Clic Clac </b></td><td >
<?php if($annonce->banquette_clic_140){
 echo ' 140 X 200 ';
 }
if($annonce->banquette_clic_130){
 echo ' 130 X 200  ';
 }?>
</td></tr><?php }?>
<?php if($annonce->banquette_bz_120 || $annonce->banquette_bz_140  || $annonce->banquette_bz_160 || $annonce->banquette_bz_80){?>
<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td ><b>Banquette BZ </b></td><td>
<?php if($annonce->banquette_bz_120){
 echo ' 120 ';
 }
if($annonce->banquette_bz_140){
 echo ' 140  ';
 }
if($annonce->banquette_bz_160){
 echo ' 160 ';
 }
if($annonce->banquette_bz_80){
 echo ' 80 ';
 }?>
</td></tr>
<?php }?>
<?php if($annonce->oreillers || $annonce->couvertures  || $annonce->couettes || $annonce->protege_matelas){?>

<tr <?php $i++;if($i %2==0){?>class="bleu"<?php }?>><td colspan="2" ><b><?= __("Autres") ?></b>
<?php if($annonce->oreillers){?>
 Oreillers
<?php }?>
<?php if($annonce->couvertures){?>
Couvertures
<?php }?>
<?php if($annonce->couettes){?>
 Couettes
<?php }?>
<?php if($annonce->protege_matelas){?>
    <?= __('Protèges Matelas ou Alèzes') ?>
<?php }?>
</td></tr>
<?php }?>









        </table>
