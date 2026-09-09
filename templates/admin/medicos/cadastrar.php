```php
<?php

/*
|--------------------------------------------------------------------------
| Página: cadastrar médico
|--------------------------------------------------------------------------
| Objetivo:
| Exibir o formulário para cadastro de um médico.
|--------------------------------------------------------------------------
*/

require_once "../../../config/conexao.php";
require_once "../../../includes/verificar_admin.php";


/*
|--------------------------------------------------------------------------
| Busca especialidades ativas
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            id,
            nome
        FROM especialidades
        WHERE ativo = 1
        ORDER BY nome ASC";


$stmt = $conn->prepare($sql);

$stmt->execute();

$resultado_especialidades = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Novo Médico</title>

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

            <a href="../usuarios/index.php">
                Usuários
            </a>

            <a
                href="index.php"
                class="active"
            >
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
                    Novo médico
                </h1>

                <p style="color: var(--muted); margin-top: 5px;">
                    Cadastre um novo médico no sistema
                </p>

            </div>

            <div class="user">

                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>

            </div>

        </div>


        <!-- MENSAGENS -->

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


        <!-- FORMULÁRIO -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>
                        Dados do médico
                    </h2>

                    <p>
                        Preencha os dados abaixo para cadastrar o médico.
                    </p>

                </div>

            </div>


            <form
                action="../../../actions/medicos/cadastrar.php"
                method="POST"
            >

                <div class="form-grid">


                    <!-- NOME -->

                    <div class="field">

                        <label for="nome">
                            Nome completo
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            maxlength="100"
                            placeholder="Digite o nome completo"
                            required
                        >

                    </div>


                    <!-- CRM -->

                    <div class="field">

                        <label for="crm_numero">
                            Número do CRM
                        </label>

                        <input
                            type="text"
                            id="crm_numero"
                            name="crm_numero"
                            maxlength="20"
                            placeholder="Digite o número do CRM"
                            required
                        >

                    </div>


                    <!-- UF -->

                    <div class="field">

                        <label for="crm_uf">
                            UF do CRM
                        </label>

                        <input
                            type="text"
                            id="crm_uf"
                            name="crm_uf"
                            maxlength="2"
                            placeholder="Ex.: RS"
                            style="text-transform: uppercase;"
                            required
                        >

                    </div>


                    <!-- ESPECIALIDADE -->

                    <div class="field">

                        <label for="especialidade_id">
                            Especialidade
                        </label>

                        <select
                            id="especialidade_id"
                            name="especialidade_id"
                            required
                        >

                            <option value="">
                                Selecione uma especialidade
                            </option>

                            <?php while ($especialidade = $resultado_especialidades->fetch_assoc()): ?>

                                <option
                                    value="<?= $especialidade["id"] ?>"
                                >

                                    <?= htmlspecialchars($especialidade["nome"]) ?>

                                </option>

                            <?php endwhile; ?>

                        </select>

                    </div>


                    <!-- TELEFONE -->

                    <div class="field">

                        <label for="telefone">
                            Telefone
                        </label>

                        <input
                            type="text"
                            id="telefone"
                            name="telefone"
                            maxlength="20"
                            placeholder="Digite o telefone"
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
                            maxlength="150"
                            placeholder="Digite o e-mail"
                            required
                        >

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
                            Cadastrar médico
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
