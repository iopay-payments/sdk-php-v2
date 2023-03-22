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

namespace IoPay\Seller;

use Exception;
use IoPay\Address\Address;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;

class SellerPj
{

    protected $mcc;
    protected $statement_descriptor;
    protected $business; //object
    protected $owner; //object
    protected $business_address; //object
    protected $owner_address;

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
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @param mixed $business
     */
    public function setBusiness($business)
    {
        $this->business = $business;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getBusinessAddress()
    {
        return $this->business_address;
    }

    /**
     * @param mixed $business_address
     */
    public function setBusinessAddress($business_address)
    {
        $this->business_address = $business_address;
    }

    /**
     * @return mixed
     */
    public function getOwnerAddress()
    {
        return $this->owner_address;
    }

    /**
     * @param mixed $owner_address
     */
    public function setOwnerAddress($owner_address)
    {
        $this->owner_address = $owner_address;
    } //object

    public function getData() {
        return array(
            'mcc'                   => $this->getMcc(),
            'statement_descriptor'  => $this->getStatementDescriptor(),
            'business'              => $this->getBusiness(),
            'owner'                 => $this->getOwner(),
            'business_address'      => $this->getBusinessAddress(),
            'owner_address'         => $this->getOwnerAddress(),
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
            $api->setUri("/v1/sellers/create/businesses");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao criar seller pessoa juridica: {$error}");
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
            $api->setUri("/v1/sellers/update/businesses/{$sellerId}");
            $api->setData($this->getData());
            $api->connect('PATCH');

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao editar seller pessoa juridica: {$error}");
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

