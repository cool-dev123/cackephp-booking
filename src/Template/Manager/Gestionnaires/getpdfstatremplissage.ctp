<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<?php
	$total_enfant=0;
	$total_adult=0;
	$total_semaine=0;
?>
<div style="width:100%;float:left;">
	<table style="width:1000px;">
	<tr>
		<td >
			<img  src="https://www.alpissime.com/images/logo_top.png"/>
		</td>

	</tr>
	</table>
</div>
<div style="width:100%;float:left;height:30px;">&nbsp;</div>
<div style="width:100%;float:left;">
<table style="width:1000px;font-family:'Open Sans',sans-serif" border="1" cellpadding="0" cellspacing="0">
	<tr>
		<td style="width:80px"><center><strong>ID annonce</strong></center></td>
		<td style="width:100px"><center><strong>Numéro appartement</strong></center></td>
		<td style="width:140px"><center><strong>Propriétaire</strong></center></td>
		<td style="width:100px"><center><strong>Date de début</strong></center></td>
		<td style="width:120px"><center><strong>Date de fin</strong></center></td>
		<td style="width:80px"><center><strong>NB enfants</strong></center></td>
		<td style="width:80px"><center><strong>NB adultes</strong></center></td>
	</tr>
	<?php foreach($a_contrat as $contr):?>

	<tr>
		<td style="width:80px;text-align:center;"><?php echo $contr->id?></td>
		<td style="width:100px;text-align:center;"><?php echo $contr->num_app?></td>
		<td style="width:140px"><?php echo utf8_encode($contr['U']['prenom']." ".$contr['U']['nom_famille']);?></td>
		<td style="width:100px;text-align:center"><?php echo date("d-m-Y", strtotime($contr['R']['dbt_at']))?></td>
		<td style="width:100px;text-align:center">
		<?php
			$total_semaine++;
			echo date("d-m-Y", strtotime($contr['R']['fin_at']))
		?>
		</td>
		<td style="width:120px;text-align:center">
		<?php
			$total_enfant+=$contr['R']['nb_enfants'];
			echo $contr['R']['nb_enfants'];
		?>
		</td>
		<td style="width:120px;text-align:center">
		<?php
			$total_adult+=$contr['R']['nb_adultes'];
			echo $contr['R']['nb_adultes'];
		?>
		</td>

	</tr>

	<?php endforeach;?>
	<tr>
		<td colspan="5" style="text-align:right;padding-right:10px;">Total :</td>

		<td style="width:120px;text-align:center">
		<?php
			echo $total_enfant;
		?>
		</td>
		<td style="width:120px;text-align:center">
		<?php
			echo $total_adult;
		?>
		</td>
	</tr>
</table>
</div>
</body>
</html>
