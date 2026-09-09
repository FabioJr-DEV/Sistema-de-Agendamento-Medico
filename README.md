# Sistema de Agendamento Médico

## Descrição

Sistema web desenvolvido em PHP e MySQL para gerenciamento de uma clínica médica.

O sistema permite o gerenciamento de usuários, médicos, especialidades, horários de atendimento, pacientes, consultas e atendimentos médicos.

A aplicação possui autenticação com diferentes níveis de acesso, permitindo que cada perfil tenha acesso às funcionalidades específicas de sua área.

O projeto foi desenvolvido utilizando PHP, MySQL, HTML, CSS e JavaScript, com o ambiente local configurado através do XAMPP.

---

## Status do Projeto

✅ **Projeto finalizado**

Todas as funcionalidades principais previstas para o Sistema de Agendamento Médico foram desenvolvidas e integradas.

---

## Tecnologias Utilizadas

* PHP
* MySQL
* HTML5
* CSS3
* JavaScript
* XAMPP
* Git
* GitHub

---

## Funcionalidades do Sistema

### Autenticação

* Login de usuários
* Logout
* Controle de sessão
* Controle de acesso por perfil
* Autenticação utilizando senha criptografada
* Alteração de senha para médicos

---

## Perfis do Sistema

### Administrador

O administrador possui acesso às funcionalidades de gerenciamento do sistema.

Principais funcionalidades:

* Gerenciar usuários
* Cadastrar usuários
* Editar usuários
* Consultar usuários
* Gerenciar médicos
* Cadastrar médicos
* Editar médicos
* Gerenciar especialidades
* Cadastrar especialidades
* Editar especialidades
* Gerenciar horários de atendimento
* Definir disponibilidade dos médicos
* Visualizar consultas
* Visualizar relatórios
* Acessar configurações do sistema

---

### Recepcionista

O perfil de recepcionista é responsável pelo atendimento administrativo da clínica.

Principais funcionalidades:

* Cadastrar pacientes
* Consultar pacientes
* Editar pacientes
* Agendar consultas
* Consultar consultas
* Reagendar consultas
* Cancelar consultas
* Confirmar presença de pacientes
* Consultar agenda médica
* Consultar médicos

---

### Médico

O perfil médico possui acesso às funcionalidades relacionadas ao atendimento clínico.

Principais funcionalidades:

* Visualizar agenda de consultas
* Iniciar atendimento
* Registrar prontuário
* Registrar sintomas
* Registrar diagnóstico
* Registrar observações
* Registrar tratamento
* Emitir receitas
* Encerrar atendimentos
* Alterar senha de acesso

---

# Banco de Dados

O sistema utiliza o banco de dados:

```text
projeto_agendamento_medico
```

Atualmente, o banco possui as seguintes tabelas:

### usuarios

Responsável pelo armazenamento dos usuários do sistema.

Perfis disponíveis:

* Administrador
* Recepcionista
* Medico

---

### especialidades

Armazena as especialidades médicas cadastradas no sistema.

Exemplos:

* Cardiologia
* Pediatria
* Clínica Geral
* Dermatologia

---

### medicos

Armazena as informações específicas dos médicos.

Principais informações:

* Usuário relacionado
* CRM
* UF do CRM
* Telefone
* Status

---

### medicos_especialidades

Tabela responsável pelo relacionamento entre médicos e especialidades.

Permite associar médicos às suas respectivas especialidades.

---

### pacientes

Armazena os dados dos pacientes cadastrados.

Principais informações:

* Nome
* CPF
* Data de nascimento
* Sexo
* Telefone
* E-mail
* Endereço
* Tipo sanguíneo
* Alergias
* Observações

---

### horarios

Armazena os horários de atendimento dos médicos.

Principais informações:

* Médico
* Dia da semana
* Hora inicial
* Hora final
* Intervalo entre atendimentos
* Status

---

### consultas

Armazena as consultas agendadas no sistema.

Principais informações:

* Paciente
* Médico
* Usuário responsável pelo agendamento
* Data da consulta
* Horário
* Motivo da consulta
* Status
* Horário de check-in

Status disponíveis:

* Agendada
* Em Andamento
* Finalizada
* Cancelada

---

### atendimentos

Armazena as informações dos atendimentos médicos realizados.

Principais informações:

* Consulta relacionada
* Sintomas
* Diagnóstico
* Observações
* Informações do prontuário
* Data do atendimento

---

### receitas

Armazena as receitas emitidas durante os atendimentos médicos.

Cada receita está relacionada a um atendimento.

---

### receita_itens

Armazena os medicamentos e informações presentes em cada receita.

Permite registrar informações como:

* Medicamento
* Dosagem
* Frequência
* Duração
* Instruções

---

### atestados

Armazena os atestados médicos emitidos durante os atendimentos.

Principais informações:

* Atendimento relacionado
* Dias de afastamento
* CID
* Observações
* Data de emissão

---

## Estrutura do Banco de Dados

O banco de dados atualmente possui as seguintes tabelas:

```text
usuarios
especialidades
medicos
medicos_especialidades
pacientes
horarios
consultas
atendimentos
receitas
receita_itens
atestados
```

---

## Estrutura do Projeto

O projeto está organizado separando as responsabilidades da aplicação.

```text
ProjetoAgendamentoMedico/

├── actions/
│   ├── consultas/
│   ├── especialidades/
│   ├── horarios/
│   ├── medicos/
│   ├── pacientes/
│   └── usuarios/
│
├── config/
│   └── conexao.php
│
├── includes/
│   ├── verificar_admin.php
│   ├── verificar_medico.php
│   └── verificações de acesso
│
├── public/
│   ├── css/
│   └── js/
│
├── templates/
│   ├── admin/
│   ├── medico/
│   └── recepcao/
│
├── schema.sql
│
├── auth.php
│
├── logout.php
│
└── README.md
```

---

## Segurança

O sistema possui algumas medidas básicas de segurança, incluindo:

* Senhas armazenadas utilizando `password_hash()`
* Verificação de senha utilizando `password_verify()`
* Controle de sessão
* Controle de acesso por perfil
* Uso de Prepared Statements
* Proteção contra SQL Injection
* Uso de `htmlspecialchars()` para exibição de dados
* Controle de usuários ativos

---

## Como Executar o Projeto

### 1. Instalar o XAMPP

Instale o XAMPP em seu computador.

---

### 2. Iniciar os serviços

Abra o painel do XAMPP e inicie:

* Apache
* MySQL

---

### 3. Copiar o projeto

Coloque o projeto dentro da pasta:

```text
C:\xampp\htdocs\
```

Exemplo:

```text
C:\xampp\htdocs\ProjetoAgendamentoMedico
```

---

### 4. Criar o banco de dados

Abra o phpMyAdmin e crie ou importe o banco:

```text
projeto_agendamento_medico
```

Importe o arquivo:

```text
schema.sql
```

---

### 5. Configurar a conexão

Verifique o arquivo:

```text
config/conexao.php
```

Configure as informações do banco de dados conforme seu ambiente local.

Exemplo:

```php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "projeto_agendamento_medico";
```

---

### 6. Acessar o sistema

Após iniciar o Apache e o MySQL, acesse:

```text
http://localhost:8080/ProjetoAgendamentoMedico/public/
```

A porta pode variar dependendo da configuração do Apache.

---

## Controle de Versão

O projeto utiliza:

* Git
* GitHub

O desenvolvimento foi organizado utilizando branches para representar diferentes etapas e funcionalidades do projeto.

Exemplos de branches utilizadas durante o desenvolvimento:

```text
main
sprint-2-usuarios
sprint-3-pacientes
sprint-4-medicos
sprint-6-agenda-medica
sprint-7-consultas
```

---

## Autor

**Fábio Júnior Gonçalves**

Responsável pelo Backend, Banco de Dados e integração do sistema.

**Derick Da Silva Vaz**

Scrum Master e responsável pelo Frontend.