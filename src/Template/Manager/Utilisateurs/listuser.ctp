<?php $this->start('cssTop'); ?>
<style>
    button.label.label-danger {
        border: none;
    }
    td{
        padding-left: 1px !important;
        padding-right: 1px !important;
    }
    th{
        text-align: center !important;
    }
    @media only screen and (max-width: 767px) {
        .hide_for_mobile{display: none !important;}
    }
    @media only screen and (min-width: 768px) {
        .hide_for_mobile{display: block !important;}
    }
/*    .jquery-loading-modal.jquery-loading-modal--visible {
    top: 9% !important;
}*/
</style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Contacts</h5>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-lg-offset-2">
        <div class="panel panel-default border-panel card-view pt-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body text-center">
                        <div class="col-lg-8 mr-0 pr-0 ml-0 mr-0">
                            <h6 class="panel-title txt-dark icantSelectIt">Nombre de propriétaires</h6>
                            <h2 id="nbProps" class="text-success"></h2>
                        </div>
                        <div class="hide_for_mobile col-lg-4 mr-0 pr-0 ml-0 mr-0">
                            <span id="pie_chart_1" class="easypiechart skill-circle skill-circle-fill" data-percent="86">
                                    <span class="percent head-font"></span>
                            </span>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <div class="panel panel-default border-panel card-view pt-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body text-center">
                        <div class="col-lg-8 mr-0 pr-0 ml-0 mr-0">
                            <h6 class="panel-title txt-dark icantSelectIt">Nombre de locataires</h6>
                            <h2 id="nbLocs" class="text-success"></h2>
                        </div>
                        <div class="hide_for_mobile col-lg-4 mr-0 pr-0 ml-0 mr-0">
                            <span id="pie_chart_2" class="easypiechart skill-circle skill-circle-fill" data-percent="86">
                                    <span class="percent head-font"></span>
                            </span>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-heading ml-0 mr-0 pl-0 pr-0 icantSelectIt">
                        <div class="pull-left">
                                <h6 class="panel-title txt-dark">Liste des contacts</h6>
                        </div>
                        <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                                <th>Prénom</th>
                                                <th>Nom de famille</th>
                                                <th>Type</th>
                                                <th>Mail validé</th>
                                                <th width="15%" >Email</th>
                                                <th>Tél Mobile</th>
                                                <th>Tél Fixe</th>
                                                <th>Code Postal</th>
                                                <th>Ville</th>
                                                <th width="8%"></th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>Prénom</th>
                                                <th>Nom de famille</th>
                                                <th>Type</th>
                                                <th>Mail validé</th>
                                                <th>Email</th>
                                                <th>Tél Mobile</th>
                                                <th>Tél Fixe</th>
                                                <th>Code Postal</th>
                                                <th>Ville</th>
                                                <th width="8%"></th>
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
    </div>
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title" id="myModalLabel">Fiche Utilisateur</h5>
            </div>
            <div id="modal-fiche-publicité-body" class="modal-body">
                <!-- this content loaded by jquery -->
            </div>
            <div class="modal-footer">
                    
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.flash.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jszip/dist/jszip.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/pdfmake/build/pdfmake.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/pdfmake/build/vfs_fonts.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Progressbar Animation JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    $(document).on('click', ".delete_station", function () {
                    var id = $(this).attr("data-key");
                    swal({
                        title: "Suppression d\'un utilisateur",   
                        text: "Êtes-vous sûr de vouloir supprimer cet utilisateur ?",   
                        type: "warning",   
                        showCancelButton: true,   
                        confirmButtonColor: "#e6b034",   
                        confirmButtonText: "OK",
                        cancelButtonText: "ANNULER",  
                        closeOnConfirm: false 
                        }, function(){
                        $('body').loadingModal({
                            position: 'auto',
                            text: 'Suppression en cours',
                            color: '#fff',
                            opacity: '0.7',
                            backgroundColor: 'rgb(0,0,0)',
                            animation: 'doubleBounce'
                          });
                        $.ajax({
                        type: "delete",
                        url: "<?php echo $this->Url->build('/',true)?>/manager/utilisateurs/deleteuser/"+id,

                        success:function(xml){
                            $('body').loadingModal('destroy');
                            swal("", "Vous venez de supprimer un utilisateur", "success");
                            table.ajax.reload();
                          },error: function(){
                                $('body').loadingModal('destroy');
                                $.toast().reset('all');
                                        $("body").removeAttr('class');
                                        $.toast({
                                            heading: 'Erreur',
                                            text: '',
                                            position: 'bottom-right',
                                            loaderBg:'#fec107',
                                            icon: 'error',
                                            hideAfter: 4000
                                        });
                            }
                        }); 
                    });
    });
    var table=null;
    function edite(id){
        $('#modal-fiche-publicité-body').empty();
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        $.ajax({
            type: "GET",
            url: "<?php echo $this->Url->build('/',true);?>manager/utilisateurs/ficheuser/"+id,

            success:function(xml){
                $('#modal-fiche-publicité-body').append(xml);
                $('body').loadingModal('destroy');
            },error: function(){
                $('#myModal').modal('hide');
                $('body').loadingModal('destroy');
                $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Erreur',
                            text: 'erreur chargement de popup',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 4000
                        });
            }
            });
    }
        function valider(){
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        var b=false;
        var c=false;
                    $.validator.addMethod("uniqueEmail",
                    function(value, element) {
                        b=false;
                        $.ajax({
                            async : false,
                            type: "get",
                            url: "<?php echo $this->Url->build('/',true)?>/manager/utilisateurs/checkEmailUnique/"+document.getElementById('id_user').value+"/"+value,

                            success:function(xml){
                              if (xml=='true'){b=true; }
                              }
                            });
                        return b;
                    },
                        "Email existe déjà."
                    );
                    
                    $.validator.addMethod("uniquePhone",
                    function(value, element) {
                    c=false;
                        $.ajax({
                            async : false,
                            type: "get",
                            url: "<?php echo $this->Url->build('/',true)?>/manager/utilisateurs/checkPhoneUnique/"+document.getElementById('id_user').value+"/"+value,

                            success:function(xml){
                            console.log(xml);
                              if (xml=='true'){c=true; }
                              }
                            });
                        return c;
                    },
                        "Ce Numéro de téléphone existe déjà."
                    );
                    $.validator.addMethod("Subdivision",
                    function(value, element) {
                        if(value=='CLT'||value=='ANNO'||value=='PRES')
                            return true;
                        else
                            return false;
                    },
                        "Choisir une subdivision valide"
                    );
                    
                    $("#test_form").validate({
                        onkeyup: false,
                                errorPlacement: function(error, element) {
                                    if (element.attr("name") == "portable" )
                                        error.insertAfter("#error-msg");
                                    else
                                        error.insertAfter(element);
                                },
                                rules: {
                                    prenom: "required",                                     
                                    nom_famille: "required",
                                    email: {
                                            required: true,
                                            email: true,
                                            uniqueEmail: true
                                    },
                                    portable: {
                                            required: true,
                                            // uniquePhone: true

                                    },
                                    type:{
                                        Subdivision:true
                                    },
                                    pays:{
                                        min:1,
                                    },
                                    // ville:{
                                    //     min:1,  
                                    // },
                                    // code_postal:{
                                    //     required:true
                                    // }
                                },
                                messages: {
                                    pays: "Ce champ est obligatoire.",
                                    ville: "Ce champ est obligatoire."
                                }
                         });
                         var test = '';
                  var telInputrestel = $("#telephone");
                  var errorMsggtel = $("#error-msg-tel");

                  if ($.trim(telInputrestel.val())) {
                    if (telInputrestel.intlTelInput("isValidNumber")) {
                      validNum = telInputrestel.intlTelInput("getNumber");
                      $("#telephone").val(validNum);
                    } else {
                      test = "non";
                      validNum = "non";
                      telInputrestel.addClass("errorNumberTel");
                      errorMsggtel.removeClass("hide");
                      errorMsggtel.addClass("errorNumberTel");
                    }
                  }
                  var telInputport = $("#portable"),
                    errorMsgport = $("#error-msg");
                    if ($.trim(telInputport.val())) {
                      if (telInputport.intlTelInput("isValidNumber")) {
                        validNum = telInputport.intlTelInput("getNumber");
                        $("#portable").val(validNum);
                      } else {
                        test = "non";
                        validNum = "non";
                        telInputport.addClass("errorNumberTel");
                        errorMsgport.removeClass("hide");
                        errorMsgport.addClass("errorNumberTel");
                      }
                    }

                if($("#test_form").valid()){
                  if(test == ''){
                    $.ajax({
                        async: true,
                        type: "POST",
                        url: "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/edituser/",
                        data:{vId:$('#id_user').val(),vPrenom:$('#prenom').val(),vDescription:$('#description').val(),vNom:$('#nom_famille').val(),vType:$('#type').val(),vTel:$('#telephone').val(),vPortable:$('#portable').val(),vAdres:$('#adresse').val(),vEmail:$('#email').val(),vPassword:$('#password').val(),vPostal:$('#code_postal').val(),vVille:$('#ville').val(),vPays:$('#pays').val(),vRegion:$('#region').val()},
                        success:function(xml){
                                        $('body').loadingModal('destroy');
                                        $('#myModal').modal('hide');
                                        table.ajax.reload();
                                        $.toast().reset('all');
                                        $("body").removeAttr('class');
                                        xml=='editmail'?text='Un email de confirmation a été envoyé':text='';
                                        $.toast({
                                            heading: 'Vous avez modifié un utilisateur',
                                            text: text,
                                            position: 'bottom-right',
                                            loaderBg:'#fec107',
                                            icon: 'success',
                                            hideAfter: 9000
                                        });

                                },error: function(){
                        $('body').loadingModal('destroy');
                        $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'Erreur',
                                    text: 'erreur lors modification de l\'utilisateur',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'error',
                                    hideAfter: 4000
                                });
                    }
                    });
                  }else{
                    $('body').loadingModal('destroy');
                    return false;
                  }
                }else{
                    $('body').loadingModal('destroy');
                }
                  
        }
        
        
    $(document).ready(function() {
    
        $('#main-container').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        $(".jquery-loading-modal").css('top', $(".navbar-inverse").height());
    
            table = $('#datable_1').DataTable({
                "columnDefs": [
                    {
                        // The `data` parameter refers to the data for the cell (defined by the
                        // `data` option, which defaults to the column being worked with, in
                        // this case `data: 0`.
                        /*"render": function ( data, type, row ) {
                            if(data == '' || data == null)
                                return data;
                            else{
                                data=data.replace(" ","");
                                if(data[0]=='+')
                                {
                                    var i = 1;
                                    var str='+';
                                }
                                else
                                {
                                    var i = 0;
                                    var str='';
                                }
                                for(i;i<data.length;i=i+2){
                                    if(data[i+1])
                                        str=str+' '+data[i]+data[i+1]
                                    else 
                                        str=str+' '+data[i]
                                }
                            }
                            return '<center>'+str+'</center>'
                        },*/
                        "width": "15%",
                        "targets": [5,6]
                    },
                    {
                        "width": "5%",
                        "targets": [0,1]
                    },
                    {
                        "width": "10%",
                        "targets": 4
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        title : 'Liste d\'utilisateurs'
                    },
                    {
                        extend: 'excel',
                        title : 'Liste d\'utilisateurs'
                    }, 
                    {
                        extend: "print",
                        title : 'Liste d\'utilisateurs',
                        customize: function(win)
                        {

                            var last = null;
                            var current = null;
                            var bod = [];

                            var css = '@page { size: landscape; }',
                                head = win.document.head || win.document.getElementsByTagName('head')[0],
                                style = win.document.createElement('style');

                            style.type = 'text/css';
                            style.media = 'print';

                            if (style.styleSheet)
                            {
                              style.styleSheet.cssText = css;
                            }
                            else
                            {
                              style.appendChild(win.document.createTextNode(css));
                            }

                            head.appendChild(style);
                     }
                  },
                ],
                responsive: true,
                "ajax": {
                    'url': "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/jsonutilisateur/",
                    complete: function(response) {
                        $('#nbProps').html(response.responseJSON.nbProps);
                        $('#nbLocs').html(response.responseJSON.nbLocs);
                        $('#pie_chart_1').attr('data-percent', response.responseJSON.nbProps*100/response.responseJSON.iTotalRecords )
                        if( $('#pie_chart_1').length > 0 ){
                                $('#pie_chart_1').easyPieChart({
                                        barColor : '#71aa68',
                                        lineWidth: 2,
                                        animate: 3000,
                                        size:	100,
                                        lineCap: 'square',
                                        scaleColor:false,
                                        trackColor: false,
                                        onStep: function(from, to, percent) {
                                                $(this.el).find('.percent').text(Math.round(percent));
                                        }
                                });
                        }
                        $('#pie_chart_2').attr('data-percent', response.responseJSON.nbLocs*100/response.responseJSON.iTotalRecords )
                        if( $('#pie_chart_2').length > 0 ){
                                $('#pie_chart_2').easyPieChart({
                                        barColor : '#71aa68',
                                        lineWidth: 2,
                                        animate: 3000,
                                        size:	100,
                                        lineCap: 'square',
                                        scaleColor:false,
                                        trackColor: false,
                                        onStep: function(from, to, percent) {
                                                $(this.el).find('.percent').text(Math.round(percent));
                                        }
                                });
                        }
                        $('#main-container').loadingModal('destroy');
                    },
                },
                "fnDrawCallback" : function() {
                    $('body').loadingModal('destroy');
                },
                "language": language_data_table
            });
              
    } );

function validermailuser(id){
    swal({
        title: "Activation d\'un utilisateur",   
        text: "Êtes-vous sûr de vouloir activer cet utilisateur ?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#e6b034",   
        confirmButtonText: "OK",
        cancelButtonText: "ANNULER",  
        closeOnConfirm: false 
        }, function(){
        $('body').loadingModal({
            position: 'auto',
            text: 'Activation en cours',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
            });
        $.ajax({
        type: "delete",
        url: "<?php echo $this->Url->build('/',true)?>/manager/utilisateurs/activermailuser/"+id,
        success:function(xml){
            $('body').loadingModal('destroy');
            swal("", "Vous venez d'activer un utilisateur", "success");
            table.ajax.reload();
            },error: function(){
                $('body').loadingModal('destroy');
                $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Erreur',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 4000
                        });
            }
        }); 
    });
}
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>