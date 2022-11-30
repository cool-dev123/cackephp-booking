<?php
/*
 *
 */
 ?>
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

	$("#reset").live('click',function() {
			loading('loading...');
			$.ajax({
				type: "POST",
				url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/arraytaxe/<?php echo $InfoGes['G']['id']?>",
				data:{vDebut:$('#from_date').val(),vFin:$('#to_date').val()},
				success:function(xml){
					//alert(xml)
						$('#tab1').html(xml);
						unloading();


					}
				});
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
					<input type="text" placeholder="date début"  id="from_date" style="margin-top:10px" />

				</td>
				<td width="30px"></td>
				<td>
					<input type="text" placeholder="date fin" id="to_date" style="margin-top:10px" />
					<button id="reset" href="#" class="btn btn-primary">Rechercher</button>
				</td>


			</tr>

		</table>
	</center>
</div>
<div style="width:97.4%" class="span12  widget clearfix">
	<div class="widget-header">
		<span><i class="icon-align-center"></i> Taxe séjour </span>
	</div><!-- End widget-header -->

	<div  style="position:relative;">

		<div class="tb_taxe" >
			<div id="tab1" class="tab_content" style='display: block;margin:10px;'>
				&nbsp;
			</div>
		</div>
	</div>
</div>
<!-- widget  span12 clearfix-->
