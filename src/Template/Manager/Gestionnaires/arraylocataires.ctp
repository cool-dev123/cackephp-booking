<?php foreach($a_locataire as $v):?>

<tr>
    <td><div class="checkbox">
            <input type="checkbox" id='locataire_<?php echo $v['U']['id']?>' data-mail='<?php echo $v['U']['email']?>' data-portable='<?php echo $v['U']['portable']?>'>
            <label for="locataire_<?php echo $v['U']['id']?>"></label>
        </div></td>
	<td><?php echo $v['U']['prenom']?> <?php echo $v['U']['nom_famille']?></td>
        <td><?php echo $tabpays[$v['U']['id']]; ?>&nbsp;&nbsp;<?php echo $v['U']['portable']?></td>
	<td><?php echo $v['U']['email']?></td>
	<td><?php echo $v->dbt_at->i18nFormat('dd-MM-yyyy')?> </td>

	<td><?php echo $v['RS']['name']?></td>

	<td><?php echo $v['A']['num_app']?></td>
	<td><center><button data-toggle="modal" data-target="#responsive-modal" class="btn btn-sm btn-default btn-icon-anim btn-circle modifier_loc" data-href='<?php  echo $this->Url->build('/',true) ?>manager/gestionnaires/editlocataire/<?php echo $v['U']['id']?>/'><i class="fa fa-pencil"></i></button></center></td>

</tr>

<?php endforeach?>
