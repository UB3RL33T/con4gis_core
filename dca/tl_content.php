<?php

/**
 * Contao Open Source CMS
 *
 * @version   php 5
 * @package   con4gis
 * @author    Tobias Dobbrunz <http://www.kuestenschmiede.de>
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2014 - 2015
 * @link      https://www.kuestenschmiede.de
 * @filesource
 */


namespace c4g;

/***
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['c4g_activationpage'] = '{type_legend},type,headline;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
// $GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'c4g_switcher';
// $GLOBALS['TL_DCA']['tl_content']['subpalettes']['c4g_map_layer_switcher'] = 'c4g_map_layer_switcher_open';
// if ($GLOBALS['con4gis_core_extension']['installed']) {
//   $GLOBALS['TL_DCA']['tl_content']['subpalettes']['c4g_map_layer_switcher'] .= ',c4g_map_layer_switcher_ext';
// }

/***
 * Fields
 */
// $GLOBALS['TL_DCA']['tl_content']['fields']['c4g_map_id'] = array
// (
//   'label'                   => &$GLOBALS['TL_LANG']['tl_content']['c4g_map_id'],
//   'exclude'                 => true,
//   'inputType'               => 'select',
//   'options_callback'        => array('tl_content_c4g_maps', 'get_maps'),
//   'eval'                    => array('submitOnChange'=>true)
// );


/**
 * Class tl_content_c4g_activationpage
 *
 * Provide methods that are used by the data configuration array.
 */
class tl_content_c4g_activationpage extends \Backend
{

}
