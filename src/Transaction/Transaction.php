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

namespace IoPay\Transaction;

use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;
use IoPay\Environment;
use IoPay\Logger\Log;
use IoPay\Source\Payment;

class Transaction
{

    protected $customer_id;
    protected $amount;
    protected $currency;
    protected $description;
    protected $token;
    protected $capture;
    protected $statement_descriptor;
    protected $installment_plan;
    protected $io_seller_id;
    protected $payment_type;
    protected $reference_id;
    protected $products;
    protected $antifraud_sessid;
    protected $shipping_address;

    protected $logger;
    protected $headers;

    /**
     * Transaction constructor.
     */
    public function __construct()
    {
        $this->logger   = new Log();
        $this->email    = Environment::IOPAY_EMAIL;
        $this->secret   = Environment::IOPAY_SECRET;
        $this->sellerId = Environment::IOPAY_SELLER_ID;

        $auth   = new Auth();
        $token = $auth->token();
        if (!$token) {
            throw new Exception("Processo interrompido por falha no token");
        }

        $this->headers = array(
            "Authorization: Bearer {$token}",
            "cache-control: no-cache",
            "content-type: application/json",
        );
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param mixed $customer_id
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
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
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
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
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getCapture()
    {
        return $this->capture;
    }

    /**
     * @param mixed $capture
     */
    public function setCapture($capture)
    {
        $this->capture = $capture;
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
    public function getInstallmentPlan()
    {
        return $this->installment_plan;
    }

    /**
     * @param mixed $installment_plan
     */
    public function setInstallmentPlan($installment_plan)
    {
        $this->installment_plan = $installment_plan;
    }

    /**
     * @return mixed
     */
    public function getIoSellerId()
    {
        return $this->io_seller_id;
    }

    /**
     * @param mixed $io_seller_id
     */
    public function setIoSellerId($io_seller_id)
    {
        $this->io_seller_id = $io_seller_id;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    /**
     * @param mixed $payment_type
     */
    public function setPaymentType($payment_type)
    {
        $this->payment_type = $payment_type;
    }

    /**
     * @return mixed
     */
    public function getReferenceId()
    {
        return $this->reference_id;
    }

    /**
     * @param mixed $reference_id
     */
    public function setReferenceId($reference_id)
    {
        $this->reference_id = $reference_id;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getAntifraudSessid()
    {
        return $this->antifraud_sessid;
    }

    /**
     * @param mixed $antifraud_sessid
     */
    public function setAntifraudSessid($antifraud_sessid)
    {
        $this->antifraud_sessid = $antifraud_sessid;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }

    /**
     * @param mixed $shipping_address
     */
    public function setShippingAddress($shipping_address)
    {
        $this->shipping_address = $shipping_address;
    }

    public function getData()
    {
        $data = array(
            "amount" => $this->getAmount(),
            "currency" => $this->getCurrency(),
            "description" => $this->getDescription(),
            "statement_descriptor" => $this->getStatementDescriptor(),
            "io_seller_id" => $this->getIoSellerId(),
            "payment_type" => $this->getPaymentType(),
            "reference_id" => $this->getReferenceId(),
            "products" => $this->getProducts(),
        );

        if ($this->getPaymentType() == Payment::TYPE_CREDITCARD) {
            $data["token"]              = $this->getToken();
            $data["capture"]            = $this->getCapture();
            $data["installment_plan"]   = $this->getInstallmentPlan();

            if (
                Environment::ANTIFRAUDE_PLAN == "with_anti_fraud" ||
                Environment::ANTIFRAUDE_PLAN == "with_anti_fraud_insurance"
            ) {
                $data["antifraud_sessid"]   = $this->getAntifraudSessid();
                $data["shipping"]           = $this->getShippingAddress();
            }
        }

        return $data;
    }

    /**
     * @return false|mixed
     */
    public function createTransactionCreditcard()
    {
        try {
            $customerId = $this->getCustomerId();

            $api = new Api();
            $api->setHeader($this->headers);
            $api->setUri("/v1/transaction/new/{$customerId}");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                throw new Exception('Erro ao criar a transação com cartão: '.json_encode($response['error']));
            } else {
                if (isset($response['success']['id'])) {
                    return $response['success'];
                }
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @return false|mixed
     */
    public function createTransactionBoleto()
    {
        try {
            $customerId = $this->getCustomerId();

            $api = new Api();
            $api->setHeader($this->headers);
            $api->setUri("/v1/transaction/new/{$customerId}");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                throw new Exception('Erro ao criar a transação com boleto: '.json_encode($response['error']));
            } else {
                if (isset($response['success']['id'])) {
                    return $response['success'];
                }
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @return false|mixed
     */
    public function createTransactionPix()
    {
        try {
            $customerId = $this->getCustomerId();

            $api = new Api();
            $api->setHeader($this->headers);
            $api->setUri("/v1/transaction/new/{$customerId}");
            $api->setData($this->getData());
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                throw new Exception('Erro ao criar a transação com Pix: '.json_encode($response['error']));
            } else {
                if (isset($response['success']['id'])) {
                    return $response['success'];
                }
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    public function get($transactionId) {
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
            $api->setUri("/v1/transaction/get/{$transactionId}");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $transactionId
     * @param $amount
     * @return false|mixed
     */
    public function capture($transactionId, $amount)
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
            $api->setUri("/v1/transaction/capture/{$transactionId}");
            $api->setData(array("amount" => $amount));
            $api->connect();

            return $api->getResponse();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $transactionId
     * @param $amount
     * @return false|mixed
     */
    public function void($transactionId, $amount)
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
            $api->setUri("/v1/transaction/void/{$transactionId}");
            $api->setData(array("amount" => $amount));
            $api->connect();

            return $api->getResponse();
        } catch (Exception $e) {
            return false;
        }
    }

    public function listAll(
        $offset = 0,
        $page = 1,
        $limit = 100,
        $payment_type = 'credit,debit,boleto,pix'
    )
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

            $params = "?offset={$offset}&page={$page}&limit={$limit}&payment_type={$payment_type}";

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/transaction/list/{$params}");
            $api->connect('GET');

            return $api->getResponse();
        } catch (Exception $e) {
            return false;
        }
    }
}
