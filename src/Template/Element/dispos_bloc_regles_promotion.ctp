<div class="divpromotionstoshow" style="display:none;">
    <div class="px-4 mb-5 activated-promos-list">
        <?php if ($annonce->proposerlastminute !== 0 || $annonce->proposerearlybooking !== 0 || $annonce->proposerlongsejours !== 0) { ?>
        <?= __("Les promotions suivantes sont activées") ?>:
        <ul>
            <?php if ($annonce->proposerearlybooking !== 0) { ?>
                <li><?= __("Promotion Early Booking.") ?></li>
            <?php } ?>

            <?php if ($annonce->proposerlastminute !== 0) { ?>
            <li><?= __("Promotion Last Minute.") ?></li>
            <?php } ?>

            <?php if ($annonce->proposerlongsejours !== 0) { ?>
                <li><?= __("Promotion pour les Longs Séjours.") ?></li>
            <?php } ?>
        </ul>
        <?php } else { echo __("Vous n'avez pas activé de promotions"); } ?>
    </div>
    <div class="px-4">

        <div class="d-flex mb-2 align-items-center h-100 shadow-sm pl-3 pr-2 py-2 rowdispos earlybooking">
            <div class="mr-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                <svg aria-hidden="true" width="50" height="50" viewBox="0 0 97.51 99.96">
                    <use xlink:href="/images/svg/Early-Booking.svg#Calque_2"></use>
                </svg>
            </div>
            <div class="fontstyle"><?= __("Promotion Early Booking.") ?></div>
        </div>

        <div class="d-flex mb-2 align-items-center h-100 shadow-sm pl-3 pr-2 py-2 rowdispos lastminute">
            <div class="mr-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                <svg aria-hidden="true" width="50" height="50" viewBox="0 0 92.33 98.13">
                    <use xlink:href="/images/svg/Last-Minute.svg#Calque_2"></use>
                </svg>
            </div>
            <div class="fontstyle"><?= __("Promotion Last Minute.") ?></div>
        </div>

        <div class="d-flex mb-2 align-items-center h-100 shadow-sm pl-3 pr-2 py-2 rowdispos mb-5 longsejours">
            <div class="mr-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                <svg aria-hidden="true" width="50" height="50" viewBox="0 0 98.04 98.04">
                    <use xlink:href="/images/svg/Longs-Sejours.svg#Calque_2"></use>
                </svg>
            </div>
            <div class="fontstyle"><?= __("Promotion pour les Longs Séjours.") ?></div>
        </div>

    </div>
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
// <script>
$(".earlybooking").click(function(){   
    $(".divpromotionstitletoshow").slideToggle(500, "swing", function(){
        $(".divearlybookingtitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divpromotionstoshow").slideToggle(500, "swing", function(){
        $(".divearlybookingtoshow").slideToggle(500, "swing");    
    });  
});
function retourEarlybooking(){
    $(".divearlybookingtitletoshow").slideToggle(500, "swing", function(){
        $(".divpromotionstitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divearlybookingtoshow").slideToggle(500, "swing", function(){
        $(".divpromotionstoshow").slideToggle(500, "swing");    
    });
}

$(".lastminute").click(function(){   
    $(".divpromotionstitletoshow").slideToggle(500, "swing", function(){
        $(".divlastminutetitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divpromotionstoshow").slideToggle(500, "swing", function(){
        $(".divlastminutetoshow").slideToggle(500, "swing");    
    });  
});
function retourLastminute(){
    $(".divlastminutetitletoshow").slideToggle(500, "swing", function(){
        $(".divpromotionstitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divlastminutetoshow").slideToggle(500, "swing", function(){
        $(".divpromotionstoshow").slideToggle(500, "swing");    
    });
}

$(".longsejours").click(function(){   
    $(".divpromotionstitletoshow").slideToggle(500, "swing", function(){
        $(".divlongsejourstitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divpromotionstoshow").slideToggle(500, "swing", function(){
        $(".divlongsejourstoshow").slideToggle(500, "swing");    
    });  
});
function retourLongsejours(){
    $(".divlongsejourstitletoshow").slideToggle(500, "swing", function(){
        $(".divpromotionstitletoshow").slideToggle(500, "swing");    
    }); 
    $(".divlongsejourstoshow").slideToggle(500, "swing", function(){
        $(".divpromotionstoshow").slideToggle(500, "swing");    
    });   
}

<?php $this->Html->scriptEnd(); ?>