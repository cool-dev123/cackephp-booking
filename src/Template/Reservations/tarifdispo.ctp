<style>
    
    .header-home {
    display: none;
}
</style>
<?php if(!empty($annonce)):?>
<?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>
<?php foreach($annonce as $ann):?>
<div style="background:url('<?php echo $this->Url->build('/',true)?>images/bien.png') no-repeat left top ;margin-left:20px;">
<h2 style="color:#fff;font-size:12px;padding-top:10px;padding-left:10px">Appartement <?php echo $ann['num_app']?></h2>


      <div class="table-responsive">
            <table id="tarifs" class="table table-condensed">
                <thead><tr>
                    <th width='50%'>P&eacute;riode</th>
                    <th width='15%'>Prix (€)</th>
                    <th width='15%'>Disponibilit&eacute;</th>
                    <th width='5%'>&nbsp;</th>
                </tr></thead>

                <?php $o = ""; foreach($ann['Dispo'] as $ligne){
					
    				$date_debut=$ligne['dbt_at']->i18nFormat('dd-MM-yyyy');
    				$prix=$ligne['prix'];
    				if($ligne['statut']==0||$ligne['statut']==50){
                   {?> <tr><?php
                        $my = $ligne['dbt_at']->month;
                        if($my!=$o)
                        {
                            $o=$my;
                            echo "<td colspan='3' tyle='color:#FF9900'><h4>Location ".html_entity_decode($mois_fr[$o])." ".$ligne['dbt_at']->year."</h4></td></tr><tr>";
                        }
                ?>
                    <td data-title="Période">du <?php echo $ligne['dbt_at']->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::NONE]);?> au <?php echo $ligne['fin_at']->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::NONE]);?></td>
                    <td data-title="Prix (€)"><span <?php if($ligne['promo_px']>0){ ?> style="text-decoration: line-through; font-weight: bold;" <?php } ?>><?php echo $prix ?> &euro;</span>
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
                    <td data-title="Disponibilité" id="<?php echo $statut?>" class="<?php echo $statut?>"><?php echo $l_disposstatuts[$ligne['statut']];?></td>
                    <td >
    				<?php if($ligne['statut']==0):?>
    				<input id='dispo_<?php echo $ligne['id']?>' data-dbt="<?php echo $date_debut ?>" data-fin="<?php echo $ligne['fin_at']->i18nFormat('dd-MM-yyyy')?>" value='<?php echo $ann['id']?>' type='radio' name='Dispo'/>
    				<?php else:?>
    				&nbsp;
    				<?php endif;?>
    				</td>
                </tr>
                <?php }}} ?>
            </table>
        </div>



   </div>
   <?php endforeach;?>
   <br><br><a id='btn_dispo_valider' class="btn btn-success hvr-sweep-to-top right marg_rig"><?= __("Valider") ?></a>
   <?php else:?>
   <br/>
   <br/>
   <p style="font-size:14px;color:#FF9900"><?php echo html_entity_decode("Vous n'êtes pas en contrat ou la période de renouvellement de votre contrat est dépassée.")?> </p>
   <p style="font-size:14px;color:#FF9900"><?php echo html_entity_decode("Merci de vous mettre en rapport avec un gestionnaire partenaire de alpissime pour bénéficier des avantages du club alpissime")?> </p>
   <?php endif;?>
