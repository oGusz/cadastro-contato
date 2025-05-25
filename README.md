# Sistema de Gerenciamento de Contatos

Este repositório contém um **sistema de gerenciamento de contatos** desenvolvido em **PHP puro** com arquitetura **MVC**, utilizando **MySQL** como banco de dados. O projeto oferece uma interface responsiva com **Bootstrap**, e funcionalidades dinâmicas implementadas com **jQuery e AJAX**, proporcionando uma experiência fluida e organizada para cadastrar, listar, editar e remover contatos.

## ✅ Funcionalidades

- **Cadastro de Contato:**
  - Nome (obrigatório)
  - E-mail (obrigatório e validado)
  - Telefone (obrigatório)
  - Data de nascimento (opcional)

- **Listagem com Filtros e Ordenação:**
  - Filtro dinâmico por nome ou e-mail
  - Ordenação por nome ou data de cadastro
  - Interface responsiva com Bootstrap

- **Ações adicionais:**
  - Edição de contatos existentes
  - Remoção segura de contatos
  - Feedback visual ao usuário

## 🧪 Validações

- **Front-end:** com jQuery e HTML5
- **Back-end:** com PHP e prepared statements (mysqli)

## 🔐 Segurança

- Uso de **prepared statements** para prevenir SQL Injection
- Prevenção básica contra **XSS**
- Validação de entrada em ambos os lados (cliente e servidor)

Configure a conexão com o banco em:

## 🚀 Como usar

1. Clone o repositório:
   ```bash
   git clone https://github.com/oGusz/cadastro-contato.git
´´´
2. Importe o banco de dados usando o arquivo /sql/contatos.sql

3. Configure a conexão com o banco em:

4. Execute o projeto em um ambiente local (XAMPP, WAMP ou Laragon).

## 🧰 Tecnologias Utilizadas
PHP (sem frameworks)

MySQL (com mysqli e prepared statements)

HTML5

CSS3 (Bootstrap)

jQuery (AJAX e manipulação do DOM)

## 🎯 Boas práticas adotadas
Arquitetura MVC

Separação clara entre front-end e back-end

Código limpo, identado e com nomes significativos

Scripts modularizados

Tratamento de erros e mensagens de retorno

Interface simples e objetiva (UX)

📌 Observações
Este projeto tem fins educacionais e práticos, ideal para treinar boas práticas em PHP, jQuery e MySQL, com foco em organização e segurança no desenvolvimento web.

