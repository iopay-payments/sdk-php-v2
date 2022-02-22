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

namespace IoPay\Transaction;

class Shipping {

    protected $taxpayer_id;
    protected $firstname;
    protected $lastname;
    protected $address_1;
    protected $address_2;
    protected $address_3;
    protected $postal_code;
    protected $city;
    protected $state;
    protected $client_type;
    protected $phone_number;

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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address_1;
    }

    /**
     * @param mixed $address_1
     */
    public function setAddress1($address_1)
    {
        $this->address_1 = $address_1;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address_2;
    }

    /**
     * @param mixed $address_2
     */
    public function setAddress2($address_2)
    {
        $this->address_2 = $address_2;
    }

    /**
     * @return mixed
     */
    public function getAddress3()
    {
        return $this->address_3;
    }

    /**
     * @param mixed $address_3
     */
    public function setAddress3($address_3)
    {
        $this->address_3 = $address_3;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param mixed $postal_code
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = preg_replace('/[^0-9]/', '', $postal_code);
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getClientType()
    {
        return $this->client_type;
    }

    /**
     * @param mixed $client_type
     */
    public function setClientType($client_type)
    {
        $this->client_type = $client_type;
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
     * @return array
     */
    public function getData() {
        return array(
            "taxpayer_id"       => $this->getTaxpayerId(),
            "firstname"          => $this->getFirstname(),
            "lastname"          => $this->getLastname(),
            "address_1"         => $this->getAddress1(),
            "address_2"         => $this->getAddress2(),
            "address_3"         => $this->getAddress3(),
            "postal_code"       => $this->getPostalCode(),
            "city"              => $this->getCity(),
            "state"             => $this->getState(),
            "client_type"       => $this->getClientType(),
            "phone_number"      => $this->getPhoneNumber()
        );
    }
}