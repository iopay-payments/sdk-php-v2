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
 * @copyright 2022-2022 IoPay.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 *
 */

namespace IoPay\SharedCustomer;

use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;

class Share {

    /**
     * @param $authorized_partner
     * @return false|mixed|void
     */
    public function authorizeSeller($authorized_partner) {
        try {
            $auth   = new Auth();
            $token  = $auth->token();
            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/shared_customers/authorize_seller");
            $api->setData(['authorized_partner' => $authorized_partner]);
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao autorizar customer: {$error}");
            } else {
                if (isset($response['id'])) {
                    return $response['id'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $authId
     * @return false|mixed|void
     */
    public function get($authId) {
        try {
            $auth   = new Auth();
            $token  = $auth->token();
            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/shared_customers/authorization/{$authId}");
            $api->connect('GET');

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao listar auth: {$error}");
            } else {
                if (isset($response['id'])) {
                    return $response['id'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return false|mixed|void
     */
    public function listAuthorized() {
        try {
            $auth   = new Auth();
            $token  = $auth->token();
            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/shared_customers/authorized_sellers");
            $api->connect('GET');

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao listar auth: {$error}");
            } else {
                if (isset($response['total'])) {
                    return $response['total'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return false|mixed|void
     */
    public function listAuthorizations() {
        try {
            $auth   = new Auth();
            $token  = $auth->token();
            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/shared_customers/authorizations");
            $api->connect('GET');

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao listar auth: {$error}");
            } else {
                if (isset($response['total'])) {
                    return $response['total'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $authId
     * @return false|mixed
     */
    public function deleteAuthorization($authId)
    {
        try {
            $auth   = new Auth();
            $token  = $auth->token();

            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/shared_customers/authorization/{$authId}");
            $api->connect('DELETE');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }
}