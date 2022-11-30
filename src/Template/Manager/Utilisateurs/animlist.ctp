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
                         <a href="<?php echo $this->Url->build('/')?>manager/utilisateurs/add" class="btn  btn-large" id="rechercher">Ajouter animateur</a>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" id="themesIndex">
					<thead>
					<tr  style="font-weight:bold;">
						<td class="black">Nom</td>
						<td class="black">P&eacute;nom</td>
						<td class="black">E-mail</td>
						<td class="black"><img src='<?php echo $this->Url->build('/')?>images/val-sel.png'/></td>
						<td class="black"></td>
						<td class="black"></td>
					</tr>
					</thead>
          
	    <?php  if (count($animateur)>0) :?>
            <tbody>
              <?php foreach($animateur as $key=>$enr):?>
                <tr>
                    <td><?php echo $enr->nom_famille?></td>
                    <td><?php echo $enr->prenom?></td>
                    <td><a href="mailto:<?php echo $enr->email?>"><?php echo $enr->email?></a></td>
					<td>
						<center>
						<a onclick="return confirm('Voulez-vous valider cet animateur');" href="<?php echo $this->Url->build('/')?>manager/utilisateurs/contrat/<?php echo $enr->id."/".$enr->statut;?>">
							<?php echo ($enr->statut!=90)?"<img title=\" contrat  \" alt=\" contrat \" src=\"".$this->Url->build('/')."images/fail-icon.png\">":"<img title=\" contrat  \" alt=\" contrat \" src=\"".$this->Url->build('/')."images/pass-icon.png\">"?>
						</a>
						</center>
					</td>
                    <td >
						<center><a href="<?php echo $this->Url->build('/')?>manager/utilisateurs/edit/<?php echo $enr->id;?>"><img src="<?php echo $this->Url->build('/')?>images/edit.png" alt="" title=""/></a></center>
					</td>
					 <td >
						<center><a onclick="return confirm('Voulez-vous supprimer cet animateur');" href="<?php echo $this->Url->build('/')?>manager/utilisateurs/delete/<?php echo $enr->id;?>"><img src="<?php echo $this->Url->build('/')?>images/delete.png" alt="" title=""/></a></center>
					 </td>
                    
                </tr>
              <?php endforeach;?>
            </tbody>
        <?php endif;?>
        </table>
        
       
       	</div>
		
    </div>
  
</div>
</div>
</div>