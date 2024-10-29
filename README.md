# Gestão Hoteleira - API de Gerenciamento e Integração

Este repositório contém uma API RESTful completa para gerenciar as principais operações hoteleiras, incluindo o cadastro e a reserva de acomodações, com suporte para a integração de dados via XML e JSON. Esta aplicação busca apresentar não apenas a funcionalidade técnica, mas também boas práticas de desenolvimento e padrões de projeto.


## Sumário
- [Sobre o Projeto](#sobre-o-projeto)
- [Introdução](#introdução)
- [Funcionalidades Implementadas](#funcionalidaeds-implementadas)
- [Requisitos Atendidos](#requisitos-atendios)
- [Diferenciais](#diferenciais)
- [Implementado via API REST](#api-rest)
- [Configuração do Ambiente de Desenvolvimento](#config-ambiente)
- [Instruções para Execução](#execucao)
- [Estrutura de Banco de Dados](#estrutura-bd)
- [Automatizações e CRON](#cron)
- [Padrões de Commit e Versionamento](#padroes-commit)
- [Imagens de Demonstração](#imagens-de-demonstracao)
- [Importante](#importante)



---

## Sobre o Projeto

Esta API foi projetada para facilitar a gestão hoteleira e aumentar a produtividade ao disponibilizar módulos de pagamento, gerência de quartos e gerenciamento de reservas. Toda a comunicação é feita por meio do JSON para assegurar compatibilidade e otimizar o desempenho, facilitando a manipulação e persistência de dados no banco de dados.

Exemplos de formatação de resposta em XML e JSON:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<hotels>
  <hotel id="1" name="Focomultimidia Hotel">
</hotels>
<!-- -->
```
```json
{
  "hotels": [
    {
      "id": 1,
      "name": "Foco Multimidia Hotel"
    }
  ]
}
```


## Funcionalidades Implementadas

- **CRUD de Quartos e Acomodações:** Gerenciamento completo de acomodações com endpoints REST;
- **CRUD de Reservas:** Gerenciamento de reservas;
- **Integração com XML:** Importação automatizada de dados em XML via CRON;
- **Persistência dos dados na base via CRON:** Dados coletados dos arquivos XML's foram persistidos na base de dados em suas respectivas tabelas;
- **Documentação:** Documentação Swagger/OpenAPI detalhada;


## Requisitos Atendidos

  - **Modelagem do Banco de Dados:** Baseada nos arquivos XML fornecidos;
  - **Importação e Persistência dos Dados XML:** Comando em Laravel para recuperar dados do XML e -  persistir no banco, utilizando CRON e Schedule do Laravel para execução periódica;
  - **API REST para CRUD de Quartos e Acomodações;**
  - **API REST para CRUD de Reservas;**
  - **Documentação com Swagger/OpenAPI 3.0;**
  - **Ambiente Dockerizado:** Configuração com docker-compose para ambientes PHP, NGINX, MySQL e PHPMyAdmin;

## Implementação de Descontos e Cupons

### CRUD de Descontos
Foi implementado um CRUD completo para gerenciamento de descontos na aplicação. Os endpoints permitem:
- Criar novos descontos.
- Atualizar descontos existentes.
- Deletar descontos.
- Listar todos os descontos.

### CRUD de Cupons
Assim como os descontos, o sistema conta com um CRUD para cupons, que inclui:
- Criação de novos cupons.
- Atualização de cupons existentes.
- Deleção de cupons.
- Listagem de todos os cupons disponíveis.

### Requisitos Pendentes
Embora a estrutura básica do CRUD para descontos e cupons tenha sido implementada, o cálculo efetivo de descontos e a aplicação de cupons não foram concluídos a tempo. Esses requisitos são essenciais para garantir que os usuários possam aproveitar os benefícios de descontos e promoções de forma adequada. Abaixo estão os pontos que precisam ser abordados em futuras iterações:

- **Cálculo de Descontos**: Implementar a lógica que calcula o valor final após a aplicação dos descontos.
- **Validação de Cupons**: Garantir que os cupons possam ser aplicados corretamente, considerando regras como validade, uso único, e restrições por tipo de produto ou serviço.


## Diferenciais

  - **Logs de Aplicação:** Sistema de logging para monitorar a execução da atualizações de dados.
  - **Padrão de Commits Convencionais:** Padronização de commits para um histórico de versionamento claro e rastreável.


## Implementado via API REST.

A documentação completa dos endpoints está disponível através do Swagger. Para acessá-la, inicie o servidor e navegue até:

  ```bash
  http://localhost:8000/api/documentation
  ```
OBS.: Exister um arquivo pdf com todos os endpoints exibidos no Swagger, o pdf nomeado: `Endpoints-Swagger-Documentation.pdf` está localizado en `./FOCO_DESAFIO/API Responses/Endpoints-Swagger-Documentation.pdf`

**Lista de Endpoints:**

  

### 1. Hotéis

| Método | Endpoint                | Descrição                                     |
|--------|-------------------------|-----------------------------------------------|
| GET    | `/status`              | Retorna o status do sistema.                 |
| GET    | `/hotels`              | Retorna uma lista de todos os hotéis.        |
| GET    | `/hotel-by-id/{id}`    | Retorna detalhes de um hotel específico.     |
| POST   | `/hotel`               | Retorna detalhes de um hotel específico por requisição json apresentando o id do hotel                         |
| POST   | `/create-hotel`        | Cria um novo hotel  |
| PUT    | `/update-hotel`        | Atualiza os dados de um hotel existente.     |
| DELETE | `/delete-hotel/{id}`   | Deleta um hotel pelo seu ID.                 |

### 2. Quartos

| Método | Endpoint                | Descrição                                     |
|--------|-------------------------|-----------------------------------------------|
| GET    | `/rooms`               | Retorna uma lista de todos os quartos.       |
| GET    | `/room-by-id/{id}`     | Retorna detalhes de um quarto específico.    |
| POST   | `/room`                | Retorna detalhes de um quarto específico por requisição json apresentando o id do quarto                          |
| POST   | `/create-room`         | Cria um novo quarto    |
| PUT    | `/update-room`         | Atualiza os dados de um quarto existente.    |
| DELETE | `/delete-room/{id}`    | Deleta um quarto pelo seu ID.                |

### 3. Reservas

| Método | Endpoint                | Descrição                                     |
|--------|-------------------------|-----------------------------------------------|
| POST   | `/reserves`            | Retorna uma lista de reservas.               |
| POST   | `/reserve`             | Retorna detalhes de uma reserva específica por requisição json apresentando o id da reserva                    |
| POST   | `/create-reserve`      | Cria uma nova reserva. (pode ser redundante) |
| PUT    | `/update-reserve`      | Atualiza os dados de uma reserva existente.  |
| DELETE | `/delete-reserve/{id}`  | Deleta uma reserva pelo seu ID.              |


Alguns endpoints acarbaram não sendo implementados no Swagger (De Discount e CouponCode). Para a documentação dos endpoints da API, também foi utilizado Thunder Client, gerando um arquivo de exportação. Este arquivo contém todos os endpoints disponíveis no projeto, incluindo aqueles relacionados a descontos e cupons. 
OBS:. O Thunder Client permite importação no VS Code, sendo possível visualizar os endpoints.

### Download do Arquivo de Endpoints

Você pode baixar o arquivo contendo todos os endpoints da API [aqui](/API%20Responses/thunder-collection_challenge_foco_api.json).

### Estrutura dos Endpoints

O arquivo `endpoints.json` inclui a seguinte estrutura de endpoints:

- **Descontos**
  - `GET /discounts`: Lista todos os descontos.
  - `POST /discount`: Cria um novo desconto.
  - `POST /create-discount`: Endpoint adicional para criar descontos.
  - `PUT /update-discount`: Atualiza um desconto existente.
  - `DELETE /delete-discount/{id}`: Deleta um desconto pelo ID.

- **Cupons**
  - `GET /coupons`: Lista todos os cupons.
  - `POST /coupon`: Cria um novo cupom.
  - `POST /create-coupon`: Endpoint adicional para criar cupons.
  - `PUT /update-coupon`: Atualiza um cupom existente.
  - `DELETE /delete-coupon/{id}`: Deleta um cupom pelo ID.



## Configuração do Ambiente de Desenvolvimento

O projeto é containerizado garantindo um ambiente de desenvolvimento consistente e fácil de configurar

### Pré-requisitos

  -  Docker e Docker Compose instalados.

### Passos para Configuração

  1. Clone o repositório:

     ```git clone https://github.com/joaovitornso/challenge_foco.git```

     ```cd hotel-management-api```

  2. Crie o arquivo .env a partir do modelo e configure as variáveis de ambiente necessárias:

     ```cp .env.example .env```
    
  3. Inicialize os containers:

    
     ```docker-compose up -d```
    
  4. Execute as migrações e seeds:

     ```docker-compose exec app-php php artisan migrate --seed```

## Instruções para Execução

### Importação do XML via CRON

Para executar a importação dos dados do XML, há um comando em Laravel configurado para dicar em execução periodicamente por meio do CRON e do Laravel Scheduler.

  - Comando:

    ```php artisan app:import-xml```

  - ***Agendamento no Scheduler:*** Configurado  routes/console.php, executa o comando 'app:import-xml' automaticamente a cada quatro horas.

### Cadastrar um Hotel

  - Instale a extensão Thunder Client no VS Code e faça uma requisição ```POST``` para o endpoint ```http://localhost:8080/api/create-hotel``` e passe os dados da requisição via json:

    ```json
      {
        "name": "Foco Hotel Palace"
      }

### Cadastrar um Quarto

  - Instale a extensão Thunder Client no VS Code e faça uma requisição ```POST``` para o endpoint ```http://localhost:8080/api/create-room``` e passe os dados da requisição via json:

    ```json
      {
        "hotel_id": 42,
        "name": "Suite Mater Foco Paradise"
      }

### Cadastrar uma Reserva

  - Instale a extensão Thunder Client no VS Code e faça uma requisição ```POST``` para o endpoint ```http://localhost:8080/api/create-reserve``` e passe os dados da requisição via json:

    ```json
    {
      "hotel_id": 97,
      "room_id": 55,
      "check_in": "2024-11-28",
      "check_out": "2024-11-30",
      "total": 224.90 
    }

## Estrutura de Banco de Dados

  Abaixo, um diagrama da modelagem de dados, incluindo as relações entre as tabelas de quartos, hotéis, reservas, diárias, hóspedes, descontos, cupons, pagamentos e métodos de pagamentos.


  ![Modelagem do Banco de Dados Conforme XML's Fornecidos](/Diagramas/challenge_db_diagram_v9.png)



## Automatizações e CRON

 O processo de importação de dados XML é automatizado via CRON e configurado para rodar diariamente. Logs de execução são gerados para acompanhamento no arquivo ```laravel.log``` localizado em ```./storage/logs/laravel.logs```.
  - Acesse o servidor onde a aplicação está hospedada.
  - Digite ```sudo crontab -e```, no terminal e no final na página cole o
  - Configure o cron para chamar o script de importação em intervalos definidos.
      - Exemplo de configuração no crontab: 
        
        ```* * * * * cd /caminho-para-seu-projeto && php artisan schedule:run >> /dev/null 2>&1```


## Padrões de Commit e Versionamento

Implementado o **Conventional Commits Pattern** para assegurar legibilidade e entendimento dos commits e versões, além de garantir rastreabilidade:

  ```feat:``` Para novas funcionalidades.
  ```fix:``` Para correções de bugs.
  ```docs:``` Para commits voltados a documentação, usado principalmento para a documentação do Swagger.

## Imagens de Demonstração

  Abaixo estão capturas de tela ilustrando o funcionamento do sistema:

   -  **Endpoints Documentados (Swagger):** Exibição dos endpoints e exemplos de resposta.
   -  **Execução CRON e Scheduler:** Logs de execução automática e atualização de dados.
   -  **Validação dos Dados com XML:** Comparação dos dados importados com os arquivos XML.

   -  **OBS:** Outras imagens apresentando o resultado das requisições e das aplicações com o CRON e Schudule permitindo uma execução periodica automatizada, estão disponivéis para visualização no diretório: ```/API Responses/```


  
  - ![Endpoints Documentados (Swagger)](/API%20Responses/api-_endpoint-reserves_and_rooms.png)

  - ![Execução CRON e Scheduler:](/API%20Responses/api-_import-reserves-xml.png)

  - ![Validação dos Dados com XML:](/API%20Responses/api-_import-guests-reserves-xml.png)




## Importante

Caso venha a ocorrer inconsistência com o container do MySQL, basta parar o seu funcionamento e utilizar um serviço diferente, o uso do sqlite é uma boa alternativa, mas não utiliza containers.
  - Parar container:
    ```sudo docker-compose stop app-db-mysql```

Após isso no arquivo ```.env``` do projeto coloque ```DB_CONNECTION``` para receber ```sqlite```, ficando assim:
  - ```DB_CONNECTION=sqlite``` 

Com isso poderá seguir com o ```php artisan migrate```, executando suas migrações e continuando o projeto.

