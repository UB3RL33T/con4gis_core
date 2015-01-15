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

/**
 * Class Content_c4g_activationpage
 */
class Content_c4g_activationpage extends \Module
{
  /**
   * Template
   * @var string
   */
  protected $strTemplate = 'ce_c4g_activationpage';

  /**
   * Generate content element
   */
  public function generate()
  {
    if (TL_MODE == 'BE')
    {
      $objTemplate = new \BackendTemplate('be_wildcard');

      // $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['CTE']['c4g_activationpage'][0]) . ' ###';
      $objTemplate->wildcard = '### ' . ($this->c4g_activationpage_action_handler ?: utf8_strtoupper($GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['msc']['auto_action_handler']) ). ' ###';
      $objTemplate->title = $this->headline;
      $objTemplate->id = $this->id;
      $objTemplate->link = $this->name;
      $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

      return $objTemplate->parse();
    }

    return parent::generate();
  }

  /**
   * Generate module
   */
  protected function compile()
  {
    // prepare stuff
    $this->import('FrontendUser', 'User');
    $stateClass = array
    (
      1 => 'c4g_activation_success',
      0 => 'c4g_activation_confirm',
      -1 => 'c4g_activation_failure'
    );

    // check if a confirmation is needed
    if ($this->c4g_activationpage_confirmation && empty( $_GET['confirm'] )) {
      $this->Template->state = $stateClass[0];
      $this->Template->output = $this->c4g_activationpage_confirmation_text;
      $this->Template->output .= '<a href="{{env::path}}{{env::request}}&confirm=true" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text">' . ($this->c4g_activationpage_confirmation_button ?: $GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['msc']['default_confirmation_button']) . '</span></a>';
    } else {
      // 1) check key
      $action = '';
      $this->Template->state = $stateClass[-1];
      $key = $_GET['key'] ?: '';
      if (!empty( $key ) && C4gActivationkeyModel::keyIsValid( $key )) {
        $action = C4gActivationkeyModel::getActionForKey( $key );
      }
      if (!empty( $action )) {
        // the key is valid
        //
        $action = explode(':', $action);
        if ($action[1]) {
          $action[1] = explode('&', $action[1]);
        }
        // 2) find handler
        if (!$this->c4g_activationpage_action_handler || $this->c4g_activationpage_action_handler === $action[0]) {
          $actionHandler = $GLOBALS['C4G_ACTIVATIONACTION'][$action[0]];
        }
        if (!empty( $actionHandler )) {
          // handler found
          // 3) execute handler
          try {
            $clActionHandler = new $actionHandler();
            if ($clActionHandler->performActivationAction( $action[0], $action[1] ?: array() )) {
              // everything went right
              // claim key and return the success
              $this->Template->state = $stateClass[1];
              $this->Template->output = $this->c4g_activationpage_success_msg ?: $GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['msc']['success_msg'];
              if( !C4gActivationkeyModel::assignUserToKey($this->User->id, $key) ) {
              $this->Template->output .= '<div class="c4g_warning">' . $GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['error']['key_not_claimed'] . '</div>';
              }
            } else {
              // ERROR: the handlers action failed
              $this->Template->output = $this->c4g_activationpage_handler_error_msg ?: $GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['errors']['handler_failed'];
            }
          } catch (Exeption $e) {
            $this->Template->output = $GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['errors']['no_handler'];
          }
        } else {
          // ERROR: no appropriate handler found
          $this->Template->output = $GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['errors']['no_handler'];
        }
      } else {
        // ERROR: the key is invalid
        $this->Template->output = $this->c4g_activationpage_invalid_key_msg ?: $GLOBALS['TL_LANG']['tl_content']['c4g_activationpage']['errors']['invalid_key'];
      }
    }
  }

  public function repInsertTags( $str )
  {
    return parent::replaceInsertTags($str);
  }

  public function import($strClass, $strKey=false, $blnForce=false)
  {
    parent::import($strClass, $strKey, $blnForce);
  }

  public function getInput() {
    return $this->Input;
  }

  public function getFrontendUrl($arrRow) {
    return parent::generateFrontendUrl($arrRow);
  }


}

?>