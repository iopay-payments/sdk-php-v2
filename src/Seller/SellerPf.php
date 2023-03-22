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

namespace IoPay\Seller;

use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;

class SellerPf {

    protected $send_welcome_email;
    protected $mcc;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $phone_number;
    protected $cpf;
    protected $birthdate;
    protected $statement_descriptor;
    protected $address;

    /**
     * @return mixed
     */
    public function getSendWelcomeEmail()
    {
        return $this->send_welcome_email;
    }

    /**
     * @param mixed $send_welcome_email
     */
    public function setSendWelcomeEmail($send_welcome_email)
    {
        $this->send_welcome_email = $send_welcome_email;
    }

    /**
     * @return mixed
     */
    public function getMcc()
    {
        return $this->mcc;
    }

    /**
     * @param mixed $mcc
     */
    public function setMcc($mcc)
    {
        $this->mcc = $mcc;
    }

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
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getStatementDescriptor()
    {
        return $this->statement_descriptor;
    }

    /**
     * @param mixed $statement_descriptor
     */
    public function setStatementDescriptor($statement_descriptor)
    {
        $this->statement_descriptor = $statement_descriptor;
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
    } //object

    /**
     * @return array
     */
    public function getData() {
        $data = array(
            'mcc'                   => $this->getMcc(),
            'first_name'            => $this->getFirstName(),
            'last_name'             => $this->getLastName(),
            'email'                 => $this->getEmail(),
            'phone_number'          => $this->getPhoneNumber(),
            'birthdate'             => $this->getBirthdate(),
            'statement_descriptor'  => $this->getStatementDescriptor(),
            'address'               => $this->getAddress(),
        );

        if ($this->getSendWelcomeEmail()) {
            $data['send_welcome_email'] = $this->getSendWelcomeEmail();
        }

        if ($this->getCpf()) {
            $data['cpf'] = $this->getCpf();
        }

        return $data;
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
            $api->setUri("/v1/sellers/create/individuals");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao criar seller pessoa fisica: {$error}");
            } else {
                if (isset($response['io_seller_id'])) {
                    return $response['io_seller_id'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function edit($sellerId) {
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
            $api->setUri("/v1/sellers/update/individuals/{$sellerId}");
            $api->setData($this->getData());
            $api->connect('PATCH');

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao editar seller pessoa fisica: {$error}");
            } else {
                if (isset($response['success']['id'])) {
                    return $response['success']['id'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }
}