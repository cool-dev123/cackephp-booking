<tbody>
	<tr>
		<th width="9%"></th>
		<th></th>
		<th></th>
		<th class="text-right">
		</th>
	</tr>
	
	<?php foreach($message as $m):?>
	<tr>
		<td >
			<input type="checkbox" id="message_<?php echo $m->id?>">
		</td>
		<td>
		<?php
		$a_date=explode(" ",$m->date_insert);
		?>
		<?php echo date('d.m.Y',strtotime($m->date_insert));?> <?php echo substr($a_date[1],0,5)?>
		</td>
		<td>
			<h6 class="blue"><?php echo $m['A']['titre']?></h6>
			<p><?php echo $m['L']['name']?> (Res.<?php echo $m['R']['name']?>)</p>
		</td>
		<td>
			<?php echo $m->demande?><br>by: <?php echo $m->prenom." ".$m->nom?>
		</td>
		<td class="td_boutton">
			<button type="button" class="btn btn-success" data-toggle="modal" onclick="show_popup(<?php echo $m->id?>)" >Plus de détails</button>
		</td>
	</tr>
	<?php endforeach;?>
	<tr>
		<td colspan=5></td>
	</tr>
</tbody>
