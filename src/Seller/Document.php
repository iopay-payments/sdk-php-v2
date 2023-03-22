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

namespace IoPay\Seller;

use CURLFile;
use Exception;
use IoPay\Authentication\Auth;
use IoPay\Connection\Api;

class Document
{

    /**
     * @param $sellerId
     * @return false|mixed|void
     */
    public function send($sellerId) {
        try {
            $auth   = new Auth();
            $token  = $auth->token();
            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/sellers/documents/upload/residencia/{$sellerId}");
            $api->setData([
                'file'=> new CURLFILE('~/Desktop/upload.pdf')
            ]);
            $api->connect();

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao enviar documento: {$error}");
            } else {
                if (isset($response['io_seller_id'])) {
                    return $response['io_seller_id'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $sellerId
     * @return false|mixed|void
     */
    public function listDocuments($sellerId) {
        try {
            $auth   = new Auth();
            $token  = $auth->token();
            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/sellers/documents/list/{$sellerId}");
            $api->connect('GET');

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao listar documentos: {$error}");
            } else {
                if (isset($response['total'])) {
                    return $response['total'];
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $sellerId
     * @param $documentId
     * @return false|mixed
     */
    public function download($sellerId, $documentId) {
        try {
            $auth   = new Auth();
            $token  = $auth->token();
            if (!$token) {
                throw new Exception("Processo interrompido por falha no token");
            }

            $headers = array(
                "Authorization: Bearer {$token}",
                "cache-control: no-cache",
                "content-type: application/json",
            );

            $api = new Api();
            $api->setHeader($headers);
            $api->setUri("/v1/sellers/documents/download/{$sellerId}/{$documentId}");
            $api->connect('GET');

            $response = $api->getResponse();

            if (isset($response['error'])) {
                $error = json_encode($response['error']);
                throw new Exception("Erro ao baixar documentos: {$error}");
            } else {
                return $response;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}