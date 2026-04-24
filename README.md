# 💰 Dinami - Sistema de Gestão Financeira

Sistema web desenvolvido para controle financeiro, permitindo gerenciar contas a pagar, contas a receber e acompanhar o fluxo de caixa de forma simples e eficiente.

---

## 🚀 Funcionalidades

* 📊 Dashboard com resumo financeiro
* 💸 Cadastro de contas a pagar
* 💰 Cadastro de contas a receber
* 📅 Controle de vencimentos
* ✅ Controle de status (Pendente / Pago / Recebido)
* 🧾 Histórico de movimentações
* 📂 Organização por módulos (Financeiro, Cadastro)

---

## 🛠️ Tecnologias utilizadas

* **Laravel** (Backend)
* **Blade** (Template engine)
* **TailwindCSS** (Estilização)
* **Alpine.js** (Interatividade)
* **PostgreSQL** (Banco de dados)

---

## 📸 Preview

> *(Adicione aqui prints do sistema depois)*

---

## ⚙️ Como rodar o projeto

### 1. Clonar repositório

```bash
git clone https://github.com/SEU_USUARIO/dinami.git
cd dinami
```

### 2. Instalar dependências

```bash
composer install
npm install
```

### 3. Configurar ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Configure o banco de dados no `.env`

---

### 4. Rodar migrations

```bash
php artisan migrate
```

---

### 5. Rodar o projeto

```bash
php artisan serve
npm run dev
```

Acesse:

```
http://127.0.0.1:8000
```

---

## 📌 Estrutura do sistema

* **Dashboard** → visão geral financeira
* **Contas a Pagar** → controle de despesas
* **Contas a Receber** → controle de receitas
* **Cadastro** → clientes e fornecedores

---

## 🎯 Melhorias futuras

* 📈 Gráficos financeiros
* 🔔 Alertas de vencimento
* 👤 Sistema de autenticação (login)
* 📊 Relatórios avançados
* 📱 Responsividade mobile

---

## 👨‍💻 Autor

Desenvolvido por **Daniel**
Projeto acadêmico de sistema financeiro.

---

## 📄 Licença

Este projeto está sob a licença MIT.
