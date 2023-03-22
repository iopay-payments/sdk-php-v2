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
use IoPay\Split\Split;
use IoPay\Source\Split as Source;

/* Criando um split */

$split = new Split();
$split->setReceiver('9f9e387d-f13f-4c64-b7ea-0e2884301d40'); //io_seller_id
$split->setReceiverFeeType(Source::RECEIVER_FEE_TYPE_PROPORTIONAL);
$split->setSplitType(Source::SPLIT_TYPE_PERCENT);
$split->setSplitValue(10);
$split->setMinAmount(100);
$split->setMaxAmount(100000);
$split->setChargebackLiable(1);

/* Testando a saída do array para o split */
$logger = new Log();
$logger->log($split->getData());

$splitId = $split->create();
if ($splitId) {
    $logger->log("Split {$splitId} criado com sucesso!");
}
