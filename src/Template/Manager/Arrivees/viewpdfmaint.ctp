<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<div style="width:100%">
<div style="width:70%;float:left">
<img style="padding:5px" src="https://www.alpissime.com/images/logo_landing_page.png"/>
</div>
<div style="width:30%;float:left;text-align:right">
<table  cellpadding="0" cellspacing="0" style="width:208px">
<tr>
<td style="background-color:#0074cc;color:#fff;font-weight:bold;font-family:arial;font-size:14px;padding:10px;">
<center>CONTRAT DE GESTION TECHNIQUE</center>
</td>
</tr>
<tr >
<td style="border:1px solid #000;font-weight:bold;font-family:arial;font-size:14px;padding:20px;">
<center>
DATE : <?=$vdate;?>
</center>
</td>
</tr>
</table>
</div>
</div>
<div style="width:100%;height:50px;float:left">&nbsp;</div>
<div style="width:100%;float:left;font-weight:bold;font-family:arial;font-size:16px;">
Le présent contrat est conclu entre :<br><br>
<table style="width:100%;font-weight:bold;font-family:arial;font-size:16px;" >
		<tr>
			<td width=70% valign=top >
			Gestionnaire Alpissime :<br>
			<?=$gestionnaire->denominationsociale?><br>
			<?=$gestionnaire->adresse?><br>
			<?=$gestionnaire->telephone?><br>
			<?=$gestionnaire->email?>
			</td>
			<td width=30% valign=top>
			<?=$contrat["U"]["prenom"]?> <?=$contrat["U"]["nom_famille"]?><br>
			<?=$contrat["U"]["adresse"]?><br>
			<?=$contrat["U"]["code_postal"]?> <?=$contrat["U"]["ville"]?><br>
			FRANCE<br>
			</td>

		</tr>
	</table>
	<br><br>
	Concernant l'hébergement : <br>
	<?=$contrat->num_app?> <?=$contrat["R"]["name"]?>
	<br><br>
</div>
<div style="width:100%;float:left;font-family:Arial;font-size:12px;">
		<?php echo $previewtext; ?>
</div>
<div style="width:100%;float:left">
<?php if(!empty($comment)):?>
<br><br>
<h3 style='text-decoration:underline'>Conditions particulières</h3>
<p style="padding:10px"><?=$comment?></p>
<br><br>
<?php endif;?>

<p><?=$gestionnaire->adresse?>, le <?=date("d/m/Y");?></p>
</div>
<div style="width:100%;height:50px;float:left">&nbsp;</div>
<div style="width:100%;float:left">
	<div style="width:70%;float:left">
		Le propriétaire<br/>
		<?=$contrat["U"]["prenom"]?> <?=$contrat["U"]["nom_famille"]?> "Lu et approuvé"<br/>
		Signature
	</div>
	<div style="width:30%;float:right">
		Le gestionnaire<br/>
		<?=$gestionnaire->denominationsociale?> <br/>
		Signature
	</div>
</div>
<div style="width:100%;height:100px;float:left">&nbsp;</div>
<?php if (preg_match("/amsa/i", $gestionnaire->name)):?>
<div style="width:100%;float:left;text-align:center">
<p style="line-height:5px;">AMSA - BP 12 - 73706 Arc 1800 cedex -</p>
<p style="line-height:5px;">services de conciergerie - Services de dépannages</p>
<p style="line-height:5px;">Travaux de rénovation - Magasin de Mobilier, Electromenager, Décoration, Rideaux</p>
<p style="line-height:5px;">Telephone 04 79 07 49 07</p>
<p style="line-height:5px;">Sarl AMSA au capital social de 7622,45 € - N° de TVA FR21405097320</p>
<p style="line-height:5px;">RCS Chambéry 405 097 320</p>
</div>
<div style="width:100%;float:left;text-align:center;color:#0068b1">
<p style="line-height:5px;">depuis le 20-08-2013
amsa est agent de voyage</p>
<p style="line-height:5px;">immatriculation Atout France n° IM073130016</p>
<p style="line-height:5px;">avec une garantie financière de 100 000 € du Crédit Agricole des Savoie</p>
</div>
<?php else:?>
<div style="width:100%;float:left;text-align:center">
<p style="line-height:5px;"><?=$gestionnaire->name?> - <?=$gestionnaire->adresse?> - <?=$gestionnaire->code_postal?> <?=$gestionnaire->ville?></p>
<p style="line-height:5px;">Telephone <?=$gestionnaire->telephone?></p>
<p style="line-height:5px;">Mail <?=$gestionnaire->email?></p>
<p style="line-height:5px;"><?=$gestionnaire->forme_juridique?> <?=$gestionnaire->capital_social?> - N° de TVA <?=$gestionnaire->num_tva?></p>
</div
<?php endif;?>
</body>
</html>
