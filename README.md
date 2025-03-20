# Desafio técnico - Coodesh



Nesse projeto é possível editar, deletar, listar dados de produtos.
Os produtos devem ser importados de uma api externa e salvo no banco de dados local para facilitar o acesso e manipulação.
---

## 📚 Tecnologias Utilizadas
- Linguagem: PHP
- Framework: Laravel
- Banco de Dados: MySQL
- Testes: PHPUnit
- Design Patterns: SOLID, DDD
- Containerização: Docker
- Documentação: OpenAPI 3.1.0 | [Ver documentação](docs/api.yml)

---

## 📂 Endpoints da API

### ✅ GET `/api`
Retorna detalhes sobre a API:
- Status da conexão com o banco de dados (leitura e escrita).
- Horário da última execução do CRON.
- Tempo online da API.
- Uso de memória.

### ✍️ PUT `/api/products/:code`
Atualiza um produto específico.
- Parâmetro: `code` (Código único do produto).
- Corpo da requisição: JSON com os dados a serem atualizados.
- Resposta: Dados do produto atualizado.

### ❌ DELETE `/api/products/:code`
Marca o produto como `trash`.
- Parâmetro: `code` (Código único do produto).
- Resposta: Mensagem de sucesso ou erro.

### 🔍 GET `/api/products/:code`
Obtém informações detalhadas de um produto.
- Parâmetro: `code` (Código único do produto).
- Resposta: JSON com os dados do produto.

### 📑 GET `/api/products`
Lista todos os produtos disponíveis.
- Suporte a paginação para não sobrecarregar o request.
- Parâmetros opcionais: `page`, `limit`.
- Também pode ser filtrado por query params adicionais, como product_name, code, status, etc.
- Resposta: Lista de produtos.

---

## 🔍 Busca Avançada 
Implementado um sistema de busca, permitindo pesquisas avançadas por produtos.

---

## 🐳 Docker 
O projeto está configurado para ser executado em um container Docker, facilitando o deploy e a configuração do ambiente.

---

## 📅 Sistema CRON
A API realiza a importação diária dos produtos da base de dados Open Food Facts, limitando a importação para 100 produtos por arquivo. Além disso, mantém um histórico de importações para fins de validação e auditoria.

---

## 🧪 Testes Unitários 
Testes unitários foram implementados para garantir o funcionamento adequado dos endpoints `GET /products/:code`, `DELETE /products/:code` e `PUT /products/:code`.


---

# ✅ Passos para Instalar o Projeto

## 📁 Criar o arquivo .env

No diretório raiz do projeto, crie o arquivo `.env` com as configurações do seu banco de dados. Adicione os seguintes valores no arquivo `.env`:

```env
# Configuração recomendada ✅
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=openfood
DB_USERNAME=root
DB_PASSWORD=mysql
MYSQL_ROOT_PASSWORD=root
```

---

## 🐳 Rodar o Docker

Após criar o arquivo `.env`, abra o terminal e execute o seguinte comando para iniciar os containers do Docker:

```bash
npm run docker:init
```

Isso vai configurar o ambiente com o Docker e nginx.

---

## 💾 Migrar o banco de dados

1. Primeiro, entre no terminal do Docker:

```bash
npm run docker:shell
```

2. Quando carregar, rode o comando para instalar as dependências e migrar o banco de dados:

```bash
composer install && php artisan migrate
```

---

## 🌐 Acessar o Projeto

Após realizar esses passos, o projeto estará pronto para ser acessado no navegador. Acesse o projeto através da URL configurada no nginx ou localhost.

🔗 Acesse a URL para ver como importar os dados : [localhost:8081](http://localhost:8081)
ou [Acessar documentação](https://produtos-c.redocly.app/setup/como-rodar-chron)


---





## This is a challenge by coodesh.
