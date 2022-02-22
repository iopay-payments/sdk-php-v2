# SDK para PHP - IOPAY
![IoPay](https://static.iopay.dev/assets/img/capa_git.jpg)

## 💡 Requisitos

PHP 5.6 ou superior

## 💻 Instalação via Composer

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) caso não tenha instalado
2. Baixe o IOPAY SDK dentro do seu projeto: `composer require "iopay-payments/sdk-php"` 

## 💻 Instalação Manual

1. Baixe o pacote SDK na última versão [Download](https://github.com/iopay-payments/sdk-php)
2. Extraia o conteúdo do pacote dentro do seu projeto (pasta lib ou vendor, de acordo com seu framework)

Pronto, seu SDK está instalado com sucesso e pronto para utilizar!

### Configuração do Ambiente

Acesse o arquivo de configuração de ambientes: `src/Environment.php`

1. Configure o ambiente (para realizar os testes, sugerimos utilizar nosso ambiente `sandbox`)

```php
/**
 * true para sandbox
 * false para production
 */
 const IS_SANDBOX = true;
```

2. Configure as credenciais de acordo com a sua conta de vendedor

```php
/**
  * Credenciais da conta do seller
  * https://minhaconta.iopay.com.br
  */
 const IOPAY_EMAIL       = "integracao@iopay.com.br";
 const IOPAY_SECRET      = "bdSt_xTiKcbMj2348EiDBuGjKdn5hKqv+GmqRNFTwK39HFKf=Ecf-";
 const IOPAY_SELLER_ID   = "076b53180-6e5d9-47a1-rb1c4-973747fbb6de0";
```

3. Habilite a criação de logs (importante para debug das saídas do módulo)

```php
/*
 * Habilitar ou desabilitar o sistema de logger/debug
 */
const LOGGER = true;
```

Pronto, seu SDK está instalado!

## 🌟 Exemplos de uso

Todos os testes e exemplos estão escritos em `examples`

### tokenização

```php
require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload files using Composer autoload

use IoPay\Authentication\Auth;

$logger = new IoPay\Logger\Log();
$auth   = new Auth();
$token  = $auth->token();

if (!$token) {
    $logger->log("Não foi possivel gerar o token");
} else {
    $logger->log("Token {$token} gerado com sucesso");
}
```

### transação com PIX

```php
require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload files using Composer autoload

use IoPay\Environment;
use IoPay\Logger\Log;
use IoPay\Source\Payment;
use IoPay\Transaction\Transaction;

$customerId = "30cdb54284424e10b9beae475c8c9879";

$transaction = new Transaction();
$transaction->setCustomerId($customerId);
$transaction->setAmount("4509");
$transaction->setCurrency(Payment::CURRENCY);
$transaction->setDescription("Venda na loja ABC");
$transaction->setStatementDescriptor("Pedido 12345");
$transaction->setIoSellerId(Environment::IOPAY_SELLER_ID);
$transaction->setPaymentType(Payment::TYPE_PIX);
$transaction->setReferenceId("123456");

/* Testando a saída do array para a transaction */
$logger = new Log();
$logger->log($transaction->getData());

/* Criando a transação e conectando */
$response = $transaction->createTransactionPix();
$logger->log("---- Transação com Pix ----");
$logger->log($response);
```

## 📚 Documentação

https://docs-api.iopay.dev/

## 🏻 License

```
MIT license. Copyright (c) 2022 - IOPAY 
http://www.apache.org/licenses/LICENSE-2.0
```