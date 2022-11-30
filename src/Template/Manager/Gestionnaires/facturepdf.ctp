<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<?php
	$a_mois=array(1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Nouvembre',12=>'Décembre');
	$total_comm=0;
?>
<div style="width:100%;float:left;">
<div style="width:600px;float:left;padding:10px 20px;font-size:26px;color:red;background-color:#B5B5B5;font-weight:bold;font-family:'Open Sans',sans-serif">
ARCS MULTI-SERVICES AGENCEMENT
</div>
</div>
<div style="width:100%;float:left;">
<table style="width:1000px;font-family:'Open Sans',sans-serif">
	<tr>
	<td style="width:700px"><strong>GALERIE PIERRE MENTA - BP 12</strong></td>
	<td style="width:300px;"></td>
	</tr>
	<tr>
	<td><strong>73706 ARC 1800 CEDEX</strong></td>
	<td></td>
	</tr>
	<tr>
	<td><strong>Tel : 04 79 07 49 07</strong></td>
	<td></td>
	</tr>
	<tr>
	<td><strong>Capital : 7622,44&euro;</strong></td>
	<td>
		<table style="width:300px;">
			<tr>
				<td style="width:150px;"><strong>ARC 1800 LE</strong></td>
				<td>
				<table style="width:150px;background-color:#32CFE7;" border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td style="width:150px;"><center><?php echo date('d-m-Y')?></center></td>
						
					</tr>	
				</table>
				</td>
			</tr>
			<tr>
				<td colspan=2>
				<p><?php echo $gestionnaire->name?></p>
				<p><?php echo $gestionnaire->adresse?></p>
				</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td><strong>TVA : FR21 405 097 320</strong></td>
	<td></td>
	</tr>
</table>
</div>

<div style="width:100%;float:left;">
<table style="width:450px;font-family:'Open Sans',sans-serif">
	<tr>
		<td style="width:150px;"><strong>N° FACTURE</strong></td>
		<td style="width:300px;">
			<table style="width:200px;background-color:#32CFE7;" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:150px;"><?php echo $num_facture?></td>
					<td style="width:50px;text-align:center">G</td>
				</tr>	
			</table>
		</td>
	</tr>
	<tr>
		<td style="width:150px;"><strong>N° GESTIONNAIRE</strong></td>
		<td style="width:200px;">
			<table style="width:200px;background-color:#32CFE7;" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:200px;"><center><?php echo $gest?></center></td>
				</tr>	
			</table>
		</td>
	</tr>
	<tr>
		<td style="width:150px;"><strong>STATION</strong></td>
		<td style="width:200px;">
			<table style="width:200px;background-color:#32CFE7;" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:200px;text-align:center"><?php echo $a_contrat[0]['L']['name']?></td>
				</tr>	
			</table>
		</td>
	</tr>
	<tr>
		<td style="width:150px;"><strong>FACTURE MOIS DE</strong></td>
		<td style="width:200px;">
			<table style="width:200px;background-color:#32CFE7;" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:200px;"><center><?php echo $a_mois[$mois]?></center></td>
				</tr>	
			</table>
		</td>
	</tr>
</table>
</div>
<div style="width:100%;float:left;">
	<table style="width:1000px;">
	<tr>
		<td >
			<img  src="https://www.alpissime.com/images/logo_landing_page.png"/>
		</td>
		
	</tr>
	</table>
</div>
<div style="width:100%;float:left;height:30px;">&nbsp;</div>
<div style="width:100%;float:left;">
<table style="width:1000px;font-family:'Open Sans',sans-serif" border="1" cellpadding="0" cellspacing="0">
	<tr>
		<td style="width:80px"><center>Numéro annonce</center></td>
		<td style="width:100px"><center>Numéro appartement </center></td>
		<td style="width:140px"><center>Propriétaire</center></td>
		<td style="width:140px"><center>Station / Village</center></td>
		<td style="width:100px"><center>Date de début du contrat</center></td>
		<td style="width:100px"><center>Date</center></td>
		<td style="width:120px"><center>Type de contrat</center></td>
		<td style="width:80px"><center>Prix HT</center></td>
		<td style="width:80px"><center>Commission</center></td>
	</tr>
	<?php for($i=0;$i<15;$i++):?>
	<?php if(!empty($a_contrat[$i]['id_gestionnaires'])):?>
	<tr>
		<td style="width:80px;text-align:center;"><?php echo $a_contrat[$i]['id']?></td>
		<td style="width:100px;text-align:center;"><?php echo $a_contrat[$i]['num_app']?></td>
		<td style="width:140px"><?php echo $a_contrat[$i]['U']['prenom']." ".$a_contrat[$i]['U']['nom_famille'];?></td>
		<td style="width:140px"><?php echo $a_contrat[$i]['L']['name']?>/<?php echo $a_contrat[$i]['V']['name']?></td>
		<td style="width:100px;text-align:center"><?php echo date("d-m-Y", strtotime($a_contrat[$i]['PC']['date_create']))?></td>
		<td style="width:100px;text-align:center"><?php echo date("d-m-Y", strtotime($a_contrat[$i]['C']['date_create']))?></td>
		<td style="width:120px;text-align:center"><?php echo $a_contrat[$i]['CT']['type']?></td>
		<td style="width:80px;text-align:center">
			<?php echo number_format(($a_contrat[$i]['C']['prix']/1.2),2);?> &euro;
		</td>
		<td style="width:80px;padding-right:5px;text-align:right;">
			<?php switch($a_contrat[$i]['CT']['id']){
					case 1:
					echo number_format((($a_contrat[$i]['C']['prix']*$gestionnaire->commission_maint/1.2)/100),2);
					$total_comm+=(($a_contrat[$i]['C']['prix']*$gestionnaire->commission_maint/1.2)/100);
					break;
					case 2:
					echo number_format((($a_contrat[$i]['C']['prix']*$gestionnaire->commission_sejour/1.2)/100),2);
					$total_comm+=(($a_contrat[$i]['C']['prix']*$gestionnaire->commission_sejour/1.2)/100);
					break;
					case 3:
					echo number_format((($a_contrat[$i]['C']['prix']*$gestionnaire->commission_relation/1.2)/100),2);
					$total_comm+=(($a_contrat[$i]['C']['prix']*$gestionnaire->commission_sejour/1.2)/100);
					break;
				}
		?> &euro;
		</td>
	</tr>
	<?php /*else:?>
	<tr>
		<td style="width:12px">&nbsp;</td>
		<td style="width:12px">&nbsp;</td>
		<td style="width:10px">&nbsp;</td>
		<td style="width:12px">&nbsp;</td>
		<td style="width:12px">&nbsp;</td>
		<td style="width:12px">&nbsp;</td>
		<td style="width:10px">&nbsp;</td>
		<td style="width:10px">&nbsp;</td>
	</tr>
	<?php*/ endif;?>
	<?php endfor;?>
</table>
</div>
<div style="width:100%;float:left;height:30px;">&nbsp;</div>
<div style="width:100%;float:left;">
	<table style="width:1000px;">
	<tr>
		<td>
			<p style="font-size:21px;font-weight:bold;font-family:'Open Sans',sans-serif">Conditions de règlement : à réception de facture</p>
			<p style="font-size:21px;font-family:'Open Sans',sans-serif">Veuillez libeller votre chèque à l'ordre de <font style='color:red'>AMSA</font></p>
			<p style="font-size:21px;font-family:'Open Sans',sans-serif">RIP FRANCE 18106 00810 9275 4244 050 69</p>
			<p style="font-size:21px;font-family:'Open Sans',sans-serif">IBAN ETRANGER FR76 1810 6008 1092 7542 4405 069</p>
			<p style="font-size:21px;font-family:'Open Sans',sans-serif">BIC AGRIFRPP881</p>
		</td>
		<td>
			<table style="width:360px;font-size:26px;font-weight:bold;font-family:'Open Sans',sans-serif" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td style="font-size:26px;font-weight:bold;width:200px;font-family:'Open Sans',sans-serif">TOTAL HT</td>
					<td style="width:200px;border-right:1px solid #000;border-bottom:1px solid #000;text-align:center;"><?php echo number_format($total_comm,2);?> &euro;</td>
				</tr>
			</table>
			<table style="width:360px; font-size:26px;font-weight:bold;font-family:'Open Sans',sans-serif" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td style="font-size:26px;font-weight:bold;width:200px;font-family:'Open Sans',sans-serif">TVA 20%</td>
					<td style="width:200px;border-right:1px solid #000;border-bottom:1px solid #000;background-color:#fff;text-align:center;"><?php echo number_format(($total_comm*0.2),2);?> &euro;</td>
				</tr>
			</table>
			<table style="width:360px;font-size:26px;font-weight:bold;font-family:'Open Sans',sans-serif" border="0" cellpadding="2" cellspacing="2">
				<tr>
				<td style="font-size:26px;font-weight:bold;width:200px;font-family:'Open Sans',sans-serif">TOTAL TTC</td>
				<td style="width:200px;border-right:1px solid #000;border-bottom:1px solid #000;background-color:#A1E9F4;text-align:center;"><?php echo number_format(($total_comm*1.2),2);?> &euro;</td>
				</tr>
			</table>
			<table style="width:360px;font-size:26px;font-weight:bold;font-family:'Open Sans',sans-serif" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td style="font-size:26px;font-weight:bold;width:200px;font-family:'Open Sans',sans-serif">A REGLER</td>
					<td style="width:200px;border-right:1px solid #000;border-bottom:1px solid #000;background-color:#73C6B9;text-align:center;"><?php echo number_format(($total_comm*1.2),2);?> &euro;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<img  src="https://www.alpissime.com/images/reseaux.png"/>
		</td>
	</tr>
	<tr>
		<td style="width:680px;font-size:19px;font-family:'Open Sans',sans-serif">
		<center>Vous pouvez également rajouter les coordonées GPS des points remarquables</center>
		<center>de votre station, merci de nous contacter pour plus d'information</center>
		</td>
		<td style="width:320px">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=2>
			<img  src="https://www.alpissime.com/images/logo_footer.png"/>
		</td>
		
	</tr>
	<tr>
	<tr>
		<td colspan=2 style="font-size:21px;font-family:'Open Sans',sans-serif">
			<p><center><strong>Si vous souhaitez des renseignements supplémentaires concernant cette facture, contactez la société <font style='color:red'>AMSA</font></strong></center></p>
			<p><center><strong>au 04 79 07 49 07, ou par Email:</strong>alpissime@gmail.com</center></p>
		</td>
		
	</tr>
	</table>
</div>
</body>
</html>