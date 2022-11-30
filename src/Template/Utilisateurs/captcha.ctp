<?php
//header("Content-type: image/png");


$image = imagecreatetruecolor(165, 50);


$color = imagecolorallocate($image, 0, 0, 0); // color

$white = imagecolorallocate($image, 255, 255, 255); // background color white

imagefilledrectangle($image, 0, 0, 709, 99, $white);

imagettftext($image, 22, 0, 5, 30, $color, $font, $session);


//

imagepng($image,$approot."/prop.png");
?>
<img src="<?php echo $this->Url->build('/',true)?>prop.png" alt="" id="captcha" />
