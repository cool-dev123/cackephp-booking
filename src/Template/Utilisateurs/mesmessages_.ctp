<?php $this->assign('title', __('Utilisateurs')); ?>

<?php $this->Html->css("/css/new/dataTables.bootstrap4.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/jquery.dataTables.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/new/dataTables.bootstrap4.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
$(document).ready(function () {
	$('#table_id_valid').DataTable({
		language: {
			"url": "<?php echo $datatable_file; ?>",
			// search: "_INPUT_",
			// searchPlaceholder: "Recherche"
		},
		"order": [[ 5, "desc" ]]
	});
		
		$("#trash_supp").css('cursor','not-allowed');
		$("#trash_supp").attr('title','<?= __("Aucune case cochée") ?>');
		$("#trash_supp").attr('onclick','');

	//document.getElementById("trash_supp").disabled = true;
});

$('#table_id_valid :checkbox').on('change', function() {
    if($('#table_id_valid :checkbox:checked').length > 0){
    		$("#trash_supp").attr('title','');
    		$("#trash_supp").css('cursor','pointer');
			$("#trash_supp").attr('onclick','open_dialog_delete()');
    }else{
    	$("#trash_supp").attr('title','<?= __("Aucune case cochée") ?>');
    	$("#trash_supp").css('cursor','not-allowed');
		$("#trash_supp").attr('onclick','');
    }
    //alert($('#table_id_valid :checkbox:checked').length);
});

var myArray = [];

/*if(!$('#table_id_valid :checkbox').is(":checked")){
	//$('#trash').attr("disabled", "disabled");
}*/


function open_dialog_delete(){
	myArray = [];
			$('#table_id_valid :checkbox:checked').each(function(){
				myArray.push($(this).val());
			});
			//alert(myArray);
			$('#delete').modal('show');
}
function delete_res(){
				$('#delete').modal( "hide" );
				//alert(myArray);

				$.ajax({
			async: false,
            url: '<?php echo $this->Url->build('/',true)?>utilisateurs/delMessage/',
            type:"POST",
            dataType: 'json',
            data: { testdata : JSON.stringify(myArray) },
            success:function(data){
                //alert(data.msg);
            },error:function(){
                //alert("error!!!!");
            }
        }); //end of ajax


				window.location.href = "<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages']?>";
			}

function getArrayMessage(){
	$('#list_messages').html('<tr><td><center><img src="<?php echo $this->Url->build('/',true)?>images/loading.gif"/></center></td></tr>');
	$.ajax({
	type: "POST",
	url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraymessage",
	data:{vSearch:$('#m_search').val()},
	success:function(xml){
		$('#list_messages').html(xml)
	}
	});
}

function show_popup_creer_message(){
	$('#reservation_list').html('<center><img src="<?php echo $this->Url->build('/',true)?>/images/loading.gif"/></center>');
	$('#creermessage').modal('show');
	$.ajax({
				type: "GET",
				url: "<?php echo $this->Url->build('/',true)?>utilisateurs/addmessage/",
				success:function(xml){
						$('#newmessage').html(xml)
				}
	});
}

function show_popup_anser(id_message){
	$('#plusdetails').modal('hide');
	$('#repondremessage').modal('show');
	$.ajax({
				type: "GET",
				url: "<?php echo $this->Url->build('/',true)?>utilisateurs/reponsemessageprop/"+id_message,
				success:function(xml){
						$('#repondre_message').html(xml)
				}
	});

}

function show_popup(id_message){
			$('#reservation_list').html('<center><img src="<?php echo $this->Url->build('/',true)?>/images/loading.gif"/></center>');
			$('#plusdetails').modal('show');
			$.ajax({
            type: "GET",
            url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getinfomessage/"+id_message,
            success:function(xml){
                $('#reservation_list').html(xml)
            }
			});

		}

<?php $this->Html->scriptEnd(); ?>
<?php echo $this->Flash->render() ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="messages" class="container">
<div class="row flex-column-reverse flex-md-row justify-content-md-between mb-5">
      <div class="col espace-menu">
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
        <?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
		<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
		<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations") ?></a></h3>
        <?php }else{ ?>
		<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
		<?php } ?>
        <h3 class="border-bottom-menu-espace float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
      </div>
      <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
      <div class="col-auto">
	  <a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>" class="text-decoration-none">
        <h3 class="text-blue espace-type"><?= __("Espace locataire") ?></h3>
      </a>
      </div>
      <?php }?>
	</div>
		
			<div class="row block">
				<div class="col-md-12">
					<div style="display:none" class="pull-right">
						<form method="" action="" class="form-inline">
							<div class="form-group">
								<input type="text" id="m_search" class="form-control" id="" placeholder="">
							</div>
							<button type="button" onclick="getArrayMessage()" class="btn btn-success"><i class="fa fa-search"></i></button>
						</form>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 block">
					<div class="table-responsive annonce">
						<table id="table_id_valid" class="table table-hover">
							<thead>
								<tr>
								    <th><?= __("Type") ?></th>
								    <th><?= __("De") ?></th>
									<th><?= __("Annonce") ?></th>
									<th><?= __("Date/heure") ?></th>					
									<th class="text-center"><a id='trash_supp' style='cursor:pointer' onclick='open_dialog_delete()'><i class="fa fa-trash" aria-hidden="true"></i></a></th>
                                    <th class="text-right"></th>
                                </tr>
	                        </thead>
				            <tbody>

<?php if(empty($message->toArray())) echo "<tr><td data-title='MESSAGES' colspan='6'><center> ".__("Vous n'avez aucun message")."</center></td></tr>" ?>
								<?php foreach($message as $m):?>
								<tr <?php if(($m->lut == 0 && $m->locataire_id != $this->Session->read('Auth.User.id')) || $unreadCount[$m->id] != 0) echo "class='bg-light font-weight-bold'"; ?>>
								    <td>
										<?php if($m->locataire_id == $this->Session->read('Auth.User.id')){ ?>
										<div class="btn-white text-blue border text-center p-1"> <?= __("Envoyé") ?> </div>
										<?php }else{ ?>
										<div class="btn-white text-blue border text-center p-1"> <?= __("Reçu") ?> </div>
										<?php } ?>
									</td>
									<td><h6><?php echo $m->prenom.' '.$m->nom; ?></h6></td>
								    <td width='35%'>
										<h5 class="blue"><?php echo $m['A']['titre']?></h5>
										<p class="mb-0"><?php echo $m['L']['name']?> (Res.<?php echo $m['R']['name']?>)</p>
									</td>
									<td data-title="Date/heure">
									<?php //echo date("d/m/Y H:i:s")."ttttt".$m->date_insert;
									$now = $m->date_insert;
									if($now != "0000-00-00" && $now != ""){
										$now_date = $now->format('d/m/Y');
										$arrTime=explode(" ", $now);
										if(date("d/m/Y") == $now_date)
										echo "Aujourd'hui ".$arrTime[1];
										else echo $now;
									}else{
										echo $now;
									}
									
									?>
									</td>
									<td class="text-center">
										<input type="checkbox" id="message_<?php echo $m->id?>" value="<?php echo $m->id?>">
									</td>
									<td class="td_boutton">
										<a class="btn btn-blue text-white rounded-0 pull-right position-relative" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/detailmessage/<?php echo $m->id?>" ><i class="fa fa-eye" aria-hidden="true"></i>
										<?php if($listeCount[$m->id] != 0){ ?>
											<span class="notif-icon"><?php echo $listeCount[$m->id]; ?></span>
										<?php } ?>
										</a>
									</td>
								</tr>
								<?php endforeach;?>

							</tbody>
						</table>
						<table  id="list_messages" class="table table-condensed">

						</table>
						<div class="pagination">
                            <ul class="list-inline"><?php if(!empty($this->Paginator->first('<<'))){ ?>
                 <li><button class="btn btn-default"><?php echo $this->Paginator->first('<<'); ?></button></li>
                            <?php } ?>
                     <?php $affichePages=$this->Paginator->numbers(); if ($affichePages=='') {} else { $affichePages=$this->Paginator->numbers(); echo ($affichePages); } ?>
                 <?php if(!empty($this->Paginator->last('>>'))){ ?>
                 <li><button class="btn btn-default"><?php echo $this->Paginator->last('>>'); ?></button></li>
                   <?php } ?>
                            </ul>
			</div><!--end pagination-->
					</div>
				
			</div>
		</div>
		
	</div>
</div>
<div class="modal fade" id="plusdetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= __("Détails de votre message") ?></h4>
      </div>
      <div class="modal-body">
				<div id="reservation_list" class="col-md-12 gray_background block">

				</div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="creermessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
	    <h4 class="modal-title" id="myModalLabel"><?= __("Envoyer message") ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  
      </div>
      <div class="modal-body">
				<div id="newmessage" class="col-md-12 gray_background block">

				</div>
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="repondremessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= __("Répondre au message") ?></h4>
      </div>
      <div class="modal-body">
				<div id="repondre_message" class="col-md-12 gray_background block">

				</div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="hdreservation"/>
		<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
				    <h4 class="modal-title" id="myModalLabel"><?= __("Supprimer les messages") ?></h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      </div>

			      <div class="modal-body">
					<center><p><?= __("Voulez-vous supprimer ces messages ?") ?></p></center>
					<div class="text-right">
					<button type="button" class="btn btn-retour" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
					<button type="button" class="btn btn-blue text-white rounded-0" onclick="delete_res()"><?= __("Oui") ?></button>
					</div>
			      </div>
			    </div>
			  </div>
			</div>
