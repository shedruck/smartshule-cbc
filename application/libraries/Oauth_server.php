<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('OAuth2/Autoloader.php');

class Oauth_server
{

        private $ci;

        /**
         * __construct
         */
        public function __construct()
        {
                $this->ci = & get_instance();
        }

        /**
         * init_server
         * 
         * @return \OAuth2\Server
         */
        public function init_server()
        {
                $this->ci = & get_instance();

                $dsn = "mysql:dbname={$this->ci->db->database};host=localhost";
                $username = $this->ci->db->username;
                $password = $this->ci->db->password;
                OAuth2\Autoloader::register();

                //$dsn is the Data Source Name for your database
                $storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

                //Pass a storage object or array of storage objects to the OAuth2 server class
                $server = new OAuth2\Server($storage, array(
                    'access_lifetime' => 604800,
                    'allow_implicit' => true,
                    'refresh_token_lifetime' => 259200
                ));
                //Add the "Client Credentials" grant type (it is the simplest of the grant types)
                $server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

                //Add the "User Credentials" grant type
                $server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));

                //Add the "Authorization Code" grant type
                //$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

                return $server;
        }

        /**
         * returns an OAuth2.0 Token to the client
         */
        function token()
        {
                $server = $this->init_server();

                // Handle a request for an OAuth2.0 Access Token and send the response to the client
                return $server->TokenRequest(OAuth2\Request::createFromGlobals());
        }

        function token2()
        {
                $server = $this->init_server();

                // Handle a request for an OAuth2.0 Access Token and send the response to the client
                $server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
        }

        /**
         * Validate Tokens in Api Requests
         * 
         */
        function resource()
        {
                $server = $this->init_server();

                // Handle a request to a resource and authenticate the access token
                if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
                {
                        $server->getResponse()->send();
                        die();
                }
                echo json_encode(array('success' => true, 'code' => 200, 'message' => 'Authorized to access the API!'));
        }

}
