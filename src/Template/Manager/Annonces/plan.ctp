<?php 
//header("Content-disposition: attachment; filename=proprietaires_mails.csv");
//header("Content-Type: application/force-download; charset=UTF-8");
//header("Content-Transfer-Encoding: application/octet-stream\n");
?>

<div class="widget  span12 clearfix">                 
    <div class="widget-header">
        <span><i class="icon-table"></i> Les fichiers csv </span>
    </div><!-- End widget-header -->	
    <div class="widget-content">
        <div id="UITab" style="position:relative;">
            <ul class="tabs" ></ul>
            <div class="tab_container" >
               
                <ul class="statistics">
                    <li>
                        <a class='btn btn-primary' href='<?php echo $this->base?>/csv/proprietaires_non_contrat.csv'>Propriétaire non en contrat</a>
						<br/>
                    </li>
					<li>&nbsp;</li>
                    <li>
                        <a class='btn btn-primary' href='<?php echo $this->base?>/csv/proprietaires_contrat.csv'>Propriétaire en contrat</a>
						<br/>
                    </li>
					<li>&nbsp;</li>
					<li>
                        <a class='btn btn-primary' href='<?php echo $this->base?>/csv/locataire.csv'>Locataire</a>
						<br/>
                    </li>
					<li>&nbsp;</li>
                </ul> 
            </div>
        </div>
    </div>
</div>