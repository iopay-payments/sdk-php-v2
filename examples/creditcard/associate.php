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

use IoPay\Creditcard\Associate;
use IoPay\Logger\Log;

/* cartão existente e um customer existente */
$customerId = "5095dd6991fb49f3a0825e646444d86e";
$cardToken  = "3193d449832f49448beab7439b9705d4";

$logger = new Log();
$logger->log("--- Associando dados gerados ---");
$logger->log("Customer ID: {$customerId}");
$logger->log("Card Token: {$cardToken}");

/* Associando cartão ao customer */
$associate = new Associate();
$associate->setIdCard($cardToken);
$associate->setIdCustomer($customerId);

$response = $associate->associate();
$logger->log("--- Retorno da associação ---");
$logger->log($response);