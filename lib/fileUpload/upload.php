<?php
    /** *********************************************************************************************** *\
     * |** Image Upload for wswgEditor
     * |** Version: 0.1 (alpha)
     * |** Last Modified Date: 2013-Sptember-25
     * |** License: LGPL (http://opensource.org/licenses/lgpl-3.0.html)
     * |** Author: Tobias Dobbrunz (Küstenschmiede GmbH Software & Design)
     * |** EMail: tobias.dobbrunz@kuestenschmiede.de
     * |** URL: http://www.kuestenschmiede.de
     * \** *********************************************************************************************** */


    if (!isset($_POST['Path']) || !isset($_FILES['File']['tmp_name'])) {
        die();
    }

    define("TL_MODE","FE");
    $sRootPath = dirname($_SERVER['SCRIPT_FILENAME']) . "/../../../../../";
    require_once($sRootPath."system/initialize.php");


    $sTempname        = $_FILES['File']['tmp_name'];
    $sFileName        = $_FILES['File']['name'];
    $sFileType        = $_FILES['File']['type'];
    $sDestinationPath = $_POST['Path'];

    if ($sFileType != "image/gif" && $sFileType != "image/jpeg" && $sFileType != "image/png") {
        die();
    }

    $aImageType = getimagesize($sTempname);

    switch ($aImageType[2]) {
        case "1":
            $endung    = "gif";
            $uniqid    = uniqid();
            $sFileName = $uniqid . ".gif";
            break;
        case "2":
            $endung    = "jpg";
            $uniqid    = uniqid();
            $sFileName = $uniqid . ".jpg";
            break;
        case "3":
            $endung    = "png";
            $uniqid    = uniqid();
            $sFileName = $uniqid . ".png";
            break;
    }

    if (empty($err)) {
        $sDestination = $sDestinationPath . $sFileName;

        if (move_uploaded_file($sTempname, TL_ROOT."/". $sDestination)) {
            echo $sDestination;
        } else {
            echo 0;
        }
    }