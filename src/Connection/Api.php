<?php

/**
 * 2022-2023 [IoPay]
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author    IoPay.
 * @copyright 2022-2023 IoPay.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 *
 */

namespace IoPay\Connection;

use Exception;
use IoPay\Environment;
use IoPay\Logger\Log;

class Api {
    /**
     * Environment variables
     * @var string
     */
    protected $apiUrl;
    protected $header;
    protected $uri;
    protected $data;
    protected $response;
    protected $responseCode;
    protected $logger;

    public function __construct()
    {

        $url = Environment::URL_LIVE;
        if (Environment::IS_SANDBOX) {
            $url = Environment::URL_SANDBOX;
        }

        $this->apiUrl  = $url;
        $this->logger   = new Log();

        $this->header = array(
            "cache-control: no-cache",
            "content-type: application/json",
        );
    }

    /**
     * Set headers for send to API
     * @param $header
     */
    public function setHeader($header) {
        $this->header = $header;
    }

    /**
     * Set URI on path
     * @param $uri
     */
    public function setUri($uri) {
        $this->uri = $uri;
    }

    /**
     * Set data for send to API
     * @param $data
     */
    public function setData($data) {
        $this->data = json_encode($data);
    }

    /**
     * Return API response
     * @return mixed
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * Return API response code
     * @return mixed
     */
    public function getResponseCode() {
        return $this->responseCode;
    }

    /**
     * Return a combination from URL + URI
     * @return false|string
     * @throws Exception
     */
    public function getCompleteUrl() {
        if (!$this->uri || !$this->apiUrl) {
            throw new Exception('Parâmetros inválidos na conexão da API');
        }

        return $this->apiUrl.$this->uri;
    }

    /**
     * Method to connect and send data to API
     * @return false|mixed|null
     */
    public function connect($method = 'POST') {
        try {

            if (!$this->uri) {
                throw new Exception('Parâmetros inválidos na conexão da API');
            }

            $url = $this->apiUrl.$this->uri;

            $this->logger->log('---- API Connect ---');
            $this->logger->log($url);
            $this->logger->log($this->data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);

            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, 1);
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            }

            if ($this->data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

            if (curl_error($ch)) {
                throw new Exception(
                    sprintf('Falha ao tentar enviar parâmetros ao IoPay: %s (%s)', curl_error($ch), curl_errno($ch))
                );
            }

            $response       = curl_exec($ch);
            $http_status    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);

            $this->responseCode = $http_status;
            $this->response     = json_decode($response, true);

            $this->logger->log('---- API Response ---');
            $this->logger->log($this->response);

            return $this->response;

        } catch (Exception $e) {
            $this->logger->log($e->getMessage());
            return null;
        }
    }
}