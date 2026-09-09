```php
<?php

/*
|--------------------------------------------------------------------------
| Página: editar especialidade
|--------------------------------------------------------------------------
| Objetivo:
| Exibir os dados de uma especialidade para edição.
|--------------------------------------------------------------------------
*/

require_once "../../../config/conexao.php";
require_once "../../../includes/verificar_admin.php";


/*
|--------------------------------------------------------------------------
| Verifica o ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    $_SESSION["erro"] = "Especialidade inválida.";

    header("Location: index.php");
    exit;
}


$id = (int) $_GET["id"];


/*
|--------------------------------------------------------------------------
| Busca a especialidade
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            id,
            nome,
            descricao,
            ativo
        FROM especialidades
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();


if ($resultado->num_rows === 0) {

    $_SESSION["erro"] = "Especialidade não encontrada.";

    header("Location: index.php");
    exit;
}


$especialidade = $resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Editar Especialidade</title>

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

                <h1>Editar Especialidade</h1>

                <div class="user">
                    Atualize os dados da especialidade
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

                    <h2>Dados da especialidade</h2>

                    <p>
                        Altere as informações necessárias e salve as alterações.
                    </p>

                </div>

            </div>


            <form
                action="../../../actions/especialidades/editar.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) $especialidade["id"] ?>"
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
                            value="<?= htmlspecialchars($especialidade["nome"]) ?>"
                            maxlength="100"
                            required
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
                                <?= ((int) $especialidade["ativo"] === 1) ? "selected" : "" ?>
                            >
                                Ativa
                            </option>

                            <option
                                value="0"
                                <?= ((int) $especialidade["ativo"] === 0) ? "selected" : "" ?>
                            >
                                Inativa
                            </option>

                        </select>

                    </div>


                    <!-- DESCRIÇÃO -->

                    <div class="field full">

                        <label for="descricao">
                            Descrição
                        </label>

                        <textarea
                            id="descricao"
                            name="descricao"
                            rows="6"
                            placeholder="Digite uma descrição para a especialidade..."
                        ><?= htmlspecialchars($especialidade["descricao"] ?? "") ?></textarea>

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
