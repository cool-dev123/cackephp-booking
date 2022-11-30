<?php $this->start('cssTop'); ?>
    <style>
        .overlay {
        position: absolute; 
        bottom: 0; 
        background: rgb(0, 0, 0);
        background: rgba(0, 0, 0, 0.5); /* Black see-through */
        color: #f1f1f1; 
        width: 100%;
        transition: .5s ease;
        opacity:0;
        color: white;
        font-size: 20px;
        padding: 20px;
        text-align: center;
      }

      /* When you mouse over the container, fade in the overlay title */
      .container-col-row:hover .overlay {
        opacity: 1;
        cursor: pointer;
      }
      .container-col-row {
        width: 100%;
        position: relative;
      }
    .img-res {
        display: block;
        width: 240px;
        height: 180px;
        margin: auto;
    }
    .jquery-loading-modal--visible {
        z-index: 1 !important;
    }
    span.route_rouge {
        background: red;
        padding: 3px;
        color: white;
        font-size: 14px;
    }
    span.route_bleu {
        background: blue;
        padding: 3px;
        color: white;
        font-size: 14px;
    }
    .whiteA{
        color: white;
    }
    .whiteA:hover{
        color: white;
    }
    </style>
<?php $this->end(); ?>
<!-- Title -->
<div class="row heading-bg">
    <div class="col-lg-12">
        <h5 class="txt-dark">Les webcams</h5>
    </div>
</div>
<!-- /Title -->

<!-- Row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="row">
                    <?php for($i=0;$i<count($cams);$i++): ?>

                        <div class="col-xs-12 col-sm-6 col-md-3 mt-10 sameHeight">
                            <div class="container-col-row item small photography item-A web">
                                <div class="showCamButton" data-video="<?= $cams[$i]['url'] ?>">
                                    <p class="PforImage">
                                        <img onload="imgLoad(this);" class="img-res" data-src="<?=$cams[$i]['url']?>&file=thumbnail" >
                                    </p>
                                    <div style="display: none;" class="overlay"><a class="whiteA" href="<?=$cams[$i]['url']?>" target="_blank">Voir Plus</a></div>
                                </div>
                            </div>
                            <p class="text-center txt-gold font-18" style=""><?= $cams[$i]['titre'] ?></p>
                            <p class="text-center txt-muted font-14" style=""><?= $cams[$i]['direction'] ?></p>
                        </div>

                    <?php endfor; ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->

<?php $this->Html->script("/js/lity-2.3.1/dist/lity.js", array('async','defer','block' => 'scriptBottom')); ?>

<!-- Slimscroll JavaScript -->
<?php $this->Html->script("/manager-arr/classic_CHOISI/dist/js/jquery.slimscroll.js", array('block' => 'scriptBottom')); ?>

<!-- Fancy Dropdown JS -->
<?php $this->Html->script("/manager-arr/classic_CHOISI/dist/js/dropdown-bootstrap-extended.js", array('block' => 'scriptBottom')); ?>

<!-- Match Height JS -->
<?php $this->Html->script("/manager-arr/js/jquery.matchHeight-min.js", array('block' => 'scriptBottom')); ?>

<!-- Owl JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js", array('block' => 'scriptBottom')); ?>

<!-- Switchery JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/switchery/dist/switchery.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    imgs=null;
    // var browser = 'notSafari';
    // var ua = navigator.userAgent.toLowerCase();
    //     if (ua.indexOf('safari') != -1) {
    //         if (ua.indexOf('chrome') > -1) {
    //         } else {
    //           browser='safari';
    //         }
    //     }

    $('.item-A').loadingModal({
        position: 'auto',
        text: 'Chargement De Vignette',
        color: '#fff',
        opacity: '1',
        backgroundColor: '#000000',
        animation: 'foldingCube',
    });

    $(document).on('click', ".showCamButton", function () {
        //if(browser!='safari'){
            var lightbox = lity("<?php echo $this->Url->build('/',true)?>camVideo?link="+$(this).attr('data-video'));
            $(document).on('click', '[data-lightbox]', lity);
        //}
    });

    function imgLoad(img){
        $(img.parentNode.parentNode.parentNode).loadingModal('destroy');
        $(img.parentNode).next().css("display","block");
        //if(browser!='safari'){
            $(img.parentNode).next().children().attr('href','#');
            $(img.parentNode).next().children().removeAttr('target');
        //}
    }
    function chargerImages() {
        imgs = document.querySelectorAll('[data-src]');
        for (i = 0; i < imgs.length; i++) {
            $(imgs[i]).attr('src',$(imgs[i]).attr("data-src"));
        }
        resize();
    }
    function resize(){
        for (i = 0; i < imgs.length; i++) {
            ml=$(imgs[i]).css("marginLeft");
            wi=$(imgs[i]).css("width");
            $(imgs[i]).parent().next().css("marginLeft",ml);
            $(imgs[i]).parent().next().css("width",wi);
        }
        setTimeout(resize, 2000);
    }
    $(window).resize(function() {
        resize();
    });
    $( document ).ready(function() {
        setTimeout(chargerImages, 500);
        $('.sameHeight').matchHeight();
    });
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/js/lity-2.3.1/dist/lity.css", array('block' => 'cssTop')); ?>
