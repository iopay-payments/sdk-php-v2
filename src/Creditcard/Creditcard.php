<?php

/**
 * 2022-2022 [IoPay]
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

class Creditcard {
    protected $holder_name;
    protected $expiration_month;
    protected $expiration_year;
    protected $card_number;
    protected $security_code;

    /**
     * @return mixed
     */
    public function getHolderName()
    {
        return $this->holder_name;
    }

    /**
     * @param mixed $holder_name
     */
    public function setHolderName($holder_name)
    {
        $this->holder_name = $holder_name;
    }

    /**
     * @return mixed
     */
    public function getExpirationMonth()
    {
        return $this->expiration_month;
    }

    /**
     * @param mixed $expiration_month
     */
    public function setExpirationMonth($expiration_month)
    {
        $this->expiration_month = $expiration_month;
    }

    /**
     * @return mixed
     */
    public function getExpirationYear()
    {
        return $this->expiration_year;
    }

    /**
     * @param mixed $expiration_year
     */
    public function setExpirationYear($expiration_year)
    {
        $this->expiration_year = $expiration_year;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * @param mixed $card_number
     */
    public function setCardNumber($card_number)
    {
        $this->card_number = $card_number;
    }

    /**
     * @return mixed
     */
    public function getSecurityCode()
    {
        return $this->security_code;
    }

    /**
     * @param mixed $security_code
     */
    public function setSecurityCode($security_code)
    {
        $this->security_code = $security_code;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            "holder_name"       => $this->getHolderName(),
            "expiration_month"  => $this->getExpirationMonth(),
            "expiration_year"   => $this->getExpirationYear(),
            "card_number"       => $this->getCardNumber(),
            "security_code"     => $this->getSecurityCode()
        );
    }

    /**
     * @param $customerId
     * @return false|mixed
     */
    public function listCards($customerId)
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
            $api->setUri("/v1/card/list/{$customerId}");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param $customerId
     * @return false|mixed
     */
    public function setDefault($customerId, $cardId)
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

            $data = array("id_card" => $cardId);

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/card/set_default/{$customerId}");
            $api->setData($data);
            $api->connect();

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param $customerId
     * @param $cardId
     * @return false|mixed
     */
    public function deleteCard($customerId, $cardId)
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
            $api->setUri("/v1/card/delete/{$customerId}/{$cardId}");
            $api->connect('DELETE');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param $customerId
     * @return false|mixed
     */
    public function deleteAll($customerId)
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
            $api->setUri("/v1/card/delete_all/{$customerId}");
            $api->connect('DELETE');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }
}