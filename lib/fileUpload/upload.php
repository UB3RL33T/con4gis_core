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


    // User not logged in...
    if (!FE_USER_LOGGED_IN) {
        header('HTTP/1.0 403 Forbidden');
        echo "Forbidden";
        die();
    }

    // xss cleanup
    $_FILES = \Contao\Input::xssClean($_FILES);

    $sTempname        = $_FILES['File']['tmp_name'];
    $sFileName        = $_FILES['File']['name'];
    $sFileType        = $_FILES['File']['type'];
    $sDestinationPath = \Contao\Input::post('Path');

    if ($sFileType != "image/gif" && $sFileType != "image/jpeg" && $sFileType != "image/png") {
        die();
    }

    $aImageType = getimagesize($sTempname);

    switch ($aImageType[2]) {
        case "1":
            $sExtension    = "gif";
            $sUniqID    = uniqid();
            $sFileName = $sUniqID . ".gif";
            break;
        case "2":
            $sExtension    = "jpg";
            $sUniqID    = uniqid();
            $sFileName = $sUniqID . ".jpg";
            break;
        case "3":
            $sExtension    = "png";
            $sUniqID    = uniqid();
            $sFileName = $sUniqID . ".png";
            break;
    }

    if (empty($sError)) {
        $sDestination = $sDestinationPath . $sFileName;

        if (move_uploaded_file($sTempname, TL_ROOT."/". $sDestination)) {
            echo $sDestination;
        } else {
            echo 0;
        }
    }