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

use IoPay\Recurrence\Plan;
use IoPay\Logger\Log;

$plan = new Plan();
$plan->setFrequency('monthly');
$plan->setInterval(1);
$plan->setDuration(12);
$plan->setTolerancePeriod(2);
$plan->setGracePeriod(1);
$plan->setAmount(1899);
$plan->setName("Plano Promicional Mensal XYZ-WK");
$plan->setDescription("Plano destinado para XYZ...");

/* Testando a saída do array para o plano */
$logger = new Log();
$logger->log($plan->getData());

$id = $plan->create();
if ($id) {
    $logger->log("Plano {$id} criado com sucesso!");
}