<?php $this->start('cssTop'); ?>
    <style type="text/css">

            .ui-dialog .ui-dialog-titlebar-close span {
                display: block !important;
                margin: -6px !important;
            }
            ul.no-bullet {
                display: flex;
            }
            .no-bullet li{
                    margin-right: 35px;
            }

            /*.morecontent span {
            display: none;
            }

            .morelink {
                display: block;
            }*/
            .fc-more-popover{
                top: auto !important;
                bottom: 0;
            }
            .heading-bg {
                height: 100% !important;
            }
            .btn-sm{
                padding-right: 2px !important;
                padding-left: 2px !important;
            }
            @media only screen and (max-width: 450px) {
                .fc .fc-toolbar > .fc-right > * {
                    margin-left: 0px !important;
                }
            }
            @media only screen and (max-width: 649px) {
                .fc .fc-toolbar > .fc-right > * {
                    margin-top: 5px !important;
                }
            }
            
    </style>
<?php $this->end(); ?>
    
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-9 col-sm-9 col-xs-12">
      <h5 class="txt-dark">Consulter Calendrier</h5>
    </div>
    <div class="col-lg-3 col-sm-3">
        <a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/stations/" class="btn  btn-primary pull-right">Dates de ma station</a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 mb-30">
                            <?php echo $this->Form->create(null,[
                                                                    'url' => ['controller' => 'Report', 'action' => 'view'],
                                                                    'class' => 'form-inline'
                                                                ]); ?>
                            <form name="search" method="post" action="" class="form-inline">
                                <div class="radio-inline pl-0 pr-0">
                                        <span class="radio radio-primary">
                                            <input type="radio" name="day" id="day" value="Day" checked="checked">
                                            <label for="day">Rapport de jour</label>
                                        </span>
                                </div>
                                <div class="radio-inline ml-0 pl-0 pr-0">
                                        <span class="radio radio-primary">
                                            <input type="radio" name="day" id="Week" value="Week">
                                            <label for="Week">Rapport de la semaine</label>
                                        </span>
                                </div>
                                <div class="input-group">
                                        <input autocomplete="off" class="form-control date" type="text" id="start_date" name="start_date">
                                        <span class="input-group-btn">
                                        <input value="Chercher" type="submit" id="search" name="search" href="#" class="btn btn-primary">
                                        </span> 
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="actions row ml-5">
                              <!--  <li><?= $this->Html->link(__('Add an Event', true), ['controller' => 'events', 'action' => 'add']) ?></li>
                                    <li><?= $this->Html->link(__('Download ics', true), ['controller' => 'events', 'action' => 'download']) ?></li>
                                    <li><?= $this->Html->link(__('Manage Events', true), ['controller' => 'events']) ?></li>
                                    <li><?= $this->Html->link(__('Manage Events Types', true), ['controller' => 'event_types']) ?></li>
                                    </li> -->
                        <button href="#" onclick="window.location.href='<?php echo $this->Url->build('/',true);?>events/download'" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right">Télécharger fichier ics</button>
                        <button href="#" onclick="javascript:cal.download('Réservations')" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right">Export Pour GoogleCalendar</button>
                    </div>
                    <br><br>
                    <div class="Calendar index row">
                        <div class="col-sm-12" id="calendar"></div>
                    </div>

                    <!-- sample modal content -->
                    <div id="eventContent" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                    <div class="modal-content">
                                            <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h5 class="modal-title" id="myModalLabel"></h5>
                                            </div>
                                            <div class="modal-body" id="event_details">
                                            </div>
                                            <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                            </div>
                                    </div>
                                    <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <!-- Popup Ends -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->css("/manager-arr/vendors/bower_components/fullcalendar/dist/fullcalendar.css", array('block' => 'cssTop')); ?>
<?= $this->Html->css('/full_calendar/css/jquery.qtip.min', ['plugin' => true,'block' => 'scriptBottom']); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<?= $this->Html->script('/full_calendar/js/icaldownload.min.js', ['plugin' => true,'block' => 'scriptBottom']); ?>
<?= $this->Html->script('/manager-arr/vendors/bower_components/moment/min/moment.min.js', ['plugin' => true,'block' => 'scriptBottom']); ?>
<?= $this->Html->script('/manager-arr/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js', ['plugin' => true,'block' => 'scriptBottom']); ?>
<?= $this->Html->script('/full_calendar/js/lang/fr.js', ['plugin' => true,'block' => 'scriptBottom']); ?>
<?= $this->Html->script('/manager-arr/vendors/jquery-ui.min.js', ['plugin' => true,'block' => 'scriptBottom']); ?>
<?= $this->Html->script('/full_calendar/js/ready.js', ['plugin' => true,'block' => 'scriptBottom']); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$("#start_date" ).datetimepicker({
                useCurrent: false,
                format: 'DD/MM/YYYY',
                defaultDate: new Date(),
                icons: {
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            });
$( document ).ready(function() {          
    $('.fc-right').append($('.actions').children());
});
<?php $this->Html->scriptEnd(); ?>
