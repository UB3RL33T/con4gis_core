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


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'c4g',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'c4g\C4GApiCheck'                => 'system/modules/con4gis_core/classes/C4GApiCheck.php',
	'c4g\C4GHTMLFactory'             => 'system/modules/con4gis_core/classes/C4GHTMLFactory.php',
	'c4g\C4GInfo'                    => 'system/modules/con4gis_core/classes/C4GInfo.php',
	'C4GJQueryGUI'                   => 'system/modules/con4gis_core/classes/C4GJQueryGUI.php',
	'c4g\C4GMembergroupSync'         => 'system/modules/con4gis_core/classes/C4GMembergroupSync.php',
	'c4g\C4GMigration'               => 'system/modules/con4gis_core/classes/C4GMigration.php',
	'c4g\C4GUtils'                   => 'system/modules/con4gis_core/classes/C4GUtils.php',
	'c4g\HttpResultHelper'           => 'system/modules/con4gis_core/classes/HttpResultHelper.php',
	'c4g\Core\ResourceLoader'      	 => 'system/modules/con4gis_core/classes/ResourceLoader.php',
	'c4g\Core\C4GApiCache' 			 => 'system/modules/con4gis_core/classes/C4GApiCache.php',
	'c4g\Core\C4GAutomator'			 =>  'system/modules/con4gis_core/classes/C4GAutomator.php',

	// Elements
	'c4g\Content_c4g_activationpage' => 'system/modules/con4gis_core/elements/Content_c4g_activationpage.php',

	// Interfaces
	'c4g\C4gApiEndpoint'             => 'system/modules/con4gis_core/interfaces/C4gApiEndpoint.php',

	// Models
	'c4g\C4gActivationkeyModel'      => 'system/modules/con4gis_core/models/C4gActivationkeyModel.php',

	// API
    'c4g\C4GFileUpload'         => 'system/modules/con4gis_core/assets/vendor/fileUpload.php',
	'c4g\C4GDeliverFileApi'		=> 'system/modules/con4gis_core/classes/C4GDeliverFileApi.php'

));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_c4g_apicheck'        => 'system/modules/con4gis_core/templates',
	'be_c4g_info'            => 'system/modules/con4gis_core/templates',
	'be_c4g_membergroupsync' => 'system/modules/con4gis_core/templates',
	'be_c4g_migration'       => 'system/modules/con4gis_core/templates',
	'ce_c4g_activationpage'  => 'system/modules/con4gis_core/templates',
));
