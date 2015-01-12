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

      $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['CE']['c4g_activationpage'][0]) . ' ###';
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
    $this->Template->output = "Activationpage compiled :)";
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