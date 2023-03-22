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

namespace IoPay;

/**
 * Class Environment
 * @package IoPay
 */
class Environment
{
    /**
     * Configure o ambiente das ransações
     * true para sandbox
     * false para production
     */
    const IS_SANDBOX        = true;

    /**
     * Urls dos ambientes
     * Só altere caso houve atualização da API
     * https://docs-api.iopay.com.br/
     */
    const URL_SANDBOX       = "https://sandbox.api.iopay.com.br/api";
    const URL_LIVE          = "https://api.iopay.com.br/api";

    /**
     * Credenciais da conta do seller
     * https://minhaconta.iopay.com.br
     */
    const IOPAY_EMAIL       = "integracao@iopay.com.br";
    const IOPAY_SECRET      = '$AIKb~BloVE4DbJc!E-RI6oKq+PC~cn6TVZ-Lssed=iJdb1KW2';
    const IOPAY_SELLER_ID   = "07b53180-6e59-47a1-b1c4-97374fbb6de0";

    /*
     * Habilitar ou desabilitar o sistema de logger/debug
     */
    const LOGGER = true;

    /*
     * https://docs-api.iopay.com.br/#ced1492c-c8d9-4400-ba15-68bdd1cdb932
     *
     * with_anti_fraud
     * with_anti_fraud_insurance
     * without_antifraud
     */
    const ANTIFRAUDE_PLAN   = 'with_anti_fraud';
    const ANTIFRAUDE_KEY    = 'AbC123890';
}