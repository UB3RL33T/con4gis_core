<?php

/**
 * Contao Open Source CMS
 *
 * @version   php 5
 * @package   con4gis
 * @author    Tobias Dobbrunz <http://www.kuestenschmiede.de>
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2014 - 2016
 * @link      https://www.kuestenschmiede.de
 * @filesource
 */

namespace c4g\Core;

/**
 * Class ResourceLoader
 *
 * Static Function library for con4gis_core
 */
class ResourceLoader
{

    /**
     * @TODO: doku
     */
    public static function loadResources($module)
    {

        switch ($module) {
            case 'maps':
                // Maps 3
                //
                $GLOBALS['TL_JAVASCRIPT']['c4g_jquery'] = 'system/modules/con4gis_core/lib/jQuery/jquery-1.11.1.min.js|static';
                // Load magnific-popup.js for projects
                if ($GLOBALS['con4gis_projects_extension']['installed']) {
                    $GLOBALS['TL_JAVASCRIPT']['magnific-popup'] = 'system/modules/con4gis_core/lib/magnific-popup/magnific-popup.js|static';
                    $GLOBALS['TL_CSS']['magnific-popup'] = 'system/modules/con4gis_core/lib/magnific-popup/magnific-popup.css';
                }

                $GLOBALS['TL_JAVASCRIPT']['clipboard'] = 'system/modules/con4gis_core/lib/clipboard.min.js|static';

                $GLOBALS['TL_JAVASCRIPT']['c4g_jq_bbc'] = 'system/modules/con4gis_core/lib/wswgEditor/editor.js';
                $GLOBALS['TL_CSS']['c4g_jq_bbc'] = 'system/modules/con4gis_core/lib/wswgEditor/css/editor.css';
                $GLOBALS['TL_CSS']['c4g_jq_bbc2'] = 'system/modules/con4gis_core/lib/wswgEditor/css/bbcodes.css';
                break;

            default:
                return false;
        }

        return true;
    }

}
