<section id="partners">
    <div class="container">
        <div class="row">

			<div class="col-md-12">
				<h2><?= __("Nos partenaires") ?></h2>
			</div>
			<!--/title-->
			<div class="col-md-12">
				<!-- Jssor Slider Begin -->
				<!-- To move inline styles to css file/block, please specify a class name for each element. -->
				<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 1170px; height: 100px; overflow: hidden; ">

					<!-- Loading Screen -->
					<div u="loading" style="position: absolute; top: 0px; left: 0px;">
						<div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
							background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
						</div>
						<div style="position: absolute; display: block; background: url(<?php echo $this->base?>/images/ico/loading.gif) no-repeat center center;
							top: 0px; left: 0px;width: 100%;height:100%;">
						</div>
					</div>

					<!-- Slides Container -->
					<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1170px; height: 100px; overflow: hidden;">
						<div class="partner"><img u="image" alt="Partner1" src="<?php echo $this->base?>/images/partners/partner1.png" /></div>
						<div class="partner"><img u="image" alt="Partner2" src="<?php echo $this->base?>/images/partners/partner2.png" /></div>
						<div class="partner"><img u="image" alt="Partner3" src="<?php echo $this->base?>/images/partners/partner3.png" /></div>
						<div class="partner"><img u="image" alt="Partner4" src="<?php echo $this->base?>/images/partners/partner4.png" /></div>
						<div class="partner"><img u="image" alt="Partner5" src="<?php echo $this->base?>/images/partners/partner5.png" /></div>
						<div class="partner"><img u="image" alt="Partner1" src="<?php echo $this->base?>/images/partners/partner1.png" /></div>
						<div class="partner"><img u="image" alt="Partner2" src="<?php echo $this->base?>/images/partners/partner2.png" /></div>
						<div class="partner"><img u="image" alt="Partner3" src="<?php echo $this->base?>/images/partners/partner3.png" /></div>
						<div class="partner"><img u="image" alt="Partner4" src="<?php echo $this->base?>/images/partners/partner4.png" /></div>
						<div class="partner"><img u="image" alt="Partner5" src="<?php echo $this->base?>/images/partners/partner5.png" /></div>
						<div class="partner"><img u="image" alt="Partner1" src="<?php echo $this->base?>/images/partners/partner1.png" /></div>
						<div class="partner"><img u="image" alt="Partner2" src="<?php echo $this->base?>/images/partners/partner2.png" /></div>
						<div class="partner"><img u="image" alt="Partner3" src="<?php echo $this->base?>/images/partners/partner3.png" /></div>
						<div class="partner"><img u="image" alt="Partner4" src="<?php echo $this->base?>/images/partners/partner4.png" /></div>
						<div class="partner"><img u="image" alt="Partner5" src="<?php echo $this->base?>/images/partners/partner5.png" /></div>
					</div>
				</div>
				<!-- Jssor Slider End -->
			</div>
            <!--/partners-->
        </div>
    </div>

</section>
<script>
        $(document).ready(function ($) {
            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 0,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 4,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseLinear,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 1600,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                $SlideWidth: 250,                                   //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 100,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 7,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                              //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1150));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
</script>
