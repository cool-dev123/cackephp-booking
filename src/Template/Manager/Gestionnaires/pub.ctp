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
	$(".view_pub").fancybox({ 'showCloseButton': false, 'hideOnOverlayClick'	:	false });
    });
	<?php if(!empty($confirm_res)): ?>
    alertMessage('success',"<?php echo $confirm_res?>");
    setTimeout("alertHide();",5000);
    <?php endif;?>
</script>
<div id="contacthotel" class="widget  span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-table"></i> Publicités </span>
        </div><!-- End widget-header -->	
        <div class="widget-content">
        <!-- Table UITab -->
        <div  style="position:relative;">
            <ul class="tabs" ></ul>
            <div class="tab_container" >
                <div id="tab1" class="tab_content" style='display: block;'> 
                    <div class="btn-group pull-top-right btn-square">
                         <a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/addpub/" class="btn  btn-large" id="rechercher">Ajouter Publicité</a>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" id="themesIndex">
                        <thead>
						<tr  style="font-weight:bold;">
							<th >Titre</th>
							
							<th >&nbsp;</th>
							<th >&nbsp;</th>
							<th >&nbsp;</th>
						</tr>
						</thead>
						
						<tbody>
						  <?php foreach($images as $key=>$enr):?>
							<tr>
								<td><?php echo $enr->titre?></td>
								
								<td><a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/viewpub/<?php echo $enr->id;?>" class="view_pub"><img src="<?php echo $this->Url->build('/',true);?>images/view.png" alt="" title=""/></a></td>
								<td>
									<a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/editpub/<?php echo $enr->id;?>"><img src="<?php echo $this->Url->build('/',true);?>images/edit.png" alt="" title=""/></a>
								</td>
								<td>
								<a onclick="return confirm('Voulez-vous supprimer cette Publicité ?');" href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/deletepub/<?php echo $enr->id;?>"><img src="<?php echo $this->Url->build('/',true);?>images/delete.png" alt="" title=""/></a>
								 </td>
								
							</tr>
						  <?php endforeach;?>
						</tbody>
					
					</table>
				</div>
                <!-- end Long Description codes -->
            </div>
            </div>
        </div>
    </div>
