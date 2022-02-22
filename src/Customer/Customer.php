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

namespace IoPay\Customer;

use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;

class Customer {

    protected $first_name;
    protected $last_name;
    protected $email;
    protected $taxpayer_id;
    protected $phone_number;
    protected $gender;
    protected $address;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTaxpayerId()
    {
        return preg_replace("/[^0-9]/", "", $this->taxpayer_id);
    }

    /**
     * @param mixed $taxpayer_id
     */
    public function setTaxpayerId($taxpayer_id)
    {
        $this->taxpayer_id = $taxpayer_id;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param mixed $phone_number
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            'first_name'     => $this->getFirstName(),
            'last_name'     => $this->getLastName(),
            'email'         => $this->getEmail(),
            'taxpayer_id'   => $this->getTaxpayerId(),
            'phone_number'  => $this->getPhoneNumber(),
            'gender'        => $this->getGender(),
            'address'       => $this->getAddress()
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
            $api->setUri("/v1/customer/new");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao criar comprador: {$error}");
            } else {
                if (isset($response['success']['id'])) {
                    return $response['success']['id'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function get($compradorId) {
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
            $api->setUri("/v1/customer/get/{$compradorId}");
            $api->connect('GET');

            $response = $api->getResponse();

            return $response;
        } catch (Exception $e) {
            return false;
        }
    }
}