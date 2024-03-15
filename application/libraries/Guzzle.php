<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

include_once(dirname(__FILE__) . '/vendor/autoload.php');

class Guzzle
{

        protected $token;
        protected $end;

        public function __construct()
        {
                $this->token = 'e651448bca3c5768c8acb95959888d92507c285a';
        }

        function get($url, $debug = FALSE)
        {
                $client = new \GuzzleHttp\Client();
                try
                {
                        $reqw = $client->request('GET', $url, [
                            'headers' => [
                                'Content-type' => 'application/json',
                                'Accept' => 'application/json',
                                'X-Authorization' => $this->token
                            ], 'debug' => $debug
                        ]);

                        $resp = $reqw->getBody()->getContents();
                }
                catch (RequestException $e)
                {
                        $resp = $e->getResponse()->getBody()->getContents();
                }
                catch (Exception $e)
                {
                        $resp = $e->getResponse()->getBody()->getContents();
                }
                if ($debug)
                {
                        print_r($resp);
                }

                return $resp;
        }

        function post($url, $data = [], $debug = FALSE)
        {
                $client = new \GuzzleHttp\Client();
                try
                {
                        $reqw = $client->request('POST', $url, [
                            'headers' => [
                                'Accept' => 'application/json',
                                'X-Authorization' => $this->token
                            ],
                            'form_params' => $data,
                            'debug' => $debug
                        ]);
                        //$resp = $reqw->getStatusCode();
                        $resp = $reqw->getBody()->getContents();
                }
                catch (RequestException $e)
                {
                        $resp = $e->getResponse()->getBody()->getContents();
                }
                catch (Exception $e)
                {
                        $resp = $e->getResponse()->getBody()->getContents();
                }
                if ($debug)
                {
                        echo '<pre>';
                        print_r($resp);
                        echo '</pre>';
                }

                return $resp;
        }

        /**
         * Post JSON to url
         * 
         * @param type $url
         * @param type $data
         * @param type $debug
         * @return type
         */
        function postjs($url, $data, $debug = FALSE)
        {
                $client = new \GuzzleHttp\Client();
                try
                {
                        $reqw = $client->request('POST', $url, [
                            'headers' => [
                                'Accept' => 'application/json'
                            ],
                            'json' => $data,
                            'debug' => $debug
                        ]);
                        //$resp = $reqw->getStatusCode();
                        $resp = $reqw->getBody()->getContents();
                }
                catch (RequestException $e)
                {
                        $resp = $e->getResponse()->getBody()->getContents();
                }
                catch (Exception $e)
                {
                        $resp = $e->getResponse()->getBody()->getContents();
                }
                if ($debug)
                {
                        echo '<pre>';
                        print_r($resp);
                        echo '</pre>';
                }

                return $resp;
        }

}
