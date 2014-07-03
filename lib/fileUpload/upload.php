<?php
/** *********************************************************************************************** *\
|** Image Upload for wswgEditor
|** Version: 0.1 (alpha)
|** Last Modified Date: 2013-Sptember-25
|** License: LGPL (http://opensource.org/licenses/lgpl-3.0.html)
|** Author: Tobias Dobbrunz (Küstenschmiede GmbH Software & Design)
|** EMail: tobias.dobbrunz@kuestenschmiede.de
|** URL: http://www.kuestenschmiede.de
\** *********************************************************************************************** */

$tempname = $_FILES['File']['tmp_name'];
$name = $_FILES['File']['name'];
$type = $_FILES['File']['type'];
$path = $_POST['Path'];

if($type != "image/gif" && $type != "image/jpeg" && $type !="image/png") {
    $err = 1;
}

$imgtype = getimagesize( $tempname );

switch ($imgtype[2]) {
    case "1":
        $endung = "gif";
        $uniqid = uniqid();
        $name = $uniqid.".gif";
        break;
    case "2":
        $endung = "jpg";
        $uniqid = uniqid();
        $name = $uniqid.".jpg";
        break;
    case "3":
        $endung = "png";
        $uniqid = uniqid();
        $name = $uniqid.".png";
        break;
}

if(empty( $err )) {
    $dir = $path;
    $ziel = $dir.$name;

    if (move_uploaded_file( $tempname  , '../../../../../../'.$ziel )){
        echo $ziel;
    } else{
        echo 0;
    }
}

?>