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

namespace IoPay\Creditcard;

use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;

class Associate {

    protected $id_customer;
    protected $id_card;

    /**
     * @return mixed
     */
    public function getIdCustomer()
    {
        return $this->id_customer;
    }

    /**
     * @param mixed $id_customer
     */
    public function setIdCustomer($id_customer)
    {
        $this->id_customer = $id_customer;
    }

    /**
     * @return mixed
     */
    public function getIdCard()
    {
        return $this->id_card;
    }

    /**
     * @param mixed $id_card
     */
    public function setIdCard($id_card)
    {
        $this->id_card = $id_card;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            "id_customer"   => $this->getIdCustomer(),
            "token"         => $this->getIdCard()
        );
    }

    /**
     * @return false|mixed
     */
    public function associate()
    {
        try {
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
            $api->setUri("/v1/card/associeate_token_with_customer");
            $api->setData($this->getData());
            $api->connect();

            return $api->getResponse();
        } catch (Exception $e) {
            return false;
        }
    }
}