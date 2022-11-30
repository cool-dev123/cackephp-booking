<?php

/* Getting file name */
$filename = $_FILES['file']['name'];

/* Getting File size */
$filesize = $_FILES['file']['size'];

/* Location */
$prefixe = $_SERVER['DOCUMENT_ROOT'];

$location = $prefixe."/webroot/images_ann/".$filename;

$return_arr = array();

/* Upload file */
if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    $src = "default.png";

    // checking file is image or not
    if(is_array(getimagesize($location))){
        $src = $location;
    }
    $return_arr = array("name" => $filename,"size" => $filesize, "src"=> $src);
}

echo json_encode($return_arr);
