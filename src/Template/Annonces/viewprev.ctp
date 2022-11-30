<?php define("BASE",""); ?>

<?php echo $this->Html->css("jquery.bxslider.css", array('block' => 'cssTop'))?>
<?php echo $this->Html->css("jquery.mCustomScrollbar.css", array('block' => 'cssTop'))?>
<?php $this->Html->css("/css/update.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/fullcalendar.css", array('block' => 'cssTop')); ?>
<link href='<?php echo $this->Url->build('/',true)?>css/fullcalendar.print.css' rel='stylesheet' media='print' />
<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/fullcalendar.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/locale/fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<!-- fotorama.css & fotorama.js. -->
<link  href="<?php echo $this->Url->build('/')?>css/fotorama.css" rel="stylesheet"> <!-- 3 KB -->
<script src="<?php echo $this->Url->build('/')?>js/fotorama.js"></script> <!-- 16 KB -->
<script type="text/javascript" src="<?php echo $this->Url->build('/')?>js/jquery.sticky.js"></script>

<style>
body{
  overflow-x: visible;
}
</style>
<?php echo $this->Flash->render() ?>
<div id="details_annonce">
  <div class="row">
    <div class="col-md-12">
      <h1 class="numero-location">Annonce N&ordm; <?php echo $annonce->id?> <span class="right"><?php echo $annonce->name?> <?php echo strtoupper($annonce->titre)?></span></h1>
    </div>
  </div>
  <div class="fotorama" data-nav="thumbs">
            <?php  if (!empty($photos)) {
                $i=0; foreach($photos as $photo) {
                    $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;
                    if($i == 0){
                        echo '<img itemprop="image" src="'.$this->Url->build('/').'images_ann/'.$photo["annonce_id"].'/'.$nomImg.'.G.jpg">';
                    }else {
                        echo '<img src="'.$this->Url->build('/').'images_ann/'.$photo["annonce_id"].'/'.$nomImg.'.G.jpg">';
                    }
                    if($i == 0){
                        $contentimg = $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImg.'.G.jpg';
                        $this->Html->meta(null, null, ['property' => 'og:image','content' => $contentimg,'block' => 'meta']);
                    }
                 $i++;
                }
            }

              ?>
          </div>
  <div class="row">
    <div class="col-md-12">
      <h1><?php echo strtoupper($annonce->titre)?></h1>
      <div class="description-details block">
        <p>
          <?php
          echo str_ireplace(array("\r","\n",'\r','\n'),' ', $annonce->description);
          //echo str_ireplace(array("\r\n","<p>","</p>"),array(",","",""),$annonce->description)?>
        </p>
      </div>
    </div>
  </div><!--/row-->


  <div class="row">
      <div class="col-md-12">
        <h1>DESCRIPTIF DU BIEN</h1>
      </div>
  </div>
  <div class="row">
    <?php $vues=array('1'=>__('Vallée'),'2'=>__('Pistes')); ?>
      <div class="col-md-12 block">
        <div style="clear:both;"></div>
        <div class="detail-suite">

          <div class="detailliste1">
            <div class="detail-res col col-md-6 col-sm-6">
              <span class="th"><?= __("Situation géographique") ?> : </span>
              <span class="td"><?php echo ($lieugeo->name)?></span>
            </div>
            <div class="detail-res col-md-6 col-sm-6">
                <span class="th">Niveau/Etage : </span>
                <span class="td"><?php echo $annonce['Annonce']['etage']?></span>
            </div>
            <div style="clear:both;"></div>
            <div class="detail-res col-rep col-md-6 col-sm-6">
              <span class="th"><?= __("Bâtiment") ?> : </span>
              <span class="td"><?php echo $residence->name?></span>
            </div>
            <div class="detail-res col col-not-res col-md-6 col-sm-6">
              <span class="th">Equipement électroménager : </span>
              <span class="td"><?php echo $annonce->texte3=="" ? "" : str_replace(array("<p>","</p>","\n"),array("","",","),($annonce->texte3))?></span>
            </div>
            <div style="clear:both;"></div>
            <div class="detail-res col col-md-6 col-sm-6">
              <span class="th">Nombre de personne maximum : </span>
              <span class="td"><?php echo $annonce->personnes_nb?></span>
            </div>
            <div class="detail-res col-md-6 col-sm-6">
              <span class="th">Equipement multimédia : </span>
              <span class="td"><?php echo str_replace(array("\n","<p>","</p>"),array(",","",""),($annonce->texte4))?></span>
            </div>
            <div style="clear:both;"></div>
            <div class="detail-res col-rep col-md-6 col-sm-6">
              <span class="th">Surface : </span>
              <span class="td"><?php echo $annonce->surface?>m²</span>
            </div>
            <div class="detail-res col col-not-res col-md-6 col-sm-6">
              <span class="th"><?= __("Pistes") ?> : </span>
              <span class="td">
                <?php if($annonce->ski_pied==1){?>
                   Skis aux pieds
                <?php }?>
                <?php if($annonce->moins_50_piste==1){?>
                   Moins de 50 m
                <?php }?>
                <?php if($annonce->cours_tennis==1){?>
                  Courts de Tennis
                <?php }?>
                <?php if($annonce->golf==1){?>
                  Golf
                <?php }?>
                <?php if($annonce->piscine==1){?>
                 Piscine
                <?php }?>
                <?php if($annonce->squash==1){?>
                  Squash
                <?php }?>
                <?php if($annonce->patinoire==1){?>
                  Patinoire
                <?php }?>
              </span>
            </div>
            <div style="clear:both;"></div>
            <div class="detail-res col col-md-6 col-sm-6">
              <span class="th">Vue : </span>
              <span class="td"><?php echo $vues[$annonce->vue]?></span>
            </div>
            <div class="detail-res col-md-6 col-sm-6">
              <span class="th">Stationnement : </span>
              <?php $stationnement=array('0'=>' Garage ','1'=>' Parking ','2'=>' &agrave; Proximit&eacute;');?>
              <span class="td"> <?php echo $stationnement[$annonce->stationnement] ;if($annonce->parking_couvert==1){ echo ' Couvert';}?></span>
            </div>
            <div style="clear:both;"></div>
          </div>
          <div style="clear:both;"></div>
          <?php
          $choix=array('Non','Oui');
          $chauffe=array('0'=>'Non','1'=>'Radiateurs Electriques ','2'=>'Chaudière Gaz','3'=>' Chaudière Fuel');
          $i=0;
          ?>

          <div class="detailliste2" style="display:none">
          <div class="detail-res col-rep col-md-6 col-sm-6">
          <span class="th">Ascenseur : </span>
                            <span class="td"><?php echo $choix[$annonce->ascenseur_yn]?></span>
                            </tr>
                        </table>
                    </div>
                    <div class="detail-res col col-not-res col-md-6 col-sm-6">
                        <span class="th">Acces Aux personnes à mobilité reduite :</span>
                        <span class="td"><?php  if($choix[$annonce->personne_reduite]=='') {echo 'Non';} else {echo $choix[$annonce->personne_reduite];}?></span>
                            </tr>
                        </table>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col col-md-6 col-sm-6">
                        <span class="th"><?= __("Non-fumeur") ?> : </span>
                        <span class="td"><?php  if($choix[$annonce->personne_reduite]=="") {echo 'Non';} else {echo $choix[$annonce->non_fumeur];} ?></span>
                    </div>
                    <div class="detail-res col-md-6 col-sm-6">
                        <span class="th"><?= __("Exposition") ?> : </span>
                        <span class="td"><?php
                        $exposition=array('0'=>'Non précisée','1'=>'Nord','2'=>'Sud','3'=>'Est','4'=>'Ouest','5'=>'Nord-Est','6'=>'Nord-Ouest', '7'=>'Sud-Est', '8'=>'Sud-Ouest');
                        echo $exposition[$annonce->exposition];?></span>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col-rep col-md-6 col-sm-6">
                        <span class="th">Espace Ludique : </span>
                        <span class="td"><?php if($annonce->jeux_video)echo ' Jeux Vidéos';?>
                        <?php if($annonce->jeux_societe)echo ' jeux de société';
                        if(($choix[$annonce->jeux_video]=='') && ($choix[$annonce->jeux_societe]=='')){echo 'Non';}
                        ?></span>
                    </div>
                    <div class="detail-res col col-not-res col-md-6 col-sm-6">
                        <span class="th"><?= __('Extérieurs') ?> : </span>
                        <span class="td"><?php if($annonce->balcon_yn==1) echo 'Balcon ';?><?php if($annonce->terasse_yn==1) echo 'Terasse ';?><?php if($annonce->jardin_yn==1) echo 'Jardin ';?></span>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col col-md-6 col-sm-6">
                        <span class="th"><?= __("Situation") ?> : </span>
                        <span class="td"><?php if($annonce->centre_comm==1){ echo 'Proche d\'un centre Commercial';?>
                        <?php if($annonce->restaurant==1){ echo ', Restaurants';}?>
                        <?php if($annonce->velos==1){ echo ', Location des Velos';}?>
                        <?php if($annonce->loc_ski==1){ echo ', Location de ski';}?>
                        <?php if($annonce->remontee_caisse==1){ echo ', Caisses de remontés mécaniques';}?>
                        <?php if($annonce->transport_public==1){ echo ', Proche des transports publics';}?>
                        <?php }?>
                        <?php if($annonce->espace_sportif==1|| $annonce->bien_etre==1){?>
                        <?php if($annonce->spa==1){ echo ', Spas';}?>
                        <?php if($annonce->hammam==1){ echo ', Hammam';}?>
                        <?php if($annonce->sauna==1){ echo ', Sauna';}?>
                        <?php if($annonce->jacuzzi==1){ echo ', Jacuzzi';}?>
                        <?php if($annonce->massage==1){ echo ', Massage';}?>
                        <?php }?>
                        <?php if($annonce->espace_sportif==1){ echo ', Proche des espaces sportifs été/hiver';?>
                        <?php if($annonce->ski_pied==1){ echo ', Skis aux pieds';}?>
                        <?php if($annonce->moins_50_piste==1){ echo ', Moins de 50 m';}?>
                        <?php if($annonce->cours_tennis==1){ echo ', Cours de Tennis';}?>
                        <?php if($annonce->piscine==1){ echo ', Piscine';}?>
                        <?php if($annonce->squash==1){ echo ', Squash';}?>
                        <?php if($annonce->patinoire==1){ echo ', Patinoire';}?>
                        <?php if($annonce->golf==1){ echo ', Golf';}?>
                        <?php } ?>
                        <?php if($annonce->lieux_anim==1|| $annonce->espace_enfant==1){?>
                        <?php if($annonce->espace_enfant==1){ echo ', Proche des espaces enfants';?>
                        <?php if($annonce->luge==1){ echo ', Luge';}?>
                        <?php if($annonce->club_enfant==1){ echo ', Club Enfant';}?>
                        <?php if($annonce->garderie==1){ echo ', Garderie';}?>
                        <?php if($annonce->ecole_ski==1){ echo ', Ecole de Ski';}?>
                        <?php }?>
                        <?php if($annonce->lieux_anim==1){ echo ', Proche des lieux d\'animation';?>
                        <?php if($annonce->bar==1){ echo ', Bars';}?>
                        <?php if($annonce->pub==1){ echo ', Pubs';}?>
                        <?php if($annonce->Disco==1){ echo ', Discothèques';}?>
                        <?php }}?>
                      </span>

                    </div>
                    <div class="detail-res col-md-6 col-sm-6">
                        <span class="th">Mobilier  :</span>
                        <span class="td"><?php if($annonce->placard)echo ' Placards ';?>
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
                        <?php if($annonce->literie_peign)echo ' Banquette Lits Peignes 2 x 70 x 190 ';?></span>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col-rep col-md-6 col-sm-6">
                        <span class="th">Nombre de salles de bain : </span>
                        <span class="td"><?php if($annonce->sdb_nb==''){echo "0";} else{ echo ($annonce->sdb_nb=="99"?"5 +":$annonce->sdb_nb);} ?></span>
                    </div>
                    <div class="detail-res col col-not-res col-md-6 col-sm-6">
                        <span class="th">Nombre de baignoires :</span>
                        <span class="td"><?php if($annonce->baignoire_nb==''){echo "0";} else{echo $annonce->baignoire_nb;} ?></span>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col col-md-6 col-sm-6">
                        <span class="th">Nombre de douches : </span>
                        <span class="td"><?php if($annonce->douche_nb==''){echo "0";} else{echo $annonce->douche_nb;} ?></span>
                    </div>
                    <div class="detail-res col-md-6 col-sm-6">
                        <span class="th">Nombre de wc :</span>
                        <span class="td"><?php if($annonce->wc_nb==''){echo "0";} else{echo $annonce->wc_nb;} ?><b> Dont </b><?php echo $annonce->wc_sep_nb; ?>&nbsp; wc séparé(s)</span>
                    </div>

                    <div style="clear:both;"></div>
                    <div class="detail-res col-rep col-md-6 col-sm-6">
                        <span class="th">Sanitaires : </span>
                        <span class="td"><?php if($annonce->baignoire_hydro|| $annonce->appart_hammam|| $annonce->appart_sauna||$annonce->robinetterie_melang||$annonce->robinetterie_mitig){?>
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
                         } else {echo "non précisé";}
                        ?></span>
                    </div>
                    <div class="detail-res col col-not-res col-md-6 col-sm-6">
                        <span class="th">Chauffage :</span>
                        <span class="td"><?php
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
                         } }?></span>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col col-md-6 col-sm-6">
                        <span class="th">Services : </span>
                        <span class="td"><?php if($annonce->serv_acc==1){?>
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
                        <?php }?></span>
                    </div>
                    <div class="detail-res col-md-6 col-sm-6">
                        <span class="th">Services Suppl&eacute;mentaires &agrave; la demande :</span>
                        <span class="td"><?php if($annonce->serv_ski==1){?>
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
                        <?php }?></span>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col-rep col-md-6 col-sm-6">
                        <span class="th">Animaux de compagnie autorisés : </span>
                        <span class="td"><?php if($choix[$annonce->ani_co_yn]==''){echo "non précisé";} else{echo $choix[$annonce->ani_co_yn];}?></span>
                    </div>
                    <div class="detail-res col col-not-res col-md-6 col-sm-6">
                        <span class="th">Acces Internet :</span>
                        <span class="td"><?php if($annonce->wifi){echo ' Wifi Gratuit (box dans l\'appartement)';} elseif ($annonce->wifi_payant){echo '  Wifi Payant';}
                        else {echo ' Non';}?></span>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col col-md-6 col-sm-6">
                        <span class="th">Electromenager : </span>
                        <span class="td"><?php if($annonce->lave_linge==1){?>
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
                        <?php if($annonce->four_mini)echo ' Mini Four';?></span>
                    </div>
                    <div class="detail-res col-md-6 col-sm-6">
                        <span class="th"><?= __('Table de Cuisson') ?> :</span>
                        <span class="td"><?php
                        $cuisson=array('0'=>'Non','1'=>'Electrique','2'=>' Gaz','3'=>' Vitrocéramique','4'=>' Induction');
                        $cuissonfeu=array('1'=>' 2 feux','2'=>' 3 feux','3'=>' 4 feux');
                        if($annonce->table_cuisson){echo $cuisson[$annonce->table_cuisson]; echo $cuissonfeu[$annonce->table_cuisson_feu];} ?></span>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col-rep col-md-6 col-sm-6">
                        <span class="th">Petit Menager : </span>
                        <span class="td"><?php if($annonce->cafetiere)echo ' Cafetière';?>
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
                        <?php if($annonce->table_repasser)echo ' Table &#224; repasser';?></span>
                    </div>
                    <div class="detail-res col col-not-res col-md-6 col-sm-6">
                        <span class="th">Multimédia :</span>
                        <span class="td"><?php if($annonce->tube_cathod)echo ' Tube Cathodique';?>
                        <?php if($annonce->cable_sat)echo ' Cable Satellite';?>
                        <?php if($annonce->decodeur_canal)echo ' Décodeur Canal+';?>
                        <?php if($annonce->ecran_plat)echo ' Ecran Plat LCD-LED';?>
                        <?php if($annonce->tnt)echo ' TNT';?>
                        <?php if($annonce->decodeur_sky)echo ' Décodeur Sky';?>
                        <?php if($annonce->ecran_plasma)echo ' Ecran Plasma';?>
                        <?php if($annonce->chaine_etranger)echo 'Chaines Etrangères';?>
                        <?php if($annonce->dvd)echo '  Lecteur DVD';?>
                        <?php if($annonce->cd)echo ' Lecteur CD';?>
                        <?php if($annonce->hifi)echo 'Chaine HIFI';?></span>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="detail-res col col-md-6 col-sm-6">
                        <span class="th">Banquette Clic Clac : </span>
                        <span class="td">
                        <?php if($annonce->banquette_clic_140 || $annonce->banquette_clic_130  ){?>
                        <?php if($annonce->banquette_clic_140){
                         echo ' 140 X 200 ';
                         }
                        if($annonce->banquette_clic_130){
                         echo ' 130 X 200  ';
                         }
                         }else{echo "Non précisé";}?></span>
                    </div>
                    <div class="detail-res col-md-6 col-sm-6">
                        <span class="th">Banquette BZ :</span>
                        <span class="td">
                        <?php if($annonce->banquette_bz_120 || $annonce->banquette_bz_140  || $annonce->banquette_bz_160 || $annonce->banquette_bz_80){?>
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
                         }
                       }else{echo "Non précisé";}?>
                       </span>
                    </div>
                    <div style="clear:both;"></div>
                    <?php if($annonce->oreillers || $annonce->couvertures  || $annonce->couettes || $annonce->protege_matelas){?>
                    <div class="detail-res col-rep col-md-6 col-sm-6">
                        <span class="th">Autres : </span>
                        <span class="td"><?php if($annonce->oreillers){?>
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
                        <?php }?></span>
                    </div>
                    <div class="detail-res col col-not-res col-md-6 col-sm-6">
                        <span class="th"></span>
                        <span class="td"></span>
                    </div>
                    <?php }?>

                </div>
                <div style="clear:both;"></div>
                <div class="detailvoirplus">
                   <center>
                       <table>
                        <tr>
          <td colspan=3 class="tdmiddle"><img src="<?php echo $this->Url->build('/',true)?>images/ico/btn_suite.png"/><?= __("Voir plus") ?><img src="<?php echo $this->Url->build('/',true)?>images/ico/btn_suite.png"/></td>
                        </tr>
                        </table>
                   </center>
                </div>
  </div>
  </div>
</div><!--/row-->

<div class="row">
<div class="col-md-12 block">
  <h1>TARIFS & DISPONIBILITÉS</h1>
      <div id="accordion" role="tablist" aria-multiselectable="true">
        <br><br>
<div class="row">
        <div class="col-md-6 block">
          <div id='calendar2'></div>
        </div>
        <div class="col-md-2 indic block">
          <p><b><?= __("Indication") ?> :</b></p>
          <div class="botmar">
          <div class="flex">
          <div id="carreorange"></div> <span class="indication">&nbsp;&nbsp; <?= __("Option") ?></span>
        </div>
          <div class="flex">
          <div id="carrevert"></div> <span class="indication">&nbsp;&nbsp; Disponible</span>
          </div>
          <div class="flex">
          <div id="carrerouge"></div> <span class="indication">&nbsp;&nbsp; <?= __("Réservé") ?></span>
        </div>
          <div class="flex">
          <div id="carrerose"></div> <span class="indication">&nbsp;&nbsp; <?= __("Promotion") ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-4 block search" id="reservationloc">
        <span class="search_titre">Chercher Disponibilité </span>
        <br>
        <div class='ad_search_content'>
          <div class="displblockre">
        <div class="form-group center disprech">
            <label for="location_du" class="marginrightlabel"><?= __("Date d'arrivée") ?></label>
            <?php echo $this->Form->input('dbt',['label'=>false,'readonly'=>'readonly','type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'location_du', 'class'=>'form-control inline-block location calendrier'])?>
        </div>
        <div class="form-group center disprech">
          <label for="location_au" class="marginrightlabel"><?= __("Date de départ") ?></label>
          <?php echo $this->Form->input('fin',['label'=>false,'readonly'=>'readonly','type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'location_au', 'class'=>'form-control inline-block location calendrier'])?>
        </div>
          </div>
        <br>
        </div>
        <button style="display:none" type="submit" class="submit_reserv btn btn-success hvr-sweep-to-top left" style="margin-top:20px;" name="valider" id="valider">Reserver </button>
        <?php echo $this->Form->end();?>
        <button type="button" class="submit_reserv btn btn-success hvr-sweep-to-top right" onclick="chercherdisponibilite()"><?= __("Chercher") ?></button>
        <div class="clearfix"></div>
    </div>
      </div>
</div>




  </div><!--Accordion -->
</div>


<hr>
  <div class="row detail_ann">
                                <div class="col-md-4">
                                    <div class="form-group">
									<span class="title-newsletter">PARTAGER CETTE ANNONCE SUR</span>
                                    </div>
                                </div>
                                <!-- /.col-md-4 -->
                                <div class="col-md-4">
                                    <div class="form-group">
<span class="share_this">
  <?php
  function formatStr($titre)
  {
     $str = strtr($titre,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
    $str = str_replace("é","e",$titre);
    $str = str_replace("è","e",$str);
    $str = str_replace("ê","e",$str);
    $str = str_replace("à","a",$str);
    $str = str_replace("â","a",$str);
    $str = str_replace("ä","a",$str);
    $str = str_replace("î","i",$str);
    $str = str_replace("ï","i",$str);
    $str = str_replace("ô","o",$str);
    $str = str_replace("ö","o",$str);
    $str = str_replace("ù","u",$str);
    $str = str_replace("û","u",$str);
    $str = str_replace("ü","u",$str);
    $str = str_replace(",","-",$str);
    $str = str_replace("'","-",$str);
    $str = str_replace(" ","-",$str);
    $str = str_replace("(","",$str);
    $str = str_replace(")","",$str);
    $str = str_replace("É","e",$str);
    $str = str_replace("%","pourcent",$str);
    $str = str_replace("œ","oe",$str);
    $str = str_replace("Œ","oe",$str);
    $str = str_replace("€","euros",$str);
    $str = str_replace("/","-",$str);
    $str = str_replace("+","-",$str);
    $str = str_replace("ç","c",$str);
    $str = str_replace("*","",$str);
    $str = str_replace("?","",$str);
    $str = str_replace("!","",$str);
    $str = str_replace("°","",$str);
    $str = str_replace("<","",$str);
    $str = str_replace(">","",$str);
    $str = str_replace("----","-",$str);
    $str = str_replace("---","-",$str);
    $str = str_replace("--","-",$str);
    $str = str_replace("²","",$str);
    $str = str_replace(":","",$str);
    return htmlentities($str);
  }

      ?>
        <?php $adr = $this->Url->build('/',true)."detail/".$annonce->id."-".strtolower(trim(formatStr($annonce->titre))).".html"; ?>

        <span><a href="https://www.facebook.com/dialog/feed?app_id=145634995501895&link=<?php echo $adr ?>" target="_blank"><img src="<?php echo $this->Url->build('/',true); ?>images/ico/fb.png" alt=""></a></span>

        <span><a href="https://twitter.com/share?url=<?php echo urlencode($adr) ?>" target="_blank"><img src="<?php echo $this->Url->build('/',true); ?>images/ico/share_twitter.png" alt=""></a></span>
        <!-- <span><a href="https://plus.google.com/share?url=<?php //echo urlencode($adr) ?>" target="_blank"><img src="<?php //echo $this->Url->build('/',true); ?>images/ico/share_google_plus.png" alt=""></a></span> -->
        <span><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($adr) ?>" target="_blank"><img src="<?php echo $this->Url->build('/',true); ?>images/ico/share_linkedin.png" alt=""></a></span>
        <span><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($adr) ?>" target="_blank"><img src="<?php echo $this->Url->build('/',true); ?>images/ico/share_pin.png" alt=""></a></span>
      </span>                                </div>

	  </div>
                                <!-- /.col-md-2 -->
                                <div class="col-md-4">
                                    <div class="form-group">
    <button class="btn btn-success hvr-sweep-to-top btn_cont_prop" data-toggle="modal" data-target="#popup_contact"><i class="fa fa-envelope fa-lg"></i> <?= __("Contacter le propriétaire") ?></button>
                                </div>
                                <!-- /.col-md-2 -->


					</div>
  </div>


</div><!--row -->


</div><!--/details_annonce-->
<hr>
<!--popup reservation-->
<div class="modal fade" id="popup_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

  <?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
  $(document).ready(function(){
    $('#calendar2').fullCalendar({
      locale: '<?php echo $language_header_name; ?>',
          //height: 400,
          header: {
            left: 'prev',
            center: 'title',
            right: 'next'
          },
         editable: false,
         eventLimit: false, // allow "more" link when too many events
         firstDay: 1,
         events: {
           url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispoLoc/<?php echo $annonce->id ?>',
           type: 'POST', // Send post data
           error: function() {
             alert('There was an error while fetching events.');
           }
         },
         eventRender: function (event, element) {

           if (event.promotion == 1) {
             /*element.css({
               'display': 'none'
             });*/
             var start = moment(event.start);
             var end = moment(event.end);
             while( start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ){
               var dataToFind = start.format('YYYY-MM-DD');
               $("td[data-date='"+dataToFind+"'].fc-widget-content").addClass('promotion');
               start.add(1, 'd');
             }
             element.addClass('promosbefore');
           }
           if(event.statut == 50){
             element.addClass('optionafter');
           }

           if(event.statut == 90 || event.statut == 100){
             element.addClass('reserverafter');
           }
         },

         eventClick:  function(event, jsEvent, view) {
           var cond;
           /*if(event.conditionnbr == 1){
             cond = " <i><b> (<?= __('semaine commence le samedi'); ?>)</b></i>" ;
           }else if (event.conditionnbr == 2){
             cond = " <i><b> (<?= __('semaine commence le dimanche'); ?>)</b></i>" ;
           }else{*/
             cond = "";
           // }
           if(cond != ''){
             $('#ModalEdit2 #labelprix').html("Prix période");
           }else{
             $('#ModalEdit2 #labelprix').html("Prix à partir de");
           }
           if(event.statut == 50) $('#ModalEdit2 #statut').html("Option");
           else if(event.statut == 0) $('#ModalEdit2 #statut').html("Libre");
           else if(event.statut == 90 || event.statut == 100) $('#ModalEdit2 #statut').html("Réservé");
           $('#ModalEdit2 #nbr_jour').html(event.nbr_jour + cond);
           $('#ModalEdit2 #prix_jour').html(event.prix_jour + "€");
           if(event.promotion == 0 ){
             document.getElementById('divpromojour').style.display = 'none';
             document.getElementById("prix_jour").style.textDecoration = "none";
             document.getElementById("prix_jour").style.color = "black";
             $('#ModalEdit2 #prix_apartir').html((event.nbr_jour * event.prix_jour)  + "€");
           }else{
             document.getElementById('divpromojour').style.display = 'block';
             $('#ModalEdit2 #promo_jour').html(event.promo_jour + "€");
             document.getElementById("prix_jour").style.textDecoration = "line-through";
             document.getElementById("prix_jour").style.color = "red";
             $('#ModalEdit2 #prix_apartir').html((event.nbr_jour * event.promo_jour) + "€");
           }
           $('#ModalEdit2 #date_depart').html(event.end.format('DD-MM-YYYY'));

           $('#ModalEdit2').modal('show');
         },
         eventMouseover: function (data, event, view) {
           var cond;
           /*if(data.conditionnbr == 1){
             cond = "<strong> (<?= __('semaine commence le samedi'); ?>)</strong>" ;
           }else if (data.conditionnbr == 2){
             cond = "<strong> (<?= __('semaine commence le dimanche'); ?>)</strong>" ;
           }else{*/
             cond = "";
           // }
           var prixminpop;
           var msgp;
           if(cond != ''){
             msgp = "Prix période";
           }else{
             msgp = "Prix à partir de";
           }
           if(data.promotion == 0){
             if(data.nbr_jour > 1){
               prixminpop = data.nbr_jour * data.prix_jour;
               tooltip = '<div class="tooltiptopicevent">' + '<?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond + '</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="nouveauprix">' + data.prix_jour + '€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span><br><strong>'+ msgp +' : </strong><span class="nouveauprix">' + prixminpop + '€</span></div>';
             }else{
               tooltip = '<div class="tooltiptopicevent">' + '<?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond + '</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="nouveauprix">' + data.prix_jour + '€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
             }
            }else{
              if(data.nbr_jour > 1){
                prixminpop = data.nbr_jour * data.promo_jour;
                tooltip = '<div class="tooltiptopicevent">' + '<?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond +'</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="ancienprix">' + data.prix_jour + '€</span></br>' + '<?= __("Prix promotion/nuitée") ?> ' + ': <span class="nouveauprix">' + data.promo_jour +'€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span><br><strong>'+ msgp +' : </strong><span class="nouveauprix">' + prixminpop + '€</span></div>';
              }else{
                tooltip = '<div class="tooltiptopicevent">' + '<?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond +'</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="ancienprix">' + data.prix_jour + '€</span></br>' + '<?= __("Prix promotion/nuitée") ?> ' + ': <span class="nouveauprix">' + data.promo_jour +'€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
              }
           }

            $("body").append(tooltip);
            $(this).mouseover(function (e) {
                //$(this).css('z-index', 10000);
                $('.tooltiptopicevent').fadeIn('500');
                $('.tooltiptopicevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
                $('.tooltiptopicevent').css('top', e.pageY + 10);
                $('.tooltiptopicevent').css('left', e.pageX + 20);
            });


        },
        eventMouseout: function (data, event, view) {
            //$(this).css('z-index', 8);

            $('.tooltiptopicevent').remove();

        },
    });

    $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);
    $('#location_du').datepicker({
        language: 'fr-FR',
        minDate: 0,
        dateFormat: "dd-mm-yy"
    });
    $('#location_du').on( "change", function() {
          //$('#location_du').datepicker( "option", "minDate", $.datepicker.parseDate( "dd-mm-yy", this.value ) );
          var d = moment(this.value,"DD-MM-YYYY").add(1, 'd');
          $('#location_au').datepicker( "option", "minDate", d.format('DD-MM-YYYY') );
        });
    $('#location_au').datepicker({
        language: 'fr-FR',
        minDate: 0,
        dateFormat: "dd-mm-yy"
    });

   });

  $(document).ready(function(){
	  document.getElementById("nameLabel").style.display = 'none';
	  document.getElementById("companyLabel").style.display = 'none';
	  document.getElementById("telephoneLabel").style.display = 'none';
	  document.getElementById("telephoneLabelerr").style.display = 'none';
	  document.getElementById("emailLabel").style.display = 'none';
	  document.getElementById("emailLabelerr").style.display = 'none';
	  document.getElementById("demandeLabel").style.display = 'none';
	  document.getElementById("messageLabel").style.display = 'none';


   });
   function chercherdisponibilite(){
     $.ajax({
       type: "POST",
       dataType : 'json',
       url: "<?php echo $this->Url->build('/',true)?>dispos/chercherdisponibilite/<?php echo $annonce->id?>",
       data: {debut:$('#location_du').val(), fin:$('#location_au').val()},
       success:function(xml){
         document.getElementById("resultatdispo").style.display = 'block';
         if(xml.nbrperiode == 1){
           var deb = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
           var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
           var fn = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
           var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

            var elim = '';
            var elimCon = '';
              $.each(xml.nbrDiff[1], function(index, value) {
                if(value.toString().indexOf("_") != -1){
                  var tab = value.split("_");
                  var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var Diff = fnDiff.diff(dbtDiff, 'days');
                  var d = tab[0];
                  if(Diff < parseInt(d)){
                    if(dbtDiff.format('YYYY-MM-DD') == deb){
                      deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                    }else{
                      fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                    }
                    elim = d;
                  }
                  /*if(Diff == 7){
                    if(xml.details['condition'][1] == 1 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                        elimCon = "ui";
                    }else if (xml.details['condition'][1] == 2 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                      elimCon = "ui";
                    }
                  }*/

                  }else{
                    var dbtDiff = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var fnDiff = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var Diff = fnDiff.diff(dbtDiff, 'days');
                    var d = value;
                    if(Diff < parseInt(d)){
                      if(dbtDiff.format('YYYY-MM-DD') == deb){
                        deb = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                      }else{
                        fn = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                      }
                      elim = d;
                    }
                    /*if(Diff == 7){
                      if(xml.details['condition'][1] == 1 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                          elimCon = "ui";
                      }else if (xml.details['condition'][1] == 2 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                        elimCon = "ui";
                      }
                    }*/

                  }
              });



              if(deb < fn){
                xml.disponi[1] = 'Période : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
              }else{
                xml.disponi[1] = '';
              }

              if( elimCon == ''){
                if((deb == debCal) && (fn == fnCal)){

                  document.getElementById("periodedispo").style.marginBottom = '0';

                  if(deb > fn){
                    $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE</span>");
                    $('#periodedispo').html('');
                  }else{
                    $('#resultatdispo').html("<span style='color: #106710;font-size: 15px;font-weight: 600;'>PERIODE DISPONIBLE</span>");
                    $('#periodedispo').html('');
                    if(xml.disponi[1] != ''){
                    $('#periodedispo').append("<div style='visibility: hidden;' class='form-group radios'><label class='radio-inline'><input type='radio' onclick='afficherbouton(this.id);' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"' checked><span></span></label></div>");
                  }
                  }

                 }else{
                   if(elim != ''){

                     $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE (Minimum séjour: "+elim+" nuitées)</span><br>");
                     $('#periodedispo').html('');
                   }else{

                     $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span><br>");
                     $('#periodedispo').html('');
                   }

                  $.each(xml.disponi, function(index, value) {
                    if(xml.disponi[index] != ''){
                    $('#periodedispo').append("<div class='form-group radios'><label class='radio-inline'><input type='radio' onclick='afficherbouton(this.id);' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"'><span> "+value+"</span></label></div>");
                  }
                  });
                }
              }else{
                $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span>");
                $('#periodedispo').html('');
              }

         }else{
           //var i = 1;
           for (i = 1; i <= xml.nbrperiode; i++) {
             var elimCon = '';
               $.each(xml.nbrDiff[i], function(index, value) {

                 var deb = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                 var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
                 var fn = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                 var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

                  var elim = '';var elimCon = '';
                    $.each(xml.nbrDiff[i], function(index, value) {
                      if(value.toString().indexOf("_") != -1){
                        var tab = value.split("_");
                        var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var Diff = fnDiff.diff(dbtDiff, 'days');
                        var d = tab[0];
                        if(Diff < parseInt(d)){
                          if(dbtDiff.format('YYYY-MM-DD') == deb){
                            deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                          }else{
                            fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                          }
                          elim = "ui";
                        }
                        /*if(Diff == 7){
                          if(xml.details['condition'][i] == 1 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                              elimCon = "ui";
                          }else if (xml.details['condition'][i] == 2 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                            elimCon = "ui";
                          }
                        }*/

                        }else{
                          var dbtDiff = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                          var fnDiff = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                          var Diff = fnDiff.diff(dbtDiff, 'days');
                          var d = value;
                          if(Diff < parseInt(d)){
                            if(dbtDiff.format('YYYY-MM-DD') == deb){
                              deb = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                            }else{
                              fn = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                            }
                            elim = "ui";
                          }
                          /*if(Diff == 7){
                            if(xml.details['condition'][i] == 1 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                                elimCon = "ui";
                            }else if (xml.details['condition'][i] == 2 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                              elimCon = "ui";
                            }
                          }*/

                        }

                    });
                    if(deb < fn){
                      xml.disponi[i] = 'Période  : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
                    }else{
                      xml.disponi[i] = '';
                    }

               });

           }

           if( elimCon == ''){

             $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span><br>");
             $('#periodedispo').html('');
             $.each(xml.disponi, function(index, value) {
               var deb = moment(xml.details['debut'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
               var fn = moment(xml.details['fin'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
               if(xml.disponi[index] != ''){
                 $('#periodedispo').append("<div class='form-group radios'><label class='radio-inline'><input type='radio' onclick='afficherbouton(this.id);' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"'><span> "+value+"</span></label></div>");
               }
             });
           }else{
             $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span>");
             //console.log(elimCon);
             $('#periodedispo').html('');
           }
         }
        }
       });
     //alert($('#location_du').val()+" "+$('#location_au').val());
   }
  function validateForm(){

    return false;
    /*  var nameReg = /^[A-Za-z]+$/;
      var numberReg =  /^[0-9]+$/;
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	  var msg="";

	  if($('#name').val() == ""){
		  document.getElementById("nameLabel").style.display = 'block';
		  msg+="nom";
	   }else{
		   document.getElementById("nameLabel").style.display = 'none';
	   }
	if($('#prenom').val() == ""){
		  document.getElementById("companyLabel").style.display = 'block';
		  msg+="prenom";
	   }else{
		  document.getElementById("companyLabel").style.display = 'none';
	   }
	if($('#tel').val() == ""){
		  document.getElementById("telephoneLabel").style.display = 'block';
		  msg+="tel";
	   }else if(!numberReg.test($('#tel').val())){
		   document.getElementById("telephoneLabel").style.display = 'none';
            document.getElementById("telephoneLabelerr").style.display = 'block';
  			msg+="tel";
          }else{
			  document.getElementById("telephoneLabel").style.display = 'none';
			  document.getElementById("telephoneLabelerr").style.display = 'none';
		  }
	if($('#email').val() == ""){
		  document.getElementById("emailLabel").style.display = 'block';
		  msg+="email";
	   }else if(!emailReg.test($('#email').val())){
		   document.getElementById("emailLabel").style.display = 'none';
			document.getElementById("emailLabelerr").style.display = 'block';
  			msg+="mail";
          }else{
			 document.getElementById("emailLabel").style.display = 'none';
			 document.getElementById("emailLabelerr").style.display = 'none';
		  }
	if($('#demande').val() == 0){
		  document.getElementById("demandeLabel").style.display = 'block';
		  msg+="demande";
	   }else{
		  document.getElementById("demandeLabel").style.display = 'none';
	   }
	if($('#elmt').val() == ""){
		  document.getElementById("messageLabel").style.display = 'block';
		  msg+="message";
	   }else{
		  document.getElementById("messageLabel").style.display = 'none';
	   }

	if(msg=="")return true;
  		else return false;*/

  }
  <?php $this->Html->scriptEnd(); ?>
  <?php echo $this->Session->flash()?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h1 class="modal-title"><span class="orange">MERCI POUR VOTRE INTERET, LAISSEZ NOUS UN MESSAGE</span>
                </h1>
            </div>
            <?php echo $this->Form->create(null,['url'=>['action'=>'prop'],'class'=>'form-horizontal','onsubmit'=>'return validateForm()']); ?>
            <?php echo $this->Form->hidden('id', ['value' =>$annonce->id]); ?>
                <div class="modal-body">
                    <div class="col-md-12 block">
                        <div class="form-group">
                            <label for="" class="col-sm-4">Nom <sup class="orange">*</sup></label>

                            <div class="col-sm-6">
                                <?php echo $this->Form->input('name',['label'=>false,'templates' => ['inputContainer' => "{{content}}"], 'class' => 'form-control', 'id'=>'name']); ?>
                                <label id='nameLabel'><span class="error_formul"> <?= __("S'il vous plaît, entrez votre Nom") ?></span></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4"><?= __("Prénom") ?> <sup class="orange">*</sup></label>

                            <div class="col-sm-6">
                                <?php echo $this->Form->input('prenom', ['label'=>false,'templates' => ['inputContainer' => "{{content}}"], 'class' => 'form-control']); ?>
                                <label id='companyLabel'><span class="error_formul"> S'il vous plaît, entrez votre Prenom</span></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4">Téléphone <sup class="orange">*</sup></label>

                            <div class="col-sm-6">
                                <?php echo $this->Form->input('tel', ['label'=>false,'templates' => ['inputContainer' => "{{content}}"], 'class' => 'form-control']); ?>
                                <label id='telephoneLabel'><span class="error_formul"> S'il vous plaît, entrez votre Téléphone</span></label>
                                <label id='telephoneLabelerr'><span class="error_formul">Le téléphone doit contenir que des chiffres</span></label>

								</div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4">E-mail <sup class="orange">*</sup></label>

                            <div class="col-sm-6">
                                <?php echo $this->Form->input('email', ['label'=>false,'templates' => ['inputContainer' => "{{content}}"], 'class' => 'form-control']); ?>
                                <label id='emailLabel'><span class="error_formul"> S'il vous plaît, entrez votre Email</span></label>
                                <label id='emailLabelerr'><span class="error_formul"> S'il vous plaît, vérifier la saisie de l'Email</span></label>

								</div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4">Demande <sup class="orange">*</sup></label>

                            <div class="col-sm-6">
                                <?php echo $this->Form->input('demande', ['label'=>false,'class' => 'form-control','templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>["----","Location"=>"Location","Appartement près de votre"=>"Appartement près de votre","Information diverses"=>"Information diverses"]]); ?>
                                <label id='demandeLabel'><span class="error_formul"> S'il vous plaît, précisez votre demande</span></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4">Votre commentaire <sup class="orange">*</sup></label>

                            <div class="col-sm-8">
                                <?php echo $this->Form->input('message', ['label'=>false,'templates' => ['inputContainer' => "{{content}}"], 'class' => 'form-control', 'rows' => 3,'id'=>'elmt']); ?>
                                <label id='messageLabel'><span class="error_formul"> S'il vous plaît, entrez votre commentaire</span></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4"></label>

                            <div class="col-sm-8">
                                <!-- Captcha HTML Code
                                <img src="../images/captcha/captcha.jpg" class="captcha-inscription">-->
                                <?= $this->Recaptcha->display() ?>
                                <!--  Copy and Paste above html in any form and include CSS, get_captcha.php files to show the captcha  -->
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <!--<button type="button" class="btn btn-success hvr-sweep-to-top"><?= __("Envoyer") ?></button>-->
                        <button type="submit" class="btn btn-success hvr-sweep-to-top " value="Envoyer"><?= __("ENVOYER") ?></button>
                    </div>
                </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="ModalEdit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">

  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel"><?= __("Détails période") ?></h4>
  </div>
  <div class="modal-body">
    <label for="title" class="col-sm-6 control-label"><?= __("Statut ") ?> : </label>
    <div class="col-sm-6">
      <p id="statut"></p>
    </div>
    <label for="end" class="col-sm-6 control-label"><?= __("Durée minimum de séjour") ?></label>
    <div class="col-sm-6">
      <p id="nbr_jour"></p>
    </div>
    <label for="end" class="col-sm-6 control-label"><?= __("Prix /nuitée") ?> </label>
    <div class="col-sm-6">
      <p id="prix_jour"></p>
    </div>
    <div id="divpromojour">
    <label for="end" class="col-sm-6 control-label"><?= __("Prix promotion /nuitée") ?> </label>
    <div class="col-sm-6">
      <p id="promo_jour"></p>
    </div>
    </div>
    <label for="end" class="col-sm-6 control-label"><?= __("Date de départ") ?></label>
    <div class="col-sm-6">
      <p id="date_depart"></p>
    </div>
    <label for="end" class="col-sm-6 control-label" id="labelprix"></label>
    <div class="col-sm-6">
      <p id="prix_apartir"></p>
    </div>
  </div>
  <br><br>
  <div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Fermer") ?></button>
  </div>
</div>
</div>
</div>

<?php $this->Html->script("/js/jquery.bxslider.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/jquery.nicescroll.plus.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>

$(document).ready(function () {
    $.ajax({
      type: "POST",
      url: "<?php echo $this->Url->build('/',true)?>annonces/getimage/<?php echo $annonce->id?>",
      data: {id_a:1},
      success:function(xml){
        $('#image_grand').html(xml);
        }
  });

});
    $(".tdmiddle").click(function () {
        if ($(".detailliste2").css('display') == 'none') {
            $(this).html('cacher');
            $(".tdmiddle").html('<img src="<?php echo $this->Url->build('/',true); ?>images/ico/btn_cacher.png"/>cacher<img src="<?php echo $this->Url->build('/',true); ?>images/ico/btn_cacher.png"/>');
            //$(".tdright").html('<img src="<?php echo $this->Url->build('/',true); ?>images/ico/btn_cacher.png"/>');
        } else {
            // $(this).html('voir plus');
            $(".tdmiddle").html('<img src="<?php echo $this->Url->build('/',true); ?>images/ico/btn_suite.png"/><?= __("Voir plus") ?><img src="<?php echo $this->Url->build('/',true); ?>images/ico/btn_suite.png"/>');
            //  $(".tdright").html('<img src="<?php echo $this->Url->build('/',true); ?>images/ico/btn_suite.png"/>');
        }
        $(".detailliste2").toggle("slow");
    });
<?php $this->Html->scriptEnd(); ?>
