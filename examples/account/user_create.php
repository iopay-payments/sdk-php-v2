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

require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload files using Composer autoload

use IoPay\DigitalAccount\User;
use IoPay\Logger\Log;

$user = new User();
$user->setEmail("newuser@iopay.com.br");
$user->setSendWelcomeEmail(true);
$user->setUserFullName("Junior Maia");
$user->setPassword("teste123");

/* Testando a saída do array para o user */
$logger = new Log();
$logger->log($user->getData());

$userFullName = $user->create('71115a47-978a-4c00-9350-4bec95a01f5b');
if ($userFullName) {
    $logger->log("Usuário {$userFullName} criado com sucesso!");
}