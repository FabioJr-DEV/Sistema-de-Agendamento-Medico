```php
<?php

/*
|--------------------------------------------------------------------------
| Página: cadastrar.php
|--------------------------------------------------------------------------
| Objetivo:
| Exibir o formulário de cadastro de usuários.
|--------------------------------------------------------------------------
*/

require_once __DIR__ . "/../../../includes/verificar_admin.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Novo Usuário</title>

    <link
        rel="stylesheet"
        href="../../../public/css/app.css"
    >

</head>

<body>

<div class="layout">

    <!-- MENU LATERAL -->

    <aside class="sidebar">

        <div class="brand">

            Clínica Vida+

            <small>
                Administrador
            </small>

        </div>

        <nav class="nav">

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a
                href="index.php"
                class="active"
            >
                Usuários
            </a>

            <a href="../medicos/index.php">
                Médicos
            </a>

            <a href="../especialidades/index.php">
                Especialidades
            </a>

            <a href="../horarios/index.php">
                Horários
            </a>

            <a href="../relatorios.php">
                Relatórios
            </a>

            <a href="../../../logout.php">
                Sair
            </a>

        </nav>

    </aside>


    <!-- CONTEÚDO PRINCIPAL -->

    <main class="main">

        <div class="topbar">

            <div>

                <h1>
                    Novo usuário
                </h1>

                <p style="color: var(--muted); margin-top: 5px;">
                    Cadastre um novo usuário no sistema
                </p>

            </div>

            <div class="user">

                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>

            </div>

        </div>


        <!-- FORMULÁRIO -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>
                        Dados do usuário
                    </h2>

                    <p>
                        Preencha os dados abaixo para realizar o cadastro.
                    </p>

                </div>

            </div>


            <form
                action="/Sistema-de-Agendamento-Medico/actions/usuarios/cadastrar.php"
                method="POST"
            >

                <div class="form-grid">


                    <!-- NOME -->

                    <div class="field">

                        <label for="nome">
                            Nome
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            placeholder="Digite o nome completo"
                            required
                        >

                    </div>


                    <!-- E-MAIL -->

                    <div class="field">

                        <label for="email">
                            E-mail
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Digite o e-mail"
                            required
                        >

                    </div>


                    <!-- SENHA -->

                    <div class="field">

                        <label for="senha">
                            Senha
                        </label>

                        <input
                            type="password"
                            id="senha"
                            name="senha"
                            placeholder="Digite a senha"
                            required
                        >

                    </div>


                    <!-- PERFIL -->

                    <div class="field">

                        <label for="perfil">
                            Perfil
                        </label>

                        <select
                            name="perfil"
                            id="perfil"
                            required
                        >

                            <option value="">
                                Selecione o perfil
                            </option>

                            <option value="Administrador">
                                Administrador
                            </option>

                            <option value="Recepcionista">
                                Recepcionista
                            </option>

                        </select>

                    </div>


                </div>


                <!-- BOTÕES -->

                <div class="card-footer">

                    <div class="actions">

                        <a
                            href="index.php"
                            class="btn btn-secondary"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Cadastrar usuário
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </main>

</div>


<script src="../../../public/js/app.js"></script>

</body>

</html>
```
