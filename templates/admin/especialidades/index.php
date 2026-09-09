```php
<?php

/*
|--------------------------------------------------------------------------
| Página: index.php
|--------------------------------------------------------------------------
| Objetivo:
| Listar as especialidades cadastradas.
|--------------------------------------------------------------------------
*/

require_once "../../../config/conexao.php";
require_once "../../../includes/verificar_admin.php";


/*
|--------------------------------------------------------------------------
| Busca as especialidades
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            id,
            nome,
            descricao,
            ativo,
            created_at
        FROM especialidades
        ORDER BY nome ASC";

$stmt = $conn->prepare($sql);

$stmt->execute();

$resultado = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Especialidades</title>

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

                <h1>Especialidades Médicas</h1>

                <div class="user">
                    Gerencie as especialidades cadastradas
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
             CARD PRINCIPAL
        ======================================================= -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>Especialidades cadastradas</h2>

                    <p>
                        Visualize e gerencie as especialidades médicas.
                    </p>

                </div>

                <a
                    class="btn btn-primary"
                    href="cadastrar.php"
                >
                    + Cadastrar especialidade
                </a>

            </div>


            <!-- ==================================================
                 TABELA
            =================================================== -->

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Nome</th>

                            <th>Descrição</th>

                            <th>Status</th>

                            <th>Data de Cadastro</th>

                            <th>Ações</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if ($resultado->num_rows > 0): ?>

                        <?php while ($especialidade = $resultado->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= (int) $especialidade["id"] ?>
                                </td>


                                <td>

                                    <strong>
                                        <?= htmlspecialchars($especialidade["nome"]) ?>
                                    </strong>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $especialidade["descricao"] ?? ""
                                    ) ?>

                                </td>


                                <td>

                                    <?php if ($especialidade["ativo"] == 1): ?>

                                        <span class="status status-active">
                                            Ativa
                                        </span>

                                    <?php else: ?>

                                        <span class="status status-inactive">
                                            Inativa
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $especialidade["created_at"]
                                    ) ?>

                                </td>


                                <td>

                                    <div class="actions">

                                        <a
                                            class="btn btn-secondary"
                                            href="editar.php?id=<?= (int) $especialidade["id"] ?>"
                                        >
                                            Editar
                                        </a>


                                        <a
                                            class="btn btn-danger"
                                            href="../../../actions/especialidades/excluir.php?id=<?= (int) $especialidade["id"] ?>"
                                            onclick="return confirm('Tem certeza que deseja excluir esta especialidade?');"
                                        >
                                            Excluir
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="6"
                                class="empty"
                            >
                                Nenhuma especialidade cadastrada.
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>


<script src="../../../public/js/app.js"></script>

</body>

</html>
```
