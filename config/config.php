<?php

/**
 * Contao Open Source CMS
 *
 * @version   php 5
 * @package   con4gis
 * @author    Tobias Dobbrunz &#40;http://www.kuestenschmiede.de&#41;
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2014 - 2015
 * @link      https://www.kuestenschmiede.de
 * @filesource
 */


$GLOBALS['con4gis_core_extension']['installed'] = true;
$GLOBALS['con4gis_core_extension']['version']   = '1.0.2';

// API-Registration
$GLOBALS['TL_API'] = array();

/**
 * Backend Modules
 */
array_insert($GLOBALS['BE_MOD'], array_search('content', array_keys($GLOBALS['BE_MOD'])) + 1, array
(
    'con4gis' => array
    (
        'c4g_core' => array
        (
            'callback' => 'c4g\C4GInfo',
            'tables'   => array(),
            'icon'     => 'system/modules/con4gis_core/assets/images/core.png'
        )
    )
));

if(TL_MODE == "FE") {
    $GLOBALS['TL_HEAD'][] = "<script>var c4g_rq = '" . $_SESSION['REQUEST_TOKEN'] . "';</script>";
}

/**
 * Content Elements
 */
array_insert($GLOBALS['TL_CTE']['con4gis'], 2, array
(
    'c4g_activationpage' => 'Content_c4g_activationpage'
));