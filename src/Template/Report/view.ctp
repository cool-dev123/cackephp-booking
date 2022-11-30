<?php $this->start('cssTop'); ?>
    <style>
        .heading-bg {
            height: 100% !important;
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12 col-sm-12">
        <h5 class="txt-dark">Liste des événements</h5><br>
    </div>
    <div class="col-lg-12 col-sm-12">
        <input type="button" name="print" id="print" value="Imprimer" class="btn btn-primary" style="width:135px;" onclick="print_page();">
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <form name="search" method="post" action="" class="form-inline">
                                <div class="radio-inline pl-0">
                                        <span class="radio radio-primary">
                                            <input type="radio" name="day" id="day" value="Day"  checked="checked">
                                            <label for="day">Rapport de jour</label>
                                        </span>
                                </div>
                                <div class="radio-inline pl-0">
                                        <span class="radio radio-primary">
                                            <input type="radio" name="day" id="Week" value="Week" <?php if($radio=='Week'){ ?> checked="checked" <?php } ?>>
                                            <label for="Week">Rapport de la semaine</label>
                                        </span>
                                </div>
                                <input autocomplete="off" class="form-control date" type="text" id="start_date" name="start_date" value="<?php if(isset($_POST['start_date'])) { echo $_POST['start_date']; } else { echo date('d/m/Y'); } ?>" />
                                <input value="Chercher" type="submit" id="search" name="search" href="#" class="btn btn-primary">
                            </form>
                        </blockquote>
                    </div>
                    <div class="table-wrap" id="printable">
                        <div>
                            <table id="footable_1" class="table table-hover display" data-sorting="true">
                                <thead>
                                    <tr>
                                        <th>Gestionnaire</th>
                                        <th><?= __("Station") ?></th>
                                        <th>Résidence</th>
                                        <th>Propriétaire email</th>
                                        <th>Propriétaire nom</th>
                                        <th>Propriétaire prénom</th>
                                        <th>Locataire email</th>
                                        <th>Locataire nom</th>
                                        <th>Locataire prénom</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                        $count=0;
                                        if(!empty($pagecontent))
                                        {
                                             foreach($pagecontent as $event)
                                             {
                                                $count++;


                                    ?>
                                        <tr class="<?php if($count%2==0) { echo 'even'; } else {echo 'odd'; } ?>">
                                            <td><?php echo $event['gestionnaire']; ?></td>
                                            <td><?php echo $event['station']; ?></td>
                                            <td><?php echo $event['residence']; ?></td>
                                            <td><?php echo $event['email_proprio']; ?></td>
                                            <td><?php echo $event['nom_proprio']; ?></td>
                                            <td><?php echo $event['prenom_proprio']; ?></td>
                                            <td><?php echo $event['mail_locataire']; ?></td>
                                            <td><?php echo $event['nom_loc']; ?></td>
                                            <td><?php echo $event['prenom_loc']; ?></td>
                                        </tr>

                                    <?php } } else {?>

                                    <tr class="odd">
                                        <td colspan="9" align="center"><b>No Record Found</b></td>
                                    </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>
<!-- Data table JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>
                
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$( document ).ready(function() {
    $('#footable_1').DataTable({
            "paging": false,"searching": false,"info": false,"ordering": false,
            responsive: true,
            "language": language_data_table
        });
});
    
    function print_page()
    {
        //window.print();

        var prtContent = document.getElementById("printable");
        var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0, resizable=yes    ');
        WinPrint.document.write('<!DOCTYPE html>');
        WinPrint.document.write('<html><head><title></title>');
        //WinPrint.document.write('<link type="text/css" rel="stylesheet" href="<?php echo $this->Url->build('/',true);?>manager-arr/css/zice.style.css"/>');
        WinPrint.document.write('</head><body>');
        WinPrint.document.write('<p style="text-align: center; color: red; font-size: 25px; "> Liste des événements</p>');
        if($('#day').is(':checked')){
            WinPrint.document.write('<p>Rapport de jour '+$('#start_date').val()+'</p>');
        }
        if($('#Week').is(':checked')){
            WinPrint.document.write('<p>Rapport de la semaine '+$('#start_date').val()+'</p>');
        }
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.write('</body></html>');
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    }
    
    $("#start_date" ).datetimepicker({
                        useCurrent: false,
                        format: 'DD/MM/YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
<?php $this->Html->scriptEnd(); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<!-- Data table CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>