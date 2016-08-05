<?php

/**
 * con4gis - the gis-kit
 *
 * @version   php 5
 * @package   con4gis
 * @author    con4gis contributors (see "authors.txt")
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2011 - 2016.
 * @link      https://www.kuestenschmiede.de
 */

$GLOBALS['con4gis_core_extension']['installed'] = true;
$GLOBALS['con4gis_core_extension']['version']   = '1.5.1-snapshot';

$GLOBALS['con4gis_core_extension']['con4gis_version']   = 'v3.2';

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
    'c4g_activationpage' => 'c4g\Content_c4g_activationpage'
));

/**
 * Purge jobs
 */
$GLOBALS['TL_PURGE']['folders']['con4gis'] = array
(
    'callback' => array('c4g\Core\C4GAutomator', 'purgeApiCache'),
    'affected' => array('system/cache/con4gis')
);