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

namespace IoPay\DigitalAccount;

use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;

class User
{

    protected $email;
    protected $password;
    protected $user_full_name;
    protected $send_welcome_email;

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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUserFullName()
    {
        return $this->user_full_name;
    }

    /**
     * @param mixed $user_full_name
     */
    public function setUserFullName($user_full_name)
    {
        $this->user_full_name = $user_full_name;
    }

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
     * @return array
     */
    public function getData() {
        return array(
            'email'                 => $this->getEmail(),
            'password'              => $this->getPassword(),
            'user_full_name'        => $this->getUserFullName(),
            'send_welcome_email'    => $this->getSendWelcomeEmail(),
        );
    }

    public function create($sellerId) {
        try {
            $auth   = new Auth();
            $token  = $auth->token();
            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            if (!$sellerId) {
                throw new Exception("Processo interrompido por falta do sellerID");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/sellers/digital_account/login/{$sellerId}");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao criar digital account: {$error}");
            } else {
                if (isset($response['user_full_name'])) {
                    return $response['user_full_name'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $sellerId
     * @return false|mixed
     */
    public function listUsers($sellerId)
    {
        try {
            $auth   = new Auth();
            $token  = $auth->token();

            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            if (!$sellerId) {
                throw new Exception("Processo interrompido por falta do sellerID");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/sellers/digital_account/login/{$sellerId}");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param $sellerId
     * @return false|mixed
     */
    public function deleteUser($sellerId)
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
            $api->setUri("/v1/sellers/digital_account/login/{$sellerId}");
            $api->setData(array('email' => $this->getEmail()));
            $api->connect('DELETE');

            return $api->getResponse();
        } catch (Exception $ex) {
            return false;
        }
    }
}