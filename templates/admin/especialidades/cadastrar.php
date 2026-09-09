```php
<?php

/*
|--------------------------------------------------------------------------
| Página: cadastrar especialidade
|--------------------------------------------------------------------------
| Objetivo:
| Exibir o formulário para cadastro de uma especialidade médica.
|--------------------------------------------------------------------------
*/

require_once "../../../includes/verificar_admin.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cadastrar Especialidade</title>

    <link
        rel="stylesheet"
        href="../../../public/css/app.css"
    >

</head>

<body>

<div class="layout">

    <!-- ==========================================================
         MENU LATERAL
    =========================================================== -->

    <aside class="sidebar">

        <div class="brand">

            Clínica Vida+

            <small>Administrador</small>

        </div>

        <nav class="nav">

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a href="../usuarios/index.php">
                Usuários
            </a>

            <a href="../medicos/index.php">
                Médicos
            </a>

            <a class="active" href="index.php">
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


    <!-- ==========================================================
         CONTEÚDO PRINCIPAL
    =========================================================== -->

    <main class="main">

        <div class="topbar">

            <div>

                <h1>Cadastrar Especialidade</h1>

                <div class="user">
                    Cadastre uma nova especialidade médica
                </div>

            </div>

            <div class="user">

                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>

            </div>

        </div>


        <!-- ======================================================
             MENSAGENS
        ======================================================= -->

        <?php if (isset($_SESSION["erro"])): ?>

            <div class="alert alert-error">

                <?= htmlspecialchars($_SESSION["erro"]) ?>

            </div>

            <?php unset($_SESSION["erro"]); ?>

        <?php endif; ?>


        <?php if (isset($_SESSION["sucesso"])): ?>

            <div class="alert alert-success">

                <?= htmlspecialchars($_SESSION["sucesso"]) ?>

            </div>

            <?php unset($_SESSION["sucesso"]); ?>

        <?php endif; ?>


        <!-- ======================================================
             FORMULÁRIO
        ======================================================= -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>Nova especialidade</h2>

                    <p>
                        Informe os dados da especialidade que deseja cadastrar.
                    </p>

                </div>

            </div>


            <form
                action="../../../actions/especialidades/cadastrar.php"
                method="POST"
            >

                <div class="form-grid">


                    <!-- NOME -->

                    <div class="field">

                        <label for="nome">
                            Nome da especialidade *
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            maxlength="100"
                            required
                        >

                    </div>


                    <!-- DESCRIÇÃO -->

                    <div class="field full">

                        <label for="descricao">
                            Descrição
                        </label>

                        <textarea
                            id="descricao"
                            name="descricao"
                            rows="5"
                            placeholder="Digite uma descrição para a especialidade..."
                        ></textarea>

                    </div>


                </div>


                <!-- ==================================================
                     BOTÕES
                =================================================== -->

                <div class="actions">

                    <a
                        class="btn btn-secondary"
                        href="index.php"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Cadastrar especialidade
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>


<script src="../../../public/js/app.js"></script>

</body>

</html>
```
