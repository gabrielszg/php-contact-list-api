<h4 align="center"> 
	🚧 API de Contatos 🚀 🚧
</h4>

<p align="center">
 <a href="#-sobre-o-projeto">Sobre</a> •
 <a href="#-funcionalidades">Funcionalidades</a> •
 <a href="#-como-executar-o-projeto">Como executar</a> • 
 <a href="#-tecnologias">Tecnologias</a> • 
 <a href="#-autor">Autor</a> • 
</p>

## 💻 Sobre o projeto

🧺 API de Contatos - é um CRUD criado para cadastrar os contatos referentes a uma empresa. 

---

## ⚙️ Funcionalidades

- [x] Cadastrar empresa
  - [x] Atualizar dados da empresa
  - [x] Deletar uma empresa específica 
  - [x] Listar todas as empresas
- [x] Cadastrar contato associado a empresa
  - [x] Atualizar contato
  - [x] Deletar contato específico
  - [x] Listar todos os contatos ou filtrar por parâmetro:
    - [x] Nome da empresa
    - [x] Nome do contato
    - [x] Sobrenome do contato
    - [x] Telefone
    - [x] Celular
    - [x] E-mail

---

## 🚀 Como executar o projeto

### Pré-requisitos

Antes de começar, você vai precisar ter instalado em sua máquina as seguintes ferramentas: [Docker][docker], [PHP8+][php].
Além disto é bom ter um editor para trabalhar com o código como [VSCode][vscode]

### Clonar o Projeto
https://github.com/gabrielszg/php-contact-list-api.git

### Criar Banco de Dados (MySQL)

```bash

# Abra o Terminal na raiz do projeto e digite o comando 
$ docker-compose up

# Logo após execute os comandos do arquivo SQL.slq para criar o Banco de Dados, as tabelas e os registros

```

### Rodando a API

```bash

# Abrir o Terminal na raiz da pasta e digitar o seguinte comando
$ php -S localhost:8000

# A API estará disponível no endereço
http://localhost:8000/company -> Listar Empresas
http://localhost:8000/contacts -> Listar Contatos

# Utilizar o PostMan ou Insomnia para consumir a API

```

---

## 🛠 Tecnologias

([PHP](https://windows.php.net/)  +  [Slim Framework](https://www.slimframework.com/))

## 🦸🏻‍♂️ Autor

<a href="https://github.com/gabrielszg">
  <p>@gabrielszg</p>
</a>
