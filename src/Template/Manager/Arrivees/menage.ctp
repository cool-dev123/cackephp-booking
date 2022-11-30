
 <style>
 .arrvee{color:#f00;font-size:15px;float:left;width:100%}
 .bg-c{background:none repeat scroll 0 0 #dde4ea;}
 .tbl_info_arr{width:100%;}
 .tbl_info_arr th{border:none;text-align:left;padding-left:10px;width:18%;}
  .tbl_info_arr td{border:none;text-align:left;padding-left:10px;width:18%;}
 </style>
 
 <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>js/datepicker.fr.js"></script>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
  $.datepicker.setDefaults($.datepicker.regional['fr']);

	oTable = $('#tb_nonarrive').dataTable( {
			"sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
			"bJQueryUI": false,
			"iDisplayLength": 10,
			"sPaginationType": "bootstrap",
			"bProcessing": true,
			"oLanguage": {
			"sProcessing": "<img src='<?php echo $this->Url->build('/',true)?>manager-arr/images/loadder/loading_bar_animated.gif'/>",
			"sLengthMenu": "_MENU_"},
			"bServerSide": true,
			"bFilter": false,
			"sAjaxSource": "<?php echo $this->Url->build('/',true)?>manager/arrivees/arraymenage/",
			"fnDrawCallback": function () {
                $(".sendmail").fancybox({ 'showCloseButton': false, 'hideOnOverlayClick'	:	false });
            },
			"fnServerParams": function ( aoData ) {
			  aoData.push( { "name": "from", "value": $('#from_date').val() });
			  aoData.push( { "name": "to", "value": $('#to_date').val() });

			}
	});
	$(".validation_menage").live('click',function() {
		var name = $(this).attr("data-name");
		var id = $(this).attr("data-key");

		$.confirm({
		'title': 'Validation ménage',
		'message': "<strong>Voulez-vous valider le ménage de l\'appartement </strong><br /><font color=red>' "+ name +" ' </font> ",
		'buttons': {
			   'OK': {
			   			'class': '',
						'action': function(){
							// Action when button Yes click.
							loading('Suppression...');
							//setTimeout("unloading();",900);
						   // oTable.drow();
							$.ajax({
								type: "GET",
								url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/validermenage/"+id,

								success:function(xml){
									//alert(xml)
										unloading();
										alertMessage('success','Vous venez de valider le ménage de l\'appartement '+name);
										setTimeout("alertHide();",5000);
										oTable.fnDraw();

									}
								});
						 }},
				'Annuler': { 'class'	: 'special'}}
		});
	});
	$("#recherche_annuler").live('click',function() {
		$.fancybox.close();
	});
	$("#recherche_res").live('click',function() {
			loading('loading...');

			$.ajax({
				type: "POST",
				url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/setmailmenage/",
				data:{vFrom:$('#from').val(),vTo:$('#to').val(),vObjet:$('#sujet').val(),vMsg:$('#comment').val()},
				success:function(xml){
					//alert(xml)
						$.fancybox.close();
						unloading();
						oTable.fnDraw();

					}
				});
	});
	$("#btn_pdf").live('click',function() {
			loading('loading...');

			$.ajax({
				type: "POST",
				url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/getpdfmenage/",
				data:{vFrom:$('#from_date').val(),vTo:$('#to_date').val()},
				success:function(xml){

						unloading();
						//alert(xml);
						window.open(xml);
						//document.location=xml;

					}
				});
	});
	$("#btn_rechercher").live('click',function() {
		oTable.fnDraw();
	});
	$("#reset").live('click',function() {
		$('#from_date').val('<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), date('d')-date('w')+1, date('Y')));?>');
		$('#to_date').val('<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), date('d')-date('w')+7, date('Y')));?>');
		$('#searchf').val('');
		oTable.fnDraw();
	});
	$("#from_date" ).datepicker({
                            dateFormat: "dd-mm-yy",
                            showOn: "button",
                            buttonImage: "<?php echo $this->Url->build('/',true)?>img/calendar.png",
                            buttonImageOnly: true
                });
	$("#to_date" ).datepicker({
                            dateFormat: "dd-mm-yy",
                            showOn: "button",
                            buttonImage: "<?php echo $this->Url->build('/',true)?>img/calendar.png",
                            buttonImageOnly: true
                });
	});
</script>

<div style='margin-left:28px' class="alert alert-block  alert-info">
	<center>
		<table>
			<tr>

				<td>
					<input type="text" value="<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), date('d')-date('w')+1, date('Y')));?>"  id="from_date" style="margin-top:10px" />

				</td>

				<td>
					<input type="text" value="<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), date('d')-date('w')+7, date('Y')));?>" id="to_date" style="margin-top:10px" />
					<button id="btn_rechercher" href="#" class="btn btn-primary">Rechercher</button>
					<button id="reset" href="#" class="btn btn-primary">Reset</button>
				</td>


			</tr>

		</table>
	</center>
</div>
<div style="width:97.4%" class="span12  widget clearfix">
	<div class="widget-header">
		<span><i class="icon-align-center"></i> Ménage   </span>
	</div><!-- End widget-header -->

	<div  style="position:relative;">

		<div class="tb_nonarrive" >
			<div id="tab1" class="tab_content" style='display: block;margin:10px;'>
				<div class="btn-group pull-top-right btn-square" style='top:40px;right:20px;'>
					<a href='javascript:void(0)' id='btn_pdf' class="btn  btn-large"><i class="icon-plus"></i>PDF</a>
                </div>
				<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" id="tb_nonarrive">
					<thead>
						<tr>
								<th>Résidence</th>
								<th>ID Annonce</th>
								<th>Num App </th>
								<th>Surface</th>
								<th>Date d'arrivée</th>
								<th>Locataire</th>
								<th>Tél Locataire</th>
								<th>Propriétaire</th>
								<th>Tél Propriétaire</th>
								<th>&nbsp;</th>


						</tr>
					</thead>
					<tbody>
					<tr>
						<td colspan="10" class="dataTables_empty">Loading data from server</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
