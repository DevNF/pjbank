<?php

namespace WFPay\Services\Credenciamento;
use WFPay\ApiPjbank;
use WFPay\Config\ProductionDataPjbank;
use WFPay\Config\SandboxDataPjbank;


class Credenciamento
{
    protected string $credenciamentoUri;

    public function __construct(private ApiPjbank $client)
    {
        $this->credenciamentoUri = $client->getIsProduction() ? ProductionDataPjbank::BASE_URI.'recebimentos' : SandboxDataPjbank::BASE_URI.'recebimentos';
    }

    public function credenciarEmpresa(array $dados_empresa)
    {
        try {
            return $this->client->getPjbankHttpClient()->exec('POST', $this->credenciamentoUri, [
                'json' => [
                    'nome_empresa' => $dados_empresa['nome_empresa'],
                    'conta_repasse' => $dados_empresa['conta_repasse'],
                    'agencia_repasse' => $dados_empresa['agencia_repasse'],
                    'banco_repasse' => $dados_empresa['banco_repasse'],
                    'cnpj' => $dados_empresa['cnpj'],
                    'ddd' => $dados_empresa['ddd'],
                    'telefone' => $dados_empresa['telefone'],
                    'email' => $dados_empresa['email'],
                    'cep' => $dados_empresa['cep'],
                    'endereco' => $dados_empresa['endereco'],
                    'numero' => $dados_empresa['numero'],
                    'bairro' => $dados_empresa['bairro'],
                    'complemento' => $dados_empresa['complemento'],
                    'cidade' => $dados_empresa['cidade'],
                    'estado' => $dados_empresa['estado'],
                    'site' => $dados_empresa['site'],
                    'cartao' => $dados_empresa['cartao'],
                    'agencia' => $dados_empresa['agencia'],
                ]
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function consultarCredenciamento()
    {
        $credencial = $this->client->getCredencial();
        $chave = $this->client->getChave();

        if(!$credencial || !$chave) throw new \Exception('Credencial e chave são obrigatórios');

        try {
            return $this->client->getPjbankHttpClient()->exec('GET', $this->credenciamentoUri.'/'.$this->client->getCredencial());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function bancosIntegrados()
    {
        try {
            return $this->client->getPjbankHttpClient()->exec('GET', 'https://pjbank.com.br/api/v2/bancos');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
