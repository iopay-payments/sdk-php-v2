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

class Plan {

    protected $frequency;
    protected $interval;
    protected $duration;
    protected $tolerance_period;
    protected $grace_period;
    protected $amount;
    protected $setup_amount;
    protected $name;
    protected $description;

    /**
     * @return mixed
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param mixed $frequency
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * @return mixed
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param mixed $interval
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getTolerancePeriod()
    {
        return $this->tolerance_period;
    }

    /**
     * @param mixed $tolerance_period
     */
    public function setTolerancePeriod($tolerance_period)
    {
        $this->tolerance_period = $tolerance_period;
    }

    /**
     * @return mixed
     */
    public function getGracePeriod()
    {
        return $this->grace_period;
    }

    /**
     * @param mixed $grace_period
     */
    public function setGracePeriod($grace_period)
    {
        $this->grace_period = $grace_period;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getSetupAmount()
    {
        return $this->setup_amount;
    }

    /**
     * @param mixed $setup_amount
     */
    public function setSetupAmount($setup_amount)
    {
        $this->setup_amount = $setup_amount;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getData() {
        return array(
            'frequency'         => $this->getFrequency(),
            'interval'          => $this->getInterval(),
            'duration'          => $this->getDuration(),
            'tolerance_period'  => $this->getTolerancePeriod(),
            "grace_period"      => $this->getGracePeriod(),
            "amount"            => $this->getAmount(),
            "setup_amount"      => $this->getSetupAmount(),
            "name"              => $this->getName(),
            "description"       => $this->getDescription()
        );
    }


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
            $api->setUri("/v1/recurrence/plan");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao criar plano: {$error}");
            } else {
                if (isset($response['id'])) {
                    return $response['id'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function details($planId)
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
            $api->setUri("/v1/recurrence/plan/{$planId}");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    public function listPlans()
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
            $api->setUri("/v1/sellers/list");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    public function deletePlan($planId)
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
            $api->setUri("/v1/recurrence/plan/$planId}");
            $api->connect('DELETE');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }
}
