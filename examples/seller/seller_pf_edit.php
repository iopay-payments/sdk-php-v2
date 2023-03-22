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

use IoPay\Logger\Log;
use IoPay\Seller\SellerPf;
use IoPay\Address\Address;

/* Criando endereço do Seller */
$address = new Address();
$address->setLine1('Av 9 de Julho');
$address->setLine2('2040');
$address->setLine3('AP 123');
$address->setNeighborhood('Bela Vista');
$address->setCity('São Paulo');
$address->setState('SP');
$address->setZipCode('01312-001');
$address->setCountryCode('BR');

/* Criando Seller PF */
$sellerPf = new SellerPf();
$sellerPf->setMcc(5499);
$sellerPf->setFirstName('Juventino');
$sellerPf->setLastName('Silva');
$sellerPf->setEmail('juventino_php@iopay.com.br');
$sellerPf->setPhoneNumber('(91)998281409');
$sellerPf->setBirthdate('2000-02-28');
$sellerPf->setStatementDescriptor('Lj Silva');
$sellerPf->setAddress($address->getData());

/* Testando a saída do array para o seller */
$logger = new Log();
$logger->log($sellerPf->getData());

/* Editando seller passando o io_seller_id */
$sellerPfId = $sellerPf->edit('91c88547-214f-409c-9bf7-1e97edccc1a0 ');
if ($sellerPfId) {
    $logger->log("Seller PF {$sellerPfId} alterado com sucesso!");
}

