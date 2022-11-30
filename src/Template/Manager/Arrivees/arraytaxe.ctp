<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" id="tb_nonarrive">
<thead>
	<tr>
			<th>Date </th>
			<th>Taxe</th>
			
			
	</tr>
</thead>
<?php foreach($a_taxe as $k=>$v):?>
<tr>
	<td><center><?php echo date("d-m-Y", strtotime($k))?></center></td>
	<td><center><?php echo $v?>&euro;</center></td>
</tr>
<?php endforeach;?>
</tbody>
</table>