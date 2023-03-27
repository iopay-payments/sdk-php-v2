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

class Subscription {

    protected $id_recurrence_plan;
    protected $id_customer;
    protected $id_card;
    protected $due_date;
    protected $expiration_date;

    /**
     * @return mixed
     */
    public function getIdRecurrencePlan()
    {
        return $this->id_recurrence_plan;
    }

    /**
     * @param mixed $id_recurrence_plan
     */
    public function setIdRecurrencePlan($id_recurrence_plan)
    {
        $this->id_recurrence_plan = $id_recurrence_plan;
    }

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
     * @return mixed
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * @param mixed $due_date
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * @param mixed $expiration_date
     */
    public function setExpirationDate($expiration_date)
    {
        $this->expiration_date = $expiration_date;
    }

    /**
     * @return array
     */
    public function getData() {
        return array(
            "id_recurrence_plan"    => $this->getIdRecurrencePlan(),
            "id_customer"           => $this->getIdCustomer(),
            "id_card"               => $this->getIdCard(),
            "due_date"              => $this->getDueDate(),
            "expiration_date"       => $this->getExpirationDate(),
        );
    }

    /**
     * @return array
     */
    public function getUpdateData() {
        return array(
            "id_card"               => $this->getIdCard(),
            "expiration_date"       => $this->getExpirationDate(),
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
            $api->setUri("/v1/recurrence/subscription");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao criar assinatura: {$error}");
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
     * @param $subscriptionId
     * @return false|mixed|void
     */
    public function update($subscriptionId) {
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
            $api->setUri("/v1/recurrence/subscription/{$subscriptionId}");
            $api->setData($this->getUpdateData());
            $api->connect('PUT');

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao atualizar assinatura: {$error}");
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
     * @param $subscriptionId
     * @return false|mixed
     */
    public function details($subscriptionId)
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
            $api->setUri("/v1/recurrence/subscription/{$subscriptionId}");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @return false|mixed
     */
    public function listSubscriptions()
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
            $api->setUri("/v1/recurrence/subscription/list");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param $subscriptionId
     * @return false|mixed|void
     */
    public function suspend($subscriptionId) {
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
            $api->setUri("/v1/recurrence/subscription/{$subscriptionId}/suspend");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao suspender assinatura: {$error}");
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
     * @param $subscriptionId
     * @return false|mixed|void
     */
    public function reactive($subscriptionId) {
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
            $api->setUri("/v1/recurrence/subscription/{$subscriptionId}/reactive");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao reativar assinatura: {$error}");
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
     * @param $subscriptionId
     * @return false|mixed
     */
    public function deleteSubscription($subscriptionId)
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
            $api->setUri("/v1/recurrence/subscription/$subscriptionId}");
            $api->connect('DELETE');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

}