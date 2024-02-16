<?php

namespace WFPay;
use WFPay\PjbankHttpClient;
use WFPay\Services\Credenciamento\Credenciamento;
use WFPay\Services\Recebimentos\CartaoCredito;
class ApiPjbank
{
    private bool $isProduction = false;
    private bool $debug = false;
    private PjbankHttpClient $PjbankHttpClient;
    private string $credencial;
    private string $chave;

    public function __construct(
        $credencial,
        $chave,
        $isProduction = false,
        $debug = false)
    {
        $this->credencial = $credencial;
        $this->chave = $chave;
        $this->isProduction = $isProduction;
        $this->debug = $debug;
        $this->PjbankHttpClient = new PjbankHttpClient($this);
    }

    public function CartaoCredito(): CartaoCredito
    {
        if(!$this->credencial || !$this->chave) throw new \Exception('Credencial e chave são obrigatórios');
        return new CartaoCredito($this);
    }

    public function Credenciamento(): Credenciamento
    {
        return new Credenciamento($this);
    }

    public function getPjbankHttpClient(): PjbankHttpClient
    {
        return $this->PjbankHttpClient;
    }

    public function getIsProduction(): bool
    {
        return $this->isProduction;
    }

    public function setIsProduction(bool $isProduction): void
    {
        $this->isProduction = $isProduction;
    }

    public function getDebug(): bool
    {
        return $this->debug;
    }

    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    public function getCredencial(): string
    {
        return $this->credencial;
    }

    public function getChave(): string
    {
        return $this->chave;
    }

}
