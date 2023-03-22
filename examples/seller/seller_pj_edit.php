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
use IoPay\Seller\SellerPj;
use IoPay\Seller\Business;
use IoPay\Seller\Owner;
use IoPay\Address\Address;

/* Criando um business */
$business = new Business();
$business->setName("Lojas Silva");
$business->setEmail("lojassilva@iopay.com.br");
$business->setPhoneNumber("(91)998281409");
$business->setOpeningDate("2000-02-28");
$business->setWebsite("https://lojassilva.com.br");
$businessAddress = new Address();
$businessAddress->setLine1('Av 9 de Julho');
$businessAddress->setLine2('2040');
$businessAddress->setLine3('AP 123');
$businessAddress->setNeighborhood('Bela Vista');
$businessAddress->setCity('São Paulo');
$businessAddress->setState('SP');
$businessAddress->setZipCode('01312-001');
$businessAddress->setCountryCode('BR');

/* Criando um owner */
$owner = new Owner();
$owner->setFirstName("Juventino");
$owner->setLastName("Silva");
$owner->setEmail("juventino@iopay.com.br");
$owner->setPhoneNumber("(91)998281409");
$owner->setCpf("03305553081");
$owner->setBirthdate("2000-02-28");
$ownerAddress = new Address();
$ownerAddress->setLine1('Av 9 de Julho');
$ownerAddress->setLine2('2040');
$ownerAddress->setLine3('AP 123');
$ownerAddress->setNeighborhood('Bela Vista');
$ownerAddress->setCity('São Paulo');
$ownerAddress->setState('SP');
$ownerAddress->setZipCode('01312-001');
$ownerAddress->setCountryCode('BR');

/* Criando Seller PJ */
$sellerPj = new SellerPj();
$sellerPj->setMcc(5499);
$sellerPj->setStatementDescriptor("Loja do Silva");
$sellerPj->setBusiness($business->getData());
$sellerPj->setBusinessAddress($businessAddress->getData());
$sellerPj->setOwner($owner->getData());
$sellerPj->setOwnerAddress($ownerAddress->getData());

/* Testando a saída do array para o seller */
$logger = new Log();
$logger->log($sellerPj->getData());

/* Editando seller passando o io_seller_id */
$sellerPjId = $sellerPj->edit('71115a47-978a-4c00-9350-4bec95a01f5b ');
if ($sellerPjId) {
    $logger->log("Seller PJ {$sellerPjId} alterado com sucesso!");
}