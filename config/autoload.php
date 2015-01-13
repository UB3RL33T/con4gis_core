<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package Con4gis_core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
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
	'c4g\C4GHTMLFactory'             => 'system/modules/con4gis_core/classes/C4GHTMLFactory.php',
	'c4g\C4GInfo'                    => 'system/modules/con4gis_core/classes/C4GInfo.php',
	'C4GJQueryGUI'                   => 'system/modules/con4gis_core/classes/C4GJQueryGUI.php',
	'c4g\C4GMigration'               => 'system/modules/con4gis_core/classes/C4GMigration.php',
	'c4g\C4GUtils'                   => 'system/modules/con4gis_core/classes/C4GUtils.php',
	'c4g\HttpResultHelper'           => 'system/modules/con4gis_core/classes/HttpResultHelper.php',

	// Elements
	'c4g\Content_c4g_activationpage' => 'system/modules/con4gis_core/elements/Content_c4g_activationpage.php',

	// Interfaces
	'c4g\C4gApiEndpoint'             => 'system/modules/con4gis_core/interfaces/C4gApiEndpoint.php',

	// Models
	'c4g\C4gActivationkeyModel'      => 'system/modules/con4gis_core/models/C4gActivationkeyModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_c4g_info'           => 'system/modules/con4gis_core/templates',
	'be_c4g_migration'      => 'system/modules/con4gis_core/templates',
	'ce_c4g_activationpage' => 'system/modules/con4gis_core/templates',
));
