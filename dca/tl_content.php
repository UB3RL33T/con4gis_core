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
$GLOBALS['TL_DCA']['tl_content']['palettes']['c4g_activationpage'] =  '{type_legend},type,headline;'.
                                                                      '{c4g_activationpage_function_legend},c4g_activationpage_action_handler;'. //@TODO more actions in the future? (error-fct, etc)
                                                                      '{c4g_activationpage_custom_message_legend},c4g_activationpage_success_msg,c4g_activationpage_invalid_key_msg,c4g_activationpage_function_error_msg;'.
                                                                      '{template_legend:hide},customTpl;'.
                                                                      '{protected_legend:hide},protected;'.
                                                                      '{expert_legend:hide},guests,cssID,space';

/***
 * Fields
 */

// function group
//
$GLOBALS['TL_DCA']['tl_content']['fields']['c4g_activationpage_action_handler'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['action_handler'],
  'exclude'                 => true,
  'inputType'               => 'select',
  'options_callback'        => array('c4g\tl_content_c4g_activationpage', 'get_registered_action_handlers'),
  'eval'                    => array('includeBlankOption' => true, 'blankOptionLabel' => $GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['msc']['auto_action_handler']),
  'sql'                     => "varchar(255) NOT NULL default ''"
);

// custom message group
//
$GLOBALS['TL_DCA']['tl_content']['fields']['c4g_activationpage_success_msg'] = array
(
  'label'           => &$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['success_msg'],
  'search'          => true,
  'inputType'       => 'textarea',
  'eval'            => array('rte'=>'tinyMCE'),
  'sql'             => "text NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['c4g_activationpage_invalid_key_msg'] = array
(
  'label'           => &$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['invalid_key_msg'],
  'search'          => true,
  'inputType'       => 'textarea',
  'eval'            => array('rte'=>'tinyMCE'),
  'sql'             => "text NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['c4g_activationpage_function_error_msg'] = array
(
  'label'           => &$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['handler_error_msg'],
  'search'          => true,
  'inputType'       => 'textarea',
  'eval'            => array('rte'=>'tinyMCE'),
  'sql'             => "text NULL"
);

/**
 * Class tl_content_c4g_activationpage
 *
 * Provide methods that are used by the data configuration array.
 */
class tl_content_c4g_activationpage extends \Backend
{
  public function get_registered_action_handlers (DataContainer $dc)
  {
    // @TODO
    // walk through the "registered_functions"-array
    // and return functions as list

    return array();
  }
}
