<?php

/**
 * con4gis
 *
 * @version   php 5
 * @package   con4gis
 * @author    con4gis contributors (see "authors.txt")
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2014
 * @link      https://www.kuestenschmiede.de
 * @filesource 
 */

// index.php is a frontend script
define('TL_MODE', 'FE');
// Start the session so we can access known request tokens
@session_start();

// Allow to bypass the token check
if (!isset( $_POST['REQUEST_TOKEN'] )) {
    define('BYPASS_TOKEN_CHECK', true);
}


// Initialize the system
require('../../../system/initialize.php');

/**
 * Api controller.
 */
class Api4Gis extends Frontend
{

	/**
     * Initialize the object
     */
	public function __construct()
	{
		// Load user object before calling the parent constructor
		$this->import('FrontendUser', 'User');
		parent::__construct();

		// Check whether a user is logged in
		define('BE_USER_LOGGED_IN', $this->getLoginStatus('BE_USER_AUTH'));
		define('FE_USER_LOGGED_IN', $this->getLoginStatus('FE_USER_AUTH'));
	}


	/**
     * Run the controller
     */
	public function run()
	{
        // Set default headers for api
        header('Content-Type: application/json');
        
        // Maintenance mode
		if ($GLOBALS['TL_CONFIG']['maintenanceMode'] && !BE_USER_LOGGED_IN)
		{
			header('HTTP/1.1 503 Service Unavailable');
            exit;
		}
        
        // Get path
        $arrFragments = $this->getFragmentsFromUrl();

        // Stop on empty path
        if (empty($arrFragments)) 
        {
            header('HTTP/1.1 400 Bad Request');
            exit;
        }
        
        // Extract api endpoint
        $strApiEndpoint = array_shift($arrFragments);
                
        // Stop if no matching endpoint is found
        if (!array_key_exists($strApiEndpoint, $GLOBALS['TL_API']))
        {
            header('HTTP/1.1 400 Bad Request');
            exit;
        }
        
        // Create the api endpoint handler
        $objHandler = new $GLOBALS['TL_API'][$strApiEndpoint]();

        // Generate the result
        echo $objHandler->generate($arrFragments);
    }
    
    /**
     * Split the request into fragments and find the api resource
     */
    protected function getFragmentsFromUrl()
    {
        // Return null on empty request path
        if (\Environment::get('request') == '')
        {
            return null;   
        }
        
        $test = \Environment::get('request');
        
        // Get the request string without the index.php fragment
		if (\Environment::get('request') == 'api4gis/index.php')
		{
			$strRequest = '';
		}
		else
		{
			list($strRequest) = explode('?', str_replace('api4gis/index.php/', '', \Environment::get('request')), 2);
		}
        
        // Remove api fragment
        if (substr($strRequest, 0, 8) == 'api4gis/')
        {
            $strRequest = substr($strRequest, 8);
        }
        
		// URL decode here
		$strRequest = rawurldecode($strRequest);

        // return the fragments
		return explode('/', $strRequest);
    }
}

/**
 * Instantiate controller
 */
$objApi = new Api4Gis();
$objApi->run();