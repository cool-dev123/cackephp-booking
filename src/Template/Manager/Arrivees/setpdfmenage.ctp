<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<div style="width:100%">
<div style="width:70%;float:left">
<img style="padding:5px" src="https://www.alpissime.com/images/bg-logo.jpg"/>
</div>
<div style="width:30%;float:left;text-align:right;">
<table  cellpadding="0" cellspacing="0" style="width:208px">
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td style="border:1px solid #000;font-weight:bold;font-family:arial;font-size:14px;padding:20px;">
<center>
<?php echo $gestionnaire->nom?><br/>le <?php echo date("d/m/Y");?>
</center>
</td>
</tr>
</table>
</div>
</div>
<div style="width:100%;height:100px;float:left">&nbsp;</div>

<div style="width:100%;float:left;font-family:Arial;font-size:12px;">
<table style="width:100%;" cellspacing="0" cellpadding="0" >
<thead>
<tr>
<th style="width: 12%;border: 1px solid #dddddd;" >Résidence</th>
<th style="width: 8%;border: 1px solid #dddddd;" >ID Annonce</th>
<th style="width: 10%;border: 1px solid #dddddd;">Num App </th>
<th style="width: 8%;border: 1px solid #dddddd;">Surface</th>
<th style="width: 8%;border: 1px solid #dddddd;" >Date d'arrivée</th>
<th style="width: 24%;border: 1px solid #dddddd;" >Locataire</th>
<th style="width: 8%;border: 1px solid #dddddd;">Tél Locataire</th>
<th style="width: 24%;border: 1px solid #dddddd;" >Propriétaire</th>
<th style="width: 8%;border: 1px solid #dddddd;">Tél Propriétaire</th>
</tr>
</thead>
<tbody >
<?php foreach($menage as $m):?>
<tr>
<td style="width: 20%;border: 1px solid #dddddd;"><center><?php echo $m['R']['name']?></center></td>
<td style="width: 20%;border: 1px solid #dddddd;"><center><?php echo $m->id?></center></td>
<td style="width: 20%;border: 1px solid #dddddd;"><center><?php echo $m->num_app?></center></td>
<td style="width: 20%;border: 1px solid #dddddd;"><center><?php echo $m->surface?> m²</center></td>
<td style="width: 20%;border: 1px solid #dddddd;"><center><?php echo date('d-m-Y', strtotime($m['RR']['dbt_at']))?></center></td>
<td style="width: 20%;border: 1px solid #dddddd;"><center><?php echo $m['U']['prenom']." ".$m['U']['nom_famille']?></center></td>
<td style="width: 20%;border: 1px solid #dddddd;"><center><?php echo $m['U']['portable']?></center></td>
<td style="width: 20%;border: 1px solid #dddddd;"><center><?php echo $m['P']['prenom']." ".$m['P']['nom_famille']?></center></td>
<td style="width: 20%;border: 1px solid #dddddd;"><center><?php echo $m['P']['portable']?></center></td>
</tr>
<?php endforeach;?>
</tbody>
</table>
</div>
</body>
</html>