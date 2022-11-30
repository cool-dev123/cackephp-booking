<?php echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";?>
<City>
	<item id="0" value=""/>
    <?php foreach($l_residence as $k=>$v):?>
    <item id="<?php echo $k?>" value="<?php echo $v?>"/>
    <?php endforeach;?>
</City>
