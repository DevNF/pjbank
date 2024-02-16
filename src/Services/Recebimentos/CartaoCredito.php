<?php

namespace WFPay\Services\Recebimentos;
use WFPay\ApiPjbank;


class CartaoCredito
{
    public function __construct(private ApiPjbank $client)
    {
    }

    public function formatUri(string $uri)
    {
        return 'recebimentos/' . $this->client->getCredencial() . $uri;
    }

    public function consultarTransacaoViaTid(string $tid)
    {
        try {
            return $this->client->getPjbankHttpClient()->exec('GET', self::formatUri('/transacoes/'. $tid));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function consultarTransacaoViaNumeroPedido(string $tid)
    {
        try {
            return $this->client->getPjbankHttpClient()->exec('GET', self::formatUri('/transacoes/'.$tid));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function criarCobrancaCartaoViaToken(array $data)
    {
        try {
            return $this->client->getPjbankHttpClient()->exec('POST', self::formatUri('/transacoes/'), [
                'json' => [
                    'descricao_pagamento' => $data['descricao_pagamento'],
                    'valor' => $data['valor'],
                    'parcelas' => $data['parcelas'],
                    'token_cartao' => $data['token_cartao']
                ]
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function cancelarCobrancaCartao(string $transacao)
    {
        try {
            return $this->client->getPjbankHttpClient()->exec('DELETE', self::formatUri('/transacoes/'. $transacao));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function atualizarDadosCartao(string $token, array $data)
    {
        try {
            return $this->client->getPjbankHttpClient()->exec('POST', self::formatUri('/tokens/'), [
                'json' => array_merge($data, ['token_cartao' => $token])
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function validarTokenCartao(string $token, array $data)
    {
        try {
            return $this->client->getPjbankHttpClient()->exec('PUT', self::formatUri('/tokens/'. $token), [
                'json' => [ $data ]
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
