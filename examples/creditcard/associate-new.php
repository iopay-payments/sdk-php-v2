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

require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload files using Composer autoload

use IoPay\Creditcard\Associate;
use IoPay\Creditcard\Creditcard;
use IoPay\Creditcard\Tokenize;
use IoPay\Customer\Address;
use IoPay\Customer\Customer;
use IoPay\Logger\Log;

/* Construindo o endereço do comprador */
$endereco = new Address();
$endereco->setLine1("Avenida São José");
$endereco->setLine2("123");
$endereco->setLine3("Condomínio");
$endereco->setNeighborhood("Cristo Rei");
$endereco->setCity("Curitiba");
$endereco->setState("PR");
$endereco->setPostalCode("80.050-350");

/* Construindo um novo comprador */
$comprador = new Customer();
$comprador->setFirstName("Junior");
$comprador->setLastName("Maia");
$comprador->setEmail("comoquepode@gmail.com");
$comprador->setTaxpayerId("845.070.650-54");
$comprador->setPhoneNumber("(41) 988062315");
$comprador->setGender("male"); //male or female
$comprador->setAddress($endereco->getData());
$customerId = $comprador->create();

if (!$customerId) {
    throw new Exception("Processo interrompido por falha ao gerar o comprador");
}

/* Construindo um cartão de crédito */
$card = new Creditcard();
$card->setHolderName("Junior Maia");
$card->setCardNumber("4716588836362104");
$card->setExpirationMonth("02");
$card->setExpirationYear("29");
$card->setSecurityCode("123");

/* Tokenizando o cartão */
$tokenize = new Tokenize();
$tokenize->setCreditcard($card);
$cardToken = $tokenize->cardToken();

if (!$cardToken) {
    throw new Exception("Processo interrompido por falha ao gerar o token do cartão de crédito");
}

$logger = new Log();
$logger->log("--- Testando dados gerados ---");
$logger->log("Customer ID: {$customerId}");
$logger->log("Card Token: {$cardToken}");

/* Associando cartão ao customer */
$associate = new Associate();
$associate->setIdCard($cardToken);
$associate->setIdCustomer($customerId);

$response = $associate->associate();
$logger->log("--- Retorno da associação ---");
$logger->log($response);