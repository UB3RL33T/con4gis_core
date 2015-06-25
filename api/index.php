<?php

    /**
     * con4gis
     *
     * @version   php 5
     * @package   con4gis
     * @author    con4gis contributors (see "authors.txt")
     * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
     * @copyright Küstenschmiede GmbH Software & Design 2014 - 2015
     * @link      https://www.kuestenschmiede.de
     * @filesource
     */

    // index.php is a frontend script
    define('TL_MODE', 'FE');
    // Start the session so we can access known request tokens
    @session_start();

    // Allow to bypass the token check
    if (!isset($_POST['REQUEST_TOKEN'])) {
        /**
         *
         */
        define('BYPASS_TOKEN_CHECK', true);
    }


    // Initialize the system
    require('../../../../system/initialize.php');

    /**
     * Api controller.
     */
    class Api4Gis extends Frontend
    {


        /**
         * @var string
         */
        private $_sApiUrl = 'system/modules/con4gis_core/api/index.php';


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
            if ($GLOBALS['TL_CONFIG']['maintenanceMode'] && !BE_USER_LOGGED_IN) {
                header('HTTP/1.1 503 Service Unavailable');
                exit;
            }

            // Get path
            $arrFragments = $this->getFragmentsFromUrl();

            // Stop on empty path
            if (empty($arrFragments)) {
                header('HTTP/1.1 400 Bad Request');
                exit;
            }

            // Extract api endpoint
            $strApiEndpoint = array_shift($arrFragments);

            // check if its a test-call
            if ($strApiEndpoint == 'c4g_apicheck_ajax') {
                if (!$arrFragments[0] || array_key_exists($arrFragments[0], $GLOBALS['TL_API'])) {
                    return true;
                } else {
                    header('HTTP/1.1 501 Not Implemented');
                    exit;
                }
            }

            // Stop if no matching endpoint is found
            if (!array_key_exists($strApiEndpoint, $GLOBALS['TL_API'])) {
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
            if (\Environment::get('request') == '') {
                return null;
            }

            $test = \Environment::get('request');

            // Get the request string without the index.php fragment
            if (\Environment::get('request') == $this->_sApiUrl . 'index.php') {
                $strRequest = '';
            } else {
                list($strRequest) = explode('?', str_replace($this->_sApiUrl . 'index.php/', '', \Environment::get('request')), 2);
            }

            // Remove api fragment
            if (substr($strRequest, 0, strlen($this->_sApiUrl)) == $this->_sApiUrl) {
                $strRequest = substr($strRequest, strlen($this->_sApiUrl));
            }

            // URL decode here
            $strRequest = rawurldecode($strRequest);
            $strRequest = substr($strRequest,1);

            // return the fragments
            return explode('/', $strRequest);
        }
    }

    /**
     * Instantiate controller
     */
    $objApi = new Api4Gis();
    $objApi->run();