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
    $this->Template->output = 'Frontend-URL: {{env::path}}{{env::request}}<br>';
    $this->Template->output .= 'This action handler: ' . $this->c4g_activationpage_action_handler . '<br>';
    $this->Template->output .= 'This success message: ' . $this->c4g_activationpage_success_msg . '<br>';
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