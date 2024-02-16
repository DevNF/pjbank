<?php 

namespace WFPay;
use GuzzleHttp\Client;
use WFPay\Config\ProductionDataPjbank;
use WFPay\Config\SandboxDataPjbank;

class PjbankHttpClient
{
    private Client $clientHttp;

    public function __construct(private ApiPjbank $client)
    {
        $baseUri = $this->client->getIsProduction() ? ProductionDataPjbank::BASE_URI : SandboxDataPjbank::BASE_URI;
        $this->clientHttp = new Client([
            'base_uri' => $baseUri,
            'headers' => [
                'Content-Type' => 'application/json',
                'X-CHAVE' => $this->client->getChave(),
            ],
        ]);
    }

    public function exec($method, $uri, $options = [])
    {
        $res = $this->clientHttp->request($method, $uri, array_merge([
            'debug' => $this->client->getDebug(),
            'http_errors' => false,
            ],$options))->getBody()->getContents();

            return json_decode($res, true);
    }
}