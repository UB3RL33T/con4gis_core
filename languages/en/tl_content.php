<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 *
 * @version   php 5
 * @package   con4gis
 * @author     Jürgen Witte <http://www.kuestenschmiede.de>
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2014 - 2015
 * @link      https://www.kuestenschmiede.de
 * @filesource
 */



/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['action_handler']           = array('Action handler', 'The handler that will be called, when a member with a valid key enters this page.');
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['confirmation']             = array('Enable confirmation for action', 'This will allow the member to confirm the action, that should be executed on this page.');
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['confirmation_text']        = array('Confirmation info text', 'This text will be shown to the user and should contain information about the action that will be triggered with this page.');
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['confirmation_button']      = array('Custom confirmation-button-label', 'Here you can replace the default label of the confirmation-button. (empty = use default label)');
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['success_msg']              = array('Custom success message', 'Enter a custom message that will be shown to the member, when the key was valid and the executed function returned a success. If this is empty, the functions default message will be used, if existant, otherwise the activationpage default message will be used.');
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['invalid_key_msg']          = array('Custom error message (invalid key)', 'Enter a custom message that will be shown to the member, when the used key is invalid or already used. If this is empty, the functions default message will be used, if existant, otherwise the activationpage default message will be used.');
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['fields']['handler_error_msg']        = array('Custom error message (handler error)', 'Enter a custom message that will be shown to the member, when the choosen function did not return a success. If this is empty, the functions default message will be used, if existant, otherwise the activationpage default message will be used.');

/**
 * Legend
 */
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage_function_legend']         = 'Function';
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage_custom_message_legend']   = 'Custom Messages';

/**
 * Errors
 */
// $GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['errors']['']              = array('', '');

/**
 * Misc.
 */
$GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['msc']['auto_action_handler'] = 'Choose automatically';