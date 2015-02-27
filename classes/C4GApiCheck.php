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


class C4GApiCheck extends \BackendModule
{
    protected $strTemplate = 'be_c4g_apicheck';
    protected $module = '';
    protected $errorFlag = '';
    protected $action = '';
    protected $output = array();
    protected $buttons = array();

    /**
     * [__construct description]
     * @param [type] $mod [description]
     */
    public function __construct( $mod )
    {
        parent::__construct();
        // import database
        // $this->import('Database');

        // set targeted module
        $this->module = $mod;

    }

    /**
     * Generate the module
     * @return string
     */
    public function generate()
    {
        if (\Input::get('act') != '') {
            $this->action = \Input::get('act');
        } else {
            $this->action = 'init';
        }

        switch( $this->action )
        {
            case 'exec':
                $this->checkApi();
                break;
            case 'back':
                \Controller::redirect( \Environment::get('script') . '?do=c4g_core' );
            case 'init':
            default:
                $this->output[] = $GLOBALS['TL_LANG']['MSC']['C4G_BE_INFO']['APICHECK']['INTRO'];
                $this->output[] = '<span class="c4g_warning">' . $GLOBALS['TL_LANG']['MSC']['C4G_BE_INFO']['APICHECK']['WARNING'] . '</span>';

                $this->buttons[] = array(
                    action  => 'exec',
                    label   => $GLOBALS['TL_LANG']['MSC']['C4G_BE_INFO']['BTN']['CHECKAPI']
                );
                break;
        }
        $this->buttons[] = array(
            action  => 'back',
            label   => $GLOBALS['TL_LANG']['MSC']['C4G_BE_INFO']['BACK']
        );

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $this->Template->mod = $this->module;

        $this->Template->action = $this->action ?: false;
        $this->Template->output = $this->output ?: '';

        $this->Template->buttons = $this->buttons ?: '';

        // $GLOBALS['TL_CSS'][] = 'system/modules/con4gis_core/assets/css/be_c4g_info.css';
        // $this->Template->c4gModules->con4gis_maps->installed = $GLOBALS[];
    }

    protected function checkApi()
    {
        if ($this->httpCheck()) {
            $this->output[] = '<span class="c4g_success">' . $GLOBALS['TL_LANG']['MSC']['C4G_BE_INFO']['APICHECK']['WORKS'] . '</span>';
            return true;
        }

        if ($this->errorFlag == 'TRYAGAIN') {
            if ($this->htaccessToggleRewriteBase()) {
                if ($this->httpCheck()) {
                    $this->output[] = '<span class="c4g_success">' . $GLOBALS['TL_LANG']['MSC']['C4G_BE_INFO']['APICHECK']['REPAIRED'] . '</span>';
                    return true;
                } else {
                    // undo htaccess-change back
                    $this->htaccessToggleRewriteBase();
                }
            }
        }

        $this->output[] = '<span class="c4g_error">' . $this->getMessageForCurrentErrorFlag() . '</span>';
        $this->output[] = '<span class="c4g_error">' .$GLOBALS['TL_LANG']['MSC']['C4G_BE_INFO']['APICHECK']['STILLBROKEN'] . '</span>';
        return false;
    }

    protected function httpCheck()
    {
        // set test-params
        if ($this->module) {
            $testParams = 'c4g_' . $this->module . '_ajax';
        } else {
            $testParams = '';
        }

        // connection-check
        $oHandle = curl_init( \Environment::get('base') . 'system/modules/con4gis_core/api/c4g_apicheck_ajax/' . $testParams );
        curl_setopt($oHandle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($oHandle);
        $httpCode = curl_getinfo($oHandle, CURLINFO_HTTP_CODE);
        curl_close($oHandle);

        // check httpCode
        //
        switch ($httpCode)
        {
            case '200':
                // everything is fine
                $this->errorFlag = '';
                break;
            case '501':
                // the module was not found
                $this->errorFlag = 'MODULENOTFOUND';
                break;
            case '403':
            case '404':
            case '500':
                // seems to be the .htaccess-error
                $this->errorFlag = 'TRYAGAIN';
                break;

            default:
                // other error-codes
                $this->errorFlag = 'OTHER';
                break;
        }

        // return the result
        return empty($this->errorFlag);
    }

    protected function htaccessToggleRewriteBase()
    {
        $path = "../system/modules/con4gis_core/api/.htaccess";
        if (!is_writeable($path)) {
            $this->errorFlag = 'NOWRITERIGHTS';
            return false;
        }

        $htaccess = file_get_contents($path);

        preg_match("/(##XX##\s*?)(#\s?RewriteBase)/", $htaccess);

        if (preg_match("/##XX##\s*?(#\s?RewriteBase)/", $htaccess)) {
            file_put_contents($path, preg_replace("/(##XX##\s*?)(#\s?RewriteBase)/", '${1}RewriteBase', $htaccess));
        } elseif (preg_match("/##XX##\s*?(RewriteBase)/", $htaccess)) {
            file_put_contents($path, preg_replace("/(##XX##\s*?)(RewriteBase)/", '${1}# RewriteBase', $htaccess));
        } else {
            $this->errorFlag = 'NOREWRITEBASE';
            return false;
        }

        return true;
    }

    protected function getMessageForCurrentErrorFlag()
    {
        return $GLOBALS['TL_LANG']['MSC']['C4G_BE_INFO']['APICHECK'][$this->errorFlag] ?: $GLOBALS['TL_LANG']['MSC']['C4G_BE_INFO']['APICHECK']['UNKNOWNERROR'];
    }
}