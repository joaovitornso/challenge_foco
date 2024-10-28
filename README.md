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
