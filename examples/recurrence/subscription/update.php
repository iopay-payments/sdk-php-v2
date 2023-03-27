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

require_once __DIR__ . '/../../../vendor/autoload.php'; // Autoload files using Composer autoload

use IoPay\Recurrence\Subscription;
use IoPay\Logger\Log;

$subscriptionId = "2f8c7e46-9f8a-46f3-9ed4-7fa4b95c1087";

$subscription = new Subscription();
$subscription->setIdCard('2f3c668807f9440a8ae32c197aed9ca4');
$subscription->setExpirationDate("2024-12-01");

/* Testando a saída do array para a assinatura */
$logger = new Log();
$logger->log($subscription->getData());

$id = $subscription->update($subscriptionId);
if ($id) {
    $logger->log("Assinatura {$id} atualizada com sucesso!");
}