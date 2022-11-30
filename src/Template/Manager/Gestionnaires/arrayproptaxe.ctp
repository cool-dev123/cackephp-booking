<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//print_r($a_locataire);
?>
<tr>
<td width='7%'> <input type='checkbox' id='checkAll'> Toutes</td>
<th width='15%'>Prénom</th>
<th>Nom de famille</th>
<th>Num Portable</th>
<th>E-mail</th>
<th>Code Postal</th>
<th>Ville</th>
</tr>
<?php foreach($a_locataire as $v):?>

<tr>
	<td> <input type='checkbox' id='locataire_<?php echo $v->id; ?>' data-id='<?php echo $v->id?>'> </td>
	<td><?php echo $v->prenom?></td>
  <td><?php echo $v->nom_famille?></td>
	<td><?php echo $v->portable?></td>
	<td><?php echo $v->email?></td>
  <td><?php echo $v->code_postal?></td>
  <td><?php echo $v->ville?></td>
</tr>

<?php endforeach?>
