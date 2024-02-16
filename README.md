# Integração PJBank

A integração com cartão de crédito deve ser feita sem intermediários ou seja quando o cliente final pagar uma cobrança, o valor deve ser creditado diretamente na conta do nosso cliente após a liberação do valor.

Então precisamos credenciar os clientes que utilizarão o wfpay com os dados deles vinculandos nossa agência ao cadastro deles.

Documentação da API da PJBank: [Acessar da documentação](https://docs.pjbank.com.br/)

# Como utilizar

O Fluxo de cobrança é o seguinte:

1. Realizamos a tokenização do número do cartão de crédito do cliente no pela biblioteca disponibilizada pela PJBank.
2. Com a tokenização do cartão de crédito, realizamos a inserção dos demais dados pela rota de Validação do token do cartão de crédito.
3. Com os dados validados, realizamos a criação da cobrança pela rota de criação de cobrança com o token do cartão de crédito.
4. Com a cobrança criada, realizamos a consulta da cobrança pela rota de consulta de cobrança.

Importante ressaltar que a biblioteca do PJBank é utilizada para a tokenização do cartão de crédito e a criação da cobrança, a validação do token do cartão de crédito e a consulta da cobrança são realizadas diretamente pela API do PJBank, não salvar nenhuma informação do cartão de crédito do cliente a não ser o token disponibilizado pela PJBank somente empresas [PCI Compliance](https://pt.pcisecuritystandards.org/) podem salvar informações de cartão de crédito.

Para utilizar a biblioteca do PJBank, primeiramente é necessário instalar a mesma em seu projeto. Para isso, execute o seguinte comando:

```bash
composer require pjbank/pjbank-php-sdk
```

Depois de instalada precisamos instanciar a classe `ApiPjbank` passando os parâmetros necessários para a autenticação.

```php
$pjbank = new ApiPjbank(
    'credencial',
    'chave',
    false, // Utilizar ambiente de produção
    false, // Utilizar debug das requisições efetuadas
);
```

## Métodos disponíveis
Aqui estão listados os métodos disponíveis na biblioteca do PJBank.

### Credenciamento

#### Cadastro de clientes

Você consegue cadastrar um cliente no PJBank utilizando o método `cadastrarCliente` passando um array com os dados do cliente que podem ser encontrados na [documentação](https://docs.pjbank.com.br/#45e7e7a5-4d02-45ac-ab58-2d4193761806).

```php
$pjbank->Credenciamento()->cadastrarCliente($dadosDoCliente);
```
#### Consulta de clientes

Também é possível consultar um cliente utilizando o método `consultarCliente` passando a `credencial` e `chave` do cliente na instância do PJBank.

```php
$pjbank->Credenciamento()->consultarCliente();
```

### Cartão de Crédito

#### Criação de cobranças

Para criar uma cobrança no cartão de crédito, você pode utilizar o método `criarCobrancaCartaoViaToken` passando um array com os dados da cobrança nessa rota é utilizado a criação de cobrança com a tokenização do número do cartão de crédito sendo efetuado no front end para remover a necessidade de ser PCI Compliance, esse metodo também é fornecido pelo PJBank e disponível na [documentação](https://docs.pjbank.com.br/#b2367781-5156-4e96-a500-fdb74d3b6998), sobre os dados adicionais que devem ser enviados para a criação da cobrança consulte a [documentação](https://docs.pjbank.com.br/#ac40e9ae-91b6-4fee-936c-75ceb1f81d73).

```php
$pjbank->CartaoCredito()->criarCobrancaCartaoViaToken($dadosDaCobranca);
```
#### Consulta de cobranças

Para consultar uma cobrança no cartão de crédito, você pode utilizar o método `consultarTransacaoViaTid` passando o `tid` da cobrança.

```php
$pjbank->CartaoCredito()->consultarTransacaoViaTid('tid');
```

Também é possível consultar utilizando o número do pedido caso tenha sido utilizado na criação da cobrança via `consultarTransacaoViaNumeroPedido`.

```php
$pjbank->CartaoCredito()->consultarTransacaoViaNumeroPedido('pedido_numero');
```

#### Cancelamento de cobranças

Para cancelar uma cobrança no cartão de crédito, você pode utilizar o método `cancelarCobrancaCartao` passando o `tid` da cobrança.

```php
$pjbank->CartaoCredito()->cancelarCobrancaCartao('tid');
```

