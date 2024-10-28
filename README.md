# Desafio Foco Multimídia - Hotel Management System

## Sumário
- [Sobre o Projeto](#sobre-o-projeto)
- [Módulos](#módulos)
- [Introdução](#introdução)
- [Definições Importantes](#definições-importantes)
- [Instruções de Desenvolvimento](#instruções-de-desenvolvimento)
- [Requisitos Desenvolvidos](#requisitos-desenvolvidos)
- [Diferenciais Implementados](#diferenciais-implementados)
- [Processos do Desenvolvimento](#processos-do-desenvolvimento)
  - [Como Executar o Cron](#como-executar-o-cron)
  - [Como Cadastrar um Quarto](#como-cadastrar-um-quarto)
  - [Outros Processos](#outros-processos)
- [Instalação e Execução do Projeto](#instalação-e-execução-do-projeto)

---

## Sobre o Projeto

Esse sistema consiste em diversos módulos que facilitam o gerenciamento hoteleiro e proporcionam maior praticidade para o cliente final. Logo abaixo são apresentados alguns módulos:

## Módulos

- **Gerência de Quartos**
- **Motor de Reservas**

Cada módulo possui suas especificidades e tecnologias apropriadas, incluindo suporte para APIs que fornecem dados em formatos XML e JSON.

## Introdução

Este projeto utiliza APIs e Web Services para troca de dados. O sistema é capaz de trabalhar com dados em formato JSON e XML, facilitando a manipulação e persistência de dados no banco de dados.

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
      "name": "Focomultimidia Hotel"
    }
  ]
}
```

## Definições Importantes

  - **Check-in:** Data de entrada no hotel
  - **Check-out:** Data de saída do hotel
  - **Daily:** Diárias do hotel, com valores por dia

## Instruções de Desenvolvimento

  - Documentar todos os processos.
  - Modelar o banco de dados com base nos XMLs anexados.
  - Desenvolver script em PHP/Laravel/Lumen para importação de XML com execução via cron job.
  - Criar API REST para CRUD de quartos/acometidações.
  - Desenvolver um endpoint de reserva via API REST (POST).

## Requisitos Desenvolvidos

**Modelagem de Banco de Dados**
Realizada com o MySQL Workbench com base nos arquivos XML fornecidos.

**CRUD de Quartos/Acomodações**
Implementado via API REST.

**Script de Importação XML**
Script em PHP/Laravel para importar dados XML e persistir no banco de dados, com execução via cron job.

**Endpoint de Reserva (POST)**
Endpoint para criação de reservas, com tentativa de persistência dos dados no banco.

## Diferenciais Implementados
**Documentação com Swagger / OpenAPI 3.0**

Todos os endpoints estão documentados com Swagger/OpenAPI 3.0.

**Docker**

Foi utilizado docker na aplicação para facilitar o ambiente de desenvolvimento e execução:

  - **PHP Container:** Hospeda os arquivos do projeto Laravel.
  - **Nginx Container:** Servidor web para exposição do sistema.
  - **MySQL Container:** Banco de dados para persistência de dados.
  - **PHPMyAdmin Container:** Interface de administração do banco de dados.

**Padrão de GIT Commit**

Implementado o **Conventional Commits Pattern** para assegurar legibilidade e entendimento dos commits e versões.


## Processos do Desenvolvimento
**Como Executar o Cron**

  - **Acesse o servidor onde a aplicação está hospedada.
  - **Configure o cron para chamar o script de importação em intervalos definidos.
      - **Exemplo de configuração no crontab: * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
  - **Verifique os logs para confirmar a execução.

**Como Cadastrar um Quarto**

  1. Acesse o endpoint /api/create-room via API REST.
  2. Envie os dados do quarto em formato JSON.
  3. Exemplo de JSON:

  ```json
  {
    "name": "Suíte Master",
  }
```

**Outros Processos**

  - **Para realizar uma reserva:**
      - Utilize o endpoint /api/create-reserve com o método POST.
      - Envie os dados de data de check-in, check-out e ID do quarto.
  - **Documentação do Swagger:**
      - Acesse /api/documentation para visualizar a documentação interativa de cada endpoint.

**Tecnologias Utilizadas**

  - PHP / Laravel
  - Docker
  - Swagger / OpenAPI 3.0
  - MySQL / SQLite
  - Nginx









