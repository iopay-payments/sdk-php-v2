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

use IoPay\Environment;
use IoPay\Logger\Log;
use IoPay\Source\Payment;
use IoPay\Transaction\Product;
use IoPay\Transaction\Shipping;
use IoPay\Transaction\Transaction;

/* Criando um produto para informar na transação */
$product = new Product();
$product->setName("Produto 1");
$product->setCode("produto1");
$product->setQuantity("3");
$product->setAmount("4509"); //sempre em centavos
$products[] = $product->getData();

$customerId = "30cdb54284424e10b9beae475c8c9879";

$transaction = new Transaction();
$transaction->setCustomerId($customerId);
$transaction->setAmount("4509");
$transaction->setCurrency(Payment::CURRENCY);
$transaction->setDescription("Venda na loja ABC");
$transaction->setStatementDescriptor("Pedido 12345");
$transaction->setIoSellerId(Environment::IOPAY_SELLER_ID);
$transaction->setPaymentType(Payment::TYPE_BOLETO);
$transaction->setReferenceId("123456");
$transaction->setProducts($products);

/* Testando a saída do array para a transaction */
$logger = new Log();
$logger->log($transaction->getData());

/* Criando a transação e conectando */
$response = $transaction->createTransactionBoleto();
$logger->log("---- Transação com Boleto ----");
$logger->log($response);


