<head>
    <style>
        body{
            margin: 0;
        }
        img.displayed {
            width: 35%;
        }
        video{
            width: 100%;
            margin-top: 2%;
            height: 86%;
        }
        p{
            margin: 0;
            background-color: white;
            width: 100%;
        }
    </style>
</head>
<p>
<svg aria-hidden="true" width="340" height="55" viewBox="0 0 1108.26 163.66">
    <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/logo-couleur-alpissime-baseline.svg#Calque_2"></use>
</svg>
<!-- <img class="displayed" src="<?php echo $this->Url->build('/',true)?>images/logo.png"/> -->
</p>
<!-- <video controls src="<?php //echo $url?>"></video> -->

<video controls="" preload="none" autobuffer="">
    <source src="<?php echo $url?>" type="video/mp4" />
    <source src="<?php echo $url?>" type="video/webm" />
    <source src="<?php echo $url?>" type="video/ogg" />
        Your browser does not support HTML5 video.
</video>


<!-- <video controls="" preload="none" autobuffer="">
    <source src="<?//$url?>" type="video/mp4">
     Your browser does not support HTML5 video.
</video> -->
