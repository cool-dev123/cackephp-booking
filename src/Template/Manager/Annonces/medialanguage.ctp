<?php $this->start('cssTop'); ?>
<style>
    @media screen and (max-width: 500px)  {
        .chart_for_mobile{
            height:  100px;
        }
    }
    @media screen and (max-width: 800px) and (min-width: 501px)  {
        .chart_for_mobile{
            height:  150px;
        }
        .chart_for_tablet{
            height: 300px;
        }
    }
    .txt-blue{
        color: #74B9FF !important;
    }
    .progress-bar-blue {
        background: #74B9FF !important;
    }
    .sorting_2 {
        background-color: transparent !important;
    }
    .progress {
        height: 12px !important;
    }
    .progress-bar {
        font-size: 11px !important;
        background-color: #0096ff !important;
    }
</style>
<?php $this->end(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php echo $this->element('menumultilingue'); ?>

<div class="row">
    <div class="col-sm-12">
	<div class="panel panel-default card-view ">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Multilingue liste média</h6>
                </div>
            </div>
            <div class="panel-wrapper collapse in">
		        <div class="panel-body">
                    <table id="datable_1" class="table table-hover display  pb-30" >
                        <thead>
                            <tr>
                                <th>Média</th>
                                <th>% traduit</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Média</th>
                                <th>% traduit</th>
                                <th>&nbsp;</th>
                            </tr>
                        </tfoot>
                        <tbody>

                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$(document).ready(function() {

    table=$('#datable_1').DataTable({
        responsive: true,
        order: [[ 0, 'asc' ]],
        "ajax":{
            "url": "<?= $this->Url->build('/',true)?>manager/annonces/allmediamultilingue",
        },
        "language": language_data_table
    });

});
    
<?php $this->Html->scriptEnd(); ?>