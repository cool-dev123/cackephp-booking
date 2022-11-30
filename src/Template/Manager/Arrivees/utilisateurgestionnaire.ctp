<?php $this->start('cssTop'); ?>
<style>
    button.label.label-danger {
        border: none;
    }
    td{
        padding-left: 0px !important;
        padding-right: 0px !important;
        text-align: center;
    }
    @media only screen and (min-width: 979px) and (max-width: 1698px) {
        td center button:first-of-type {
            margin-bottom: 3px;
        }
    }
    @media only screen and (max-width: 978px) {
        td center button:first-of-type {
            margin-right: 3px;
        }
    }
    @media only screen and (min-width: 1699px) {
        td center button:first-of-type {
            margin-right: 5px;
        }
    }
</style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Contacts</h5>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-8 col-sm-8 col-lg-offset-3 col-sm-offset-2 col-md-offset-2">
        <div class="panel panel-default border-panel card-view pt-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body text-center">
                        <div class="col-lg-7 col-md-7 col-sm-6 pr-0 ml-0 mr-0">
                            <h6 class="panel-title txt-black font-18">Nombre de Propriétaires</h6>
                            <h2 id="nbProps" class="text-success"></h2>
                            
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-2 mt-20 pr-0 ml-0 mr-0">
                            <a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/inscription/" class="btn mb-10 btn-sm btn-primary font-13">Inscription propriétaire</a>
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
                                                <th>Email</th>
                                                <th>Tél Mobile</th>
                                                <th>Tél Fixe</th>
                                                <th>Code Postal</th>
                                                <th>Ville</th>
                                                <th>&nbsp;</th>
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

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var table=null;
    function edite(id){
            $('body').loadingModal({
                position: 'auto',
                text: '',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'doubleBounce'
            });
            $('#modal-fiche-publicité-body').empty();
        $.ajax({
            async: true,
            type: "GET",
            url: "<?php echo $this->Url->build('/',true);?>manager/utilisateurs/ficheuser/"+id,

            success:function(xml){
                $('#modal-fiche-publicité-body').append(xml);
                $('body').loadingModal('destroy');
            },
        error: function(){
                        $('#myModal').modal('hide');
                        $('body').loadingModal('destroy');
                        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Erreur',
                            text: 'error chargement de l\'utilisateur',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 4000
                        });
                    }
            });
        $('body').loadingModal('destroy');
    }
        function valider(){
        $('body').loadingModal({
                        position: 'auto',
                        text: 'Modification en cours',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'doubleBounce'
                      });
        var b=false;
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
        var c=false;            
                    $.validator.addMethod("uniquePhone",
                    function(value, element) {
                        c=false;
                        $.ajax({
                            async : false,
                            type: "get",
                            url: "<?php echo $this->Url->build('/',true)?>/manager/utilisateurs/checkPhoneUnique/"+document.getElementById('id_user').value+"/"+value,

                            success:function(xml){
                              if (xml=='true'){c=true; }
                              }
                            });
                        return c;
                    },
                        "Ce Numéro de téléphone existe déjà."
                    );
                
                    $.validator.addMethod("Subdivision",
                    function(value, element) {
                        if(value=='CLT'||value=='ANNO')
                            return true;
                        else
                            return false;
                    },
                        "Choisir une subdivision valide"
                    );
                    $.validator.addMethod("non_vide",
                        function(value, element) {
                            if(value<=0)
                                return false;
                            else
                                return true;
                        },
                            "Ce champ est obligatoire."
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
                                    nom_famille: "required",
                                    email: {
                                        required: true,
                                        email: true,
                                        uniqueEmail: true
                                    },
                                    portable: {
                                        required: true,
                                        uniquePhone: true
                                    },
                                    type:{
                                        Subdivision:true
                                    },
                                    pays:{
                                        min:1,
                                    },
                                    ville:{
                                        min:1,  
                                    },
                                    code_postal:{
                                        required:true
                                    }
                                    
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
                        data:{vId:$('#id_user').val(),vPrenom:$('#prenom').val(),vNom:$('#nom_famille').val(),vType:$('#type').val(),vTel:$('#telephone').val(),vPortable:$('#portable').val(),vAdres:$('#adresse').val(),vEmail:$('#email').val(),vPassword:$('#password').val(),vPostal:$('#code_postal').val(),vVille:$('#ville').val(),vPays:$('#pays').val(),vRegion:$('#region').val()},
                        success:function(xml){
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
                                $('body').loadingModal('destroy');
                                },
                        error:function(){
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
                            $('body').loadingModal('destroy');
                        }
                    });
                  }else{
                    $('body').loadingModal('destroy');
                    return false;
                  }
                }
                else{
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
                          //alert(xml)
                            swal("", "Vous venez de supprimer un utilisateur", "success");
                            table.ajax.reload();
                          }
                        }); 
                    });
            });
            
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
            // buttons: [
            //     {
            //        extend : 'pdfHtml5',
            //        title : function() {
            //            return 'Liste d\'utilisateurs';
            //        },
            //        orientation : 'landscape',
            //        pageSize : 'LEGAL',
            //        text : '<i class="fa fa-file-pdf-o"> PDF</i>',
            //        titleAttr : 'PDF'
            //    } ,
            //     {
            //         extend: 'csv',
            //         title : 'Liste d\'utilisateurs'
            //     },
            //     {
            //         extend: 'excel',
            //         title : 'Liste d\'utilisateurs'
            //     }, 
            //     {
            //         extend: 'print',
            //         text : '<i class="icon-printer"> Imprimer</i>',
            //         title : 'Liste d\'utilisateurs'
            //     }
            // ],
            buttons: [],
            "ajax": {
                'url': "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/jsonutilisateurgestionnaire/",
                complete: function(response) {
                    $('#nbProps').html(response.responseJSON.iTotalRecords);
                    $('#main-container').loadingModal('destroy');
                },
            },
            "drawCallback" : function() {
                $('body').loadingModal('destroy');
            },
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "language": language_data_table
        });
            "use strict";
	
	var SweetAlert = function() {};

    //examples 
    SweetAlert.prototype.init = function() {

    },
    //init
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert;
	
	$.SweetAlert.init();
              
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