const MAIN_URL = BASE_URL + "dispos/";

var Promotions = {
    urls: {
        early_booking: "calendarAddEarlyBooking",
        long_stay: "calendarAddLongSejour",
        last_minute: "calendarAddLastMinute"
    },
    reqUrl: '',
    formData: '',
    __init() {
        this.initEvents();
    },
    initEvents() {
        const self = this;

        if (proposerearlybooking != 0){
            $('#proposerearlybooking').attr('checked', 'checked');
            $(".montantearlybookingbloc").slideDown(500, "swing");
        } else {
            $('#proposerearlybooking').removeAttr('checked');
            $(".montantearlybookingbloc").slideUp(500, "swing");
        }

        $('#proposerearlybooking').off('change').on('change', function() {
            const block = $(".montantearlybookingbloc");
            if ($(this).is(':checked')) {
                block.slideDown(500, "swing");
            } else {
                block.slideUp(500, "swing");
            }
        });

        if(proposerlastminute != 0){
            $('#proposerlastminute').attr('checked', 'checked');
            $(".montantlastminutebloc").slideDown(500, "swing");
        }else{
            $('#proposerlastminute').removeAttr('checked');
            $(".montantlastminutebloc").slideUp(500, "swing");
        }

        $('#proposerlastminute').off('change').on('change', function() {
            const block = $(".montantlastminutebloc");
            if ($(this).is(':checked')){
                block.slideDown(500, "swing");
            } else {
                block.slideUp(500, "swing");
            }
        });

        if(proposerlongsejours != 0){
            $('#proposerlongsejours').attr('checked', 'checked');
            $(".montantlongsejoursbloc").slideDown(500, "swing");
        }else{
            $('#proposerlongsejours').removeAttr('checked');
            $(".montantlongsejoursbloc").slideUp(500, "swing");
        }

        $('#proposerlongsejours').off('change').on('change', function() {
            const block = $(".montantlongsejoursbloc");
            if($(this).is(':checked')){
                block.slideDown(500, "swing");
            }else{
                block.slideUp(500, "swing");
            }
        });

        $('.automation-promotion-form').off('submit').on('submit', function(e) {
            e.preventDefault();

            if (self.validateForm($(this))) {
                self.formData = $(this).serialize();
                self.reqUrl = self.urls[$(this).attr('data-type')];
                $("#promo_save_popup").modal('show');
            }
        });

        $('#promo_save_popup').on('hidden.bs.modal', function () {
            self.formData = '';
            self.reqUrl = '';
        });

        $("#promo_save_popup .confirm-btn").off('click').on('click', function() {
            if (self.formData) {
                self.savePromo();
            }
        });

        $('.montant-block input').off('input').on('input', function() {
           const value = $(this).val();
           const minValue = +$(this).attr('min');
           const maxValue = +$(this).attr('max');

            if (value !== '' && +value < minValue) {
                $(this).val(minValue);
            }

            if (value !== '' && +value > maxValue) {
                $(this).val(maxValue);
            }
        });
    },
    validateForm(form) {
        $('.automation-promotion-form  .montant-block .row').removeClass('error');
        let inputs = form.find('.montant-block input');
        let validated = true;

        inputs.each(function(i, input) {
            if ($(input).val() === '') {
                validated = false;
                $(input).closest('.row').addClass('error');
            }
        });

        return validated;
    },
    savePromo() {
        const self = this;

        $.ajax({
            type: "POST",
            dataType : 'json',
            url: MAIN_URL + self.reqUrl,
            data: self.formData,
            success:function(resp) {
                location.reload();
                // self.getPromotions();
                // $("#promo_save_popup").modal('hide');
            }
        });
    },
    getPromotions() {
        const self = this;

        $.ajax({
            type: "POST",
            dataType : 'json',
            url: BASE_URL + "annonces/activatedpromotions",
            data: self.formData,
            success:function(resp) {
                $('.activated-promos-list').html(resp.html);
            }
        });
    },
}

Promotions.__init();