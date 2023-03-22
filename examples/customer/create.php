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

require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload files using Composer autoload

use IoPay\Logger\Log;
use IoPay\Customer\Customer;
use IoPay\Customer\Address;

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

/* Testando a saída do array para o comprador */
$logger = new Log();
$logger->log($comprador->getData());

$customerId = $comprador->create();
if ($customerId) {
    $logger->log("Comprador {$customerId} criado com sucesso!");
}
