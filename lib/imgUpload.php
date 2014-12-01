<?php
// PHP Upload Script for CKEditor:  http://coursesweb.net/

    try {
        define("TL_MODE", "FE");
        $sRootPath = dirname($_SERVER['SCRIPT_FILENAME']) . "/../../../../";
        require_once($sRootPath . "system/initialize.php");

        // User not logged in...
        if (!FE_USER_LOGGED_IN) {
            header('HTTP/1.0 403 Forbidden');
            echo "Forbidden";
            die();
        }


        \Contao\System::loadLanguageFile("default");

        // xss cleanup
        $_FILES = \Contao\Input::xssClean($_FILES);

        $sServerName = \Contao\Environment::get("serverName");
        $sRequestUri = \Contao\Environment::get("requestUri");
        $sHttps      = \Contao\Environment::get("https");
        $path        = \Contao\Environment::get("path");

        $sConfigUploadPath = \Contao\Session::getInstance()->get("con4gisImageUploadPath");
        $sConfigUploadPath = \Contao\Input::xssClean($sConfigUploadPath);
        $sSubfolder        = date("Y-m-d");

        //if not configured, use fallbackpath
        if (empty($sConfigUploadPath)) {
            $sUploadPath = \Contao\Config::get("uploadPath");
            $sUploadDir  = "/" . $sUploadPath . "/uploads/";
        } else {
            $sUploadDir = "/" . $sConfigUploadPath;
        }

        // add subfolder
        $sUploadDir = $sUploadDir . $sSubfolder;


        // create if not exist
        if (!is_dir(TL_ROOT . "/" . $sUploadDir)) {
            mkdir(TL_ROOT . "/" . $sUploadDir, 0777, true);
        }

        // HERE SET THE PATH TO THE FOLDER WITH IMAGES ON YOUR SERVER (RELATIVE TO THE ROOT OF YOUR WEBSITE ON SERVER)


        $sValidFileTypes = \Contao\Session::getInstance()->get("c4g_forum_bbcodes_editor_uploadTypes");
        $sMaxFileSize    = \Contao\Session::getInstance()->get("c4g_forum_bbcodes_editor_maxFileSize");
        $sMaxImageWidth  = \Contao\Session::getInstance()->get("c4g_forum_bbcodes_editor_imageWidth");
        $sMaxImageheight = \Contao\Session::getInstance()->get("c4g_forum_bbcodes_editor_imageHeight");


        if (empty($sValidFileTypes)) {
            // get system-configured allowed filetypes
            $sValidFileTypes = \Contao\Config::get("uploadTypes");
        }
        if (empty($sMaxFileSize)) {
            // get system-configured max filesize
            $sMaxFileSize = \Contao\Config::get("maxFileSize");
        }
        if (empty($sMaxImageWidth)) {
            // get system-configured max filesize
            $sMaxImageWidth = \Contao\Config::get("imageWidth");
        }
        if (empty($sMaxImageheight)) {
            // get system-configured max filesize
            $sMaxImageheight = \Contao\Config::get("imageHeight");
        }

        $sValidFileTypes = \Contao\Input::xssClean($sValidFileTypes);
        $sMaxFileSize    = \Contao\Input::xssClean($sMaxFileSize);
        $sMaxImageWidth  = \Contao\Input::xssClean($sMaxImageWidth);
        $sMaxImageheight = \Contao\Input::xssClean($sMaxImageheight);


        // HERE PERMISSIONS FOR IMAGE
        $imgsets = array(
            'maxsize'   => intval($sMaxFileSize),          // maximum file size, in KiloBytes (2 MB)
            'maxwidth'  => intval($sMaxImageWidth),          // maximum allowed width, in pixels
            'maxheight' => intval($sMaxImageheight),         // maximum allowed height, in pixels
            'minwidth'  => 10,           // minimum allowed width, in pixels
            'minheight' => 10,          // minimum allowed height, in pixels
            'type'      => explode(",", $sValidFileTypes)        // allowed extensions
        );

        $sReturn = '';


        $CKEditorFuncNum = \Contao\Input::get('CKEditorFuncNum');
        if (!empty($_FILES['upload']) && strlen($_FILES['upload']['name']) > 1 && !empty($_FILES['upload']['tmp_name'])) {
            $sUploadDir = trim($sUploadDir, '/') . '/';
            $img_name   = basename($_FILES['upload']['name']);

            // get protocol and host name to send the absolute image path to CKEditor
            $protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $site     = $protocol . $_SERVER['SERVER_NAME'] . '/';

            $uploadpath = TL_ROOT . '/' . $sUploadDir . $img_name;       // full file path
            $sExtension  = pathinfo($_FILES['upload']['name']);
            $sType       = $sExtension['extension'];       // gets extension
            list($width, $height) = getimagesize($_FILES['upload']['tmp_name']);     // gets image width and height
            $err = '';         // to store the errors

            // Checks if the file has allowed type, size, width and height (for images)
            if (!in_array($sType, $imgsets['type'])) {
                $err = sprintf($GLOBALS['TL_LANG']['MSC']['C4G_ERROR']['image_upload_invalid_extension'], $_FILES['upload']['name']);
            }elseif ($_FILES['upload']['size'] > $imgsets['maxsize']) {
                $err = sprintf($GLOBALS['TL_LANG']['MSC']['C4G_ERROR']['image_upload_invalid_size'], ($imgsets['maxsize'] / 1024));
            }elseif (isset($width) && isset($height)) {
                if ($width > $imgsets['maxwidth'] || $height > $imgsets['maxheight']) {
                    $err = sprintf($GLOBALS['TL_LANG']['MSC']['C4G_ERROR']['image_upload_invalid_dimensions'], $width, $height, $imgsets['maxwidth'], $imgsets['maxheight']);
                }elseif ($width < $imgsets['minwidth'] || $height < $imgsets['minheight']) {
                    $err = sprintf($GLOBALS['TL_LANG']['MSC']['C4G_ERROR']['image_upload_invalid_dimensions'], $width, $height, $imgsets['maxwidth'], $imgsets['maxheight']);
                }
            }


            if(!empty($path)){
                $path = substr($path,1)."/";
            }else{
                $path = "";
            }
            // If no errors, upload the image, else, output the errors
            if ($err == '') {
                if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath)) {
                    $url     = $site . $path.$sUploadDir . $img_name;
                    $message = sprintf($GLOBALS['TL_LANG']['MSC']['C4G_ERROR']['image_upload_successful'], $img_name, number_format($_FILES['upload']['size'] / 1024, 3, '.', ''), $width, $height);
                    $sReturn = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')";
                } else {
                    $sReturn = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '', '" . $GLOBALS['TL_LANG']['MSC']['C4G_ERROR']['image_upload_error'] . "')";
                }
            } else {
                $sReturn = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '', '" . $err . "')";
            }
        } else {
            $message = "";

            if (!empty($_FILES['upload']['size'])) {
                if ($_FILES['upload']['size'] > $imgsets['maxsize']) {
                    $message .= sprintf($GLOBALS['TL_LANG']['MSC']['C4G_ERROR']['image_upload_invalid_size'], ($imgsets['maxsize'] / 1024));
                } else {
                    $message .= $GLOBALS['TL_LANG']['MSC']['C4G_ERROR']['image_upload_error'];
                }
            } else {
                $message .= $GLOBALS['TL_LANG']['MSC']['C4G_ERROR']['image_upload_error'];
            }

            $sReturn = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '', '$message')";
        }
    } catch (Exception $e) {

    }
    echo "<script>$sReturn;</script>";
