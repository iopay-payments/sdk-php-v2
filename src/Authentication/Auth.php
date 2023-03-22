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

namespace IoPay\Authentication;

use Exception;
use IoPay\Connection\Api;
use IoPay\Environment;
use IoPay\Logger\Log;

class Auth {

    protected $logger;
    protected $email;
    protected $secret;
    protected $sellerId;
    protected $auth;
    protected $headers;

    public function __construct()
    {
        $this->logger   = new Log();
        $this->email    = Environment::IOPAY_EMAIL;
        $this->secret   = Environment::IOPAY_SECRET;
        $this->sellerId = Environment::IOPAY_SELLER_ID;

        $this->auth = array(
            "email"         => $this->email,
            "secret"        => $this->secret,
            "io_seller_id"  => $this->sellerId
        );

        $this->headers = array(
            "cache-control: no-cache",
            "content-type: application/json",
        );
    }

    public function token() {
        try {
            $api = new Api();
            $api->setHeader($this->headers);
            $api->setUri("/auth/login?email={$this->email}&secret={$this->secret}&io_seller_id={$this->sellerId}");
            $api->setData($this->auth);
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                throw new Exception('IoPay: Erro ao recuperar access_token: '.json_encode($response['error']));
            } else {
                if (isset($response['access_token'])) {
                    return $response['access_token'];
                }
            }
        } catch (Exception $e) {
            $this->logger->log("--- getToken Error ---");
            $this->logger->log($e->getMessage());
            return false;
        }
    }

    public function cardAuth() {
        try {
            $api = new Api();
            $api->setHeader($this->headers);
            $api->setUri("/v1/card/authentication");
            $api->setData($this->auth);
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                throw new Exception('IoPay: Erro ao recuperar card_token: '.json_encode($response['error']));
            } else {
                if (isset($response['access_token'])) {
                    return $response['access_token'];
                }
            }
        } catch (Exception $e) {
            $this->logger->log("--- getCardToken Error ---");
            $this->logger->log($e->getMessage());
            return false;
        }
    }
}