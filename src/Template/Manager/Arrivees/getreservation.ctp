<?php if(!empty($annonce)):?>
<?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>
<?php foreach($annonce as $ann):?>
<div style="background:url('<?php echo $this->Url->build('/',true)?>images/bien.png') no-repeat left top ;margin-left:20px;">
<h2 style="color:#fff;font-size:12px;padding-top:3px;padding-left:10px">Appartement <?php echo $ann['num_app']?></h2>


        <table id="tarifs" style="width:521px;margin-left:2px;border-spacing:1px;margin:13px 0;font-size:10px;background-color: #E0E0E0"><tr><td class="black" >P&eacute;riode</td><td class="black">Prix en &euro;</td><td class="black">Disponibilit&eacute;</td><td>&nbsp;</td></tr>

            <?php $o = ""; foreach($ann['Dispo'] as $ligne){

				$date_debut=$ligne['dbt_at']->i18nFormat('dd-MM-yyyy');
				$prix=$ligne['prix'];
				if($ligne['statut']==0||$ligne['statut']==50){
               {?> <tr><?php
                    $my = $ligne['dbt_at']->month;
                    if($my!=$o)
                    {
                        $o=$my;
                        echo "<td colspan='3' style='color:#FF9900'><h4>Location ".html_entity_decode($mois_fr[$o])." ".$ligne['dbt_at']->year."</h4></td></tr><tr>";
                    }
            ?>
                <td width="60%" class="bgk_tarifs_gray" width="450px">du <?php echo $ligne['dbt_at']->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::NONE]);?> au <?php echo $ligne['fin_at']->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::NONE]);?></td>
                <td width="15%" class="bgk_tarifs_euro"><span <?php if($ligne['promo_px']>0){ ?> style="text-decoration: line-through; font-weight: bold;" <?php } ?>><?php echo $prix ?> &euro;</span>
					<?php if($ligne['promo_px']>0): ?>
                    <span style="font-weight: bold; color:#cc0000"><?php echo $ligne['promo_px']?></span>
					<?php endif; ?>
                </td>
            <?php  switch ($ligne['statut'])
                    {
                        case 0 : $statut = 'libre';break;
                        case 50: $statut = 'option';break;
                        case 90: $statut = 'reserve';break;
                    }
                ?>
                <td width="20%" id="<?php echo $statut?>" class="<?php echo $statut?>"><?php echo $l_disposstatuts[$ligne['statut']];?></td>
                <td width='5%'>
				<?php if($ligne['statut']==0):?>
				<input id='dispo_<?php echo $ligne['id']?>' data-dbt="<?php echo $date_debut ?>" data-fin="<?php echo $ligne['fin_at']->i18nFormat('dd-MM-yyyy')?>" value='<?php echo $ann['id']?>' type='radio' name='Dispo'/>
				<?php else:?>
				&nbsp;
				<?php endif;?>
				</td>
            </tr>
        <?php }}}?> </table>
   </div>
   <?php endforeach;?>
   <input type="button" id='recherche_annuler' value="Fermer" class="btn-search" style="float:right;width:17%;margin-right:9px">
   <input type="button" id='btn_dispo_valider' value="Valider" class="btn-search" style="float:right;width:17%;margin-right:9px">
   <?php else:?>
   <br/>
   <br/>
   <p style="font-size:14px;color:#FF9900"><?php echo html_entity_decode("Vous n'vous êtes pas en contrat ou la période de renouvellement de votre contrat est dépassée.")?> </p>
   <p style="font-size:14px;color:#FF9900"><?php echo html_entity_decode("Merci de vous mettre en rapport avec un gestionnaire partenaire de alpissime pour bénéficier des avantages du club alpissime")?> </p>
   <?php endif;?>
