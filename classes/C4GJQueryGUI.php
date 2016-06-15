<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

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


/**
 * Class C4GJQueryGUI
 */
class C4GJQueryGUI
{
	public static function initializeTree ( $addCore=false, $addJQuery=true, $addJQueryUI=true )
	{
		C4GJQueryGUI::initializeLibraries( $addCore, $addJQuery, $addJQueryUI, true, false, false, false, false, false, false, false, true, false);
	}

	private static function optimizeJSForContao3 ( $libKey )
	{
		if (version_compare( VERSION, '3', '>=' ) && version_compare( VERSION, '3.2', '<' )) {
			$GLOBALS['TL_JAVASCRIPT'][$libKey] .= '|static';
		}
	}

	public static function initializeLibraries ( $addCore=true, $addJQuery=true, $addJQueryUI=true, $useTree=true, $useTable=true, $useHistory=true, $useTooltip=true,
											   		$useMaps=false, $useGoogleMaps=false, $useMapsEditor=false, $useWswgEditor=false, $useScrollpane=false, $usePopups=false )
	{
   		if ($addJQuery)
   		{
   			if (version_compare( VERSION, '3', '>=' ) &&
   				is_array( $GLOBALS['TL_JAVASCRIPT'] ) &&
   				(array_search( 'assets/jquery/core/' . JQUERY . '/jquery.min.js|static', $GLOBALS['TL_JAVASCRIPT'] ) !== false))
   			{
   				// jQuery is already loaded by Contao 3, don't load again!
   			}
   			else {
				// Include JQuery JS
				$GLOBALS['TL_JAVASCRIPT']['c4g_jquery'] 			= 'system/modules/con4gis_core/lib/jQuery/jquery-1.11.1.min.js|static';
				// just until the old plugins are replaced
				// $GLOBALS['TL_JAVASCRIPT']['c4g_jquery_migrate']		= 'system/modules/con4gis_core/lib/jQuery/jquery-migrate-1.2.1.min.js';
				C4GJQueryGUI::optimizeJSForContao3('c4g_jquery');
				// Set JQuery to noConflict mode immediately after load of jQuery
				$GLOBALS['TL_JAVASCRIPT']['c4g_jquery_noconflict'] 	= 'system/modules/con4gis_core/assets/js/c4gjQueryNoConflict.js';
		        C4GJQueryGUI::optimizeJSForContao3('c4g_jquery_noconflict');
   			}
   		}

   		if ($addJQueryUI || $useTree || $useMaps)
   		{
			// Include JQuery UI JS - only js to append the css files to the end of $GLOBALS['TL_CSS'] array.
			$GLOBALS['TL_JAVASCRIPT']['c4g_jquery_ui'] 		= 'system/modules/con4gis_core/lib/jQuery/ui-1.11.0.custom/jquery-ui.min.js';
			C4GJQueryGUI::optimizeJSForContao3('c4g_jquery_ui');
            $GLOBALS ['TL_JAVASCRIPT'] ['c4g_a'] 	= 'system/modules/con4gis_core/lib/jQuery/plugins/jquery.legacy.min.js';
   		}

		if ($useTable)
		{
			// Include DataTables JS
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_datatables'] 	= 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/media/js/jquery.dataTables.min.js';
            C4GJQueryGUI::optimizeJSForContao3('c4g_jq_datatables');

			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_datatables_buttons'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js';
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_datatables_buttons_print'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Buttons/js/buttons.print.min.js';
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_datatables_buttons_jquery'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Buttons/js/buttons.jqueryui.min.js';
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_datatables_buttons_pdf'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Buttons/js/pdfmake.min.js';
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_datatables_buttons_html5'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Buttons/js/buttons.html5.min.js';
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_datatables_buttons_font'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Buttons/js/vfs_fonts.js';
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_datatables_jszip'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Buttons/js/jszip.min.js';
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_datatables_sort_date_de'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Sorting/date-de.js';

			// Include DataTables CSS
			$GLOBALS['TL_CSS']['c4g_jq_datatables'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/media/css/jquery.dataTables_themeroller.css';
			$GLOBALS['TL_CSS']['c4g_jq_datatables_buttons']	= 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css';
			$GLOBALS['TL_CSS']['c4g_jq_datatables_buttons_jquery'] = 'system/modules/con4gis_core/lib/jQuery/plugins/datatables/extensions/Buttons/css/buttons.jqueryui.min.css';
        }

		if ($useTree || $useMaps)
		{
			// Include dynatree JS
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_dynatree'] 	= 'system/modules/con4gis_core/lib/jQuery/plugins/dynatree/jquery.dynatree.min.js';
			C4GJQueryGUI::optimizeJSForContao3('c4g_jq_dynatree');
			// Include dynatree CSS
			$GLOBALS['TL_CSS']['c4g_jq_dynatree'] 			= 'system/modules/con4gis_core/lib/jQuery/plugins/dynatree/skin/ui.dynatree.css';
		}

		if ($useHistory)
		{
   			$GLOBALS ['TL_JAVASCRIPT'] ['c4g_jq_history'] 	= 'system/modules/con4gis_core/lib/jQuery/plugins/jquery.history.js';
			C4GJQueryGUI::optimizeJSForContao3('c4g_jq_history');
		}

		if ($useTooltip)
		{
   			$GLOBALS ['TL_JAVASCRIPT'] ['c4g_jq_tooltip_b'] 	= 'system/modules/con4gis_core/lib/jQuery/plugins/jquery.tooltip.pack.js';
			C4GJQueryGUI::optimizeJSForContao3('c4g_jq_tooltip');
		}

		if ($useWswgEditor)
		{
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_bbc'] 		= 'system/modules/con4gis_core/lib/wswgEditor/editor.js';
			$GLOBALS['TL_CSS']['c4g_jq_bbc'] 				= 'system/modules/con4gis_core/lib/wswgEditor/css/editor.css';
			$GLOBALS['TL_CSS']['c4g_jq_bbc2'] 				= 'system/modules/con4gis_core/lib/wswgEditor/css/bbcodes.css';
			// also use file-upload
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_fileupload'] 	= 'system/modules/con4gis_core/lib/fileUpload/upload.js';
		}

		if ($useScrollpane)
		{
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_scrollpane'] 	= 'system/modules/con4gis_core/lib/jQuery/plugins/jScrollPane/js/jquery.jscrollpane.min.js';
			C4GJQueryGUI::optimizeJSForContao3('c4g_jq_scrollpane');
			$GLOBALS['TL_JAVASCRIPT']['c4g_jq_mousewheel'] 	= 'system/modules/con4gis_core/lib/jQuery/plugins/jScrollPane/js/jquery.mousewheel.js';
			C4GJQueryGUI::optimizeJSForContao3('c4g_jq_mousewheel');
			$GLOBALS['TL_JAVASCRIPT']['c4g_mwheelintent'] 	= 'system/modules/con4gis_core/lib/jQuery/plugins/jScrollPane/js/mwheelIntent.js';
			C4GJQueryGUI::optimizeJSForContao3('c4g_mwheelintent');
			$GLOBALS['TL_CSS']['c4g_jq_scrollpane'] 		= 'system/modules/con4gis_core/lib/jQuery/plugins/jScrollPane/css/jquery.jscrollpane.css';
		}

		if ($usePopups || ($GLOBALS['con4gis_projects_extension']['installed'] && $useMaps))
		{
			$GLOBALS['TL_CSS']['magnific-popup'] = 'system/modules/con4gis_core/lib/magnific-popup/magnific-popup.css';
			$GLOBALS['TL_JAVASCRIPT']['magnific-popup'] = 'system/modules/con4gis_core/lib/magnific-popup/magnific-popup.js';
		}

		if ($useMaps && $GLOBALS['con4gis_maps_extension']['installed'])
		{
			if (version_compare($GLOBALS['con4gis_maps_extension']['version'], '3.0', '<'))
			{
				// Maps 2
				//
				$GLOBALS['TL_JAVASCRIPT']['c4g_openlayers'] = $GLOBALS['con4gis_maps_extension']['js_openlayers_libs']['DEFAULT'];
		    	$GLOBALS['TL_JAVASCRIPT']['c4g_maps'] 		= 'system/modules/con4gis_maps/html/js/C4GMaps.js';

		    	if ($useGoogleMaps) {
		    		$GLOBALS['TL_JAVASCRIPT']['c4g_google'] = $GLOBALS['con4gis_maps_extension']['js_google'];
		    	}
			   	if ($useMapsEditor) {
			   		if ($GLOBALS['con4gis_maps_extension']['js_editor']) {
			    		$GLOBALS['TL_JAVASCRIPT']['c4g_maps_edit'] 	= $GLOBALS['con4gis_maps_extension']['js_editor'];
			    		$GLOBALS['TL_CSS']['c4g_maps_edit'] 		= $GLOBALS['con4gis_maps_extension']['css_editor'];
			   		}
			   	}
			   	// Include Extended LayerSwitcher JS
			   	$GLOBALS['TL_JAVASCRIPT']['c4g_layerswitcher'] 		= 'system/modules/con4gis_maps/html/js/C4GLayerSwitcher.js';
			   	// Include LayerSwitcher CSS (Dynatree styling)
			   	$GLOBALS['TL_CSS']['c4g_layerswitcher'] 			= 'system/modules/con4gis_maps/html/css/C4GLayerSwitcher.css';

			} else
			{
				// Maps 3
				//
				// TODO: recieve and use profileId
 				\c4g\Maps\ResourceLoader::loadResources();

				// Core-Resources
				//
				if (version_compare( VERSION, '3', '>=' ) &&
					is_array( $GLOBALS['TL_JAVASCRIPT'] ) &&
					(array_search( 'assets/jquery/core/' . JQUERY . '/jquery.min.js|static', $GLOBALS['TL_JAVASCRIPT'] ) !== false))
				{
					// jQuery is already loaded by Contao 3, don't load again!
				}
				else {
					$GLOBALS['TL_JAVASCRIPT']['c4g_jquery'] = 'system/modules/con4gis_core/lib/jQuery/jquery-1.11.1.min.js|static';
				}
				// Load magnific-popup.js for projects
		        if ($GLOBALS['con4gis_projects_extension']['installed']) {
		            $GLOBALS['TL_JAVASCRIPT']['magnific-popup'] = 'system/modules/con4gis_core/lib/magnific-popup/magnific-popup.js|static';
		            $GLOBALS['TL_CSS']['magnific-popup'] = 'system/modules/con4gis_core/lib/magnific-popup/magnific-popup.css';
		        }

		        $GLOBALS['TL_JAVASCRIPT']['clipboard'] = 'system/modules/con4gis_core/lib/clipboard.min.js|static';
				$GLOBALS['TL_JAVASCRIPT']['datetimepicker'] = 'system/modules/con4gis_core/lib/jQuery/plugins/jquery-simple-datetimepicker/1.13.0/jquery.simple-dtpicker.js|static';

				//ToDo uncomment for PDF Export
				//$GLOBALS['TL_JAVASCRIPT']['jspdf'] = 'system/modules/con4gis_core/lib/jspdf/jspdf.min.js|static';
			}
		}

		if ($addCore)
		{
	        $GLOBALS ['TL_JAVASCRIPT']['c4g_jquery_gui'] = 'system/modules/con4gis_core/lib/jQuery/plugins/jquery.c4gGui.js';
	        C4GJQueryGUI::optimizeJSForContao3('c4g_jquery_gui');
	        $GLOBALS ['TL_CSS']['c4g_jquery_gui'] = 'system/modules/con4gis_core/assets/css/c4gGui.css';
			$GLOBALS ['TL_CSS']['c4g_loader'] = 'system/modules/con4gis_core/assets/css/c4gLoader.css';
		}

		if ($addJQueryUI || $useTree || $useMaps)
		{
			// Add the JQuery UI CSS to the bottom of the $GLOBALS['TL_CSS'] array to prevent overriding from other plugins
			$GLOBALS['TL_CSS']['c4g_jquery_ui_core'] = 'system/modules/con4gis_core/lib/jQuery/ui-1.11.0.custom/jquery-ui.min.css';
			// Set the JQuery UI theme to be used
			if (empty($GLOBALS['TL_CSS']['c4g_jquery_ui'])) {
				$GLOBALS['TL_CSS']['c4g_jquery_ui'] = 'system/modules/con4gis_core/lib/jQuery/ui-1.11.0.custom/jquery-ui.theme.min.css';
			}
		}

    }
}
