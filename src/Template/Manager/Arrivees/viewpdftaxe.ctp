<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<div style="width:100%">
<div style="width:70%;float:left">
<img style="padding:5px" src="https://www.alpissime.com/images/bg-logo.jpg"/>
</div>
<div style="width:30%;float:left;text-align:right">
<table  cellpadding="0" cellspacing="0" style="width:208px">
<tr>
<td style="background-color:#0074cc;color:#fff;font-weight:bold;font-family:arial;font-size:14px;padding:10px;">
<center>TAXE DE SEJOUR</center>
</td>
</tr>
<tr >
<td style="border:1px solid #000;font-weight:bold;font-family:arial;font-size:14px;padding:20px;">
<center>
DATE :<br>Du <?php echo $debutperiode ?><br>Au <?php echo $finperiode ?>
</center>
</td>
</tr>
</table>
</div>
</div>
<div style="width:100%;height:80px">&nbsp;</div>
<div style="width:100%;font-size: 22px;margin-bottom:20px;">Propriétaire : <?php echo $proprietaire->prenom." ".$proprietaire->nom_famille ?></div>
<div style="width:100%">
  <center>
<table cellpadding="0" cellspacing="0" style="font-family: verdana,arial,sans-serif;font-size:11px;color:#333333 ;border-width: 1px;border-color: #a9c6c9 ;border-collapse: collapse;width: 100%;text-align: center;">
    <thead>
      <tr>
        <th width="12%" style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        background: #0074cc;
        color: white;
        border-color: #0458bf;">Début de Période </th>
        <th width="12%" style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        background: #0074cc;
        color: white;
        border-color: #0458bf;">Fin de Période </th>
        <th width="15%" style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        background: #0074cc;
        color: white;
        border-color: #0458bf;">Résidence</th>
        <th width="10%" style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        background: #0074cc;
        color: white;
        border-color: #0458bf;">Num app</th>
        <th width="15%" style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        background: #0074cc;
        color: white;
        border-color: #0458bf;">Locataire</th>
        <th width="5%" style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        background: #0074cc;
        color: white;
        border-color: #0458bf;">Nombre Adulte</th>
        <th width="5%" style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        background: #0074cc;
        color: white;
        border-color: #0458bf;">Nombre Enfant</th>
        <th width="7%" style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        background: #0074cc;
        color: white;
        border-color: #0458bf;">Méthode Paiement</th>
        <th width="10%" style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        background: #0074cc;
        color: white;
        border-color: #0458bf;">Taxe séjour (&euro;)</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($listeTaxes as $key => $value) { ?>

      <tr>
        <td style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #0874f9 ;" ><?php echo $value[0] ?> </td>
        <td style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #0874f9 ;" ><?php echo $value[1] ?></td>
        <td style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #0874f9 ;" ><?php echo $value[2] ?></td>
        <td style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #0874f9 ;" ><?php echo $value[3] ?></td>
        <td style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #0874f9 ;" ><?php echo $value[4] ?></td>
        <td style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #0874f9 ;" ><?php echo $value[5] ?></td>
        <td style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #0874f9 ;" ><?php echo $value[6] ?></td>
        <td style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #0874f9 ;" ><?php echo $value[7] ?></td>
        <td style="border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #0874f9 ;" ><?php echo $value[8] ?></td>
      </tr>
      <?php $total = $value[9];
      $totalespece = $value[10];
      $totalcheque = $value[11];
      $totalCB = $value[12];
     } ?>
    </tbody>
  </table>
</center>
</div>
<div style="width: 100%;
    text-align: right;
    margin-top: 25px;
    font-size: 22px;
    color: black;">Total Chèque : <?php echo $totalcheque; ?> &euro; &nbsp;&nbsp; Total Espèce : <?php echo $totalespece; ?> &euro; &nbsp;&nbsp; Total Carte bancaire : <?php echo $totalCB; ?> &euro; <br><br>Total taxe : <?php echo $total; ?> &euro;</div>


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
</div>
<?php endif;?>
</body>
</html>
