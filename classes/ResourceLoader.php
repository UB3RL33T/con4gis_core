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

namespace c4g\Core;

/**
 * Class ResourceLoader
 * @package c4g\Core
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
                $scripts = $GLOBALS['TL_JAVASCRIPT'];
                if (is_array($scripts)) {
                    foreach ($scripts as $strScriptUrl) {
                        if (preg_match('/assets\/jquery\/core\/\d+\.\d+\.\d+\/jquery\.min\.js/i', $strScriptUrl)) {
                            $jQueryLoaded = true;
                            break;
                        }
                    }
                }

                $neededResources['jquery'] = !$jQueryLoaded;

                // Load magnific-popup.js for projects
                $neededResources['magnific-popup'] = $GLOBALS['con4gis_projects_extension']['installed'];

                //ToDo switch for pdf export
                $neededResources['jspdf'] = false;

                break;

            default:
                return false;
        }

        return self::loadResources($neededResources);
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
            'clipboard' => $allByDefault,
            'jspdf' => $allByDefault,
        ),
        $resources);

        if ($resources['jquery']) {
            // load jQuery
            if (version_compare( VERSION, '3', '>=' ) &&
                is_array( $GLOBALS['TL_JAVASCRIPT'] ) &&
                (array_search( 'assets/jquery/core/' . JQUERY . '/jquery.min.js|static', $GLOBALS['TL_JAVASCRIPT'] ) !== false))
            {
                // jQuery is already loaded by Contao 3, don't load again!
            }
            else {
                $GLOBALS['TL_JAVASCRIPT']['c4g_jquery'] = 'system/modules/con4gis_core/lib/jQuery/jquery-1.11.1.min.js|static';
            }
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
        if ($resources['jspdf']) {
            // load clipboard
            $GLOBALS['TL_JAVASCRIPT']['jspdf'] = 'system/modules/con4gis_core/lib/jspdf/jspdf.min.js|static';
            //$GLOBALS['TL_JAVASCRIPT']['jspdf.plugin.from_html'] = 'system/modules/con4gis_core/lib/jspdf/plugins/from_html.js|static';
        }

        return true;
    }

}
