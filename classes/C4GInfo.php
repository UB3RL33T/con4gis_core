<?php

/**
 * Contao Open Source CMS
 *
 * @version   php 5
 * @package   con4gis
 * @author    Tobias Dobbrunz
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2014 - 2015
 * @link      https://www.kuestenschmiede.de
 * @filesource
 */

namespace c4g;


class C4GInfo extends \BackendModule
{
	protected $strTemplate = 'be_c4g_info';

	/**
     * Generate the module
     * @return string
     */
    public function generate()
    {
        $GLOBALS['TL_CSS'][] = 'system/modules/con4gis_core/assets/css/be_c4g_info.css';

    	// check for actions (atm only "migrate")
    	if (\Input::get('perf') != '') {
    		if (\Input::get('perf') == 'migrate' && \Input::get('mod') != '') {
        		$objCallback = new C4GMigration(\Input::get('mod'));
        		return $objCallback->generate();
    		} elseif (\Input::get('perf') == 'apicheck' && \Input::get('mod') != '') {
                $objCallback = new C4GApiCheck(\Input::get('mod'));
                return $objCallback->generate();
            }
    	}

    	return parent::generate();
    }

	/**
     * Generate the module
     */
    protected function compile()
    {
        // nothing to do here
    }

}
?>