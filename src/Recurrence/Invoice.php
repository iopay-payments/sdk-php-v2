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

namespace IoPay\Recurrence;

use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;

class Invoice {

    /**
     * @return false|mixed
     */
    public function listInvoices()
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
            $api->setUri("/v1/recurrence/invoice/list");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param $invoiceId
     * @return false|mixed
     */
    public function details($invoiceId)
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
            $api->setUri("/v1/recurrence/invoice/{$invoiceId}");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }
}