<?php

    define("TL_MODE", "FE");
    $sRootPath = dirname($_SERVER['SCRIPT_FILENAME']) . "/../../../../";
    require_once($sRootPath . "system/initialize.php");

    // User not logged in...
    if (!FE_USER_LOGGED_IN) {
        header('HTTP/1.0 403 Forbidden');
        echo "Forbidden";
        die();
    }

    // xss cleanup
    $_FILES = \Contao\Input::xssClean($_FILES);

    $sServerName = \Contao\Environment::get("serverName");
    $sRequestUri = \Contao\Environment::get("requestUri");
    $sHttps      = \Contao\Environment::get("https");
    $path      = \Contao\Environment::get("path");


    $sConfigUploadPath = \Contao\Session::getInstance()->get("con4gisFileUploadPath");
    $sConfigUploadPath = \Contao\Input::xssClean($sConfigUploadPath);
    $sSubfolder        = date("Y-m-d");

    //if not configured, use fallbackpath
    if (empty($sConfigUploadPath)) {
        $sUploadDir = $path."/files/uploads/";
    } else {
        $sUploadDir = $path."/".$sConfigUploadPath;
    }

    // add subfolder
    $sUploadDir = $sUploadDir . $sSubfolder;


    // create if not exist
    if (!is_dir(TL_ROOT . "/" . $sUploadDir)) {
        mkdir(TL_ROOT . "/" . $sUploadDir,0777, true);
    }


    $sValidFileTypes = \Contao\Session::getInstance()->get("c4g_forum_bbcodes_editor_uploadTypes");
    $sMaxFileSize    = \Contao\Session::getInstance()->get("c4g_forum_bbcodes_editor_maxFileSize");

    if (empty($sValidFileTypes)) {
        // get system-configured allowed filetypes
        $sValidFileTypes = \Contao\Config::get("uploadTypes");
    }
    if (empty($sMaxFileSize)) {
        // get system-configured max filesize
        $sMaxFileSize = \Contao\Config::get("maxFileSize");
    }

    $sValidFileTypes = \Contao\Input::xssClean($sValidFileTypes);
    $sMaxFileSize    = \Contao\Input::xssClean($sMaxFileSize);

    //config array
    $aConfig = array(
        'maxsize' => intval($sMaxFileSize),          // maximum file size, in KiloBytes (2 MB)
        'type'    => explode(",", $sValidFileTypes)        // allowed extensions
    );

    $re = '';

    if (isset($_FILES['uploadFile']) && strlen($_FILES['uploadFile']['name']) > 1) {
        $aInfo         = pathinfo($_FILES['uploadFile']['name']);
        $sUploadDir    = trim($sUploadDir, '/') . '/';
        $sFileName     = basename($_FILES['uploadFile']['name']);
        $sUniqFileName = md5(uniqid('', true)) . "." . $aInfo['extension'];

        // get protocol and host name to send the absolute image path to CKEditor
        $sProtocol = !empty($sHttps) ? 'https://' : 'http://';
        $sSite     = $sProtocol . $sServerName . $path.'/system/modules/con4gis_core/lib/deliver.php?file=';


        // build file path
        $sUploadpath = TL_ROOT . '/' . $sUploadDir . $sUniqFileName;       // full file path
        $sExtension  = explode('.', strtolower($_FILES['uploadFile']['name']));
        $sType       = end($sExtension);       // gets extension
        list($width, $height) = getimagesize($_FILES['uploadFile']['tmp_name']);     // gets image width and height
        $sError = '';         // to store the errors

        // Checks if the file has allowed type, size, width and height (for images)
        if (!in_array($sType, $aConfig['type'])) {
            $sError .= 'The file: ' . $_FILES['uploadFile']['name'] . ' has not the allowed extension type.';
        }
        if ($_FILES['uploadFile']['size'] > $aConfig['maxsize'] * 1000) {
            $sError .= '\\n Maximum file size must be: ' . $aConfig['maxsize'] . ' KB.';
        }

        $sFileHash = md5($sUniqFileName . $GLOBALS['TL_CONFIG']['encryptionKey'] . $sFileName);

        // If no errors, upload the image, else, output the errors
        if ($sError == '') {
            if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $sUploadpath)) {
                $CKEditorFuncNum = \Contao\Input::get('CKEditorFuncNum');
                $url             = $sSite . $sUploadDir . $sFileName . "&u=" . $sUniqFileName . "&c=" . $sFileHash;
                $message         = $sFileName . ' successfully uploaded: \\n- Size: ' . number_format($_FILES['uploadFile']['size'] / 1024, 3, '.', '') . ' KB';
                $re              = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')";
            } else {
                $re = 'alert("Unable to upload the file")';
            }
        } else {
            $re = 'alert("' . $sError . '")';
        }
    }
    echo "<script>$re;</script>";
