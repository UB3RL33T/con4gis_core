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
     * Function loadResourcesForModule
     *
     * Loads core-resources needed by the given module
     */
    public static function loadResourcesForModule($module)
    {
        $neededResources = array();

        switch ($module) {
            case 'maps':
                // Maps 3
                //
                $neededResources['clipboard'] = true;

                // check if jQuery needs to be loaded
                $jQueryLoaded = false;
                foreach ($GLOBALS['TL_JAVASCRIPT'] as $strScriptUrl) {
                    if (preg_match('/assets\/jquery\/core\/\d+\.\d+\.\d+\/jquery\.min\.js/i', $strScriptUrl))
                    {
                        $jQueryLoaded = true;
                        break;
                    }
                }
                $neededResources['jquery'] = !$jQueryLoaded;

                // @TODO: check
                // Load magnific-popup.js for projects
                $neededResources['magnific-popup'] = $GLOBALS['con4gis_projects_extension']['installed'];
                break;

            default:
                return false;
        }

        return ResourceLoader::loadResources($neededResources);
    }

    /**
     * Function loadResources
     *
     * Loads the requested resources
     */
    public static function loadResources($resources=array())
    {
        if (!is_array($resources) || empty($resources)) {
            $allByDefault = true;
            $resources = array();
        } else {
            $allByDefault = false;
        }

        $resources = array_merge(array
        (
            'jquery' => $allByDefault,
            'magnific-popup' => $allByDefault,
            'clipboard' => $allByDefault
        ),
        $resources);

        if ($resources['jquery']) {
            // load jQuery
            $GLOBALS['TL_JAVASCRIPT']['c4g_jquery'] = 'system/modules/con4gis_core/lib/jQuery/jquery-1.11.1.min.js|static';
        }
        if ($resources['magnific-popup']) {
            // load magnific-popup
            $GLOBALS['TL_JAVASCRIPT']['magnific-popup'] = 'system/modules/con4gis_core/lib/magnific-popup/magnific-popup.js|static';
            $GLOBALS['TL_CSS']['magnific-popup'] = 'system/modules/con4gis_core/lib/magnific-popup/magnific-popup.css';
        }
        if ($resources['clipboard']) {
            // load clipboard
            $GLOBALS['TL_JAVASCRIPT']['clipboard'] = 'system/modules/con4gis_core/lib/clipboard.min.js|static';
        }

        return true;
    }

}
