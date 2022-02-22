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

use IoPay\Creditcard\Creditcard;
use IoPay\Creditcard\Tokenize;
use IoPay\Logger\Log;

/* Construindo um cartão de crédito */
$card = new Creditcard();
$card->setHolderName("Junior Maia");
$card->setCardNumber("4716588836362104");
$card->setExpirationMonth("02");
$card->setExpirationYear("29");
$card->setSecurityCode("123");

/* Testando a saída do array para o cartão */
$logger = new Log();
$logger->log($card->getData());

/* Tokenizando o cartão */
$tokenize = new Tokenize();
$tokenize->setCreditcard($card);
$cardToken = $tokenize->cardToken();

if (!$cardToken) {
    $logger->log("Não foi possivel gerar o Card Token");
} else {
    $logger->log("Card Token {$cardToken} gerado com sucesso!");
}





