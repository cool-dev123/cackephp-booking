<?php $this->Html->css("/css/new/dataTables.bootstrap4.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/jquery.dataTables.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/new/dataTables.bootstrap4.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-eu-pre": function ( date ) {
        date = date.replace(" ", "");

        if ( ! date ) {
            return 0;
        }

        var year;
        var eu_date = date.split(/[\.\-\/]/);

        /*year (optional)*/
        if ( eu_date[2] ) {
            year = eu_date[2];
        }
        else {
            year = 0;
        }

        /*month*/
        var month = eu_date[1];
        if ( month.length == 1 ) {
            month = 0+month;
        }

        /*day*/
        var day = eu_date[0];
        if ( day.length == 1 ) {
            day = 0+day;
        }

        return (year + month + day) * 1;
    },

    "date-eu-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-eu-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('propform');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }   
        // Execute recaptcha
        // grecaptcha.execute();     
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

$(document).ready(function() {
    $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

    var table = $('#example').DataTable({
        language:{
            "url": "<?php echo $datatable_file; ?>"
        },
        "iDisplayLength": 10,
        /*'responsive': {
            'details': {
            'type': 'column',
            'target': 0
            }
        },*/
        'columnDefs': [
            {
                'data': null,
                'defaultContent': '',
                'className': 'control',
                'orderable': false,
                'targets': 0,
            }
        ],
        'columns': [
            { 'data': 0 },
            { 'data': 1 ,'type': 'date-eu'},
            { 'data': 2 }
        ],
        order: [1, 'desc'],
        'select': {
            'style': 'multi',
            'selector': 'td:not(.control)'
        }
    });

    $( "#dialog:ui-dialog" ).dialog( "destroy" );
			

});
    
<?php $this->Html->scriptEnd(); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="reservation_en_cours" class="reservation_en_cours container">
  <div class="row justify-content-between mb-5">
      <div class="col espace-menu">
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
        <?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
		<h3 class="border-bottom-menu-espace float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations") ?></a></h3>
        <?php }else{ ?>
		<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
		<?php } ?>
        <h3 class="float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
      </div>
      <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
      <div class="col-auto align-self-end">
        <h3 class="text-blue"><?= __("Espace") ?> <?php if($this->Session->read('Auth.User.nature')=='CLT') echo "Locataire"; else echo "Propriétaire";?></h3>
      </div>
	  <?php }?>
  </div>
  <div class="row">
    <div class="col-12 col-sm-4 col-md px-0">
      <a class="text-white btn-grey rounded-0 py-2 w-100 d-block text-decoration-none text-center" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations en attente") ?></a>
    </div>
    <div class="col-12 col-sm-4 col-md px-0">
        <a class="text-white btn-grey rounded-0 py-2 w-100 d-block text-decoration-none text-center py-2" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/view"><?= __("Réservations validées") ?></a>
    </div>
    <div class="col-12 col-sm-4 col-md px-0">
        <a class="text-white btn-blue rounded-0 py-2 w-100 d-block text-decoration-none text-center py-2" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/reservationcalendar"><?= __("Réservations Synchronisées") ?></a>
    </div>
    <div class="col pr-0 pl-0 pl-md-2  text-center text-md-right mt-3 mt-md-0">
    <a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_addres'];?>"><span class="btn text-white bg-orange px-5 px-md-3 px-lg-5"><?= __("Créer une réservation") ?></span></a>
    </div>
  </div>
            
    <?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>
    <div class="row mt-5">
        <div class="table-responsive">
                                
            <table id="example" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <!-- <th></th> -->
                        <th><?php echo __('Annonce ID');?></th> 
                        <th><?php echo __('Période');?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($reservations as $value) { ?>   
                    <tr>
                        <td><?php echo $value->annonce_id; ?></td>
                        <td><?php echo $value->dbt_at->i18nFormat('dd/MM/yy')." - ".$value->fin_at->i18nFormat('dd/MM/yy'); ?></td>
                        <td><?php echo "<div class='d-flex'><a href='".$this->Url->build('/',true)."reservations/editreservationcalendar/".$value->id."' title='Modifier' class='mr-3' style='cursor:pointer' src='".$this->Url->build('/',true)."images/edit.png'><i class='fa fa-edit fa-lg'></i></a></div>"; ?></td>
                    </tr>
                <?php } ?>
                </tbody>   
            </table>
        </div>
    </div>
</div>
