<?php foreach($a_gest as $v):?>

<tr>
	<td><?php echo $v->name?></td>
	<td><?php echo $v['S']['totalsms']?></td>
	<td><?php echo $v['envoye']?></td>
	<td><?php echo ($v['S']['totalsms']-$v['envoye'])?></td>
	<td>
            <center>
                <button data-toggle="modal" data-target="#responsive-modal" class="btn btn-sm btn-default btn-icon-anim btn-circle edit_sms" data-key="<?php echo $v['S']['id']?>" data-name="<?php echo $v->name ?>"><i class="fa fa-pencil"></i></button>
            </center>
	</td>
</tr>

<?php endforeach?>
