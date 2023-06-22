## Requisitos

Certifique-se de que seu sistema atende aos seguintes requisitos destes arquivos instalados na máquina:

- PHP >= 8.1
- Composer

## Instalação

1. Faça o download ou clone este repositório.
2. Execute o comando `composer install` para instalar as dependências do Laravel.
3. Renomeie o arquivo `.env.example` para `.env` e atualize as informações do banco de dados.
4. Execute o comando `php artisan key:generate` para gerar a chave do aplicativo.
5. Execute o comando `php artisan migrate` para executar as migrações do banco de dados.
6. Execute o comando `php artisan db:seed` para popular o banco de dados com dados de teste.

## Execução do projeto

1. Execute o comando `php artisan serve` para rodar o servidor.

## Executando Testes

1. Execute o comando `php artisan test` . Os testes serão executados e os resultados serão exibidos no terminal.


## Documentação da API

A API está documentada usando o Swagger. Para acessar a documentação da API, siga estas etapas:

Certifique-se de que o servidor local esteja em execução. Caso contrário, execute o comando php artisan serve para iniciar o servidor.

Abra seu navegador e acesse o seguinte link:

`http://localhost:8000/api/documentation#/`

A documentação da API será exibida com detalhes sobre cada endpoint, seus parâmetros e exemplos de solicitações e respostas.