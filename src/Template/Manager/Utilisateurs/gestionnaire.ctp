<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    oTable = $('#themesIndex').dataTable( {
    "sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
    "bJQueryUI": false,
    "iDisplayLength": 10,
    "sPaginationType": "bootstrap",
    "oLanguage": {
            "sLengthMenu": "_MENU_",
            "sSearch": "Search"
    }
    });
    });
    <?php if(!empty($confirm_res)): ?>
    alertMessage('success','Gestionnaire supprimée');
    setTimeout("alertHide();",5000);
    <?php endif;?>
</script>
<div id="contacthotel" class="widget  span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-table"></i> Liste des gestionnaires </span>
        </div><!-- End widget-header -->	
        <div class="widget-content">
        <!-- Table UITab -->
        <div  style="position:relative;">
            <ul class="tabs" ></ul>
            <div class="tab_container" >
                <div id="tab1" class="tab_content" style='display: block;'> 
                    <div class="btn-group pull-top-right btn-square">
                         <a href="<?php echo $this->base?>/manager/utilisateurs/addgestionnaire" class="btn  btn-large" id="rechercher">Nouveau gestionnaire</a>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" id="themesIndex">
                        <thead>
						<tr  style="font-weight:bold;">
							<td >Gestionnaire</td>
							<td >Role</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						</tr>
						</thead>
						<?php if (count($gestionnaires)>0) {?>
							<tbody>
							  <?php foreach($gestionnaires as $key=>$enr) {?>
								<tr>
									<td><?php echo $enr['Gestionnaire']['name'];?></td>
									<td><?php echo $enr['Gestionnaire']['role']; ?></td>
									<td ><a href="<?php echo $this->base;?>/manager/utilisateurs/editgestionnaire/<?php echo $enr['Gestionnaire']['id'];?>"><img src="<?php echo $this->base;?>/images/edit.png" alt="" title=""/></a></td>
									<td ><a onclick="return(confirm('Etes-vous s&ucirc;r de vouloir supprimer cette entr&eacute;e?'));" href="<?php echo $this->base;?>/manager/utilisateurs/deletegestionnaire/<?php echo $enr['Gestionnaire']['id'];?>"><img src="<?php echo $this->base;?>/images/delete.png" alt="" title=""/></a></td> 
									
								</tr>
							  <?php }?>
							</tbody>
						<?php }?>
					</table>
				</div>
                <!-- end Long Description codes -->
            </div>
            </div>
        </div>
    </div>
 
    