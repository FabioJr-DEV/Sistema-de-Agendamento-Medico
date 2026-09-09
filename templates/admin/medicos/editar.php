```php
<?php

/*
|--------------------------------------------------------------------------
| Página: editar médico
|--------------------------------------------------------------------------
| Objetivo:
| Exibir o formulário de edição dos dados de um médico.
|--------------------------------------------------------------------------
*/

require_once "../../../includes/verificar_admin.php";
require_once "../../../config/conexao.php";


/*
|--------------------------------------------------------------------------
| Verifica se o ID foi informado
|--------------------------------------------------------------------------
*/

if (!isset($_GET["id"])) {

    header("Location: index.php");
    exit;
}

$id = (int) $_GET["id"];

if ($id <= 0) {

    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Busca os dados do médico
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            m.id,
            u.nome,
            u.email,
            m.crm_numero,
            m.crm_uf,
            m.telefone,
            m.ativo,
            me.especialidade_id
        FROM medicos m
        INNER JOIN usuarios u
            ON u.id = m.usuario_id
        LEFT JOIN medicos_especialidades me
            ON me.medico_id = m.id
        WHERE m.id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

$medico = $resultado->fetch_assoc();


if (!$medico) {

    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Busca as especialidades ativas
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

    <title>Editar Médico</title>

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

            <a class="active" href="index.php">
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


    <!-- ==========================================================
         CONTEÚDO PRINCIPAL
    =========================================================== -->

    <main class="main">

        <div class="topbar">

            <div>

                <h1>Editar Médico</h1>

                <div class="user">
                    Atualize os dados do médico
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

                    <h2>Dados do médico</h2>

                    <p>
                        Altere as informações necessárias e salve as alterações.
                    </p>

                </div>

            </div>


            <form
                action="../../../actions/medicos/editar.php"
                method="POST"
            >

                <!-- ID DO MÉDICO -->

                <input
                    type="hidden"
                    name="medico_id"
                    value="<?= (int) $medico["id"] ?>"
                >


                <div class="form-grid">


                    <!-- NOME -->

                    <div class="field">

                        <label for="nome">
                            Nome *
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            maxlength="100"
                            value="<?= htmlspecialchars($medico["nome"]) ?>"
                            required
                        >

                    </div>


                    <!-- E-MAIL -->

                    <div class="field">

                        <label for="email">
                            E-mail *
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            maxlength="150"
                            value="<?= htmlspecialchars($medico["email"]) ?>"
                            required
                        >

                    </div>


                    <!-- CRM -->

                    <div class="field">

                        <label for="crm_numero">
                            Número do CRM *
                        </label>

                        <input
                            type="text"
                            id="crm_numero"
                            name="crm_numero"
                            maxlength="20"
                            value="<?= htmlspecialchars($medico["crm_numero"]) ?>"
                            required
                        >

                    </div>


                    <!-- UF CRM -->

                    <div class="field">

                        <label for="crm_uf">
                            UF do CRM *
                        </label>

                        <input
                            type="text"
                            id="crm_uf"
                            name="crm_uf"
                            maxlength="2"
                            value="<?= htmlspecialchars($medico["crm_uf"]) ?>"
                            style="text-transform: uppercase;"
                            required
                        >

                    </div>


                    <!-- ESPECIALIDADE -->

                    <div class="field">

                        <label for="especialidade_id">
                            Especialidade *
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
                                    value="<?= (int) $especialidade["id"] ?>"
                                    <?= ((int) $medico["especialidade_id"] === (int) $especialidade["id"]) ? "selected" : "" ?>
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
                            value="<?= htmlspecialchars($medico["telefone"] ?? "") ?>"
                        >

                    </div>


                    <!-- STATUS -->

                    <div class="field">

                        <label for="ativo">
                            Status *
                        </label>

                        <select
                            id="ativo"
                            name="ativo"
                            required
                        >

                            <option
                                value="1"
                                <?= ((int) $medico["ativo"] === 1) ? "selected" : "" ?>
                            >
                                Ativo
                            </option>

                            <option
                                value="0"
                                <?= ((int) $medico["ativo"] === 0) ? "selected" : "" ?>
                            >
                                Inativo
                            </option>

                        </select>

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
                        Salvar alterações
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
