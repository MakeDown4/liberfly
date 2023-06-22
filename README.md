## Requisitos

Recomendo o uso do WampServer (Wamp64), um pacote de software que inclui o PHP e todas as extensões necessárias, além do MySQL e Apache, para simplificar a configuração do projeto. No entanto, certifique-se de que seu sistema atende aos seguintes requisitos mínimos:

PHP >= 8.1
Composer
O WampServer (Wamp64) é uma opção conveniente para configuração rápida e fácil do ambiente de desenvolvimento. Ele já possui o PHP na versão adequada e as extensões necessárias para o projeto. Se você optar por usar o WampServer (Wamp64), não será necessário fazer nenhuma configuração adicional relacionada ao PHP e às extensões.

## Instalação

1. Faça o download ou clone este repositório.
2. Execute o comando `composer install` para instalar as dependências do Laravel.
3. Renomeie o arquivo `.env.example` para `.env` e atualize as informações do banco de dados.
4. Execute o comando `php artisan key:generate` para gerar a chave do aplicativo.
5. Execute o cmando `php artisan jwt:secret` para gerar o token JWT.
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