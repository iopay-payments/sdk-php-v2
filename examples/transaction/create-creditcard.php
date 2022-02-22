<?php
session_start();
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

$customerId     = "30cdb54284424e10b9beae475c8c9879";
$cardToken      = "2c4de4ff34ef404cb2141e89a1695434";

$transaction = new Transaction();
$transaction->setCustomerId($customerId);
$transaction->setToken($cardToken);
$transaction->setAmount("4509");
$transaction->setCurrency(Payment::CURRENCY);
$transaction->setDescription("Venda na loja ABC");
$transaction->setCapture(1);
$transaction->setStatementDescriptor("Pedido 12345");
$transaction->setInstallmentPlan(array('number_installments' => 1));
$transaction->setIoSellerId(Environment::IOPAY_SELLER_ID);
$transaction->setPaymentType(Payment::TYPE_CREDITCARD);
$transaction->setReferenceId("123456");
$transaction->setProducts($products);

/*
* Para plano com antifraude é necessário adicionar o endereço do cliente
*/
if (
    Environment::ANTIFRAUDE_PLAN == "with_anti_fraud" ||
    Environment::ANTIFRAUDE_PLAN == "with_anti_fraud_insurance"
) {
    /* Constoi o endereço do cliente */
    $shipping = new Shipping();
    $shipping->setTaxpayerId("845.070.650-54");
    $shipping->setFirstname("Junior");
    $shipping->setLastname("Maia");
    $shipping->setAddress1("Avenida São José");
    $shipping->setAddress2("123");
    $shipping->setAddress3("Condominio");
    $shipping->setPostalCode("80.050-350");
    $shipping->setCity("Curitiba");
    $shipping->setState("PR");
    $shipping->setClientType(Payment::CLIENTE_TYPE_PF);
    $shipping->setPhoneNumber("(41) 988062315");

    /* Adiciona a sessão do usuário */
    $transaction->setAntifraudSessid(session_id());
    $transaction->setShippingAddress($shipping->getData());
}

/* Testando a saída do array para a transaction */
$logger = new Log();
$logger->log($transaction->getData());

/* Criando a transação e conectando */
$response = $transaction->createTransactionCreditcard();
$logger->log("---- Transação com Cartão de Crédito ----");
$logger->log($response);