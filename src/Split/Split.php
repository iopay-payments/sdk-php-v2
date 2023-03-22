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

namespace IoPay\Split;

use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;

class Split {

    protected $receiver; //io_seller_id
    protected $receiver_fee_type;
    protected $split_type;
    protected $split_value;
    protected $min_amount;
    protected $max_amount;
    protected $chargeback_liable;

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getReceiverFeeType()
    {
        return $this->receiver_fee_type;
    }

    /**
     * @param mixed $receiver_fee_type
     */
    public function setReceiverFeeType($receiver_fee_type)
    {
        $this->receiver_fee_type = $receiver_fee_type;
    }

    /**
     * @return mixed
     */
    public function getSplitType()
    {
        return $this->split_type;
    }

    /**
     * @param mixed $split_type
     */
    public function setSplitType($split_type)
    {
        $this->split_type = $split_type;
    }

    /**
     * @return mixed
     */
    public function getSplitValue()
    {
        return $this->split_value;
    }

    /**
     * @param mixed $split_value
     */
    public function setSplitValue($split_value)
    {
        $this->split_value = $split_value;
    }

    /**
     * @return mixed
     */
    public function getMinAmount()
    {
        return $this->min_amount;
    }

    /**
     * @param mixed $min_amount
     */
    public function setMinAmount($min_amount)
    {
        $this->min_amount = $min_amount;
    }

    /**
     * @return mixed
     */
    public function getMaxAmount()
    {
        return $this->max_amount;
    }

    /**
     * @param mixed $max_amount
     */
    public function setMaxAmount($max_amount)
    {
        $this->max_amount = $max_amount;
    }

    /**
     * @return mixed
     */
    public function getChargebackLiable()
    {
        return $this->chargeback_liable;
    }

    /**
     * @param mixed $chargeback_liable
     */
    public function setChargebackLiable($chargeback_liable)
    {
        $this->chargeback_liable = $chargeback_liable;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            'receiver'              => $this->getReceiver(),
            'receiver_fee_type'     => $this->getReceiverFeeType(),
            'split_type'            => $this->getSplitType(),
            'split_value'           => $this->getSplitValue(),
            'min_amount'            => $this->getMinAmount(),
            'max_amount'            => $this->getMaxAmount(),
            'chargeback_liable'     => $this->getChargebackLiable()
        );
    }

    /**
     * @return false|mixed|void
     */
    public function create() {
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
            $api->setUri("/v1/split_rules");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao criar split: {$error}");
            } else {
                if (isset($response['success']['id'])) {
                    return $response['success']['id'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $splitId
     * @return false|mixed
     */
    public function get($splitId) {
        try {
            $auth = new Auth();
            $token = $auth->token();
            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            /* Constuindo requisição e conectando */
            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/split_rules{$splitId}");
            $api->connect('GET');

            $response = $api->getResponse();

            return $response;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $receiverId
     * @return false|mixed
     */
    public function listSplits($receiverId)
    {
        try {
            $auth = new Auth();
            $token = $auth->token();

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
            $api->setUri("/v1/split_rules?receiver={$receiverId}");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param $splitId
     * @return false|mixed
     */
    public function deleteSplit($splitId)
    {
        try {
            $auth       = new Auth();
            $cardAuth   = $auth->cardAuth();

            if (!$cardAuth) {
                throw new Exception("Processo interrompido por falha no token");
            }

            $headers = array(
                "Authorization: Bearer {$cardAuth}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/split_rules/{$splitId}");
            $api->connect('DELETE');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

}