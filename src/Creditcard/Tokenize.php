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

namespace IoPay\Creditcard;

use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;
use IoPay\Logger\Log;

class Tokenize {

    protected $creditcard;

    /**
     * @return mixed
     */
    public function getCreditcard()
    {
        return $this->creditcard;
    }

    /**
     * @param mixed $creditcard
     */
    public function setCreditcard(Creditcard $creditcard)
    {
        $this->creditcard = $creditcard;
    }


    public function cardToken() {
        $auth       = new Auth();
        $cardAuth   = $auth->cardAuth();

        if (!$cardAuth) {
            throw new Exception("Processo interrompido por falha na autenticaçao do cartão");
        }

        $headers = array(
            "Authorization: Bearer {$cardAuth}",
            "cache-control: no-cache",
            "content-type: application/json",
        );

        $api = new Api();
        $api->setHeader($headers);
        $api->setUri("/v1/card/tokenize/token");
        $api->setData($this->getCreditcard()->getData());
        $api->connect();

        $response = $api->getResponse();

        if (isset($response['error'])) {
            throw new Exception('IoPay: Erro ao recuperar card_token: '.json_encode($response['error']));
        } else {
            if (isset($response['id'])) {
                return $response['id'];
            }
        }
    }
}