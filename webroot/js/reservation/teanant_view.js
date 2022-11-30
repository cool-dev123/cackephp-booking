const MAIN_URL = BASE_URL + "reservations/";

const tenantView = {
    timerInterval: 60000,
    selectedReservationId: 0,
    startDate:  null,
    endDate: null,
    __init: function() {
        const self = this;

        setTimeout(function() {
            self.processTimer();

            setInterval(function () {
                self.processTimer();
            }, self.timerInterval);
        }, self.timerInterval);

        self.initEvents();

        if (selectedReservationId) {
            window.history.pushState( {} , '', window.location.origin + window.location.pathname);
            self.openDetails(selectedReservationId);
            const element = document.getElementById(selectedReservationId);

            if (element) {
                element.scrollIntoView();
            }
        }
    },
    setDatepickerPos: function (input, inst) {
        var rect = input.getBoundingClientRect();
        // use 'setTimeout' to prevent effect overridden by other scripts
        setTimeout(function () {
            var scrollTop = $("body").scrollTop();
            inst.dpDiv.css({ top: rect.top + input.offsetHeight + scrollTop });
        }, 0);
    },
    initEvents: function() {
        const self = this;

        $('.reservations_row .see-details-btn').off('click').on('click', function() {
            self.openDetails($(this).closest('.reservations_row').attr('id'));
        });

        $('.reservations_row .send-message-btn').off('click').on('click', function() {
            self.sendMsg($(this).closest('.reservations_row').attr('id'));
        });

        $('input[name="justificatif"]').off('click').on('click', function(){
            if($(this).val() == 0) {
                $("#divJustification").addClass("hidden");
                $("#divSansJustification").removeClass("hidden");
                var fnDiff = moment($("#dbtreservation").val(), "DD-MM-YYYY");
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1;
                var yyyy = today.getFullYear();
                if(dd < 10) {
                    dd='0' + dd;
                }

                if(mm < 10) {
                    mm='0'+mm;
                }
                today = dd+'-'+mm+'-'+yyyy;
                var dbtDiff = moment(today, "DD-MM-YYYY");
                var Diff = fnDiff.diff(dbtDiff, 'days');

                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    url: BASE_URL + "dispos/calculertotalprixperiodebyidreservation",
                    data: { id_reservation: self.selectedReservationId },
                    success:function(xml){
                        nbrjour = 0;
                        $.each(xml.resultatDetail['nbrsejour'], function(index, value) {
                            nbrjour = nbrjour + value;
                        });
                        var prixTotal = (xml.resultatDetail['total']).toFixed(2);
                        var taxeDeSejour = (xml.resultatDetail['prixtaxeapayer']).toFixed(2);

                        var fraisAlpissime = (xml.resultatDetail['total']/100 * 10.6);
                        var fraisStripe = (xml.resultatDetail['total']/100 * 1.4);
                        var fraisService = (fraisAlpissime + fraisStripe).toFixed(2);

                        var msgSansJustif = "";
                        var msgSansJustifp1 = "";
                        var msgSansJustifp2 = "";
                        var totalPrixPayer;
                        var tauxcommission = 3;

                        if(xml.tauxcommissionprop != 0) tauxcommission = xml.tauxcommissionprop;
                        $.each(xml.listeannulation, function(index, value) {
                            if((value.interval_1 == 0 && Diff <= value.interval_2) || (value.interval_2 == 100 && Diff >= value.interval_1) || (Diff >= value.interval_1 && Diff <= value.interval_2)){
                                totalPrixPayer = (((parseFloat(prixTotal)/100)*(100-value.reservation_pourc)) + (parseFloat(taxeDeSejour))).toFixed(2);
                                if(value.reservation_pourc == 100) msgSansJustifp1 = noRefundRentalAmountTxt;
                                else msgSansJustifp1 = "<p>" + reimbursementTxt + (100-value.reservation_pourc)+"% " + amountOfTheRentalTxt;
                                // if(value.service_pourc == 0) msgSansJustifp2 = "et aucun remboursement pour les frais de service.";
                                // else msgSansJustifp2 = "et de "+value.service_pourc+"% des frais de service.</p>";
                                msgSansJustifp2 = refund100PercentTxt;
                                msgSansJustif = msgSansJustifp1+msgSansJustifp2+"<p>" + reimbursementTxt+" : "+totalPrixPayer+" €</p>";
                                montantProp = ((parseFloat(prixTotal)/100)*(value.reservation_pourc)).toFixed(2) - ((parseFloat(prixTotal)/100)*tauxcommission).toFixed(2);
                                $("#inputMontantProp").val(montantProp);
                            }
                        });

                        if(msgSansJustif == ""){
                            if(Diff > 30){
                                totalPrixPayer = (parseFloat(prixTotal) + parseFloat(taxeDeSejour)).toFixed(2);
                                msgSansJustif = "<p>" + noRefundTxt + "</p><p>" + reimbursementTxt + " : "+totalPrixPayer+" €</p>";
                                $("#inputMailSansJustification").val("annulationreservationlocMois");
                                montantProp = 0;
                                $("#inputMontantProp").val(montantProp);
                            }else if(Diff >= 7 && Diff <= 30){
                                totalPrixPayer = ((parseFloat(prixTotal)/2) + parseFloat(taxeDeSejour)).toFixed(2);
                                msgSansJustif = "<p>" + refundOf50Txt + "</p><p>" + reimbursementTxt + " : "+totalPrixPayer+" €</p>";
                                $("#inputMailSansJustification").val("annulationreservationlocSemaineMois");
                                montantProp = ((parseFloat(prixTotal)/2) - ((parseFloat(prixTotal)/100)*tauxcommission)).toFixed(2);
                                $("#inputMontantProp").val(montantProp);
                            }else if(Diff < 7){
                                totalPrixPayer = taxeDeSejour;
                                msgSansJustif = "<p>" + noRefundRentalAmountAndServiceTxt + "</p><p>" + totalRefundTxt + " : "+totalPrixPayer+" €</p>";
                                $("#inputMailSansJustification").val("annulationreservationlocSemaine");
                                montantProp = (parseFloat(prixTotal) - ((parseFloat(prixTotal)/100)*tauxcommission)).toFixed(2);
                                $("#inputMontantProp").val(montantProp);
                            }
                        }

                        $("#divSansJustification").html(msgSansJustif);
                        $("#prixremboursement").val(totalPrixPayer);
                    }
                });


            } else {
                $("#formjustificatif")[0].reset();
                $(this).attr("checked", "checked");
                $("#divJustification").removeClass("hidden");
                $("#divSansJustification").empty().addClass("hidden");
                $("#prixremboursement").val('');
            }
        });
    },
    initModalEvents: function() {
        const self = this;
        const modal = $('#reservation-details');
        const minDate = modal.find("#from").val();
        const maxDate = modal.find("#end").val();

        const [day, month, year] = minDate.split('/');
        const mindate =  new Date(+year, month - 1, +day);
        mindate.setDate(mindate.getDate() + 1);

        const [day1, month1, year1] = maxDate.split('/');
        const maxdate =  new Date(+year1, month1 - 1, +day1);
        maxdate.setDate(maxdate.getDate() - 1);

        modal.find("#from").datepicker({
            dateFormat: "dd/mm/yy",
            minDate: minDate,
            maxDate: maxdate,
            onSelect: function(dateText) {
                self.openDateConfirmed(true);
                self.startDate = dateText;
                self.endDate = maxDate;
            },
            beforeShow: function(input, inst) {
                self.setDatepickerPos(input, inst);
            },
        });
        modal.find("#end").datepicker({
            dateFormat: "dd/mm/yy",
            minDate: mindate,
            maxDate: maxDate,
            onSelect: function(dateText) {
                self.openDateConfirmed();
                self.startDate = minDate;
                self.endDate = dateText;
            },
            beforeShow: function(input, inst) {
                self.setDatepickerPos(input, inst);
            },
        });

        modal.on('hidden.bs.modal', function () {
            self.selectedReservationId = 0;
        });

        modal.find('#upload_inventory').off('submit').on('submit', function(e) {
            e.preventDefault();
            self.uploadInventoryFile(this);
        });

        modal.find('#inventory_file').off('change').on('change', function() {
            modal.find('#upload_inventory').submit();
        });

        modal.find('#upload_inventory_btn').off('click').on('click', function() {
            modal.find('#inventory_file').val('').trigger('click');
        });

        modal.find('.send-message-btn').off('click').on('click', function() {
            self.sendMsg();
        });

        modal.find('.add-comment-btn').off('click').on('click', function() {
            self.addComment();
        });

        $('#comment_filed').off('keydown').on('keydown', function (e) {
            if (e.keyCode == 13) {
                self.addComment();
            }
        });

        modal.find('.cancel-reservation-btn').off('click').on('click', function() {
            if ($(this).attr('data-type') === 'pending') {
                self.openDeletePending();
            } else {
                self.openDeleteConfirmed($(this).attr('data-start_date'));
            }

        });

        $('.delete-confirmation-modal .confirm-delete-btn').off('click').on('click', function() {
            if ($(this).attr('data-type') === 'pending') {
                self.deletePending();
            } else {
                self.deleteConfirmed();
            }
        });

        $('#delete_pending').on('hidden.bs.modal', function () {
            if (($("#reservation-details").data('bs.modal') || {})._isShown) {
                $('body').addClass('modal-open');
            }
        });

        $('#delete_confirmed').on('hidden.bs.modal', function () {
            if (($("#reservation-details").data('bs.modal') || {})._isShown) {
                $('body').addClass('modal-open');
            }
            self.resetDeleteConfirmedModal();
        });
        $('#date_confirmed').on('hidden.bs.modal', function () {
            self.resetDetailsModal();
        });

        $('.date-confirmation-modal .confirm-date-btn').off('click').on('click', function() {
            if ($(this).attr('data-type') === 'pending') {
                self.datePending();
            } else {
                self.dateConfirmed();
            }
        });

    },
    openDetails: function(id) {
        const self = this;
        const modal = $('#reservation-details');

        $.ajax({
            type: "POST",
            url: MAIN_URL + "get_reservation_locataire",
            data: {id : id},
            success:function(html){
                self.selectedReservationId = id;
                modal.find('.modal-body').html(html);
                self.initModalEvents();
                modal.modal('show');
            }
        });
    },
    processTimer: function() {
        const self = this;
        const pendingSection = $(".reservation_container[data-group='pending']");

        pendingSection.find('.description-timer').each(function(i, elem) {
            let hrsSection = $(elem).find('.remained-hrs');
            let minsSection = $(elem).find('.remained-mins');
            let currentHrs = +hrsSection.text();
            console.log("currentHrs = ",currentHrs)
            let currentMins = +minsSection.text();
            let newMinutes = --currentMins;

            if (newMinutes === 0) {
                hrsSection.text(--currentHrs);
                newMinutes = 59;
            }

            minsSection.text(newMinutes);
        });
    },
    sendMsg: function(resId) {
        const self = this;
        let idres = resId || self.selectedReservationId;

        $.ajax({
            type: "POST",
            dataType : 'json',
            url: MAIN_URL + "sendmessagefromreservation",
            data: {id : idres},
            success:function(xml){
                if (xml.redirect_url) {
                    window.location.href = xml.redirect_url;
                } else {
                    $("#idUser").val(xml.utilisateur_id);
                    $('#id').val(xml.id);
                    $('#dbt_msg').val(xml.dbt_msg);
                    $('#reservation_id').val(idres);
                    $('#fin_msg').val(xml.fin_msg);
                    $('#nbCouchage_ad_msg').val(xml.nbCouchage_ad_msg);
                    $('#nbCouchage_enf_msg').val(xml.nbCouchage_enf_msg);
                    $('#msgerrorphone').addClass('d-none');
                    $('#send_message').modal('show');
                    // Execute recaptcha
                    // grecaptcha.execute();
                }
            }
        });
    },
    openDeleteConfirmed: function(dbt) {
        $('#dbtreservation').val(dbt);
        $("#formjustificatif")[0].reset();
        $('#delete_confirmed').modal('show');
    },
    deleteConfirmed: function() {
        const self = this;
        let validated = true;

        if (!$("input[name='justificatif']:checked").val()) {
            $("#justificatifobligatoire").removeClass("hidden");
            validated = false;
        }

        if ($('input:radio[name="justificatif"]:checked').val() == 1) {
            $("#justificatifobligatoire").addClass("hidden");

            if ($('input[name="justificatif"]').val() == 1) {
                if (!$("input[name='motif']:checked").val()) {
                    $("#motifobligatoire").removeClass("hidden");
                    validated = false;
                } else {
                    $("#motifobligatoire").addClass("hidden");
                }

                if ($('input[name="fileJustificatif"]').val() == "") {
                    $("#fileobligatoire").removeClass("hidden");
                    validated = false;
                } else {
                    $("#fileobligatoire").addClass("hidden");
                }

                if ($('#commentaire').val() == "") {
                    $("#commentaireobligatoire").removeClass("hidden");
                    validated = false;
                } else {
                    $("#commentaireobligatoire").addClass("hidden");
                }
            }
        } else {
            $("#motifobligatoire").addClass("hidden");
            $("#fileobligatoire").addClass("hidden");
            $("#commentaireobligatoire").addClass("hidden");
        }

        if (validated) {
            let formData = new FormData($("#formjustificatif")[0]);

            $.ajax({
                async: false,
                type: "POST",
                processData: false,
                contentType: false,
                url: MAIN_URL + "deletereservationlocatairejustif/" + self.selectedReservationId,
                data: formData,
                success:function(xml){
                    self.resetDeleteConfirmedModal();
                    $('#delete_confirmed').modal( "hide" );
                    location.reload();
                }
            });
        }
    },
    resetDeleteConfirmedModal: function() {
        $("#formjustificatif")[0].reset();
        $("#divJustification").addClass("hidden");
        $("#divSansJustification").empty().addClass("hidden");
        $("#motifobligatoire").addClass("hidden");
        $("#fileobligatoire").addClass("hidden");
        $("#commentaireobligatoire").addClass("hidden");
        $("#prixremboursement").val('');
        $('input[name="justificatif"]').removeAttr('checked');
    },
    openDeletePending: function(id) {
        $('#delete_pending').modal('show');
    },
    deletePending: function() {
        const self = this;

        $.ajax({
            async: false,
            type: "POST",
            url: MAIN_URL + "deletereservationlocataire/" + self.selectedReservationId,
            success:function(xml){
                $('#delete_pending').modal( "hide" );
                location.reload();
            }
        });
    },
    addComment: function() {
        const self = this;
        const field = $('#comment_filed');
        const existingCommentfield = $('#existing_comment');
        const alertSuccess = $('.alert-success');
        const alertDanger = $('.alert-danger');
        const txt = field.val().trim();

        if (txt && txt != existingCommentfield.val()) {
            $.ajax({
                async: false,
                type: "POST",
                url: MAIN_URL + "addReservationComment/" + self.selectedReservationId,
                data: {comment: txt},
                success: function (res) {
                    let result = JSON.parse(res)
                    if (result.success) {
                        field.blur();
                        existingCommentfield.val(txt);
                        alertSuccess.removeClass('hidden');
                    } else {
                        alertDanger.removeClass('hidden');
                    }

                    setTimeout(function(){
                        alertSuccess.addClass('hidden');
                        alertDanger.addClass('hidden');
                    }, 5000)
                }
            });
        }
    },
    openDateConfirmed: function(isStart) {
        const modal = $('#date_confirmed')
        if (isStart) {
            modal.find('#startText').show()
            modal.find('#endText').hide()
        } else {
            modal.find('#startText').hide()
            modal.find('#endText').show()
        }
        modal.modal('show');
        modal.on('hidden.bs.modal', function () {
            if (($("#reservation-details").data('bs.modal') || {})._isShown) {
                $('body').addClass('modal-open');
            }
        });
    },
    dateConfirmed: function() {
        const self = this;
        const modal = $('#reservation-details');
        const resBlock = $('.reservations_row[id=' + self.selectedReservationId + ']');
        const [day, month, year] = self.startDate.split('/');
        const dbt_at = year + '-' + month + '-' + day;
        const mindate =  new Date(+year, month - 1, +day);
        const selectedmindate = new Date(+year, month - 1, +day);
        mindate.setDate(mindate.getDate());
        selectedmindate.setDate(selectedmindate.getDate() + 1);

        const [day1, month1, year1] = self.endDate.split('/');
        const fin_at =  year1 + '-' + month1 + '-' + day1;
        const maxdate =  new Date(+year1, month1 - 1, +day1);
        const selectedmaxdate = new Date(+year1, month1 - 1, +day1);
        maxdate.setDate(maxdate.getDate());
        selectedmaxdate.setDate(selectedmaxdate.getDate() - 1);

        $.ajax({
            type: "POST",
            url: MAIN_URL + "edit_reservation_dates",
            data: {id : self.selectedReservationId, dbt_at: dbt_at, fin_at: fin_at},
            success:function(){
                modal.find("#from").datepicker({
                    dateFormat: "dd/mm/yy",
                    minDate: mindate,
                    maxDate: selectedmaxdate,
                    onSelect: function(dateText) {
                        self.openDateConfirmed(true)
                        self.startDate = dateText
                        self.endDate = selectedmaxdate
                    }
                });
                modal.find("#end").datepicker({
                    dateFormat: "dd/mm/yy",
                    minDate: selectedmindate,
                    maxDate: maxdate,
                    onSelect: function(dateText) {
                        self.openDateConfirmed()
                        self.startDate = selectedmindate
                        self.endDate = dateText
                    }
                });

                resBlock.find('.arrive_date').text(self.startDate)
                resBlock.find('.fin_date').text(self.endDate)
                $('#date_confirmed').modal("hide");
            }
        });
    },
    resetDetailsModal: function() {
        const self = this;
        self.openDetails(self.selectedReservationId);
        const modal = $('#reservation-details');
        const date =  $(modal).find('#from').datepicker("option", "minDate");
        const [day, month, year] = date.split('/');
        const mindate =  new Date(+year, month - 1, +day);
        const selectedmindate = new Date(+year, month - 1, +day);
        selectedmindate.setDate(selectedmindate.getDate() + 1);

        const date1 =  $(modal).find('#end').datepicker("option", "maxDate" );
        const [day1, month1, year1] = date1.split('/');
        const maxdate =  new Date(+year1, month1 - 1, +day1);
        const selectedmaxdate = new Date(+year1, month1 - 1, +day1);
        selectedmaxdate.setDate(selectedmaxdate.getDate() - 1);

        modal.find("#from").datepicker({
            dateFormat: "dd/mm/yy",
            minDate: mindate,
            maxDate: selectedmaxdate,
            onSelect: function(dateText) {
                self.openDateConfirmed(true)
                self.startDate = dateText
                self.endDate = selectedmaxdate
            }
        });
        modal.find("#end").datepicker({
            dateFormat: "dd/mm/yy",
            minDate: selectedmindate,
            maxDate: maxdate,
            onSelect: function(dateText) {
                self.openDateConfirmed()
                self.startDate = selectedmindate
                self.endDate = dateText
            }
        });
    },
    uploadInventoryFile: function(form) {
        const self = this;
        const url = $(form).attr('action');
        const data = new FormData(form);
        const alertSuccess = $('.inventory_section .alert-success');
        const alertDanger = $('.inventory_section .alert-danger');
        const field = $('#inventory_comment_filed');
        const downloadBtn = $('#download_inventory_btn');
        const uploadBtn = $('#upload_inventory_btn');
        const txt = field.val().trim();

        if (txt) {
            $.ajax({
                async: false,
                type: "POST",
                url: url,
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function (res) {
                    let result = JSON.parse(res)

                    if (result.success) {
                        field.blur();
                        alertSuccess.text(result.message);
                        alertSuccess.removeClass('hidden');
                        downloadBtn.attr('href', result.file_url).removeClass('hidden');
                        uploadBtn.addClass('hidden');
                    } else {
                        alertDanger.text(result.message);
                        alertDanger.removeClass('hidden');
                    }

                    setTimeout(function () {
                        alertSuccess.addClass('hidden').empty();
                        alertDanger.addClass('hidden').empty();
                    }, 5000)
                }
            });
        } else {
            const requiredAlert = $('.inventory_section .required-alert');
            requiredAlert.removeClass('hidden');

            setTimeout(function () {
                requiredAlert.addClass('hidden');
            }, 5000)
        }
    }
};

$(document).ready(function () {
    tenantView.__init();
});

